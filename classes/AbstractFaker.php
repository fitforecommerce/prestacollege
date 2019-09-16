<?php

abstract class AbstractFaker
{
    public $conf;

    public function __construct($conf = null)
    {
        if (!is_array($conf)) {
            $conf = array();
        }
        $this->conf = array_merge($this->default_conf(), $conf);
    }

    protected function default_conf()
    {
      return array(
        'localization' => 'de',
      );
    }

    protected function faker()
    {
        if (isset($this->faker)) {
            return $this->faker;
        }
        $this->faker = Faker\Factory::create($this->faker_localization());

        return $this->faker;
    }

    protected function faker_localization()
    {
        $loc = strtolower($this->conf['localization']);
        $loc .= '_'.strtoupper($this->conf['localization']);

        return $loc;
    }
    protected function random_date($diff_min = '-5 years', $diff_max = 'now', $f = "Y-m-d H:i:s")
    {
        $fd      = $this->faker()->dateTimeBetween($diff_min, $diff_max, $timezone = null);
        return $fd->format($f);
    }
    protected function g_rand()
    {
      $peak         = 40; // Peak at 10-o-clock
      $stdev        = 30; // Standard deviation of two hours
      $hoursOnClock = 90; // 24-hour clock

      do // Generate gaussian variable using Box-Muller
      {
          $u = 2.0 * mt_rand() / mt_getrandmax()-1.0;
          $v = 2.0*mt_rand() / mt_getrandmax() -1.0;
          $s = $u * $u + $v * $v;
      } while ($s > 1);

      $gauss = $u * sqrt(-2.0 * log($s) / $s);

      $gauss = $gauss * $stdev + $peak; // Transform to correct peak and standard deviation

      while ($gauss < 0) $gauss+=$hoursOnClock; // Wrap around hours to keep the random time 
      $result = fmod($gauss,$hoursOnClock);     // on the clock

      return $result;
    }
}
