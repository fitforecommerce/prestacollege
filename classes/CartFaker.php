<?php

class CartFaker extends AbstractFaker
{
    public $faker;

    function __construct() {
      $this->set_customer_ids();
    }
    public function fake_carts()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        $output = '<ul>';
        for ($i = 0; $i < $this->conf['fake_carts_number']; ++$i) {
            $fc = $this->fake_cart();
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<li>'.$fc->getOrderTotal();
            $output .= '</li>';
        }
        $output .= '</ul>';

        return $output;
    }

    public function fake_cart()
    {
        $cart = new Cart();
        $cart->id_customer = $this->customer_id();
        $cart->id_currency = 1;
        $cart->id_lang = 1;
        $cart->save();

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

        return $cart;
    }
    private function set_customer_ids()
    {
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT `id_customer` FROM `'._DB_PREFIX_.'customer`;');
      $this->all_customer_ids = $q->getAll();
      $this->max_customer_id = count($this->all_customer_ids) - 1;
      return $this->all_customer_ids;
    }
    private function customer_id()
    {
      $cind = random_int(0, $this->max_customer_id);
      return $this->all_customer_ids[$cind];
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
    }
}
