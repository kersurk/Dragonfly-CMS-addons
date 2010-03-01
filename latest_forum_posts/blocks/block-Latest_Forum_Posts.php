<?php
/*********************************************
CPG Dragonfly™ CMS
 ********************************************
Copyright © 2004 - 2010 by CPG-Nuke Dev Team
http://dragonflycms.org

Dragonfly is released under the terms and conditions
of the GNU GPL version 2 or any later version

$Source: block-Latest_Forum_Posts.php,v $
$Revision: 9.9 $
$Author: Madis $
$Date: 2009/09/05 22:30:00 $
Encoding test: n-array summation ∑ latin ae w/ acute ǽ
 ********************************************************/
//Security check needed by Dragonfly
if (!defined('CPG_NUKE')) { exit; }

//Get global variables for sql querys($db, $prefix, $user_prefix),
//multilanguage(forums.php uses $lang not defines) and for applying templating system($cpgtpl)
global $db, $prefix, $user_prefix, $lang, $cpgtpl, $userinfo, $CPG_SESS;

//Get languages/USED_LANGUAGE/forums.php file for having translated strings
//Uncomment this, if you need translated strings:
//get_lang('forums');

//Check if Forums module is active and say if it isn't
if (!is_active('Forums')) {
    $content = 'ERROR';
    return trigger_error('Forums module is inactive. Please activate the Forums in order to use this block.', E_USER_WARNING);
} else {

    get_lang('latest_forum_posts');

    //How many topics would you like to show?
    $count = 8;

    $query_restriction = '';

    if (!is_admin()) {
        $query_restriction = ' AND (f.auth_view < 2 && f.auth_read < 2)';
        //$query_restriction = ' AND (f.auth_view < 2 || f.auth_read < 2)';
    }

    //Main query
    $result = $db->sql_query('SELECT
t.topic_id AS topic_id, t.forum_id AS forum_id, t.topic_title AS topic_title,
t.topic_replies AS topic_replies, t.topic_last_post_id AS topic_last_post_id,
f.forum_id, f.auth_view AS auth_view, f.auth_read AS auth_read, f.forum_name,
p.poster_id, p.post_time AS post_time,
u.user_id AS user_id, u.username AS username
FROM ('.$prefix.'_bbtopics t, '.$prefix.'_bbforums f)
LEFT JOIN '.$prefix.'_bbposts p ON (p.post_id = t.topic_last_post_id)
LEFT JOIN '.$user_prefix.'_users u ON (u.user_id = p.poster_id)
WHERE t.forum_id=f.forum_id'.$query_restriction.'
ORDER BY t.topic_last_post_id
DESC LIMIT '.$count);

    //Check if at least one Topic exists and say if isn't
    if ($db->sql_numrows($result) < 1) {
        $content = _ERROR;
        return trigger_error('There are no forum posts', E_USER_NOTICE);
    } else {

        $tracking_topics = isset($CPG_SESS['Forums']['track_topics']) ? $CPG_SESS['Forums']['track_topics'] : array();
        $tracking_forums = isset($CPG_SESS['Forums']['track_forums']) ? $CPG_SESS['Forums']['track_forums'] : array();

        while ($row = $db->sql_fetchrow($result)) {

            $topic_id = $row['topic_id'];
            $forum_id = $row['forum_id'];

            $post_date = MB::tolower(formatDateTime($row['post_time'], '%d. %b'));
            $post_time = formatDateTime($row['post_time'], '%T');

            $post_time_ago = getTimeAgo($row['post_time'], dfTime());

            $new_post = 0;
            if (is_user() && ($row['post_time'] > $userinfo['user_lastvisit']) && (!empty($tracking_topics) || !empty($tracking_forums) ||
                    isset($CPG_SESS['Forums']['track_all']))) {
                $new_post = 1;
                if ((!empty($tracking_topics[$topic_id]) && ($tracking_topics[$topic_id] > $row['post_time'])) ||
                        (!empty($tracking_forums[$forum_id]) && ($tracking_forums[$forum_id] > $row['post_time'])) ||
                        (isset($CPG_SESS['Forums']['track_all']) && ($CPG_SESS['Forums']['track_all'] > $row['post_time']))) {
                    $new_post = 0;
                }
            }


            $cpgtpl->assign_block_vars('topic', array(
                'LAST_POST_LINK'		=> getlink('Forums&amp;file=viewtopic&amp;p='.$row['topic_last_post_id'].'#'.$row['topic_last_post_id']),
                'TOPIC_TITLE'			=> $row['topic_title'],
                'TOPIC_REPLIES'			=> $row['topic_replies'],
                'LAST_POST_USERNAME'	=> $row['username'],
                'USER_LINK'				=> getlink('Your_Account&amp;profile='.$row['user_id']),
                'LAST_POST_DATE'		=> $post_date,
                'LAST_POST_TIME'		=> $post_time,
                'LAST_POST_TIME_AGO'    => $post_time_ago,
                'S_NEW_POST'			=> $new_post,
                'FORUM_NAME'			=> $row['forum_name'],
            ));

        }

        $cpgtpl->assign_var('FORUMS_URL',getlink('Forums'));

    }


    //Uncomment this, if you need translated strings:
    /*
    $cpgtpl->assign_vars(array(
      'S_REPLIES'         => $lang['Replies'],
      'S_LAST_POST'       => $lang['Last_Post']
    ));
    */

    ob_start();
    $cpgtpl->set_filenames(array('template' => 'blocks/latest_forum_posts.html'));
    $cpgtpl->display('template');
    $content = ob_get_clean();
}



function getTimeAgo($datefrom, $dateto=-1) {
    // Defaults and assume if 0 is passed in that
    // its an error rather than the epoch

    if ($datefrom<=0) { return _LONG_TIME_AGO; }
    if ($dateto==-1) { $dateto = time(); }

    // Calculate the difference in seconds betweeen
    // the two timestamps

    $difference = $dateto - $datefrom;

    // If difference is less than 60 seconds,
    // seconds is a good interval of choice

    if ($difference < 60) {
        $interval = "s";

        // If difference is between 60 seconds and
        // 60 minutes, minutes is a good interval
    } elseif($difference >= 60 && $difference<60*60) {
        $interval = "n";

        // If difference is between 1 hour and 24 hours
        // hours is a good interval
    } elseif ($difference >= 60*60 && $difference<60*60*24) {
        $interval = "h";

        // If difference is between 1 day and 7 days
        // days is a good interval
    } elseif ($difference >= 60*60*24 && $difference<60*60*24*7) {
        $interval = "d";

        // If difference is between 1 week and 30 days
        // weeks is a good interval
    } elseif ($difference >= 60*60*24*7 && $difference < 60*60*24*30) {
        $interval = "ww";

        // If difference is between 30 days and 365 days
        // months is a good interval, again, the same thing
        // applies, if the 29th February happens to exist
        // between your 2 dates, the function will return
        // the 'incorrect' value for a day
    } elseif ($difference >= 60*60*24*30 && $difference < 60*60*24*365) {
        $interval = "m";

        // If difference is greater than or equal to 365
        // days, return year. This will be incorrect if
        // for example, you call the function on the 28th April
        // 2008 passing in 29th April 2007. It will return
        // 1 year ago when in actual fact (yawn!) not quite
        // a year has gone by
    } elseif($difference >= 60*60*24*365) {
        $interval = "y";
    }

    // Based on the interval, determine the
    // number of units between the two dates
    // From this point on, you would be hard
    // pushed telling the difference between
    // this function and DateDiff. If the $datediff
    // returned is 1, be sure to return the singular
    // of the unit, e.g. 'day' rather 'days'

    switch($interval) {
        case "m":
            $months_difference = floor($difference / 60 / 60 / 24 /
                    29);
            while (mktime(date("H", $datefrom), date("i", $datefrom),
                date("s", $datefrom), date("n", $datefrom)+($months_difference),
                date("j", $dateto), date("Y", $datefrom)) < $dateto)
            {
                $months_difference++;
            }
            $datediff = $months_difference;

            // We need this in here because it is possible
            // to have an 'm' interval and a months
            // difference of 12 because we are using 29 days
            // in a month

            if ($datediff==12) {
                $datediff--;
            }

            $res = ($datediff==1) ? _ONE_MONTH_AGO : sprintf(_MONTHS_AGO, $datediff);
            break;

        case "y":
            $datediff = floor($difference / 60 / 60 / 24 / 365);
            $res = ($datediff==1) ? _ONE_YEAR_AGO : sprintf(_YEARS_AGO, $datediff);
            break;

        case "d":
            $datediff = floor($difference / 60 / 60 / 24);
            $res = ($datediff==1) ? _ONE_DAY_AGO : sprintf(_DAYS_AGO, $datediff);
            break;

        case "ww":
            $datediff = floor($difference / 60 / 60 / 24 / 7);
            $res = ($datediff==1) ? _ONE_WEEK_AGO : sprintf(_WEEKS_AGO, $datediff);
            break;

        case "h":
            $datediff = floor($difference / 60 / 60);
            $res = ($datediff==1) ? _ONE_HOUR_AGO : sprintf(_HOURS_AGO, $datediff);
            break;

        case "n":
            $datediff = floor($difference / 60);
            $res = ($datediff==1) ? _ONE_MINUTE_AGO : sprintf(_MINUTES_AGO, $datediff);
            break;

        case "s":
            $datediff = $difference;
            $res = ($datediff==1) ? _ONE_SECOND_AGO : sprintf(_SECONDS_AGO, $datediff);
            break;
    }
    return $res;
}


/*Current time, depends what df version is used*/
function dfTime() {
    //Dragonfly 10+
    if (version_compare(CPG_NUKE, '10.0.0', '>=')) {
        return time();
        //Older
    } else {
        return gmtime();
    }
}
