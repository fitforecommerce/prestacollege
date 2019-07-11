<?php
  
/**
 * A class for upload snapshots from the user's PC
 *
 * @author Martin Kolb
 */
class SnapshotUploader
{
  public $action;

  public function __construct($config) {
    $this->action = $config['action'];
  }

  public function run()
  {
    return $this->upload_snapshot();
  }

  private function upload_snapshot()
  {
    $newName = $_FILES['snapshotfile']['name'];

    $uploader = new Uploader('snapshotfile');
    $uploader->setSavePath($this->snapshotdir());
    $files = $uploader->process();
    error_log("SnapshotUploader::upload_snapshot ".print_r($files, true));
    error_log("\tfile type: ".Tools::strtolower(pathinfo($files[0]['name'], PATHINFO_EXTENSION)));
    error_log("\tallowed types: ".implode(', ', $this->accept_types()));
    if(in_array(Tools::strtolower(pathinfo($files[0]['name'], PATHINFO_EXTENSION)), $this->accept_types())) {
      $trg = $this->snapshotdir().$newName;
      rename($files[0]['save_path'], $this->snapshotdir().$newName);
      return true;
    } else {
      throw new Exception("Received invalid file type. Make sure file type is of ".implode(', ', $this->accept_types()), 1);
    }
  }

  private function accept_types()
  {
    if($this->action=='db') {
      return array('bz2');
    }
    return array('zip');
  }
  private function snapshotdir()
  {
    if(isset($this->snapshotdir)) {
      return $this->snapshotdir;
    }
    if($this->action=='db') {
      $this->snapshotdir = FakerDatabaseBackup::snapshotdir();
    } else {
      $this->snapshotdir = FakerFileBackup::snapshotdir();
    }
  }
} // END class SnapshotUploader
?>