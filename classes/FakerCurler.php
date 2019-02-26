<?php
/**
 * A class for downloading files via curl.
 */
class FakerCurler
{
    public function __construct()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');
    }

    public function run()
    {
        try {
            $this->curl_file();
        } catch (Exception $e) {
            return "<div class='alert alert-warning'>Error in FakerCurler when downloading file <p><code>$e</code></p></div>";
        }

        return "<div class='alert alert-success'>Snapshot successfully downloaded. You can now install it.</div>";
    }

    protected function curl_file()
    {
        $destination = $this->snapshotdir()->dir_path.'/'.$this->filename();
        $destination = trim($destination);

        $file = fopen($destination, 'w+');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($this->snapshot_user_url()));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $file);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);

        fclose($file);
    }

    protected function snapshotdir()
    {
        return false;
    }

    private function filename()
    {
        $parts = parse_url($this->snapshot_user_url());
        $str = basename($parts['path']);
        error_log($str);

        return $str;
    }
} // END class FakerCurler
