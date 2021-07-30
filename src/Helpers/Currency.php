<?php

namespace Manzadey\RegRu\Helpers;

use Manzadey\RegRu\Exceptions\CurrencyException;

class Currency
{
    protected $currencies = [
        'RUR',
        'USD',
        'EUR',
        'UAH',
    ];

    /**
     * @return string[]
     */
    public function getCurrencies() : array
    {
        return $this->currencies;
    }

    /**
     * @param string[] $currencies
     */
    public function setCurrencies(array $currencies) : void
    {
        $this->currencies = $currencies;
    }

    /**
     * @throws \Manzadey\RegRu\Exceptions\CurrencyException
     */
    public function checkCurrency(string $currency) : void
    {
        if(!in_array($currency, $this->currencies, true)) {
            throw new CurrencyException;
        }
    }
}