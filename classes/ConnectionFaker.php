<?php

class ConnectionFaker extends AbstractFaker
{
    public $faker;

    public function fake_connections()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        $output = $this->fake_guests();

        $output = '<div><p>Faked Connections</p>';
        for ($i = 0; $i < $this->conf['fake_connections_number']; ++$i) {
            $fc = $this->fake_connection();
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<span>'.$fc->id_guest.'</span> ';
        }
        $output .= '</div>';
        return $output;
    }

    protected function default_conf()
    {
      $conf = array(
        'fake_connections_number' => 1000,
        'add_datespan_min' => '-1 years',
        'add_datespan_max' => 'now',
      );
      return array_merge(parent::default_conf(), $conf);
    }
    private function fake_guests()
    {
      $gf = new GuestFaker();
      return $gf->fake_guests();
    }
    
    private function fake_connection()
    {
      $fc = new Connection();
      $fc->id_guest = $this->fake_guest();
      $fc->id_page = 1;
      $fc->id_shop = 1;
      $fc->id_shop_group = 1;
      $fc->date_add = $this->random_date(
        $this->conf['add_datespan_min'],
        $this->conf['add_datespan_max']
      );
      $fc->save(false, false);
      return $fc;
    }
    private function fake_guest()
    {
      $i = array_rand($this->guests(), 1);
      $gid = $this->guests()[$i]['id_guest'];
      return $gid;
    }
    private function guests()
    {
      if(isset($this->guests)) {
        return $this->guests;
      }
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT id_guest
FROM `' . _DB_PREFIX_ . 'guest`');
      $this->guests = $q->fetchAll();
      return $this->guests;
    }
}

