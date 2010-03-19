<?php

$path = 'D:\Programmid\wamp\www\Dragonfly-CMS-addons';
set_include_path(get_include_path().PATH_SEPARATOR.$path);

require_once 'abstractblocks/modules/AbstractBlocks/AbstractBlocksModule.php';
//require_once dirname(__FILE__).'/../../../../abstract/modules/AbstractModule.php';

require_once 'PHPUnit/Framework.php';

class AbstractBlocksModuleTest extends PHPUnit_Framework_TestCase {
    protected $object;

    protected function setUp() {
        $this->object = new AbstractBlocksModule();
    }

    /**
     * @test
     */
    public function showHello() {
/*
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
        $this->assertEquals('1 day ago', $test);*/

    }


}