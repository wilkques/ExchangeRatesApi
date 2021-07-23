<?php

namespace Wilkques\ExchangeRate\Factories\Interfaces;

interface ExchangeRateInterface
{
    /**
     * @param string $url
     * 
     * @return static
     */
    public function setUrl(string $url);

    /**
     * @param string $version
     * 
     * @return static
     */
    public function setApiVersion(string $version);

    /**
     * @param array $options
     * 
     * @return static
     */
    public function withOptions(array $options = []);

    /**
     * @param string $access_token
     * 
     * @return static
     */
    public function setToken(string $access_token);

    /**
     * @param array|string $currencies
     * 
     * @return static
     */
    public function setCurrencies($currencies);

    /**
     * @param string $callback
     * 
     * @return static
     */
    public function setCallback(string $callback = null);

    /**
     * @param string $base
     * 
     * @return static
     */
    public function setBase(string $base = null);

    /**
     * @param string $from
     * 
     * @return static
     */
    public function setFrom(string $from = null);

    /**
     * @param string $to
     * 
     * @return static
     */
    public function setTo(string $to = null);

    /**
     * @param float|string|null $amount
     * 
     * @return static
     */
    public function setAmount($amount = null);

    /**
     * @param string $start_date
     * 
     * @return static
     */
    public function setStartDate(string $start_date = null);

    /**
     * @param string $end_date
     * 
     * @return static
     */
    public function setEndDate(string $end_date = null);

    /**
     * @return Response
     */
    public function latest();

    /**
     * @return Response
     */
    public function symbols();

    /**
     * @param string $dateTime
     * 
     * @return Response
     */
    public function historical(string $dateTime);

    /**
     * @return Response
     */
    public function convert();

    /**
     * @return Response
     */
    public function timeseries();

    /**
     * @return Response
     */
    public function fluctuation();
}
