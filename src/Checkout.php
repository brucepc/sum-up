<?php
namespace BPCI\SumUp\SDK;

class Checkout
{
    private $id;
    private $status;
    private $amount;
    private $payTo;
    private $reference;
    private $description;

    function __construct($amount, $pay_to_email, $checkout_reference, $description)
    {

        $this->amount = $amount;
        $this->payTo = $pay_to_email;
        $this->reference = $checkout_reference;
        $this->description = $description;
    }

    static function create($amount, $pay_to_email, $checkout_reference, $description)
    {
        $checkout = new Checkout($amount, $pay_to_email, $checkout_reference, $description);
        
    }

}
