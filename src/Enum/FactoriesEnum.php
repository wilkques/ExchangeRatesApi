<?php

namespace Wilkques\ExchangeRates\Enum;

class FactoriesEnum
{
    /** @var string */
    const Exchangeratesapi = 'exchangeratesapi';

    /** @var array */
    const Factories = [
        self::Exchangeratesapi => \Wilkques\ExchangeRates\Factories\ExchangeRatesApi::class,
    ];
}