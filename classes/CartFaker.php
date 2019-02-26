<?php

class CartFaker extends AbstractFaker
{
    public $faker;

    public function fake_carts()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        $output = '<ul>';
        for ($i = 0; $i < $this->conf['fake_carts_number']; ++$i) {
            $fc = $this->fake_cart();
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<li>'.print_r($fc, true);
            $output .= '</li>';
        }
        $output .= '</ul>';

        return $output;
    }

    public function fake_cart()
    {
        $cart = new Cart();
        $cart->id_currency = 1;
        $cart->id_lang = 1;

        $cart->updateQty(
          $this->quantity(),      # quantity
          $this->product_id(),    # $id_product
          null,                   # id_product_attribute
          false,                  # id_customization
          'up',                   # operator
          0,                      # $id_address_delivery
          null,                   # shop
          true,                   # auto_add_cart_rule
          false                   # skipAvailabilityCheckOutOfStock
        );
        # $cart->id_customer = $customer->id;
        # $cart->lastname = $customer->lastname;
        # $cart->firstname = $customer->firstname;
        $cart->save();

        return $cart;
    }

    public function fake_address()
    {
        $addr = new Cart();
        # $addr->lastname = $this->faker()->lastname;
        # $addr->firstname = $this->faker()->firstname;
        # $addr->alias = $addr->firstname.'_'.$addr->lastname;
        # $addr->address1 = $this->faker()->streetAddress;
        # $addr->postcode = $this->faker()->postcode;
        # $addr->city = $this->faker()->city;
        # // $addr->country = $this->faker()->country;
        # $addr->country = 'Deutschland';
        # $addr->id_country = $this->id_country();
        $addr->save();

        return $addr;
    }

    private function quantity()
    {
      return random_int(1, 20);
    }
    private function product_id()
    {
      return 23;
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
