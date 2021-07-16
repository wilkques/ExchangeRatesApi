<?php

namespace Wilkques\ExchangeRate\Factories;

class UrlEnum
{
    const Exchangeratesapi = 'exchangeratesapi';

    const Urls = [
        self::Exchangeratesapi => 'https://api.exchangeratesapi.io',
    ];

    /**
     * @return array
     */
    public static function getUrls()
    {
        return self::Urls;
    }

    /**
     * @param string $key
     * 
     * @return string
     */
    public static function getUrlByKey(string $key)
    {
        return self::getUrls()[$key];
    }
}