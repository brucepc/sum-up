<?php

namespace BPCI\SumUp\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use BPCI\SumUp\Customer\Address as SumUpAddress;

/**
 * @ORM\Entity(repositoryClass="BPCI\SumUp\Tests\Repository\AddressRepository")
 */
class Address extends SumUpAddress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
}
