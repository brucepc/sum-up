<?php

namespace BPCI\SumUp\Customer;

class Address implements AddressInterface
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

    function __construct($data = [])
    {
        $this->setLine1($data['line1'] ?? null);
        $this->setLine2($data['line2'] ?? null);
        $this->setCountry($data['country'] ?? null);
        $this->setPostalCode($data['postal_code'] ?? null);
        $this->setCity($data['city'] ?? null);
        $this->setState($data['state'] ?? null);
    }

    /**
     * Get $line1
     *
     * @return  string
     */ 
    public function getLine1(): ?string
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
    public function setLine1(?string $line1): AddressInterface
    {
        $this->line1 = $line1;

        return $this;
    }

    /**
     * Get second address line
     *
     * @return  string
     */ 
    public function getLine2(): ?string
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
    public function setLine2(?string $line2): AddressInterface
    {
        $this->line2 = $line2;

        return $this;
    }

    /**
     * Get address Country
     *
     * @return  string
     */ 
    public function getCountry(): ?string
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
    public function setCountry(?string $country): AddressInterface
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get address postal code
     *
     * @return  string
     */ 
    public function getPostalCode(): ?string
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
    public function setPostalCode(?string $postalCode): AddressInterface
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get address City
     *
     * @return  string
     */ 
    public function getCity(): ?string
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
    public function setCity(?string $city): AddressInterface
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get address State
     *
     * @return  string
     */ 
    public function getState(): ?string
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
    public function setState(?string $state): AddressInterface
    {
        $this->state = $state;

        return $this;
    }
}