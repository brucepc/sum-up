<?php

namespace BPCI\SumUp\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use BPCI\SumUp\Checkout\Checkout as SumUpCheckout;

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

    // add your own fields
	function __construct(array $data = null)
	{
		parent::__construct($data);
		$this->setCustomer(new Customer());
	}
}
