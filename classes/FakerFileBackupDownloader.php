<?php
/**
* FakerFileBackupDownloader initiates a download of a file backup file
*/
class FakerFileBackupDownloader
{

  public $module_path;
  public $backupfile;
  public $snapshotdir;

  public function run()
  {
    $o  = "download cool stuff! from '".$this->module_path."'";
    $o .= $this->download();
    return $o;
  }

  private function download()
  {
    $backupdir = $this->module_path.DIRECTORY_SEPARATOR.$this->snapshotdir;

    // Check the realpath so we can validate the backup file is under the backup directory
    $backupfile = realpath($backupdir.DIRECTORY_SEPARATOR.$this->backupfile);

    error_log("FakerFileBackupDownloader::download backupfile: \n\t'$backupfile' \n\t'".$this->backupfile."'");

    # if ($backupfile === false || strncmp($backupdir, $backupfile, strlen($backupdir)) != 0) {
    #     die(Tools::dieOrLog('The backup file "'.$backupfile.'" does not exist.'));
    # }

    if (substr($backupfile, -4) == '.bz2') {
        $contentType = 'application/x-bzip2';
    } elseif (substr($backupfile, -3) == '.gz') {
        $contentType = 'application/x-gzip';
    } else {
        $contentType = 'text/x-sql';
    }
    $fp = @fopen($backupfile, 'r');

    if ($fp === false) {
        die(Context::getContext()->getTranslator()->trans(
                'Unable to open backup file(s).',
                array(),
                'Admin.Advparameters.Notification'
            ).' "'.addslashes($backupfile).'"'
        );
    }

    // Add the correct headers, this forces the file is saved
    header('Content-Type: '.$contentType);
    header('Content-Disposition: attachment; filename="'.$this->backupfile. '"');

    if (ob_get_level() && ob_get_length() > 0) {
        ob_clean();
    }
    $ret = @fpassthru($fp);

    fclose($fp);

    if ($ret === false) {
        die(Context::getContext()->getTranslator()->trans(
                'Unable to display backup file(s).',
                array(),
                'Admin.Advparameters.Notification'
            ).' "'.addslashes($backupfile).'"'
        );
    }
  }
}
?>