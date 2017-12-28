<?php

namespace BPCI\SumUp\Customer;

class Customer implements CustomerInterface
{
    /**
     * Customer SumUp ID
     *
     * @var string
     */
    private $customerId;

    /**
     * Customer Name
     *
     * @var string
     */
    private $name;

    /**
     * Customer phone
     *
     * @var string
     */
    private $phone;

    /**
     * Cusomter address
     *
     * @var AddressInterface
     */
    private $address;

    /**
     * Get customer SumUp ID
     *
     * @return  string
     */ 
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customer SumUp ID
     *
     * @param  string  $customerId  Customer SumUp ID
     *
     * @return  self
     */ 
    public function setCustomerId(string $customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customer Name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set customer Name
     *
     * @param  string  $name  Customer Name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get customer phone
     *
     * @return  string
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set customer phone
     *
     * @param  string  $phone  Customer phone
     *
     * @return  self
     */ 
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get cusomter address
     *
     * @return  AddressInterface
     */ 
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cusomter address
     *
     * @param Array|AddressInterface $address  Cusomter address
     *
     * @return  self
     */ 
    public function setAddress($address)
    {
        if($address instanceof AddressInterface)
        {
            $this->address = $address;
        }else{
            $this->address = new Address($address);
        }

        return $this;
    }
}