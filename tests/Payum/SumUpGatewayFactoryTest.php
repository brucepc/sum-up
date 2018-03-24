<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 12/03/18
 * Time: 14:03
 */

namespace BPCI\SumUp\Tests\Payum;


use BPCI\SumUp\Payum\SumUpGatewayFactory;
use Payum\Core\CoreGatewayFactory;
use Payum\Core\Gateway;
use Payum\Core\GatewayFactoryInterface;
use PHPUnit\Framework\TestCase;

class SumUpGatewayFactoryTest extends TestCase
{
    public function testShouldSubClassGatewayFactory()
    {
        $rc = new \ReflectionClass('BPCI\SumUp\Payum\SumUpGatewayFactory');
        $this->assertTrue($rc->isSubclassOf('Payum\Core\GatewayFactory'));
    }

    public function testCouldBeConstructedWithoutAnyArguments()
    {
        $factory = new SumUpGatewayFactory();
        $this->assertNotNull($factory);
    }

    public function testShouldCreateCoreGatewayFactoryIfNotPassed()
    {
        $factory = new SumUpGatewayFactory();

        $this->assertAttributeInstanceOf(CoreGatewayFactory::class, 'coreGatewayFactory', $factory);
    }

    public function testShouldUseCoreGatewayFactoryPassedAsSecondArgument()
    {
        $coreGateway = $this->createMock(GatewayFactoryInterface::class);

        $factory = new SumUpGatewayFactory([], $coreGateway);

        $this->assertAttributeSame($coreGateway, 'coreGatewayFactory', $factory);
    }

    public function testShouldAllowCreateGateway()
    {
        $factory = new SumUpGatewayFactory();

        $gateway = $factory->create(
            [
                'client_id' => 'aClientId',
                'client_secret' => 'aSecretKey',
            ]
        );

        $this->assertInstanceOf(Gateway::class, $gateway);

        $this->assertAttributeNotEmpty('actions', $gateway);
    }

    public function testShouldAllowCreateGatewayConfig()
    {
        $factory = new SumUpGatewayFactory();

        $conf = $factory->createConfig();

        $this->assertInternalType('array', $conf);
        $this->assertNotEmpty($conf);
    }

    public function testShouldAddDefaultConfigPassedInConstructorWhileCreatingGatewayConfig()
    {
        $factory = new SumUpGatewayFactory(
            [
                'foo' => 'fooVal',
                'bar' => 'barVal',
            ]
        );
        $config = $factory->createConfig();
        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('foo', $config);
        $this->assertEquals('fooVal', $config['foo']);
        $this->assertArrayHasKey('bar', $config);
        $this->assertEquals('barVal', $config['bar']);
    }

    public function testShouldConfigContainDefaultOptions()
    {
        $factory = new SumUpGatewayFactory();

        $conf = $factory->createConfig();

        $this->assertInternalType('array', $conf);

        $this->assertArrayHasKey('payum.default_options', $conf);
        $this->assertEquals(
            [
                'client_id' => '',
                'client_secret' => '',
            ],
            $conf['payum.default_options']
        );
    }

    public function testShouldConfigContainFactoryNameAndTitle()
    {
        $factory = new SumUpGatewayFactory();
        $conf = $factory->createConfig();

        $this->assertInternalType('array', $conf);

        $this->assertArrayHasKey('payum.factory_name', $conf);
        $this->assertEquals('sumup_checkout', $conf['payum.factory_name']);

        $this->assertArrayHasKey('payum.factory_title', $conf);
        $this->assertEquals('SumUp Checkout', $conf['payum.factory_title']);
    }

    /**
     * @expectedException Payum\Core\Exception\LogicException
     * @expectedExceptionMessage The client_id, client_secret fields are required.
     */
    public function testShouldThrowIfRequiredOptionsNotPassed()
    {
        $factory = new SumUpGatewayFactory();

        $factory->create();
    }
}