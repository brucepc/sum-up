<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 25/02/18
 * Time: 10:29
 */

namespace BPCI\SumUp\Tests\Checkout;


use BPCI\SumUp\Checkout\CheckoutClient;
use BPCI\SumUp\Checkout\CheckoutInterface;
use BPCI\SumUp\Context;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\Tests\Entity\Checkout;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CheckoutClientTest extends TestCase
{
    protected static $context;

    function setUp()
    {
        self::$context = Context::loadContextFromFile('./tests/test.json');
    }

    function testCompleteUrlGenerate()
    {
        $id = uniqid();
        $checkout = new Checkout(['id' => $id]);
        $url_generated = CheckoutClient::getCompleteUrl($checkout);
        $url = SumUp::getEntrypoint().$id;
        $this->assertEquals($url, $url_generated);
    }

    /**
     * @cover CheckoutClient::request()
     */
    function testCreatingANewCheckout()
    {
        $reference = uniqid();
        $checkout = new Checkout(
            [
                'currency' => 'EUR',
                'amount' => 1,
                'pay_to_email' => 'merchant@mail.com',
                'checkout_reference' => $reference,
                'description' => 'unit test',
            ]
        );
        $header = ['Content-Type' => 'application/json'];
        $responseCollection = [
            new Response(
                201,
                $header,
                /** @lang JSON */
                <<<BODY
{
  "checkout_reference": "...",
  "amount": 1,
  "currency": "BRL",
  "pay_to_email": "merchant@mail.com",
  "pay_from_email": "...",
  "description": "...",
  "id": "...",
  "status": "PENDING|PAID|FAILED",
  "date": "...",
  "return_url": "...",
  "valid_until": "...",
  "transactions": [
    {
      "id": "...",
      "transaction_code": "...",
      "merchant_code": "...",
      "amount": 1,
      "vat_amount": 1,
      "tip_amount": 1,
      "currency": "...",
      "timestamp": "...",
      "status": "...",
      "payment_type": "...",
      "entry_mode": "...",
      "installments_count": 1,
      "auth_code": "...",
      "internal_id": 1
    }
  ]
}
BODY
            ),
            new Response(
                409,
                $header,
                /** @lang JSON */
                <<<BODY
{
  "error_code": "DUPLICATED_CHECKOUT",
  "message": "Checkout with this checkout reference and pay to email already exists"
}
BODY
            ),
        ];

        $options = [
            'handler' => HandlerStack::create(new MockHandler($responseCollection)),
        ];
        $token = new AccessToken('FAKE_TOKEN', 'Bearer', '86000');
        $client = new CheckoutClient(self::$context, $options);
        $client->setToken($token);
        $this->assertInstanceOf(CheckoutInterface::class, $client->create($checkout));
        $this->assertNotNull($checkout->getId());
        $this->assertNotNull($checkout->getCheckoutReference());
        $this->assertNotNull($client->getLastResponse());
        $this->assertNull($client->create($checkout));
    }

    function testCompletingACheckout()
    {
        $id = uniqid();
        $reference = uniqid();
        $checkout = new Checkout(
            [
                "id" => $id,
                'currency' => 'EUR',
                "payment_type" => "card",
                "token" => "VALID_CARD_TOKEN",
                "customer_id" => "YOUR_CUSTOMER_ID",
                'checkout_reference' => $reference,
                'amount' => 1,
                'pay_to_email' => 'merchant@sumup.com',
            ]
        );
        $checkout->setId($id);
        $header = ['Conent-Type' => 'application/json'];
        $responseCollection = [
            new Response(
                200,
                $header,
                /** @lang JSON */
                <<<BODY
{
  "checkout_reference": "...",
  "amount": 1,
  "currency": "BRL",
  "pay_to_email": "...",
  "pay_from_email": "...",
  "description": "...",
  "id": "...",
  "status": "...",
  "date": "...",
  "return_url": "...",
  "valid_until": "...",
  "transaction_code": "...",
  "transaction_id": "...",
  "transactions": [
    {
      "id": "...",
      "transaction_code": "...",
      "merchant_code": "...",
      "amount": 1,
      "vat_amount": 1,
      "tip_amount": 1,
      "currency": "...",
      "timestamp": "...",
      "status": "...",
      "payment_type": "...",
      "entry_mode": "...",
      "installments_count": 1,
      "auth_code": "...",
      "internal_id": 1
    }
  ],
  "token": "..."
}
BODY
            ),
            new Response(
                409,
                $header,
                /** @lang JSON */
                <<<BODY
{
	"error_code": "INSUFFICIENT_BALANCE",
	"message": "Sender balance not enough to cover the payment"
}
BODY
            ),
        ];
        $mock = new MockHandler($responseCollection);
        $options = [
            'handler' => HandlerStack::create($mock),
        ];

        $token = new AccessToken('FAKE_TOKEN', 'Bearer', '86000');
        $client = new CheckoutClient(self::$context, $options);
        $client->setToken($token);
        $this->assertInstanceOf(CheckoutInterface::class, $client->complete($checkout));
        $this->assertNull($client->complete($checkout));
    }
}
