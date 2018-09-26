<?php
/**
 * A class for downloading DB snapshots from a url
 */
class FakerFileCurler extends FakerCurler
{
  protected function snapshot_user_url()
  {
    return Tools::getValue('filesnapshotcurlurl');
  }
  protected function snapshotdir()
  {
    if(isset($this->snapshotdir)) return $this->snapshotdir;
    $this->snapshotdir = new SnapshotDir(FakerFileBackup::snapshotdir());
    return $this->snapshotdir;
  }
} // END class FakerDatabaseCurler
?>