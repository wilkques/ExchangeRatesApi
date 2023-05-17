<?php

namespace Wilkques\ExchangeRates\Enum;

class UrlEnum
{
    /** @var string */
    protected $https = 'https';

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
        return sprintf($this->getUrls()[$key], $this->getHttps());
    }

    /**
     * @param string $https
     * 
     * @return static
     */
    public function setHttps(string $https)
    {
        $this->https = $https;

        return $this;
    }

    /**
     * @return string
     */
    public function getHttps()
    {
        return $this->https;
    }

    /**
     * @param boolean $supportHTTPS
     * 
     * @return static
     */
    public function supportHTTPS(bool $supportHTTPS = true)
    {
        return $this->setHttps($supportHTTPS ? 'https' : 'http');
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