<?php
require_once(dirname(__FILE__).'/faker/autoload.php');

class CustomerFaker extends AbstractFaker
{
  var $faker;
  var $address_faker;

  public function fake_customers()
  {
    $output  = '<ul>';
    for ($i=0; $i < $this->conf['fake_customers_number']; $i++) { 
      $fc = $this->fake_customer();
      $fa = $this->address_faker()->fake_customer_address($fc);
      $output .= '<li>'.$fc->firstname.' '.$fc->lastname.' - '.$fc->email;
      # $output .= '<p>'.$fa->address1.'</p>';
      # $output .= '<p>'.$fa->postcode.' '.$fa->city.'</p>';
      # $output .= '<p>'.$fa->country.'</p>';
      $output .= '</li>';
    }
    $output .= '</ul>';
    return $output;
  }

  protected function default_conf()
  {
    $conf = array(
      'fake_customers_number' => 10,
    );
    return array_merge(parent::default_conf(), $conf);
  }

  private function fake_customer()
  {
    $fc = new Customer();
    $fc->id_gender = $this->rnd_gender_int();
    $g_str = $this->gender_string($fc->id_gender);
    $fc->lastname = $this->faker()->lastname;
    $fc->firstname = $this->faker()->firstname($g_str);
    $fc->email = strtolower($fc->firstname.$fc->lastname."@fitforecommerce.eu");
    $fc->newsletter = false;
    $fc->optin = false;
    $fc->setWsPasswd($fc->firstname);
    $fc->save();
    return $fc;
  }
  private function address_faker()
  {
    if(isset($this->address_faker)) return $this->address_faker;
    $this->address_faker = new AddressFaker();
    return $this->address_faker;
  }
  private function rnd_gender_int()
  {
    return rand(1 , 2);
  }
  private function gender_string($i)
  {
    if($i==1) return 'male';
    return 'female';
  }
}
?>