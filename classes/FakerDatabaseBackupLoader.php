<?php
/**
* Class for loading a Database snapshot into the database
*/
class FakerDatabaseBackupLoader
{

  public function run()
  {
    $qstring = $this->load_snapshot();
    if(!$qstring) return "ERROR in FakerDatabaseBackupLoader: Unable to load snapshot! No querystring";
    try {
      $result = DB::getInstance()->query($qstring);
    } catch (PrestaShopDatabaseException $e) {
      return "<div class='alert alert-warning'>Error in FakerDatabaseBackupLoader <p><code>$e</code></p></div>";
    }
    return "<div class='alert alert-success'>Database snapshot successfully imported. Remember to clear caches afterwards.</div>";
  }
  public function snapshot_filenames()
  {
    return $this->snapshotdir()->snapshot_filenames();
  }
  private function snapshot_user_choice()
  {
    return $this->snapshotdir()->dir_path.Tools::getValue('dbsnapshotname');
  }
  private function load_snapshot()
  {
    return $this->snapshotdir()->load_snapshot_file_contents($this->snapshot_user_choice());
  }
  private function snapshotdir()
  {
    if(isset($this->snapshotdir)) return $this->snapshotdir;
    $this->snapshotdir = new SnapshotDir(FakerDatabaseBackup::snapshotdir());
    return $this->snapshotdir;
  }
}
?>