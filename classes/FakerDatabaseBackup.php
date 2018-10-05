<?php
/**
* code based on Prestashop class PrestaShopBackupCore
* (c) 2007-2018 PrestaShop SA.
*/
class FakerDatabaseBackup extends PrestaShopBackupCore
{
    public static function snapshotdir()
    {
        return _PS_MODULE_DIR_.'prestacollege'.DIRECTORY_SEPARATOR.'snapshots_db'.DIRECTORY_SEPARATOR;
    }

    public function __construct()
    {
        parent::__construct();
        $this->psBackupAll = 0;
        $this->psBackupDropTable = 1;
    }

    public function add()
    {
        $ignoreInsertTable = $this->ignore_insert_table();
        $ignoreDrops = $this->ignore_drop_table();

        // Generate some random number, to make it extra hard to guess backup file names
        $vers = _PS_VERSION_;
        $rand = substr(dechex(mt_rand(0, min(0xffffffff, mt_getrandmax()))), 0, 4);
        $date = date('YmdHis');
        $backupfile = FakerDatabaseBackup::snapshotdir().$vers.'-'.$date.'-'.$rand.'.sql';

        // Figure out what compression is available and open the file
        if (function_exists('bzopen')) {
            $backupfile .= '.bz2';
            $fp = @bzopen($backupfile, 'w');
        } elseif (function_exists('gzopen')) {
            $backupfile .= '.gz';
            $fp = @gzopen($backupfile, 'w');
        } else {
            $fp = @fopen($backupfile, 'w');
        }

        if (false === $fp) {
            echo Context::getContext()->getTranslator()->trans('Unable to create backup file', array(), 'Admin.Advparameters.Notification').' "'.addslashes($backupfile).'"';

            return false;
        }

        error_log('<p>FakerDatabaseBackup:: backupfile: '.$backupfile);
        $this->id = realpath($backupfile);

        fwrite($fp, '/* Backup for '.Tools::getHttpHost(false, false).__PS_BASE_URI__."\n *  at ".date($date)."\n */\n");
        fwrite($fp, "\n".'SET NAMES \'utf8\';');
        fwrite($fp, "\n".'SET FOREIGN_KEY_CHECKS = 0;');
        fwrite($fp, "\n".'SET SESSION sql_mode = \'\';'."\n\n");

        // Find all tables
        $tables = Db::getInstance()->executeS('SHOW TABLES');
        $found = 0;
        foreach ($tables as $table) {
            $table = current($table);

            // Skip tables which do not start with _DB_PREFIX_
            if (strlen($table) < strlen(_DB_PREFIX_) || 0 != strncmp($table, _DB_PREFIX_, strlen(_DB_PREFIX_))) {
                continue;
            }

            // Export the table schema
            $schema = Db::getInstance()->executeS('SHOW CREATE TABLE `'.$table.'`');

            if (1 != count($schema) || !isset($schema[0]['Table']) || !isset($schema[0]['Create Table'])) {
                fclose($fp);
                $this->delete();
                echo Context::getContext()->getTranslator()->trans('An error occurred while backing up. Unable to obtain the schema of %s', array($table), 'Admin.Advparameters.Notification');

                return false;
            }

            fwrite($fp, '/* Scheme for table '.$schema[0]['Table']." */\n");

            if ($this->psBackupDropTable && !in_array($schema[0]['Table'], $ignoreDrops)) {
                fwrite($fp, 'DROP TABLE IF EXISTS `'.$schema[0]['Table'].'`;'."\n");
            }
            if (!in_array($schema[0]['Table'], $ignoreDrops)) {
                fwrite($fp, $schema[0]['Create Table'].";\n\n");
            }

            if (!in_array($schema[0]['Table'], $ignoreInsertTable)) {
                $data = Db::getInstance()->query('SELECT * FROM `'.$schema[0]['Table'].'`', false);
                $sizeof = DB::getInstance()->NumRows();
                $lines = explode("\n", $schema[0]['Create Table']);

                if ($data && $sizeof > 0) {
                    // Export the table data
                    fwrite($fp, 'INSERT INTO `'.$schema[0]['Table']."` VALUES\n");
                    $i = 1;
                    while ($row = DB::getInstance()->nextRow($data)) {
                        $s = '(';

                        foreach ($row as $field => $value) {
                            $tmp = "'".pSQL($value, true)."',";
                            if ("''," != $tmp) {
                                $s .= $tmp;
                            } else {
                                foreach ($lines as $line) {
                                    if (false !== strpos($line, '`'.$field.'`')) {
                                        if (preg_match('/(.*NOT NULL.*)/Ui', $line)) {
                                            $s .= "'',";
                                        } else {
                                            $s .= 'NULL,';
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                        $s = rtrim($s, ',');

                        if (0 == $i % 200 && $i < $sizeof) {
                            $s .= ");\nINSERT INTO `".$schema[0]['Table']."` VALUES\n";
                        } elseif ($i < $sizeof) {
                            $s .= "),\n";
                        } else {
                            $s .= ");\n";
                        }

                        fwrite($fp, $s);
                        ++$i;
                    }
                }
            } else {
                error_log("\tignoring: ".$schema[0]['Table']);
            }
            ++$found;
        }

        fclose($fp);
        if (0 == $found) {
            $this->delete();
            echo Context::getContext()->getTranslator()->trans('No valid tables were found to backup.', array(), 'Admin.Advparameters.Notification');

            return false;
        }

        return true;
    }

    protected function ignore_insert_table()
    {
        if ($this->psBackupAll) {
            return array();
        }

        return array(
      _DB_PREFIX_.'connections',
      _DB_PREFIX_.'connections_page',
      _DB_PREFIX_.'connections_source',
      _DB_PREFIX_.'guest',
      _DB_PREFIX_.'statssearch',
      _DB_PREFIX_.'shop_url',
      _DB_PREFIX_.'contact',
      _DB_PREFIX_.'employee',
      _DB_PREFIX_.'employee_shop',
      _DB_PREFIX_.'access',
      _DB_PREFIX_.'configuration',
    );
    }

    protected function ignore_drop_table()
    {
        if ($this->psBackupAll) {
            return array();
        }

        return array(
      _DB_PREFIX_.'shop_url',
      _DB_PREFIX_.'contact',
      _DB_PREFIX_.'employee',
      _DB_PREFIX_.'employee_shop',
      _DB_PREFIX_.'access',
      _DB_PREFIX_.'configuration',
    );
    }

    protected function ignore_table_values()
    {
        if ($this->psBackupAll) {
            return array();
        }

        return array(
      array('table' => _DB_PREFIX_.'configuration', 'fieldname' => 'name', 'value' => 'PS_SHOP_DOMAIN'),
      array('table' => _DB_PREFIX_.'configuration', 'fieldname' => 'name', 'value' => 'PS_SHOP_DOMAIN_SSL'),
      array('table' => _DB_PREFIX_.'configuration', 'fieldname' => 'name', 'value' => 'PS_SHOP_EMAIL'),
    );
    }
}
