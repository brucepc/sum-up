<?php

namespace BPCI\SumUp\Customer;

class Address extends AddressInterface
{
    /**
     * First address line
     *
     * @var string $line1
     */
    private $line1;

    /**
     * Second address line
     *
     * @var string
     */
    private $line2;

    /**
     * Address Country
     *
     * @var string
     */
    private $country;

    /**
     * Address postal code
     *
     * @var string
     */
    private $postalCode;

    /**
     * Address City
     *
     * @var string
     */
    private $city;    

    /**
     * Address State 
     *
     * @var string
     */
    private $state;

    function __construct($data)
    {
        $this->setLine1($data['line1']);
        $this->setLine2($data['line2']);
        $this->setCountry($data['country']);
        $this->setPostalCode($data['postal_code']);
        $this->setCity($data['city']);
        $this->setState($data['state']);
    }

    /**
     * Get $line1
     *
     * @return  string
     */ 
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * Set $line1
     *
     * @param  string  $line1  $line1
     *
     * @return  self
     */ 
    public function setLine1(string $line1)
    {
        $this->line1 = $line1;

        return $this;
    }

    /**
     * Get second address line
     *
     * @return  string
     */ 
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * Set second address line
     *
     * @param  string  $line2  Second address line
     *
     * @return  self
     */ 
    public function setLine2(string $line2)
    {
        $this->line2 = $line2;

        return $this;
    }

    /**
     * Get address Country
     *
     * @return  string
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set address Country
     *
     * @param  string  $country  Address Country
     *
     * @return  self
     */ 
    public function setCountry(string $country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get address postal code
     *
     * @return  string
     */ 
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set address postal code
     *
     * @param  string  $postalCode  Address postal code
     *
     * @return  self
     */ 
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get address City
     *
     * @return  string
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address City
     *
     * @param  string  $city  Address City
     *
     * @return  self
     */ 
    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get address State
     *
     * @return  string
     */ 
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set address State
     *
     * @param  string  $state  Address State
     *
     * @return  self
     */ 
    public function setState(string $state)
    {
        $this->state = $state;

        return $this;
    }
}