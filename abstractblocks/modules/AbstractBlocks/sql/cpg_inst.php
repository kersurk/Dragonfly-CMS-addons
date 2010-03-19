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

class AbstractBlocks {
    //global $special_mname;
    public $radmin;
    public $version;
    public $modname;
    public $description;
    public $author;
    public $website;
    public $dbtables;
    public $spc_prefix;

    // class constructor
    function __construct() {
        global $prefix;

        $this->radmin = true;
        $this->version = '0.1';
        //$this->modname = 'AbstractBlocks';
        $this->modname = basename(dirname(dirname(__FILE__)));
        $this->description = 'Allows admins to select blocks and position them';
        $this->author = 'Madis Liias';
        $this->website = '000.pri.ee';
        $this->prefix = strtolower($this->modname);
        $this->spc_prefix = $prefix.'_'.$this->prefix;
        $this->dbtables = array($this->prefix.'_blocks');
    }

    # module installer
    function install() {
        global $tablelist, $tables, $indexes, $records, $db;
        foreach ($tables AS $table => $columns) {
            if (isset($tablelist[$table])) { $db->query('DROP TABLE '.$tablelist[$table]); }
            db_check::create_table($table, $columns, $indexes[$table]);
        }
        if (is_array($records) && !empty($records)) {
            foreach ($records AS $table => $content) {
                db_check::table_data($table, $content);
            }
        }
        return true;
    }

    # module uninstaller
    function uninstall() {
        global $installer;
        foreach ($this->dbtables as $table) {
            $installer->add_query('DROP', $table);
        }
        return true;
    }

    # module upgrader
    function upgrade($prev_version) {
        global $tablelist, $tables, $indexes, $records, $installer, $db, $prefix;

        foreach ($tables AS $table => $columns) {
            db_check::table_structure($table, $columns, $indexes[$table]);
        }

        if (is_array($records) && !empty($records)) {
            foreach ($records AS $table => $content) {
                db_check::table_data($table, $content);
            }
        }
        return true;
    }
}
