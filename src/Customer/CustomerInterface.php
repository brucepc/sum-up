<?php
namespace BPCI\SumUp\Customer;

interface CustomerInterface
{
    function getCustomerId(): string;
    function setCustomerId(string $id): self;
    function getName(): string;
    function setName(string $name): self;
    function getCpfCnpj(): string;
    function setCpfCnpj(string $cpfCnpj): self;
    function getPhone(): string;
    function setPhone(string $phone): self;
    function getAddress(): AddressInterface;
    function setAddress(Array $address): self;
    function isValid(): bool;
}