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
    private $id;

    // add your own fields
}
