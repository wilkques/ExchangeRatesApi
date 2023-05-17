<?php

namespace Wilkques\ExchangeRates;

use Wilkques\ExchangeRates\Enum\FactoriesEnum;

class ExchangeRate
{
    /**
     * @param string $abstract
     * 
     * @return mixed
     */
    public static function make(string $abstract = null)
    {
        $exchangeRate = new static;

        if ($abstract) {
            return $exchangeRate->exchangeRate($abstract);
        }
        
        return $exchangeRate;
    }

    /**
     * @param string $abstract
     * 
     * @return mixed
     */
    public function exchangeRate(string $abstract)
    {
        $factories = FactoriesEnum::Factories;

        if (in_array($abstract, $factories)) {
            return new $abstract;
        }

        if (array_key_exists($abstract, $factories)) {
            return new $factories[$abstract];
        }
    }
}
