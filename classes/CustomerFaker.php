<?php

require_once dirname(__FILE__).'/faker/autoload.php';

class CustomerFaker extends AbstractFaker
{
    public $faker;
    public $address_faker;

    public function fake_customers()
    {
        @set_time_limit(0);
        @ini_set('max_execution_time', '0');

        $output = '<ul>';
        for ($i = 0; $i < $this->conf['fake_customers_number']; ++$i) {
            $fc = $this->fake_customer();
            $fa = $this->address_faker()->fake_customer_address($fc);
            $output .= '<li>'.$fc->firstname.' '.$fc->lastname.' - '.$fc->email;
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
        $fc->email = $this->create_email_string($fc->firstname, $fc->lastname);
        $fc->newsletter = rand(20,100) > 50 ? true : false;
        $fc->optin = rand(0,80) > 50 ? true : false;
        $fc->setWsPasswd($fc->firstname);
        try {
            $fc->save();
            $fc->date_add = $this->random_add_date();
            $fc->save();
        } catch (PrestaShopException $e) {
            error_log("invalid customer: ".$fc->email);
            throw $e;
        }
        return $fc;
    }

    private function address_faker()
    {
        if (isset($this->address_faker)) {
            return $this->address_faker;
        }
        $this->address_faker = new AddressFaker();

        return $this->address_faker;
    }

    private function rnd_gender_int()
    {
        return rand(1, 2);
    }

    private function gender_string($i)
    {
        if (1 == $i) {
            return 'male';
        }
        return 'female';
    }
    private function create_email_string($fn, $ln)
    {
        $rv = $fn.'.'.$ln.'@fitforecommerce.eu';
        $rv = preg_replace('/\s+/', '', $rv);
        $rv = $this->unaccent($rv);
        $rv = strtolower($rv);
        return $rv;
    }
    private function unaccent($string)
    {
        if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false) {
            $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
        }
        return $string;
    }
    private function random_add_date($past_years = 5)
    {
        $now      = time();
        $from     = time() - (60*60*24*7*52) * $past_years;
        $rand_ts  = mt_rand($from, $now);
        return date("Y-m-d H:i:s", $rand_ts);
    }
}
