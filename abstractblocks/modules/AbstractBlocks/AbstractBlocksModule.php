<?php
/**
 * User: madis
 * Date: 19.03.2010
 * Time: 16:43:28
 */

class AbstractBlocksModule {

    function __construct() {

    }

    public function showHeader() {
        require_once('header.php');
    }

    public function showHello() {
        echo 'Hello';
    }
}
