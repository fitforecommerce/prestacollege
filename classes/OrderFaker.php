<?php

class OrderFaker extends AbstractFaker
{
    public $faker;

    public function fake_orders()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        try {
          $this->set_customer_ids();
        } catch (Exception $e) {
          return '<div class="alert alert-warning">No customers in database! Please add customers first before faking orders!</div>';
        }

        error_log("OrderFaker ".print_r($this->conf, true));
        $output = '<ul>';
        for ($i = 0; $i < $this->conf['fake_orders_number']; ++$i) {
            error_log("Creating order $fc");
            $fc = $this->fake_order();
            # $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<li>Customer: '.$fc->id_customer.' Cart Total: '.$fc->total_paid;
            $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    }

    protected function default_conf()
    {
      $conf = array(
        'fake_orders_number' => 10
      );
      return array_merge(parent::default_conf(), $conf);
    }
    private function fake_order()
    {
        $cid  = $this->customer_id();
        $cart = $this->cart_faker()->fake_cart();
        $cart->id_customer = $cid['id_customer'];
        $cart->secure_key =  $cid['secure_key'];

        $order = new Order();
        $order->id_address_delivery = $this->delivery_addr($cid);
        $order->id_address_invoice = $this->invoice_addr($cid);
        $order->id_cart = $cart->id;
        $order->id_currency = $cart->id_currency;
        $order->id_shop_group = $cart->id_shop_group;
        $order->id_shop = $cart->id_shop;
        $order->id_lang = $cart->id_lang;
        $order->id_customer = $cart->id_customer;
        $order->id_carrier = 5;
        $order->current_state = 10;
        $order->secure_key = $cart->secure_key;
        $order->payment = 'Banküberweisung';
        $order->module = 'ps_wirepayment';
        $order->recyclable = 0;
        $order->gift = 0;
        $order->gift_message = '';
        $order->mobile_theme = 0;
        # $order->total_discounts = 0;
        # $order->total_discounts_tax_incl = 0;
        # $order->total_discounts_tax_excl = 0;
        # $order->total_paid = $cart->getOrderTotal();
        # $order->total_paid_tax_incl = 0;
        # $order->total_paid_tax_excl = 0;
        # $order->total_paid_real = 0;
        # $order->total_products = 0;
        # $order->total_products_wt = 0;
        # $order->total_shipping = 0;
        # $order->total_shipping_tax_incl = 0;
        # $order->total_shipping_tax_excl = 0;
        # $order->carrier_tax_rate = 0;
        # $order->total_wrapping = 0;
        # $order->total_wrapping_tax_incl = 0;
        # $order->total_wrapping_tax_excl = 0;
        # $order->round_mode = 0;
        # $order->round_type = 0;
        # $order->shipping_number = 0;
        # $order->conversion_rate = 0;
        # $order->invoice_number = 0;
        # $order->delivery_number = 0;
        # $order->invoice_date = 0;
        # $order->delivery_date = 0;
        # $order->valid = 0;
        # $order->reference = 0;
        # $order->date_add = 0;
        # $order->date_upd = 0;
        return $order;
    }
    private function cart_faker()
    {
      if(isset($this->cart_faker)) return $this->cart_faker;
      $this->cart_faker = new CartFaker();
      return $this->cart_faker;
    }
    private function address_ids($cid)
    {
      $q = Db::getInstance(_PS_USE_SQL_SLAVE_)->query('SELECT `id_address` FROM `'._DB_PREFIX_.'address` WHERE `id_customer`='.$cid['id_customer'].';');
      error_log("query: $q");
      return $q->fetchAll();
    }
    private function delivery_addr($cid)
    {
      return array_values(array_slice($this->address_ids($cid), -1))[0];
    }
    private function invoice_addr($cid)
    {
      return $this->address_ids[0];
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
