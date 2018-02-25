<?php

namespace BPCI\SumUp\Tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use BPCI\SumUp\Customer\Customer as SumUpCustomer;

/**
 * @ORM\Entity(repositoryClass="BPCI\SumUp\Tests\Repository\CustomerRepository")
 */
class Customer extends SumUpCustomer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
	 * Set the value of id
	 *
	 * @param $id
	 * @return Customer
	 */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}
