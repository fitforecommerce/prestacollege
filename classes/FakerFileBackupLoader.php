<?php
/**
* FakerFileBackupLoader provides functionality for importing Prestashop folders
* from a zip file created with the FakerFileBackup class.
*/
class FakerFileBackupLoader
{
    private $zip_file;

    public function run()
    {
        $zf = $this->zip_file();

        if(!$zf instanceof ZipArchive) {
          error_log("Unable to create ZipArchive object in FakerFileBackupLoader!!!");
          return "Unable to create ZipArchive object in FakerFileBackupLoader";
        }
        if($zf->numFiles==0) {
          $msg = "Empty ZipArchive object created in FakerFileBackupLoader ".$this->debug_zip_file($zf);
          error_log($msg);
          $msg = "<div class='alert alert-danger'>$msg</div>";
          return $msg;
        }

        $zf->extractTo(_PS_ROOT_DIR_);

        return "<div class='alert alert-success'>File snapshot successfully imported. Remember to clear caches afterwards.</div>";
    }

    public function snapshot_filenames()
    {
        return $this->snapshotdir()->snapshot_filenames();
    }

    private function zip_file()
    {
        if (isset($this->zip_file)) {
            return $this->zip_file;
        }
        $this->zip_file = new ZipArchive();
        $this->zip_file->open($this->snapshot_user_choice());

        return $this->zip_file;
    }

    private function snapshot_user_choice()
    {
        return $this->snapshotdir()->dir_path.Tools::getValue('snapshot');
    }

    private function debug_zip_file()
    {
        $rv = '';
        for ($i = 0; $i < $zf->numFiles; ++$i) {
            $stat = $zf->statIndex($i);
            $rv = $rv.'<p>'.$stat['name'].'</p>';
        }

        return $rv;
    }

    private function snapshotdir()
    {
        if (isset($this->snapshotdir)) {
            return $this->snapshotdir;
        }
        $this->snapshotdir = new SnapshotDir(FakerFileBackup::snapshotdir());

        return $this->snapshotdir;
    }
}
