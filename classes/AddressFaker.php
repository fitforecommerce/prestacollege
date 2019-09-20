<?php

class AddressFaker extends AbstractFaker
{
    public $faker;

    public function fake_customer_address($customer)
    {
        $addr = $this->fake_address();
        $addr->id_customer = $customer->id;
        $addr->lastname = $customer->lastname;
        $addr->firstname = $customer->firstname;
        $addr->save();

        return $addr;
    }

    public function fake_address()
    {
        $addr = new Address();
        $addr->alias = $this->aliases()[0];
        $addr->lastname = $this->faker()->lastname;
        $addr->firstname = $this->faker()->firstname;
        $addr->address1 = $this->faker()->streetAddress;
        $addr->postcode = $this->faker()->postcode;
        $addr->city = $this->faker()->city;
        $addr->phone = $this->faker()->phoneNumber;
        // $addr->country = $this->faker()->country;
        $addr->country = 'Deutschland';
        $addr->id_country = $this->id_country();
        $addr->save();

        return $addr;
    }

    private function aliases(){
      $a = array(
        'de' => array("Meine Adresse", "Zuhause")
      );
      $loc = $this->conf['localization'];
      return $a[$loc];
    }
    private function id_country($loc = null)
    {
        if (!is_string($loc)) {
            $loc = $this->conf['localization'];
        }
        $result = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('SELECT `id_country` FROM `'._DB_PREFIX_.'country` WHERE `iso_code` = "'.strtoupper($loc).'";');

        return $result['id_country'];
    }
}
