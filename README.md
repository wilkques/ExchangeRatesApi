# Exchange rate api

[![Latest Stable Version](https://poser.pugx.org/wilkques/exchange-rate/v/stable)](https://packagist.org/packages/wilkques/exchange-rate)
[![License](https://poser.pugx.org/wilkques/exchange-rate/license)](https://packagist.org/packages/wilkques/exchange-rate)

````
composer require wilkques/exchange-rate
````
## API
|      API        |              Url                |           Document              |
|-----------------|---------------------------------|---------------------------------|
 exchangeratesapi | https://api.exchangeratesapi.io | https://exchangeratesapi.io/documentation/
## How to use
1. Get ExchangeRatesApi
    ```php
    use Wilkques\ExchangeRate\Factories\ExchangeRatesApi;

    $exchangeRatesApi = (new ExchangeRatesApi)->url(
        (new UrlEnum())->getUrlByKey(UrlEnum::Exchangeratesapi)
    )->token('<access token>');
    // or
    $exchangeRatesApi = ExchangeRatesApi::url(
        UrlEnum::make()->getUrlByKey(UrlEnum::Exchangeratesapi)
    )->token('<access token>')
    ```
1. Example
    ````php
    $currencies = $exchangeRatesApiurl->currencies();

    $currencies->throw(); // throw exception

    // or

    $currencies->throw(function ($response, $exception) {
        // code
    });

    $currencies = $currencies->json(); // to array
    ````
1. All Methods
    1. ExchangeRatesApi
        |   Methods     |   Description    |
        |---------------|------------------|
        `token`         | set access token
        `url`           | set api url
        `apiVersion`    | set api version
        `symbols`       | set symbols
        `callback`      | set callback
        `base`          | set base
        `from`          | set from
        `to`            | set to
        `amount`        | set amount
        `startDate`     | set startDate
        `endDate`       | set endDate
        `latest`        | call api with latest
        `currencies`    | call api with symbols
        `historical`    | call api with historical
        `convert`       | call api with convert
        `timeseries`    | call api with timeseries
        `fluctuation`   | call api with fluctuation

    1. Response see REFERENCE [Http Client](#REFERENCE)
        |   Methods     |   Description    |
        |---------------|------------------|
        `throw`         | throw Exception

# REFERENCE
1. [Exchangeratesapi](https://exchangeratesapi.io/documentation/)
1. [Http Client](https://github.com/wilkques/http-client)
