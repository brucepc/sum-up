<?php
namespace BPCI\SumUp\Tests\Utils;

use PHPUnit\Framework\TestCase;
use BPCI\SumUp\Utils\Currency;

class CurrencyTest extends TestCase
{
    function testCurrencyUtils()
    {
        $this->assertGreaterThanOrEqual(8, count(Currency::getCurrencies()));
        $this->assertTrue(Currency::isValid('BRL'));
        $this->assertFalse(Currency::isValid('BLR'));
    } 
}