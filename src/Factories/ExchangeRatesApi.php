<?php

namespace Wilkques\ExchangeRates\Factories;

use Wilkques\ExchangeRates\Contracts\ExchangeRatesApiInterface;
use Wilkques\ExchangeRates\Response;

/**
 * @method static static token(string $access_token)
 * @method static static url(string $key) UrlEnum Key
 * @method static static apiVersion(string $version)
 * @method static static currencies($currencies)
 * @method static static callback(string $callback)
 * @method static static base(string $base)
 * @method static static from(string $from)
 * @method static static to(string $to)
 * @method static static amount(string $amount)
 * @method static static startDate(string $startDate)
 * @method static static endDate(string $endDate)
 */
class ExchangeRatesApi extends ExchangeRates implements ExchangeRatesApiInterface
{
    /** @var array */
    protected $data = [];

    /** @var string */
    protected $url;

    /** @var array */
    public $methods = [
        'token', 'url', 'apiVersion', 'currencies', 'callback', 'base', 'from', 'to',
        'amount', 'startDate', 'endDate'
    ];

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
     * @param array $data
     * 
     * @return static
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param mixed $value
     * 
     * @return static
     */
    public function setDataByKey(string $key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * 
     * @return mixed
     */
    public function getDataByKey(string $key)
    {
        return $this->data[$key];
    }

    /**
     * @param array $data
     * 
     * @return static
     */
    public function withData(array $data = [])
    {
        return $this->setData(array_replace_recursive($this->data, $data));
    }

    /**
     * @param string $access_token
     * 
     * @return static
     */
    public function setToken(string $access_key = null)
    {
        $this->withData(compact('access_key'));

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->getDataByKey('access_key');
    }

    /**
     * @param array|string|null $currencies
     * 
     * @return static
     */
    public function setCurrencies($currencies = null)
    {
        return $this->withData(compact('currencies'));
    }

    /**
     * @return array|string|null
     */
    public function getCurrencies()
    {
        return $this->getDataByKey('currencies');
    }

    /**
     * @param string $base
     * 
     * @return static
     */
    public function setBase(string $base = null)
    {
        return $this->withData(compact('base'));
    }

    /**
     * @return string
     */
    public function getBase()
    {
        return $this->getDataByKey('base');
    }

    /**
     * @param string $from
     * 
     * @return static
     */
    public function setFrom(string $from = null)
    {
        return $this->withData(compact('from'));
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->getDataByKey('from');
    }

    /**
     * @param string $to
     * 
     * @return static
     */
    public function setTo(string $to = null)
    {
        return $this->withData(compact('to'));
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->getDataByKey('to');
    }

    /**
     * @param float|string|null $amount
     * 
     * @return static
     */
    public function setAmount($amount = null)
    {
        return $this->withData(compact('amount'));
    }

    /**
     * @return float|string|null
     */
    public function getAmount()
    {
        return $this->getDataByKey('amount');
    }

    /**
     * @param string $start_date
     * 
     * @return static
     */
    public function setStartDate(string $start_date = null)
    {
        return $this->withData(compact('start_date'));
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->getDataByKey('start_date');
    }

    /**
     * @param string $end_date
     * 
     * @return static
     */
    public function setEndDate(string $end_date = null)
    {
        return $this->withData(compact('end_date'));
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->getDataByKey('end_date');
    }

    /**
     * @param string $callback
     * 
     * @return static
     */
    public function setCallback(string $callback = null)
    {
        return $this->withData(compact('callback'));
    }

    /**
     * @return string
     */
    public function getCallback()
    {
        return $this->getDataByKey('callback');
    }

    /**
     * @param string $apiUrl
     * 
     * @return Response
     */
    public function get(string $apiUrl)
    {
        return new Response($this->getClient()->get($apiUrl, $this->getData()));
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
    public function symbols()
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
}
