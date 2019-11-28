<?php

class CartFaker extends AbstractFaker
{
    public $faker;

    function __construct($conf = null) 
    {
      parent::__construct();

      try {
        $this->set_customer_ids();
      } catch (Exception $e) {
        return '<div class="alert alert-warning">No customers in database! Please add customers first before faking carts!</div>';
      }

      $this->set_product_ids();
    }
    public function fake_carts()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        $output = '<ul>';
        for ($i = 0; $i < $this->conf['fake_carts_number']; ++$i) {
            if($this->in_rnd_range($this->conf['customer_cart_rate'])) {
              $cid = $this->customer_id();
              $fc = $this->fake_customer_cart($cid);
            } else {
              $fc = $this->fake_cart();
            }
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<li>Customer: '.$fc->id_customer.' Cart Total: '.$fc->getOrderTotal();
            $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    }

    protected function default_conf()
    {
      $conf = array(
        'fake_carts_number' => 50,
        'customer_cart_rate'  => 20,
        'minimum_item_quantity' => 1, # minimum order quantity
        'maximum_item_quantity' => 3, # maximum order quantity
        'minimum_order_items'  => 1,
        'maximum_order_items'  => 5,
        'id_currency' => 1,      # currency id
        'id_lang' => 1,          # language id
        'add_datespan_min' => '-1 years',
        'add_datespan_max' => 'now',
        'upd_timediff_min' => 0,
        'upd_timediff_max' => 1440,
      );
      return array_merge(parent::default_conf(), $conf);
    }
    public function fake_customer_cart($cid)
    {
      $cart = $this->fake_cart();
      $cart->id_customer = $cid['id_customer'];
      $cart->secure_key =  $cid['secure_key'];
      return $cart;
    }
    public function fake_cart()
    {
        $cart = new Cart();
        $cart->id_currency = $this->conf['id_currency'];
        $cart->id_lang     = $this->conf['id_lang'];

        $fdate = $this->fake_date();
        $upd_timediff = random_int($this->conf['upd_timediff_min'],$this->conf['upd_timediff_max']);

        $cart->date_add    = $fdate->format('Y-m-d H:i:s');
        $cart->date_upd    = $fdate->modify('+'.$upd_timediff.' minutes')->format('Y-m-d H:i:s');

        $cart->add(false, false);

        for ($i=0; $i < $this->order_items_quantity(); $i++) { 
          $cart->updateQty(
            $this->item_quantity(), # quantity
            $this->product_id(),    # $id_product
            null,                   # id_product_attribute
            false,                  # id_customization
            'up',                   # operator
            0,                      # $id_address_delivery
            null,                   # shop
            true,                   # auto_add_cart_rule
            false                    # skipAvailabilityCheckOutOfStock
          );
        }
        return $cart;
    }
    private function fake_date()
    {
      return $this->faker()->dateTimeBetween(
        $this->conf['add_datespan_min'],
        $this->conf['add_datespan_max'],
        $timezone = null
      );
    }
    private function order_items_quantity()
    {
      $q = random_int($this->conf['minimum_order_items'], $this->conf['maximum_order_items']);
      return $q;
    }
    private function item_quantity()
    {
      $q = random_int($this->conf['minimum_item_quantity'], $this->conf['maximum_item_quantity']);
      return $q;
    }
    private function set_product_ids()
    {
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT `id_product` FROM `'._DB_PREFIX_.'product`;');
      $this->all_product_ids = $q->fetchAll();
      $this->max_product_id = count($this->all_product_ids) - 1;
      error_log("CartFaker:.set_product_ids" . print_r($this->all_product_ids, true));
      return $this->all_product_ids;
    }
    private function product_id()
    {
      $pind = random_int(0, $this->max_product_id);
      return $this->all_product_ids[$pind]['id_product'];
    }
    private function id_country($loc = null)
    {
        if (!is_string($loc)) {
            $loc = $this->conf['localization'];
        }
    }
}
