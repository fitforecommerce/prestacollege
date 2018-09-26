<?php
/**
* @author Martin Kolb <edi@ediathome.de>
* @copyright 2018 Martin Kolb
*
* based on default template source code from PrestaShop 
* which is released under http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* (c) 2007-2018 PrestaShop SA
*  PrestaShop is an International Registered Trademark & Property of PrestaShop SA
*
* Faker php library is written by François Zaninotto
* Copyright (c) 2011 François Zaninotto
* https://github.com/fzaninotto/Faker
* for license see https://github.com/fzaninotto/Faker/blob/master/LICENSE
* 
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once (dirname(__FILE__).'/classes/AbstractFaker.php');
require_once (dirname(__FILE__).'/classes/CustomerFaker.php');
require_once (dirname(__FILE__).'/classes/AddressFaker.php');
require_once (dirname(__FILE__).'/classes/SnapshotDir.php');
require_once (dirname(__FILE__).'/classes/FakerDatabaseBackup.php');
require_once (dirname(__FILE__).'/classes/FakerDatabaseBackupLoader.php');
require_once (dirname(__FILE__).'/classes/FakerCurler.php');
require_once (dirname(__FILE__).'/classes/FakerDatabaseCurler.php');
require_once (dirname(__FILE__).'/classes/FakerFileCurler.php');
require_once (dirname(__FILE__).'/classes/FakerFileBackup.php');
require_once (dirname(__FILE__).'/classes/FakerFileBackupLoader.php');

class PrestaCollege extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->debug = false;
        $this->name = 'prestacollege';
        $this->tab = 'others';
        $this->version = '0.1.0';
        $this->author = 'Martin Kolb';
        $this->need_instance = 1;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('PrestaCollege');
        $this->description = $this->l('A module for classroom use of Prestashop');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('PRESTACOLLEGE_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader');
    }

    public function uninstall()
    {
        Configuration::deleteByName('PRESTACOLLEGE_LIVE_MODE');

        return parent::uninstall();
    }

    public function fake_customers()
    {
      $conf = array('fake_customers_number' => Tools::getValue('fake_customers_number', ''));
      $faker = new CustomerFaker($conf);
      $output  = '<div class="panel">';
      $output .= "<h2>Now fake some customers</h2>";
      $output .= "<p>CustomerFaker says: '".$faker->fake_customers()."'</p>";
      $output .= '</div>';
      return $output;
    }
    public function create_dbsnapshot()
    {
      $db_backup = new FakerDatabaseBackup();
      $file_backup = new FakerFileBackup();
      $output  = '<div class="panel">';
      $output .= '<h2>Creating a database snapshot</h2>';
      $output .= '<div>FakerDatabaseBackup says: '.$db_backup->add().'</div>';
      $output .= '<div>FakerFileBackup says: '.$file_backup->run().'</div>';
      return $output;
    }
    public function import_dbsnapshot()
    {
      $output  = '<div class="panel">';
      $output .= '<h2>Importing a database snapshot</h2>';
      $output .= '<div>'.$this->dbbackup_loader()->run().'</div>';
      $output .= '</div>';
      return $output;
    }
    public function exportfilesnapshot()
    {
      $file_backup = new FakerFileBackup();
      $output  = '<div class="panel">';
      $output .= '<h2>Exporting a file snapshot</h2>';
      $output .= '<div>Status: '.$file_backup->run().'</div>';
      $output .= '</div>';
      return $output;
    }
    public function importfilesnapshot()
    {
      $output  = '<div class="panel">';
      $output .= '<h2>Importing a file snapshot</h2>';
      $output .= '<div>Status: '.$this->file_backup_loader()->run().'</div>';
      $output .= '</div>';
      return $output;
    }
    public function curldbsnapshot()
    {
      $output  = '<div class="panel">';
      $output .= '<h2>Downloading a database snapshot</h2>';
      $output .= '<div>Status: '.$this->db_curler()->run().'</div>';
      $output .= '</div>';
      return $output;
    }
    public function curlfilesnapshot()
    {
      $output  = '<div class="panel">';
      $output .= '<h2>Downloading a file snapshot</h2>';
      $output .= '<div>Status: '.$this->file_curler()->run().'</div>';
      $output .= '</div>';
      return $output;
    }
    public function getContent()
    {
        $output  = '';
        $action_done = false;
        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign('tpl_dir', $this->local_path.'views/templates/admin');
        $this->context->smarty->assign('form_action_url', $this->admin_link());
        $this->context->smarty->assign('importdbsnapshots', $this->dbbackup_loader()->snapshot_filenames());
        $this->context->smarty->assign('importfilesnapshots', $this->file_backup_loader()->snapshot_filenames());

        $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/panel.tpl');
        if($this->debug) {
          $output .= "<hr><code>".print_r($_REQUEST, true)."</code>";
        }

         # If values have been submitted in the form, process.
        if (((bool)Tools::isSubmit('submitPrestaCollegeModule')) == true) {
          switch (Tools::getValue('PRESTACOLLEGE_ACTION', '')) {
            case 'fakecustomers':
              $output = $this->fake_customers() . $output;
              $action_done = true;
              break;
            case 'createdbsnapshot':
              $output = $this->create_dbsnapshot() . $output;
              $action_done = true;
              break;
            case 'importdbsnapshot':
              $output = $this->import_dbsnapshot(). $output;
              $action_done = true;
              break;
            case 'exportfilesnapshot':
              $output = $this->exportfilesnapshot(). $output;
              $action_done = true;
              break;
            case 'importfilesnapshot':
              $output = $this->importfilesnapshot(). $output;
              $action_done = true;
              break;
            case 'curldbsnapshot':
              $output = $this->curldbsnapshot(). $output;
              $action_done = true;
              break;
            case 'curlfilesnapshot':
              $output = $this->curlfilesnapshot(). $output;
              $action_done = true;
              break;
          }
          if (Tools::getValue('PRESTACOLLEGE_ACTION', '') != '' && !$action_done) {
            $output = "<div class='panel'><div class='alert alert-warning'>Invalid action '".Tools::getValue('PRESTACOLLEGE_ACTION', '')."'</div></div>" . $output;
          }
        }
        return $output;
    }
    private function file_backup_loader()
    {
      if(isset($this->file_backup_loader)) return $this->file_backup_loader;
      $this->file_backup_loader = new FakerFileBackupLoader();
      return $this->file_backup_loader;
    }
    private function dbbackup_loader()
    {
      if(isset($this->db_backup_loader)) return $this->db_backup_loader;
      $this->db_backup_loader = new FakerDatabaseBackupLoader();
      return $this->db_backup_loader;
    }
    private function db_curler()
    {
      if(isset($this->db_curler)) return $this->db_curler;
      $this->db_curler = new FakerDatabaseCurler();
      return $this->db_curler;
    }
    private function file_curler()
    {
      if(isset($this->file_curler)) return $this->file_curler;
      $this->file_curler = new FakerFileCurler();
      return $this->file_curler;
    }
    private function admin_link()
    {
      $this->context->link->getAdminLink('AdminModules', false)
                  .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
    }
    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
      if (Tools::getValue('configure') == $this->name) {
          $this->context->controller->addJS($this->_path.'views/js/back.js');
          $this->context->controller->addCSS($this->_path.'views/css/back.css');
      }
    }
    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        # $this->context->controller->addJS($this->_path.'/views/js/front.js');
        # $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }
}
