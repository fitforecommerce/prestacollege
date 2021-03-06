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
*/
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once dirname(__FILE__).'/classes/AbstractFaker.php';
require_once dirname(__FILE__).'/classes/CustomerFaker.php';
require_once dirname(__FILE__).'/classes/CartFaker.php';
require_once dirname(__FILE__).'/classes/AddressFaker.php';
require_once dirname(__FILE__).'/classes/GuestFaker.php';
require_once dirname(__FILE__).'/classes/ConnectionFaker.php';
require_once dirname(__FILE__).'/classes/SnapshotDir.php';
require_once dirname(__FILE__).'/classes/FakerDatabaseBackup.php';
require_once dirname(__FILE__).'/classes/FakerDatabaseBackupLoader.php';
require_once dirname(__FILE__).'/classes/FakerCurler.php';
require_once dirname(__FILE__).'/classes/FakerDatabaseCurler.php';
require_once dirname(__FILE__).'/classes/FakerFileCurler.php';
require_once dirname(__FILE__).'/classes/FakerFileBackup.php';
require_once dirname(__FILE__).'/classes/FakerFileBackupDownloader.php';
require_once dirname(__FILE__).'/classes/FakerFileBackupLoader.php';
require_once dirname(__FILE__).'/classes/SnapshotUploader.php';
require_once dirname(__FILE__).'/classes/SnapshotRemover.php';
require_once dirname(__FILE__).'/classes/JamandoJSONSource.php';

