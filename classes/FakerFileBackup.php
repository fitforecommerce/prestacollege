<?php
/**
* FakerFileBackup provides functionality for exporting Prestashop folders
* as a joined zip file.
*/
class FakerFileBackup
{
    private $zip_file;

    public static function snapshotdir()
    {
        return _PS_MODULE_DIR_.'prestacollege'.DIRECTORY_SEPARATOR.'snapshots_files'.DIRECTORY_SEPARATOR;
    }

    public function run()
    {
        foreach ($this->zip_src_dirs() as $srcdir) {
            $this->process_dir($srcdir);
        }

        return 1;
    }

    private function process_dir($srcdir)
    {
        foreach ($this->dir_iterator(_PS_ROOT_DIR_.$srcdir) as $name => $file) {
            if (!$file->isDir()) {
                $this->add_to_zip_file($file, $srcdir);
            }
        }
    }

    private function add_to_zip_file($file, $srcdir)
    {
        $filePath = $file->getRealPath();
        $relativePath = $srcdir.'/'.substr($filePath, strlen(_PS_ROOT_DIR_.$srcdir) + 1);
        if ($this->is_allowed_file($relativePath)) {
            $this->zip_file()->addFile($filePath, $relativePath);
        }

        return true;
    }

    private function dir_iterator($srcdir)
    {
        return new RecursiveIteratorIterator(
      new RecursiveDirectoryIterator($srcdir),
      RecursiveIteratorIterator::LEAVES_ONLY
    );
    }

    private function zip_src_dirs()
    {
        return array(
      '/img', '/modules',
    );
    }

    private function is_allowed_file($fp)
    {
        foreach ($this->files_blacklist() as $regex) {
            if (preg_match($regex, $fp)) {
                error_log("skipping $fp");

                return false;
            }
        }

        return true;
    }

    private function files_blacklist()
    {
        return array('/\/modules\/prestacollege\/.*/');
    }

    private function zip_file()
    {
        if (isset($this->zip_file)) {
            return $this->zip_file;
        }
        $this->zip_file = new ZipArchive();
        $this->zip_file->open(
      $this->zip_target_path().'/'.$this->zip_filename(),
      ZipArchive::CREATE | ZipArchive::OVERWRITE
    );

        return $this->zip_file;
    }

    private function zip_target_path()
    {
        $backupDir = FakerFileBackup::snapshotdir();
        if (strrpos($backupDir, DIRECTORY_SEPARATOR)) {
            $backupDir .= DIRECTORY_SEPARATOR;
        }

        return $backupDir;
    }

    private function zip_filename()
    {
        // Generate some random number, to make it extra hard to guess backup file names
        $vers = _PS_VERSION_;
        $rand = substr(dechex(mt_rand(0, min(0xffffffff, mt_getrandmax()))), 0, 4);
        $date = date('YmdHis');

        return $vers.'-'.$date.'-'.$rand.'.zip';
    }
}
