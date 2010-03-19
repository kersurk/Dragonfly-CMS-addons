<?php
/**
 * User: madis
 * Date: 19.03.2010
 * Time: 16:43:28
 */

class AbstractBlocksModule {

    private static $types = array('file', 'custom');

    function __construct() {

    }

    public function showHeader() {
        require_once('header.php');
    }

    public function showHello() {
        echo 'Hello';
    }

    public function doSth() {

        // Test data
        $id = 1;
        $access = array(1,2,3);
        $active = 1;
        $title = 'Example Block';
        $type = 1; //1-file, 2-custom
        $file = 'Latest_Forum_Posts';
        $custom = '';
        $position = 'half';
        $order = 1;

        if ($this->isType($type, 'file')) {
            $filename = 'block-'.$file.'.php';

            //todo: get $content value from blocks/$filename
            $content = $filename;
        } else if ($this->isType($type, 'custom')) {
            //todo: secure it?
            $content = $custom;
        } else {
            throw new AbstractBlocksException('unknown type: '.$type);
        }

        new AdvancedBlocksBlock($title, $content, $position);
    }


    private function isType($givenType, $wantedType) {
        return $givenType == getType($wantedType);
    }

    private function getType($type) {
        return key(self::$types[$type]);
    }


}