class PrestaCollege extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->debug = false;
        $this->name = 'prestacollege';
        $this->tab = 'others';
        $this->version = '0.7.0';
        $this->author = 'Martin Kolb';
        $this->need_instance = 1;

        /*
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
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update.
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

    public function fake_carts_form()
    {
      $cart_faker = new CartFaker();
      $cartfaker_labels = array(
        'fake_carts_number' => $this->l('Number of carts'),
        'customer_cart_rate'  => $this->l('Share of carts from logged-in customers'),
        'minimum_item_quantity' => $this->l('Minimum quantity per order item'), # minimum order quantity
        'maximum_item_quantity' => $this->l('Maximum quantity per order item'), # maximum order quantity
        'minimum_order_items'  => $this->l('Minimum items per order'),
        'maximum_order_items'  => $this->l('Maximum items per order'),
        'id_currency' => $this->l('Currency id'),      # currency id
        'id_lang' => $this->l('Language id'),          # language id
        'add_datespan_min' => $this->l('Orders placed after (e.g. "-30 days")'),
        'add_datespan_max' => $this->l('Orders placed before (e.g. "now")'),
        'upd_timediff_min' => $this->l('Minimum time for last cart update (in sec)'),
        'upd_timediff_max' => $this->l('Maximum time for last cart update (in sec)'),
      );
      $this->context->smarty->assign('cartfaker_def', $cart_faker->conf);
      $this->context->smarty->assign('cartfaker_labels', $cartfaker_labels);

      $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/fake_carts_form.tpl');
      return $output;
    }
    public function fakecarts()
    {
        $conf = array('fake_carts_number' => Tools::getValue('fake_carts_number', ''));
        $faker = new CartFaker($conf);
        $faker->get_conf_values();
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Fake Carts').'</h2>';
        $output .= '<div>'.$this->l('Creating the following fake carts').$faker->fake_carts().'</div>';
        $output .= '</div>';

        return $output;
    }

    public function fake_customers_form()
    {
      $customer_faker = new CustomerFaker();
      $custfaker_labels = array(
        'fake_customers_number' => $this->l('Number of customers'),
        'female_customer_rate' => $this->l('Female customer rate'),
        'visitor_rate' => $this->l('Visitor rate'),
        'guest_rate' => $this->l('Guest rate'),
        'banned_rate' => $this->l('Banned user rate'),
        'company_rate' => $this->l('Company customer rate'),
        'newsletter_rate' => $this->l('Newsletter subscription rate'),
        'optin_rate' => $this->l('Newsletter optin rate'),
        'second_address_rate' => $this->l('Second address rate'),
        'birthday_given_rate' => $this->l('Birthday given rate'),
        'max_age' => $this->l('Maximum age'),
        'profile_add_min' => $this->l('Earliest profile add date (e.g. "-1 year")'),
        'profile_add_max' => $this->l('Latest profile add date (e.g. "now")'),
      );
      $this->context->smarty->assign('custfaker_def', $customer_faker->conf);
      $this->context->smarty->assign('custfaker_labels', $custfaker_labels);

      $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/fake_customers_form.tpl');

      return $output;
    }
    public function fakecustomers()
    {
        $faker = new CustomerFaker();
        $faker->get_conf_values();
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Fake Customers').'</h2>';
        $output .= '<div>'.$this->l('Creating the following fake customers').$faker->fake_customers().'</div>';
        $output .= '</div>';

        return $output;
    }

    public function fake_connections_form()
    {
      $conn_faker = new ConnectionFaker();
      $connfaker_labels = array(
        'fake_connections_number' => 'Number of fake connections',
        'add_datespan_min' => $this->l('Connections after (e.g. "-30 days")'),
        'add_datespan_max' => $this->l('Connections before (e.g. "now")'),
      );
      $this->context->smarty->assign('connfaker_def', $conn_faker->conf);
      $this->context->smarty->assign('connfaker_labels', $connfaker_labels);

      $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/fake_connections_form.tpl');
      return $output;
    }
    public function fakeconnections()
    {
        $faker = new ConnectionFaker();
        $faker->get_conf_values();
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Fake Connections').'</h2>';
        $output .= '<div>'.$this->l('Creating the following fake connections').$faker->fake_connections().'</div>';
        $output .= '</div>';

        return $output;
    }
    public function createdbsnapshot()
    {
        $db_backup = new FakerDatabaseBackup();
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Creating a database snapshot').'</h2>';
        if($db_backup->add()) {
          $output .= '<div class="alert-success">'.$this->l('Snapshot successfully created').'</div>';
        } else {
          $output .= '<div class="alert-error">'.$this->l('An error occured when creating the snapshot').'</div>';
        }
        $output .= '</div>';

        return $output;
    }

    public function importdbsnapshot()
    {
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Importing a database snapshot').'</h2>';
        if($this->dbbackup_loader()->run()) {
          $output .= '<div class="alert-success">'.$this->l('Snapshot successfully imported').'</div>';
        } else {
          $output .= '<div class="alert-error">'.$this->l('An error occured when importing the snapshot').'</div>';
        }
        $output .= '</div>';

        return $output;
    }

    public function createfilesnapshot()
    {
        $file_backup = new FakerFileBackup();
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Exporting a file snapshot').'</h2>';
        if($file_backup->run()) {
          $output .= '<div class="alert-success">'.$this->l('Snapshot successfully created').'</div>';
        } else {
          $output .= '<div class="alert-error">'.$this->l('An error occured when creating the snapshot').'</div>';
        }
        $output .= '</div>';

        return $output;
    }

    public function importfilesnapshot()
    {
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Importing a file snapshot').'</h2>';
        $output .= '<div>Status: '.$this->file_backup_loader()->run().'</div>';
        $output .= '</div>';

        return $output;
    }

    public function downloaddbsnapshot()
    {
      $output = '<div class="panel">';
      $output .= '<h2>'.$this->l('Downloading a database snapshot').'</h2>';
      $output .= '<div>Status: '.$this->file_backup_downloader('snapshots_db')->run().'</div>';
      $output .= '</div>';

      return $output;
    }
    public function downloadfilesnapshot()
    {
      $output = '<div class="panel">';
      $output .= '<h2>'.$this->l('Downloading a file snapshot').'</h2>';
      $output .= '<div>Status: '.$this->file_backup_downloader('snapshots_files')->run().'</div>';
      $output .= '</div>';

      return $output;
    }
    public function administer_filesnapshots()
    {
      $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/file_snapshot.tpl');
      return $output;
    }

    public function administer_dbsnapshots()
    {
      $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/db_snapshot.tpl');
      return $output;
    }
    public function curldbsnapshot()
    {
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Downloading a database snapshot').'</h2>';
        $output .= '<div>Status: '.$this->db_curler()->run().'</div>';
        $output .= '</div>';

        return $output;
    }

    public function curlfilesnapshot()
    {
        $output = '<div class="panel">';
        $output .= '<h2>'.$this->l('Downloading a file snapshot').'</h2>';
        $output .= '<div>Status: '.$this->file_curler()->run().'</div>';
        $output .= '</div>';

        return $output;
    }
    public function curljamandosnapshot()
    {
      $json_ds = new JamandoJSONSource();
      $curl_urls = $json_ds->curl_urls();
      $curldb = Tools::getValue('curldb', 0);
      $curlfile = Tools::getValue('curlfile', 0);

      $output = '<div class="panel">';
      $output .= '<h2>'.$this->l('Downloading database snapshot').'</h2>';

      if($curldb && isset($curl_urls['db']) && $curl_urls['db']!='') {
        $output .= '<div>Status: '.$this->db_curler()->run($curl_urls['db']).'</div>';
      }
      if($curlfile && isset($curl_urls['files']) && $curl_urls['files']!='') {
        $output .= '<div>Status: '.$this->file_curler()->run($curl_urls['files']).'</div>';
      }
      # $output .= '<div>Status: '.$this->jamando_curler()->run().'</div>';
      $output .= '</div>';

      return $output;
    }
    public function removedbsnapshot()
    {
      $sr = new SnapshotRemover(array('action' => 'db'));
      return $this->run_remove_snapshot($sr);
    }
    public function removefilesnapshot()
    {
      $sr = new SnapshotRemover(array('action' => 'file'));
      return $this->run_remove_snapshot($sr);
    }
    private function run_remove_snapshot($sr)
    {
      $o = '';
      try {
        $sr->run();
        $o .= '<div class="alert alert-success">'.$this->l('Successfully deleted the snapshot').'</div>';
      } catch (Exception $e) {
        $o .= '<div class="alert alert-warning">'.$this->l('There was an error deleting the file.').'<p><code>'.$e->getMessage().'</code></p></div>';
      }
      return $o;
    }
    public function uploaddbsnapshot()
    {
      # $o = "<p>uploaddbsnapshot()</p><blockquote>".print_r($_POST, true)."</blockquote><blockquote>".print_r($_FILES, true)."</blockquote>";
      $o = '';
      $su = new SnapshotUploader(array('action' => 'db'));
      return $this->run_upload($su);
    }
    public function uploadfilesnapshot()
    {
      # $o = "<p>uploafilebsnapshot()</p><blockquote>".print_r($_POST, true)."</blockquote><blockquote>".print_r($_FILES, true)."</blockquote>";
      $o = '';
      $su = new SnapshotUploader(array('action' => 'file'));
      return $this->run_upload($su);
    }
    private function run_upload($su)
    {
      $o = '';
      try {
        $su->run();
        $o .= '<div class="alert alert-success">'.$this->l('Successfully uploaded the snapshot').'</div>';
      } catch (Exception $e) {
        $o .= '<div class="alert alert-warning">'.$this->l('There was an error uploading the file. Please check that your max_upload_size and post_max_size values in your php.ini and your Prestashop settings are set to allow bigger uploads!').'<p><code>'.$e->getMessage().'</code></p></div>';
      }
      return $o;
    }
    public function uploaddbsnapshotselect()
    {
      return $this->upload_select('db');
    }
    public function uploadfilesnapshotselect()
    {
      return $this->upload_select('file');
    }
    public function loaddbjamandosnapshot()
    {
      $json_ds = new JamandoJSONSource();
      $this->context->smarty->assign('json', $json_ds->json());

      # $output = '<div class="panel"><code>json: "'.print_r($json_ds->json(), true).'"</code></div>';

      $output  = '<div class="panel">';
      $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/modal_jamando_upload.tpl');
      $output .= '</div>';
      return $output;
    }
    
    private function upload_select($action='db')
    {
      $this->context->smarty->assign('curlaction', $action);
      $this->context->smarty->assign('max_upload_size', ini_get('post_max_size'));

      $output = '<div class="panel">';
      $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/modal_upload.tpl');
      $output .= '</div>';
      return $output;
    }
    public function getContent()
    {
        $output = '';
        $action_done = false;
        $action = Tools::getValue('PRESTACOLLEGE_ACTION', '');

        $this->context->smarty->assign('module_dir', $this->_path);
        $this->context->smarty->assign('tpl_dir', $this->local_path.'views/templates/admin');
        $this->context->smarty->assign('form_action_url', $this->admin_link());
        $this->context->smarty->assign('importdbsnapshots', $this->dbbackup_loader()->snapshot_filenames());
        $this->context->smarty->assign('importfilesnapshots', $this->file_backup_loader()->snapshot_filenames());

        if ($this->debug) {
            $output .= '<hr><code>'.print_r($_REQUEST, true).'</code>';
        }
        if($action!='' && in_array($action, $this->fullscreen_functions())) {
          $output .= "<a href='".$this->admin_link()."'><< ".$this->l('Go back')."…</a>";                
        } else {
          $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/panel.tpl');
        }

        // If values have been submitted in the form, process.
        if (Tools::getValue('PRESTACOLLEGE_ACTION')) {
          if (method_exists($this, $action)) {
            $output = call_user_func(array($this, $action)) . $output;
            $action_done = true;
          } else {
            $output  = "<div class='panel'><div class='alert alert-warning'>".$this->l('Invalid action');
            $output .= " '".Tools::getValue('PRESTACOLLEGE_ACTION', '')."'</div></div>" . $output;
          }
        }

        return $output;
    }

    private function fullscreen_functions()
    {
      return array('uploadfilesnapshotselect', 'uploaddbsnapshotselect', 'curlfilesnapshot', 'curldbsnapshot',
        'createfilesnapshot', 'createdbsnapshot', 'removedbsnapshot', 'removefilesnapshot', 'uploafilebsnapshot', 'uploaddbsnapshot',
        'fakecarts', 'loaddbjamandosnapshot', 'curljamandosnapshot',
        'fake_customers_form', 'fake_carts_form', 'fake_connections_form',
        'administer_dbsnapshots', 'administer_filesnapshots'
      );
    }

    private function file_backup_downloader($sdir='snapshots_db')
    {
      if (isset($this->file_backup_downloader)) {
        $this->file_backup_downloader->snapshotdir = $sdir;
        return $this->file_backup_downloader;
      }
      $this->file_backup_downloader = new FakerFileBackupDownloader();
      $this->file_backup_downloader->module_path = $this->local_path;
      $this->file_backup_downloader->backupfile = Tools::getValue('snapshot');
      $this->file_backup_downloader->snapshotdir = $sdir;

      return $this->file_backup_downloader;
    }
    private function file_backup_loader()
    {
        if (isset($this->file_backup_loader)) {
            return $this->file_backup_loader;
        }
        $this->file_backup_loader = new FakerFileBackupLoader();

        return $this->file_backup_loader;
    }

    private function dbbackup_loader()
    {
        if (isset($this->db_backup_loader)) {
            return $this->db_backup_loader;
        }
        $this->db_backup_loader = new FakerDatabaseBackupLoader();

        return $this->db_backup_loader;
    }

    private function db_curler()
    {
        if (isset($this->db_curler)) {
            return $this->db_curler;
        }
        $this->db_curler = new FakerDatabaseCurler();

        return $this->db_curler;
    }

    private function file_curler()
    {
        if (isset($this->file_curler)) {
            return $this->file_curler;
        }
        $this->file_curler = new FakerFileCurler();

        return $this->file_curler;
    }

    private function admin_link()
    {
        return $this->context->link->getAdminLink('AdminModules', true)
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
        // $this->context->controller->addJS($this->_path.'/views/js/front.js');
        // $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }
}
