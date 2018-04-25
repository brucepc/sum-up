<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 22/03/18
 * Time: 15:31
 */

namespace BPCI\SumUp\Payum;


use BPCI\SumUp\Checkout\Checkout;
use BPCI\SumUp\Checkout\CheckoutClient;
use BPCI\SumUp\Context;
use Payum\Core\Bridge\Spl\ArrayObject;
use BPCI\SumUp\Transaction\TransactionClient;
use BPCI\SumUp\Transaction\Transaction;

class Api
{
    /** @var Context $context */
    protected $context;

    protected $options;

    public function __construct(array $options, Context $context)
    {
        $this->context = $context;
        $options = ArrayObject::ensureArrayObject($options);
        $options->validateNotEmpty(['pay_to_email']);
        $this->options = $options;
    }

    public function createCheckout(array $fields, array $options = [])
    {
        $fields = ArrayObject::ensureArrayObject($fields);
        $fields['pay_to_email'] = $this->options['pay_to_email'];
        $fields->validateNotEmpty(
            [
                'checkout_reference',
                'amount',
                'pay_to_email',
            ]
        );

        $checkout = new Checkout($fields->toUnsafeArray());
        $clientCheckout = new CheckoutClient($this->context, $options);
        $clientCheckout->create($checkout);

        return \GuzzleHttp\json_decode($clientCheckout->getLastResponse()->getBody(), true);
    }

    public function refund(array $fields, string $amount = null, array $options = [])
    {
        $transaction = new Transaction($fields);
        $transactionClient = new TransactionClient($this->context, $options);
        $transactionClient->refund($transaction, $amount);
    }

}