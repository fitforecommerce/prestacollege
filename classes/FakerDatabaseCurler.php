<?php
/**
 * A class for downloading DB snapshots from a url.
 */
class FakerDatabaseCurler extends FakerCurler
{
    protected function snapshot_user_url()
    {
        return Tools::getValue('dbsnapshotcurlurl');
    }

    protected function snapshotdir()
    {
        if (isset($this->snapshotdir)) {
            return $this->snapshotdir;
        }
        $this->snapshotdir = new SnapshotDir(FakerDatabaseBackup::snapshotdir());

        return $this->snapshotdir;
    }
} // END class FakerDatabaseCurler
