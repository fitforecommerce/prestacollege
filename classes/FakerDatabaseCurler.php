<?php
/**
 * A class for downloading DB snapshots from a url
 */
class FakerDatabaseCurler
{
  public function run()
  {
    try {
      $this->curl_file();
    } catch (Exception $e) {
      return "<div class='alert alert-warning'>Error in FakerDatabaseCurler when downloading file <p><code>$e</code></p></div>";
    }
    return "<div class='alert alert-success'>Database snapshot successfully downloaded. You can now install it.</div>";
  }
  private function curl_file()
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->snapshot_user_url());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSLVERSION,3);
    $fdata = curl_exec($ch);
    curl_close($ch);

    $destination = $this->snapshotdir()->dir_path."/test.zip";
    $file = fopen($destination, "w+");
    fputs($file, $fdata);
    fclose($file);
  }
  private function snapshot_user_url()
  {
    return Tools::getValue('dbsnapshotcurlurl');
  }
  private function snapshotdir()
  {
    if(isset($this->snapshotdir)) return $this->snapshotdir;
    $this->snapshotdir = new SnapshotDir(FakerDatabaseBackup::snapshotdir());
    return $this->snapshotdir;
  }
} // END class FakerDatabaseCurler
?>