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

/**
 * AbstractBlocks
 * Allows selecting blocks and position them
 */

if (!defined('CPG_NUKE')) { exit; }
require_once('AbstractBlocksModule.php');
require_once('AbstractBlocksException.php');


try {
    $abstractBlocksModule = new AbstractBlocksModule();
    $abstractBlocksModule->showHeader();
    $abstractBlocksModule->showHello();
//todo: some of it shouldn't be caught here, but separately for each blocks    
} catch (AbstractBlocksException $abe) {
    echo 'something went wrong';
}