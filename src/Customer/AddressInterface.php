<?php
namespace BPCI\SumUp\Customer;

interface AddressInterface
{
    function getLine1(): string;
    function setLine1(string $line): AddressInterface;
    function getLine2(): string;
    function setLine2(string $line): AddressInterface;
    function getCountry(): string;
    function setCountry(string $country): AddressInterface;
    function getCity(): string;
    function setCity(string $city): AddressInterface;
    function getState(): string;
    function setState(string $state): AddressInterface;
}