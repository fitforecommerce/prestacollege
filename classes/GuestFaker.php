<?php

class GuestFaker extends AbstractFaker
{
    public $faker;

    public function fake_guests()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');
        $os_pr = $this->os_probability_ranges();
      
        $output = '<div><p>Faked guests:</p>';
        for ($i = 0; $i < $this->conf['fake_guests_number']; ++$i) {
            $fc = $this->fake_guest();
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<span>Guest created: '.$fc->id.'</span>';
        }
        $output .= '</div>';
        return $output;
    }
    protected function default_conf()
    {
      $conf = array(
        'fake_guests_number' => 100,
      );
      return array_merge(parent::default_conf(), $conf);
    }
    private function fake_guest()
    {
        $guest = new Guest();
        $guest->id_operating_system = $this->fake_os();
        # if($this->in_rnd_range($this->conf['customer_cart_rate'])) {
        #   $cart->id_customer = $cid;
        # }
        $guest->accept_language = $this->faker_localization();
        $guest->save();
        return $guest;
    }
    private function fake_os()
    {
      # $i = mt_rand(0, count($this->operating_systems()) - 1);
      $i = mt_rand(0, $this->max_os_probability());
      foreach ($this->os_probability_ranges() as $k => $r) {
        if($r[0] <= $i && $i <= $r[1]) {
          return $k;
        }
      }
      throw new Exception("Unable to fake os", 1);
    }
    private function os_probability_ranges()
    {
      if(isset($this->os_probability_ranges)) {
        return $this->os_probability_ranges;
      }
      $osp = $this->os_probability();
      $prob = [];
      $i = 0;
      foreach ($osp as $k => $v) {
        $prob[$k] = [$i, $i + $v['probability']];
        $i = $i + $v['probability'];
      }
      $this->os_probability_ranges = $prob;
      return $this->os_probability_ranges;
    }
    private function max_os_probability()
    {
      $pr = $this->os_probability_ranges();
      return end($pr)[1];
    }
    private function os_probability()
    {
      return array (
        1 => array('os' => 'Windows XP', 'probability' => 2),
        2 => array('os' => 'Windows Vista', 'probability' => 3),
        3 => array('os' => 'Windows 7', 'probability' => 2),
        4 => array('os' => 'Windows 8', 'probability' => 2),
        5 => array('os' => 'Windows 8.1', 'probability' => 5),
        6 => array('os' => 'Windows 10', 'probability' => 20),
        7 => array('os' => 'MacOsX', 'probability' => 6 + 14),
        8 => array('os' => 'Linux', 'probability' => 1),
        9 => array('os' => 'Android', 'probability' => 41)
      );
    }
    private function operating_systems()
    {
      if(isset($this->operating_systems)) {
        return $this->operating_systems;
      }
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT *
FROM `' . _DB_PREFIX_ . 'operating_system`');
      $this->operating_systems = $q->fetchAll();
      return $this->operating_systems;
    }
    private function webbrowsers()
    {
      if(isset($this->webbrowsers)) {
        return $this->webbrowsers;
      }
      $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT *
FROM `' . _DB_PREFIX_ . 'web_browser` wb');
      $this->webbrowsers = $q->fetchAll();
      return $this->webbrowsers;
    }
    private function browser_probability()
    {
      return array(
        1 => array('name' => 'Safari', 'probability' => 10),
        2 => array('name' => 'Safari iPad', 'probability' => 6),
        3 => array('name' => 'Firefox', 'probability' => 4),
        4 => array('name' => 'Opera', 'probability' => 1),
        5 => array('name' => 'IE 6', 'probability' => 0),
        6 => array('name' => 'IE 7', 'probability' => 0),
        7 => array('name' => 'IE 8', 'probability' => 0),
        8 => array('name' => 'IE 9', 'probability' => 0),
        9 => array('name' => 'IE 10', 'probability' => 1),
        10 => array('name' => 'IE 11', 'probability' => 2),
        11 => array('name' => 'Chrome', 'probability' => 64)
      );
    }
}
