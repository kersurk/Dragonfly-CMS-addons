<?php
/*********************************************
CPG Dragonfly™ CMS
 ********************************************
Copyright © 2004 - 2010 by DragonflyCMS Dev Team
http://dragonflycms.org

Dragonfly is released under the terms and conditions
of the GNU GPL version 2 or any later version

$Id:  $
$HeadURL:  $
Encoding test: n-array summation ∑ latin ae w/ acute ǽ
 ********************************************************/
if (!defined('ADMIN_MOD_INSTALL')) { exit; }

$spc_mname = basename(dirname(dirname(__FILE__)));
$spc_prefix = strtolower($spc_mname);

$table_ids[$spc_prefix.'_blocks'] = 'id';

$tables[$spc_prefix.'_blocks'] = array(
    'id' => array('Type' => 'SERIAL4', 'Null' => 0), //AbstractBlock ID
    'access' => array('Type' => 'VARCHAR(255)', 'Null' => 0, 'Default' => ''), //Array of who has access to see it
    'active' => array('Type' => DBFT_INT1, 'Null' => 0, 'Default' => 1), //Active or not?
    'title' => array('Type' => 'VARCHAR(255)', 'Null' => 0, 'Default' => ''), //Title - can be constant as well. If empty block filename is used (can also be constant). Can also be with link?)
    'type' => array('Type' => DBFT_INT4, 'Null' => 0, 'Default' => 2), //Type, file = 1, custom = 2
    'file' => array('Type' => 'VARCHAR(255)', 'Null' => 0, 'Default' => ''), //Block filename without prefix and suffix, i.e Latest_forum_posts = block-Latest_Forum_Posts.php
    'custom' => array('Type' => 'TEXT', 'Null' => 0, 'Default' => ''), //Content, if type=2, then used
    'position' => array('Type' => 'VARCHAR(255)', 'Null' => 0, 'Default' => ''), // CSS Classname
    'weight' => array('Type' => DBFT_INT4, 'Null' => 0, 'Default' => 0), //Rendering order
);
$indexes[$spc_prefix.'_blocks'] = array(
	'PRIMARY' => array('unique' => 1, 'type' => 'BTREE',
	0 => array('name' => 'id', 'Sub_part' => '', 'Null' => 0))
);
