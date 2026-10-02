<?php
namespace App;
use DB;
class notifactions
{
    protected static $countries = [
        'Deutschland' => 'de',
        'Oesterreich' => 'at',
        'Schweiz'     => 'ch'
    ];

    /**
     * Return a list of all countries
     * 
     * @return array  Array of all listed countries
     */
    public static function allCountries()
    {
        return static::$countries;
    }
}