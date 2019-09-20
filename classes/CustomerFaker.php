<?php

require_once dirname(__FILE__).'/faker/autoload.php';

/**
 * This class fakes Customer accounts.
 * Remember the three default types of customer accounts, according to Prestashop terminology:
 * Visitor - All persons without a valid customer account. 
 * Guest (id_default_group = 2) - Customers who have placed an order with a guest account (if enabled). 
 * Customer (id_default_group = 3) - All the people who have created an account on this site.
 *
 * @author Martin Kolb
 */
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
            'female_customer_rate' => 50,
            # 'visitor_rate' => 50,
            'guest_rate' => 30,
            'banned_rate' => 1,
            'company_rate' => 10,
            'newsletter_rate' => 70,
            'optin_rate' => 90,
            'second_address_rate' => 10,
            'birthday_given_rate' => 60,
            'max_age' => 90,
            'profile_add_min' => '-2 years',
            'profile_add_max' => 'now',
        );
        return array_merge(parent::default_conf(), $conf);
    }

    private function fake_customer()
    {
        $fc = new Customer();

        $fc->id_gender = 1;
        $g_str = $this->gender_string($fc->id_gender);
        $fc->firstname = $this->faker()->firstname($g_str);
        $fc->lastname = $this->faker()->lastname;
        $fc->email = $this->create_email_string($fc->firstname, $fc->lastname);

        if($this->in_rnd_range($this->conf['female_customer_rate'])) {
          $fc->id_gender = 2;
        }

        if($this->in_rnd_range($this->conf['guest_rate'])) {
          $fc->id_default_group = Configuration::get('PS_GUEST_GROUP');
          $fc->is_guest = true;
        }

        if($this->in_rnd_range($this->conf['banned_rate'])) {
          $fc->active = false;
        }
        if($this->in_rnd_range($this->conf['company_rate'])) {
          $fc->company = $this->faker()->company;
        }

        if($this->in_rnd_range($this->conf['newsletter_rate'])) {
          $fc->newsletter = true;
          $fc->ip_registration_newsletter = $this->faker()->ipv4;
          $fc->optin = rand(0,100) < $this->conf['optin_rate'] ? true : false;
        }

        if($this->in_rnd_range($this->conf['birthday_given_rate'])) {
          $tdiff = round($this->g_rand());
          $fc->birthday = $this->random_date('-'.$tdiff.' years', '-'.$tdiff.' years', 'Y-m-d');
        }
        $fc->setWsPasswd($fc->firstname);
        try {
            $fc->save();
            $fc->date_add = $this->random_date(
              $this->conf['profile_add_min'],
              $this->conf['profile_add_max']
            );
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
