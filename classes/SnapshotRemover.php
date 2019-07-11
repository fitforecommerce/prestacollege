<?php
  
/**
 * A class for removing snapshots from the snapshots dir
 *
 * @author Martin Kolb
 */
class SnapshotRemover
{
  public $action;

  public function __construct($config) {
    $this->action = $config['action'];
  }

  public function run()
  {
    return $this->delete_snapshot();
  }

  private function delete_snapshot()
  {
    $newName = Tools::getValue('snapshot', '');
    $trg = $this->snapshotdir().$newName;

    if(!file_exists($trg)) {
      throw new Exception("Unable to locate file $newName", 1);
    }
    try {
      unlink($trg);
      return true;
    } catch(Exception $e) {
      throw new Exception("Error when trying to delete the file $newName: ".$e->getMessage(), 1);
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
    return $this->snapshotdir;
  }
} // END class SnapshotUploader
?>