<?php
/**
 * User: madis
 * Date: 19.03.2010
 * Time: 16:43:28
 */

require_once('AbstractBlocksBlock.php');
require_once('AbstractBlocksBlockException.php');

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

    public function renderBlocks() {
        global $cpgtpl;


        // Test data
        $blockInfo = array();
        $blockInfo['id'] = 1;
        $blockInfo['access'] = array(1,2,3);
        $blockInfo['active'] = 1;
        $blockInfo['title'] = 'Example Block';
        $blockInfo['type'] = 0;
        //$blockInfo['file'] = 'Latest_Forum_Posts';
        $blockInfo['file'] = 'Example_Block';

        $blockInfo['custom'] = '';
        $blockInfo['position'] = 'half';
        $blockInfo['weight'] = 1;
        $blocks = array();
        $blocks[] = $blockInfo;



        // This should run already in right order
        foreach ($blocks as $advancedBlockInfo) {
            try {
                $abstractBlocksBlock = new AbstractBlocksBlock($advancedBlockInfo);
                $abstractBlocksBlock->assignBlockVariables();
            } catch (AbstractBlocksBlockException $blockException) {
                //$blockException->...
                echo $blockException;
                echo 'something went wrong';
            }
        }

        $cpgtpl->set_filenames(array('abstractblocks' => 'abstractblocks/abstractblocks.html'));
        $cpgtpl->display('abstractblocks');
    }
}