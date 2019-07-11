<?php
/**
 * A class for representing a snapshot dir.
 */
class SnapshotDir
{
    public function __construct($dir_path)
    {
        $this->dir_path = $dir_path;
    }

    public function snapshot_filenames()
    {
        $snf = $this->snapshot_file_paths();
        foreach ($snf as $i => $fp) {
            $snf[$i] = array(basename($fp), SnapshotDir::human_filesize(filesize($fp)));
        }

        return $snf;
    }

    private function snapshot_file_paths()
    {
        $d = dir($this->dir_path);
        if (!$d) {
            return false;
        }

        $rv = array();
        while (false !== ($entry = $d->read())) {
            if (!preg_match('/^\.+/', $entry)) {
                $rv[] = $d->path.$entry;
            }
        }
        $d->close();

        return $rv;
    }

    public function load_snapshot_file_contents($fp)
    {
        if (preg_match('/\.bz2$/', $fp)) {
            return $this->read_bzfile($fp);
        } elseif (preg_match('/\.gz$/', $fp)) {
            return $this->read_gzfile($fp);
        }

        return file_get_contents();
    }

    private function read_bzfile($fp)
    {
        $bzfile = bzopen($fp, 'r');
        $decompressed_file = '';
        while (!feof($bzfile)) {
            $decompressed_file .= bzread($bzfile, 4096);
        }
        bzclose($bzfile);
        error_log("SnapshotDir::read_bzfile $decompressed_file");

        return $decompressed_file;
    }

    private function read_gzfile($fp)
    {
        $file = fopen($fp, 'rb');
        fseek($file, -4, SEEK_END);
        $buf = fread($file, 4);
        $gz_file_size = end(unpack('V', $buf));
        fclose($file);

        $gzfile = gzopen($fp, 'rb');
        $decompressed_file = gzread($gzfile, $gz_file_size);
        error_log("SnapshotDir::read_gzfile $decompressed_file");

        return $decompressed_file;
    }
    public static function  human_filesize($bytes, $decimals = 2) {
      $sz = 'BKMGTP';
      $factor = floor((strlen($bytes) - 1) / 3);
      $d = (empty($factor))?0:$decimals;
      return sprintf("%.{$d}f", $bytes / pow(1024, $factor)) . " ". ((!empty($factor))?@$sz[(int)$factor]:"");
    }
}
