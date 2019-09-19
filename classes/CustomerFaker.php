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

    public function default_conf()
    {
        $conf = array(
            'fake_customers_number' => 10,
            'company_rate' => 10,
            'newsletter_rate' => 70,
            'optin_rate' => 90,
            'second_address_rate' => 10,
            'birthday_given_rate' => 60,
            'max_age' => 90
        );
        return array_merge(parent::default_conf(), $conf);
    }

    private function fake_customer()
    {
        $fc = new Customer();
        $fc->id_gender = $this->rnd_gender_int();
        $g_str = $this->gender_string($fc->id_gender);
        $fc->firstname = $this->faker()->firstname($g_str);
        $fc->lastname = $this->faker()->lastname;
        $fc->email = $this->create_email_string($fc->firstname, $fc->lastname);
        if(rand(0,100) <= $this->conf['company_rate']) {
          $fc->company = $this->faker()->company;
        }
        if(rand(0,100) <= $this->conf['newsletter_rate']) {
          $fc->newsletter = true;
          $fc->ip_registration_newsletter = $this->faker()->ipv4;
          $fc->optin = rand(0,100) < $this->conf['optin_rate'] ? true : false;
        }
        if(rand(0,100) <= $this->conf['birthday_given_rate']) {
          $tdiff = round($this->g_rand());
          $fc->birthday = $this->random_date('-'.$tdiff.' years', '-'.$tdiff.' years', 'Y-m-d');
          error_log("CustomerFaker::fake_customer $fc->birthday");
        }
        $fc->setWsPasswd($fc->firstname);
        try {
            $fc->save();
            $fc->date_add = $this->random_date();
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
        $rv = $fn.'.'.$ln.'@example.com';
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
}
