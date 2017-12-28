<?php
namespace BPCI\SumUp\Customer;

interface CustomerInterface
{
    function getCustomerId(): string;
    function setCustomerId(string $id): CustomerInterface;
    function getName(): string;
    function setName(string $name): CustomerInterface;
    function getPhone(): string;
    function setPhone(string $phone): CustomerInterface;
    function getAddress(): AddressInterface;
    function setAddress(Array $address): CustomerInterface;
}