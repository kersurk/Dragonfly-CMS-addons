<?php
/**
 * User: madis
 * Date: 19.03.2010
 * Time: 19:42:41
 */

class AdvancedBlocksBlock {

    private $title;
    private $content;
    private $position;
    
    function __construct($title, $content, $position) {
        $this->title = $title;
        $this->content = $content;
        $this->position = $position;
    }

    public function render() {
        //Add to cpgtpl? or echo?
    }
}
