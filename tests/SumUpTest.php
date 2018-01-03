<?php
namespace BPCI\SumUp\Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\ClientInterface;
use BPCI\SumUp\SumUp;

class SumUpTest extends TestCase
{
    function testGetClient()
    {
        $client = SumUp::getClient();
        $this->assertTrue($client instanceof ClientInterface);
    }
}
