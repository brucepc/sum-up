<?php

namespace BPCI\SumUp\Tests\Entity;

use BPCI\SumUp\Checkout\Checkout as SumUpCheckout;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BPCI\SumUp\Tests\Repository\CheckoutRepository")
 */
class Checkout extends SumUpCheckout
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     */
    protected $amount;

    /**
     * @ORM\Column(type="string")
     */
    protected $reference;

    /**
     * @ORM\Column(type="string")
     */
    protected $currency;

    /**
     * @ORM\Column(type="string")
     */
    protected $payToEmail;

    // add your own fields
	function __construct(array $data = null)
	{
		parent::__construct($data);
		$this->setCustomer(new Customer());
	}
}
