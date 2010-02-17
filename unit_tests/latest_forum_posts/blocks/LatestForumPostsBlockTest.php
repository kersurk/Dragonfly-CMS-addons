<?php

define('CPG_NUKE', '10');
require_once dirname(__FILE__).'/../../../latest_forum_posts/blocks/LatestForumPostsBlock.php';

class LatestForumPostsBlockTest extends PHPUnit_Framework_TestCase {
    protected $object;

    protected function setUp() {
        $this->object = new LatestForumPostsBlock();
    }

    /**
     * @test
     */
    public function getTimeAgo() {

        // 30 seconds ago
        $timeGiven = time()-30;
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('30 seconds ago', $test);

            // 90 seconds ago
        $timeGiven = time()-90;
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('1 minute ago', $test);

            // 490 seconds ago
        $timeGiven = time()-490;
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('8 minutes ago', $test);

            // 1 hour ago
        $timeGiven = time()-3600;
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('1 hour ago', $test);

            // 2 hours ago
        $timeGiven = time()-7200;
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('2 hours ago', $test);

        $timeGiven = time()-14600;
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('4 hours ago', $test);

        $timeGiven = strtotime('yesterday');
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('1 day ago', $test);

        $this->tryWithLastTimeUnit('week');
        $this->tryWithLastTimeUnit('month');
        $this->tryWithLastTimeUnit('year');
    }

    private function tryWithLastTimeUnit($timeUnit) {
        $timeGiven = strtotime('last '.$timeUnit);
        $test = $this->object->getTimeAgo($timeGiven);
        $this->assertEquals('1 '.$timeUnit.' ago', $test);
    }

}