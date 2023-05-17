<?php

namespace Wilkques\ExchangeRates\Factories;

use Wilkques\Http\Client;

abstract class ExchangeRates
{
    /** @var Client|null */
    protected $client;

    /** @var string */
    protected $version = 'v1';

    /** @var array */
    public $methods = [];

    /**
     * @param string $url
     * 
     * @return static
     */
    abstract public function setUrl(string $url);

    /**
     * @param array $methods
     * 
     * @return static
     */
    public function setMethods(array $methods)
    {
        $this->methods += $methods;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param string $version
     * 
     * @return static
     */
    public function setApiVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->version;
    }

    /**
     * @param null|Client $client
     * 
     * @return static
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return null|Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return Http
     */
    public function newClient()
    {
        return $this->client ?? $this->setClient(new Client)->getClient();
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, $value)
    {
        $this->{$key} ?? $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * 
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->{$key} ?? $this->options[$key];
    }

    /**
     * @param string $method
     * @param array $arguments
     * 
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        $method = ltrim(trim($method));

        if (in_array($method, $this->methods)) {
            $method = "set" . ucfirst($method);

            return $this->{$method}(...$arguments);
        }

        return $this->newClient()->{$method}(...$arguments);
    }

    /**
     * @param string $method
     * @param array $arguments
     * 
     * @return mixed
     */
    public static function __callStatic(string $method, array $arguments)
    {
        return (new Static)->{$method}(...$arguments);
    }
}