<?php
/**
 * User: madis
 * Date: 19.03.2010
 * Time: 19:42:41
 */


class AbstractBlocksBlock {

    private $title;
    private $content;
    private $position;

    private static $types = array('file', 'custom');

    function __construct($blockInfo) {

        if ($this->isType($blockInfo['type'], 'file')) {
            $filename = 'block-'.$blockInfo['file'].'.php';

            //todo: get $content value from blocks/$filename
            //$content = $filename;

            if (is_file('blocks/'.$filename)) {
                require_once('blocks/'.$filename);
                /*if ($content == 'ERROR') {
                }*/
                
                if (!empty($content)) {
                    //$block['content'] =& $content;
                    //$this->assign($side, $block);
                }
            }


        } else if ($this->isType($blockInfo['type'], 'custom')) {
            //todo: secure it?
            $content = $blockInfo['custom'];
        } else {
            throw new AbstractBlocksBlockException('unknown type: '.$blockInfo['type']);
        }

        $this->title = $blockInfo['title'];
        $this->content = $content;
        $this->position = $blockInfo['position'];
    }


    public function assignBlockVariables() {
        global $cpgtpl;

        $cpgtpl->assign_block_vars('abstractblock', array(
            'POSITION'      => $this->position,
            'TITLE'         => $this->title,
            'CONTENT'       => $this->content,
        ));
    }


    private function isType($givenType, $wantedType) {
        return $givenType == getType($wantedType);
    }

    private function getType($type) {
        return key(self::$types[$type]);
    }
}
