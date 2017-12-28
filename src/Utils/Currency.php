<?php
namespace BPCI\SumUp\Utils;

class Currency
{
    const EUR = 'EUR';
    const GBP = 'GBP';
    const RUB = 'RUB';
    const BRL = 'BRL';
    const PLN = 'PLN';
    const CHF = 'CHF';
    const SEK = 'SEK';
    const USD = 'USD';
 
    static function isValid(string $currency){
        $currencies = self::getCurrencies();
        return in_array($currency, $currencies);
    }

    static function getCurrencies(): Array{
        $rClass = new \ReflectionClass(__CLASS__);
        return $rClass->getConstants();
    }
}