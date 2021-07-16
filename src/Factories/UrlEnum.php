<?php

namespace Wilkques\ExchangeRate\Factories;

class UrlEnum
{
    /** @var string */
    const Exchangeratesapi = 'exchangeratesapi';

    /** @var array */
    const Urls = [
        self::Exchangeratesapi => '%s://api.exchangeratesapi.io',
    ];

    /**
     * @param boolean $supportHTTPS
     */
    public function __construct(bool $supportHTTPS = true)
    {
        $this->supportHTTPS($supportHTTPS);
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return self::Urls;
    }

    /**
     * @param string $key
     * 
     * @return string
     */
    public function getUrlByKey(string $key)
    {
        return sprintf($this->getUrls()[$key], $this->getHttp());
    }

    /**
     * @param string $http
     * 
     * @return static
     */
    public function setHttp(string $http)
    {
        $this->http = $http;

        return $this;
    }

    /**
     * @return string
     */
    public function getHttp()
    {
        return $this->http;
    }

    /**
     * @param boolean $supportHTTPS
     * 
     * @return static
     */
    public function supportHTTPS(bool $supportHTTPS = true)
    {
        return $this->setHttp($supportHTTPS ? 'https' : 'http');
    }

    /**
     * @param boolean $supportHTTPS
     * 
     * @return static
     */
    public static function make(bool $supportHTTPS = true)
    {
        return new static($supportHTTPS);
    }
}