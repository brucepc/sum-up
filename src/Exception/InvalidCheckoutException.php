<?php
namespace BPCI\SumUp\Exception;

use BPCI\SumUp\Checkout\CheckoutInterface;
use Throwable;

class InvalidCheckoutException extends \RuntimeException
{
    public function __construct(CheckoutInterface $checkout, $code = 10, Throwable $previous = null)
	{
		$message = sprintf(<<<MSG
		Something is wrong with this checkout:
		 checkout_reference: %s
		 amount: %s
		 pay_to_email: %s
MSG
            ,
            $checkout->getReference(),
            $checkout->getAmount(),
            $checkout->getPayToEmail()
        );
		parent::__construct($message, $code, $previous);
	}
}
