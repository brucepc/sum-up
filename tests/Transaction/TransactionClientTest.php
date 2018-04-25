<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 26/03/18
 * Time: 20:59
 */

namespace BPCI\SumUp\Tests;


use BPCI\SumUp\Context;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\Transaction\TransactionClient;
use BPCI\SumUp\Transaction\TransactionClientInterface;
use BPCI\SumUp\Transaction\TransactionHistoryInterface;
use BPCI\SumUp\Transaction\TransactionInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use http\Env\Request;
use PHPUnit\Framework\TestCase;

class TransactionClientTest extends TestCase
{
    protected static $context;

    function setUp()
    {
        self::$context = Context::loadContextFromFile('./tests/test.json');
    }

    function testScopes()
    {
        $this->assertArraySubset(['transactions.history'], TransactionClient::getScopes());
    }

    function testEndPoint()
    {
        $client = new TransactionClient(self::$context);
        $this->assertEquals('me/transactions', $client->getEndPoint());
    }

    function testGetHistory()
    {
        $header = ['Content-Type' => 'application/json'];
        $rCollection = [
            // History response
            new Response(
                200,
                $header,
                /** @lang JSON */
                <<<BODY
{
  "items": [
    {
      "id": "...",
      "transaction_id": "...",
      "user": "...",
      "type": "...",
      "status": "...",
      "timestamp": "...",
      "currency": "...",
      "amount": 1,
      "transaction_code": "...",
      "product_summary": "...",
      "installments_count": 1,
      "payment_type": "...",
      "card_type": "...",
      "payouts_total": 1,
      "payouts_received": 1,
      "payout_date": "...",
      "payout_plan": "...",
      "payout_type: ... (string, optional) - BANK_ACCOUNT / PREPAID_CARD / BALANCE": "Hello, world!"
    }
  ],
  "links": [
    {
      "rel": "...",
      "href": "...",
      "type": "..."
    }
  ]
}
BODY
            ),
            // Transactions response
            new Response(
                200,
                $header,
                /** @lang JSON */
                <<<BODY
{
  "id": "...",
  "transaction_code": "...",
  "foreign_transaction_id": "...",
  "merchant_code": "...",
  "username": "...",
  "amount": 1,
  "vat_amount": 1,
  "tip_amount": 1,
  "currency": "...",
  "timestamp": "...",
  "lat": 1,
  "lon": 1,
  "horizontal_accuracy": 1,
  "status": "...",
  "payment_type": "...",
  "simple_payment_type": "...",
  "entry_mode": "...",
  "verification_method": "...",
  "card": {
    "last_4_digits": "...",
    "type": "..."
  },
  "elv_account": {
    "sort_code": "...",
    "last_4_digits": "...",
    "sequence_no": "...",
    "iban": "..."
  },
  "product_summary": "...",
  "local_time": "...",
  "payout_date": "...",
  "payout_plan": "...",
  "payout_type": "...",
  "installments_count": 1,
  "process_as": "...",
  "products": {
    "name": "...",
    "price": 1,
    "vat_rate": 1,
    "single_vat_amount": 1,
    "price_with_vat": 1,
    "vat_amount": 1,
    "quantity": 1,
    "total_price": 1,
    "total_with_vat": 1
  },
  "transaction_events": {
    "id": 1,
    "event_type: ... (string, optional) - Type of the transaction event. Possible values: PAYOUT, CHARGE_BACK, REFUND": "Hello, world!",
    "status": "...",
    "amount": 1,
    "due_date": "...",
    "date": "...",
    "installment_number": 1,
    "timestamp": "..."
  },
  "simple_status: CANCEL_FAILED|CANCELLED|CHARGEBACK|FAILED|REFUND_FAILED|REFUNDED|SUCCESSFUL(string, optional) - Simple status generated from processing status and latest transaction state - Possible values CANCEL_FAILED,CANCELLED,CHARGEBACK,FAILED,REFUND_FAILED,REFUNDED,SUCCESSFUL": "Hello, world!",
  "links": {
    "rel": "...",
    "href": "...",
    "type": "..."
  },
  "events": {
    "id": 1,
    "transaction_id": "...",
    "type": "...",
    "status": "...",
    "amount": 1,
    "timestamp": "...",
    "fee_amount": 1,
    "receipt_no": "..."
  },
  "payouts_received": 1,
  "payouts_total": 1,
  "location": {
    "lat": 1,
    "lon": 1,
    "horizontal_accuracy": 1
  },
  "tax_enabled": true,
  "auth_code": "...",
  "internal_id": 1
}
BODY
            ),
            // Receipts response
            new Response(
                200,
                $header,
                /** @lang JSON */
                <<<BODY
{
  "transaction": {
    "transaction_code": "...",
    "merchant_code": "...",
    "amount": 1,
    "vat_amount": 1,
    "tip_amount": 1,
    "currency": "...",
    "timestamp": "...",
    "status": "...",
    "payment_type": "...",
    "simple_payment_type": "...",
    "entry_mode": "...",
    "verification_method": "...",
    "card": {
      "last_4_digits": "...",
      "type": "..."
    },
    "elv_account": {
      "sort_code": "...",
      "last_4_digits": "...",
      "sequence_no": "...",
      "iban": "..."
    },
    "local_time": "...",
    "installments_count": 1,
    "process_as": "...",
    "products": {
      "name": "...",
      "price": 1,
      "vat_rate": 1,
      "single_vat_amount": 1,
      "price_with_vat": 1,
      "vat_amount": 1,
      "quantity": 1,
      "total_price": 1,
      "total_with_vat": 1
    },
    "events": {
      "id": 1,
      "transaction_id": "...",
      "type": "...",
      "status": "...",
      "amount": 1,
      "timestamp": "...",
      "fee_amount": 1,
      "receipt_no": "..."
    },
    "location": {
      "lat": 1,
      "lon": 1,
      "horizontal_accuracy": 1
    },
    "tax_enabled": true,
    "auth_code": "..."
  },
  "merchant_profile": {
    "merchant_code": "...",
    "business_name": "...",
    "company_registration_number": "...",
    "vat_id": "...",
    "website": "...",
    "email": "...",
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
    },
    "settings": {
      "tax_enabled": "..."
    },
    "legal_type": {
      "description": "...",
      "sole_trader": true
    },
    "national_id": "...",
    "locale": "..."
  },
  "signature": "...",
  "receipt_number": "...",
  "card_application": {
    "name": "...",
    "aid": "..."
  },
  "acquirer_data": {
    "tid": "...",
    "mid": "...",
    "authorization_code": "...",
    "mandate_reference": "...",
    "return_code": "...",
    "local_time": "..."
  },
  "emv_data": {
    "tvr": "...",
    "tsi": "...",
    "cvr": "...",
    "iad": "...",
    "arc": "...",
    "aid": "...",
    "act": "...",
    "acv": "..."
  }
}
BODY
            ),
            // Refund response
            new Response(
                204,
                $header,
                ""
            ),
        ];

        $options = [
            'handler' => HandlerStack::create(new MockHandler($rCollection)),
        ];
        $token = new AccessToken('FAKE_TOKEN', 'Bearer', '86000');
        /** @var TransactionClientInterface $client */
        $client = new TransactionClient(self::$context, $options);
        $client->setToken($token);
        /** @var TransactionHistoryInterface $history */
        $history = $client->getHistory([]);
        $this->assertInstanceOf(TransactionHistoryInterface::class, $history);
        $this->assertNotNull($history->getItems());
        $this->assertNotNull($history->getLinks());
        $filter = [];
        $transaction = $client->getTransactionDetails($filter);
        $client->refund($transaction);
    }

}