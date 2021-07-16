<?php

namespace Wilkques\ExchangeRate\Factories;

use Wilkques\ExchangeRate\Factories\Interfaces\ExchangeRateInterface;
use Wilkques\ExchangeRate\Factories\Response;
use Wilkques\HttpClient\Http;

/**
 * @method static static token(string $access_token)
 * @method static static url(string $key) UrlEnum Key
 * @method static static apiVersion(string $version)
 * @method static static symbols($symbols)
 * @method static static callback(string $callback)
 * @method static static base(string $base)
 * @method static static from(string $from)
 * @method static static to(string $to)
 * @method static static amount(string $amount)
 * @method static static startDate(string $startDate)
 * @method static static endDate(string $endDate)
 */
class ExchangeRatesApi implements ExchangeRateInterface
{
    /** @var array */
    protected $options = [];
    /** @var string */
    protected $version = 'v1';
    /** @var string */
    protected $url;
    /** @var Http|null */
    protected $client;
    /** @var array */
    protected $methods = [
        'token', 'url', 'apiVersion', 'symbols', 'callback', 'base', 'from', 'to',
        'amount', 'startDate', 'endDate'
    ];

    /**
     * @param null|Http $client
     * 
     * @return static
     */
    public function setClient(Http $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return null|Http
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param string $url
     * 
     * @return static
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $tarage
     * 
     * @return string
     */
    public function apiUrl(string $tarage)
    {
        return sprintf('%s/%s/%s', $this->getUrl(), $this->getApiVersion(), $tarage);
    }

    /**
     * @param array $options
     * 
     * @return static
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $key
     * @param mixed $value
     * 
     * @return static
     */
    public function setOptionsByKey(string $key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * 
     * @return mixed
     */
    public function getOptionsByKey(string $key)
    {
        return $this->options[$key];
    }

    /**
     * @param array $options
     * 
     * @return static
     */
    public function withOptions(array $options = [])
    {
        return $this->setOptions(array_replace_recursive($this->options, $options));
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
     * @param string $access_token
     * 
     * @return static
     */
    public function setToken(string $access_key = null)
    {
        $this->withOptions(compact('access_key'));

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getOptionsByKey('access_key');
    }

    /**
     * @param array|string|null $symbols
     * 
     * @return static
     */
    public function setSymbols($symbols = null)
    {
        return $this->withOptions(compact('symbols'));
    }

    /**
     * @return array|string|null
     */
    public function getSymbols()
    {
        return $this->getOptionsByKey('symbols');
    }

    /**
     * @param string $base
     * 
     * @return static
     */
    public function setBase(string $base = null)
    {
        return $this->withOptions(compact('base'));
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->getOptionsByKey('base');
    }

    /**
     * @param string $from
     * 
     * @return static
     */
    public function setFrom(string $from = null)
    {
        return $this->withOptions(compact('from'));
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->getOptionsByKey('from');
    }

    /**
     * @param string $to
     * 
     * @return static
     */
    public function setTo(string $to = null)
    {
        return $this->withOptions(compact('to'));
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->getOptionsByKey('to');
    }

    /**
     * @param float|string|null $amount
     * 
     * @return static
     */
    public function setAmount($amount = null)
    {
        return $this->withOptions(compact('amount'));
    }

    /**
     * @return float|string|null
     */
    public function getAmount()
    {
        return $this->getOptionsByKey('amount');
    }

    /**
     * @param string $start_date
     * 
     * @return static
     */
    public function setStartDate(string $start_date = null)
    {
        return $this->withOptions(compact('start_date'));
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->getOptionsByKey('start_date');
    }

    /**
     * @param string $end_date
     * 
     * @return static
     */
    public function setEndDate(string $end_date = null)
    {
        return $this->withOptions(compact('end_date'));
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->getOptionsByKey('end_date');
    }

    /**
     * @param string $callback
     * 
     * @return static
     */
    public function setCallback(string $callback = null)
    {
        return $this->withOptions(compact('callback'));
    }

    /**
     * @return string
     */
    public function getCallback()
    {
        return $this->getOptionsByKey('callback');
    }

    /**
     * @param string $apiUrl
     * 
     * @return Response
     */
    public function get(string $apiUrl)
    {
        return new Response($this->getClient()->get($apiUrl, $this->getOptions()));
    }

    /**
     * @return Response
     */
    public function latest()
    {
        return $this->get($this->apiUrl('latest'));
    }

    /**
     * @return Response
     */
    public function currencies()
    {
        return $this->get($this->apiUrl('symbols'));
    }

    /**
     * @param string $dateTime
     * 
     * @return Response
     */
    public function historical(string $dateTime)
    {
        return $this->get($this->apiUrl($dateTime));
    }

    /**
     * @return Response
     */
    public function convert()
    {
        return $this->get($this->apiUrl('convert'));
    }

    /**
     * @return Response
     */
    public function timeseries()
    {
        return $this->get($this->apiUrl('timeseries'));
    }

    /**
     * @return Response
     */
    public function fluctuation()
    {
        return $this->get($this->apiUrl('fluctuation'));
    }

    /**
     * @return Http
     */
    public function newClient()
    {
        return $this->client ?? $this->setClient(new Http)->getClient();
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

        $client = $this->newClient();

        if (in_array($method, $this->methods)) {
            $method = "set" . ucfirst($method);

            return $this->{$method}(...$arguments);
        }

        return $client->{$method}(...$arguments);
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
