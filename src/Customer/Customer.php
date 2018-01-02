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
     * cpf or cnpj of brazilian customer max 14 characters
     *
     * @var string
     */
    private $cpfCnpj;

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

    function __construct()
    {
        $this->address = new Address([]);
    }

    /**
     * Get customer SumUp ID
     *
     * @return  string
     */ 
    public function getCustomerId(): ?string
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
    public function setCustomerId(?string $customerId): CustomerInterface
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customer Name
     *
     * @return  string
     */ 
    public function getName(): ?string
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
    public function setName(?string $name): CustomerInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get customer phone
     *
     * @return  string
     */ 
    public function getPhone(): ?string
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
    public function setPhone(?string $phone): CustomerInterface
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get cusomter address
     *
     * @return  AddressInterface
     */ 
    public function getAddress(): ?AddressInterface
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
    public function setAddress($address): CustomerInterface
    {
        if($address instanceof AddressInterface)
        {
            $this->address = $address;
        }else{
            $this->address = new Address($address);
        }

        return $this;
    }

    function isValid():bool
    {
        return $this->getName() !== null
                && $this->getCpfCnpj() !== null;
    }

    /**
     * Get cpf or cnpj of brazilian customer max 14 characters
     *
     * @return  string
     */ 
    public function getCpfCnpj(): ?string
    {
        return $this->cpfCnpj;
    }

    /**
     * Set cpf or cnpj of brazilian customer max 14 characters
     *
     * @param  string  $cpfCnpj  cpf or cnpj of brazilian customer max 14 characters
     *
     * @return  self
     */ 
    public function setCpfCnpj(?string $cpfCnpj): CustomerInterface
    {
        $this->cpfCnpj = trim($cpfCnpj) === '' ? null : $cpfCnpj;

        return $this;
    }
}