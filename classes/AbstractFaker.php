<?php

abstract class AbstractFaker
{
    public $conf;

    public function __construct($conf = null)
    {
        if (!is_array($conf)) {
            $conf = array();
        }
        $this->conf = array_merge($this->default_conf(), $conf);
    }

    protected function default_conf()
    {
        return array(
      'number_of_customers' => 10,
      'localization' => 'de',
    );
    }

    protected function faker()
    {
        if (isset($this->faker)) {
            return $this->faker;
        }
        error_log($this->faker_localization());
        $this->faker = Faker\Factory::create($this->faker_localization());

        return $this->faker;
    }

    protected function faker_localization()
    {
        $loc = strtolower($this->conf['localization']);
        $loc .= '_'.strtoupper($this->conf['localization']);

        return $loc;
    }
}
