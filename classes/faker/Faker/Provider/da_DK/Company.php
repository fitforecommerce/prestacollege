<?php

namespace Faker\Provider\da_DK;

/**
 * @author Antoine Corcy <contact@sbin.dk>
 */
class Company extends \Faker\Provider\Company
{
    /**
     * @var array danish company name formats
     */
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{companySuffix}}',
        '{{lastName}} {{companySuffix}}',
        '{{firstname}} {{lastName}} {{companySuffix}}',
        '{{middleName}} {{companySuffix}}',
        '{{middleName}} {{companySuffix}}',
        '{{middleName}} {{companySuffix}}',
        '{{firstname}} {{middleName}} {{companySuffix}}',
        '{{lastName}} & {{lastName}} {{companySuffix}}',
        '{{lastName}} og {{lastName}} {{companySuffix}}',
        '{{lastName}} & {{lastName}} {{companySuffix}}',
        '{{lastName}} og {{lastName}} {{companySuffix}}',
        '{{middleName}} & {{middleName}} {{companySuffix}}',
        '{{middleName}} og {{middleName}} {{companySuffix}}',
        '{{middleName}} & {{lastName}}',
        '{{middleName}} og {{lastName}}',
    );

    /**
     * @var array company suffixes
     */
    protected static $companySuffix = array('ApS', 'A/S', 'I/S', 'K/S');

    /**
     * @see http://cvr.dk/Site/Forms/CMS/DisplayPage.aspx?pageid=60
     *
     * @var string CVR number format
     */
    protected static $cvrFormat = '%#######';

    /**
     * @see http://cvr.dk/Site/Forms/CMS/DisplayPage.aspx?pageid=60
     *
     * @var string p number (production number) format
     */
    protected static $pFormat = '%#########';

    /**
     * Generates a CVR number (8 digits).
     *
     * @return string
     */
    public static function cvr()
    {
        return static::numerify(static::$cvrFormat);
    }

    /**
     * Generates a P entity number (10 digits).
     *
     * @return string
     */
    public static function p()
    {
        return static::numerify(static::$pFormat);
    }
}
