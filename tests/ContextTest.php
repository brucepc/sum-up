<?php
namespace BPCI\SumUp\Tests;

use BPCI\SumUp\Context;
use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Exception\FileNotFoundException;
use PHPUnit\Framework\TestCase;

class ContextTest extends TestCase
{
    protected static $context;

    function setUp()
    {
        self::$context = Context::loadContextFromFile('./tests/test.json');
    }

    /**
     * @expectedException \BPCI\SumUp\Exception\FileNotFoundException
     * @expectedException \BPCI\SumUp\Exception\MalformedJsonException
     */
    function testLoadContextFromFileException()
    {
        Context::loadContextFromFile('./notfound.json');
        Context::loadContextFromFile('./tests/malformed.json');
    }

    function testLoadContextFromFile()
    {
        $this->assertTrue(self::$context instanceof ContextInterface);
    }

    function testGetContextData()
    {
        $data = self::$context->getContextData();
        $this->assertInternalType('array', $data);
        self::$context->setIndexUri(1);
        $this->assertEquals('http://test.sumup.com', self::$context->getRedirectUri());

    }
}
