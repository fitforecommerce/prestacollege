<?php

namespace Faker\Provider\is_IS;

/**
 * @author Birkir Gudjonsson <birkir.gudjonsson@gmail.com>
 */
class Internet extends \Faker\Provider\Internet
{
    /**
     * @var array some email domains in Denmark
     */
    protected static $freeEmailDomain = array(
        'gmail.com', 'yahoo.com', 'hotmail.com', 'visir.is', 'simnet.is', 'internet.is',
    );

    /**
     * @var array some TLD
     */
    protected static $tld = array(
        'com', 'com', 'com', 'net', 'is', 'is', 'is',
    );
}
