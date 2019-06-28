<?php

class CartFaker extends AbstractFaker
{
    public $faker;

    public function fake_carts()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        $this->set_customer_ids();
        $this->set_product_ids();

        $output = '<ul>';
        for ($i = 0; $i < $this->conf['fake_carts_number']; ++$i) {
            $fc = $this->fake_cart();
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<li>Customer: '.$fc->id_customer.' Cart Total: '.$fc->getOrderTotal();
            $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    }

    protected function default_conf()
    {
      return array(
        'minimum_quantity' => 1, # minimum order quantity
        'maximum_quantity' => 3, # maximum order quantity
        'id_currency' => 1,      # currency id
        'id_lang' => 1,          # language id
      );
    }
    private function fake_cart()
    {
        $cart = new Cart();
        $cid = $this->customer_id();
        $cart->id_customer = $cid;
        $cart->id_currency = $this->conf['id_currency'];
        $cart->id_lang     = $this->conf['id_lang'];
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
          true                   # skipAvailabilityCheckOutOfStock
        );

        return $cart;
    }
    private function set_customer_ids()
    {
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT `id_customer` FROM `'._DB_PREFIX_.'customer`;');
      $this->all_customer_ids = $q->fetchAll();
      $this->max_customer_id = count($this->all_customer_ids) - 1;
      return $this->all_customer_ids;
    }
    private function customer_id()
    {
      $cind = random_int(0, $this->max_customer_id);
      return $this->all_customer_ids[$cind]['id_customer'];
    }
    private function quantity()
    {
      $q = random_int($this->conf['minimum_quantity'], $this->conf['maximum_quantity']);
      error_log("CartFaker::quantity() $q");
      return $q;
    }
    private function set_product_ids()
    {
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT `id_product` FROM `'._DB_PREFIX_.'product`;');
      $this->all_product_ids = $q->fetchAll();
      $this->max_product_id = count($this->all_product_ids) - 1;
      return $this->all_product_ids;
    }
    private function product_id()
    {
      $pind = random_int(0, $this->max_product_id);
      error_log("CartFaker::product_id() - '".print_r($this->all_product_ids, true)."'");
      return $this->all_product_ids[$pind]['id_product'];
    }
    private function id_country($loc = null)
    {
        if (!is_string($loc)) {
            $loc = $this->conf['localization'];
        }
    }
}
