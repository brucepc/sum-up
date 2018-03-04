<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 26/02/18
 * Time: 09:18
 */

namespace BPCI\SumUp\Tests\Customer;


use BPCI\SumUp\Context;
use BPCI\SumUp\Customer\Customer;
use BPCI\SumUp\Customer\CustomerClient;
use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\Customer\PaymentInstrument\PaymentInstrument;
use BPCI\SumUp\OAuth\AccessToken;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CustomerClientTest extends TestCase
{

    protected static $context;
    protected static $customer;

    function setUp()
    {
        self::$context = Context::loadContextFromFile('./tests/test.json');
        self::$customer = new Customer(
            [
                'customer_id' => uniqid(),
                'name' => 'Tester',
            ]
        );
    }

    /**
     * @cover CustomerClient::request
     */
    function testCreatingANewCustomer()
    {
        $header = ['Content-Type' => 'application/json'];
        $responseCollection = [
            new Response(
                201,
                $header,
                /** @lang JSON */
                <<<JSON
{
  "customer_id": "...",
  "personal_details": {
    "name": "...",
    "phone": "...",
    "address": {
      "address_line1": "...",
      "address_line2": "...",
      "city": "...",
      "country": "...",
      "country_en_name": "...",
      "country_native_name": "...",
      "region_id": 1,
      "region_name": "...",
      "post_code": "...",
      "landline": "...",
      "line1": "...",
      "line2": "...",
      "postal_code": "...",
      "state": "..."
    }
  }
}
JSON
            ),
            new Response(
                409,
                $header,
                /** @lang JSON */
                <<<JSON
{
  "error_code": "CUSTOMER_ALREADY_EXISTS",
  "message": "Customer already exists"
}
JSON
            ),
        ];

        $options = [
            'handler' => HandlerStack::create(new MockHandler($responseCollection)),
        ];
        $customer = clone self::$customer;
        $token = new AccessToken('FAKE_TOKEN', 'Bearer', '86000');
        $client = new CustomerClient(self::$context, $options);
        $client->setToken($token);
        $this->assertInstanceOf(CustomerInterface::class, $client->create($customer));
        $this->assertNotNull($customer->getCustomerId());

    }

    function testGetPaymentInstruments()
    {
        $customer = clone self::$customer;
        $instrument = new PaymentInstrument(
            [
                'token' => 'fake_token_card',
                'active' => true,
                'type' => 'token_type',
                'card' => [
                    'last_4_digits' => '0000',
                    'type' => 'card schema name',
                ],
            ]
        );
        $header = ['Content-Type' => 'application/json'];
        $responseCollection = [
            new Response(
                200,
                $header,
                /** @lang JSON */
                <<<JSON
{
  "token": "...",
  "active": true,
  "type": "...",
  "card": {
    "last_4_digits": "...",
    "type": "..."
  }
}
JSON
            ),
            new Response(
                404,
                $header,
                /** @lang JSON */
                <<<JSON
{
  "error_code": "NOT_FOUND",
  "message": "Customer not found"
}
JSON
            ),
        ];
        $options = [
            'handler' => HandlerStack::create(new MockHandler($responseCollection)),
        ];
        $token = new AccessToken('FAKE_TOKE', 'Bearer', '86000');
        $client = new CustomerClient(self::$context, $options);
        $client->setToken($token);
        $this->assertNotNull($client->getPaymentInstruments($customer));
        $this->assertCount(0, $client->getPaymentInstruments($customer));
        $request = $client->getLastResponse();
        $error = \GuzzleHttp\json_decode($request->getBody(), true);
        $this->assertEquals(404, $request->getStatusCode());
        $this->assertEquals('NOT_FOUND', $error['error_code']);
    }


    function testDisablePaymentInstrument()
    {
        $customer = clone self::$customer;
        $instrument = new PaymentInstrument(
            [
                'token' => 'fake_token_card',
                'active' => true,
                'type' => 'token_type',
                'card' => [
                    'last_4_digits' => '0000',
                    'type' => 'card schema name',
                ],
            ]
        );

        $header = ['Content-Type' => 'application/json'];
        $responseCollection = [
            new Response(
                204,
                $header,
                /** @lang JSON */
                <<<JSON
{
  "token": "...",
  "active": true,
  "type": "...",
  "card": {
    "last_4_digits": "...",
    "type": "..."
  }
}
JSON
            ),
            new Response(
                404,
                $header,
                /** @lang JSON */
                <<<JSON
{
  "error_code": "NOT_FOUND",
  "message": "Customer not found"
}
JSON
            ),
        ];
        $options = ['handler' => HandlerStack::create(new MockHandler($responseCollection))];
        $token = new AccessToken('FAKE_TOKEN', 'Bearer', '86000');
        $client = new CustomerClient(self::$context, $options);
        $client->setToken($token);
        $this->assertNotNull($client->disablePaymentInstrument($customer, $instrument));
        $this->assertFalse($client->disablePaymentInstrument($customer, $instrument));
    }
}
