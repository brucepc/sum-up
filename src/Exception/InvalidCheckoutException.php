<?php
namespace BPCI\SumUp\Exception;

use BPCI\SumUp\Checkout\CheckoutInterface;
use Throwable;

class InvalidCheckoutException extends \RuntimeException
{
	public function __construct($message = "",CheckoutInterface $checkout, $code = 0, Throwable $previous = null)
	{
		$message = sprintf(<<<MSG
		%s
		Something is wrong with this checkout:
		 checkout_reference: %s
		 amount: %s
		 pay_to_email: %s
MSG
		, $message, $checkout->getReference(), $checkout->getAmount(), $checkout->getPayToEmail());
		parent::__construct($message, $code, $previous);
	}
}
