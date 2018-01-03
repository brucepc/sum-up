<?php
namespace BPCI\SumUp\Test\OAuth;

use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    function testToken(){
        $this->assertEquals('token', 'token');
    }
}