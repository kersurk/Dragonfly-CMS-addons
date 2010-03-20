<?php
/**
 * User: madis
 * Date: 19.03.2010
 * Time: 20:06:12
 */

class AbstractBlocksBlockException extends Exception {
    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
                .': <b>'.$this->getMessage().'</b>';

        echo '<!-- '.$errorMsg.' -->';
        return $errorMsg;
    }
}
