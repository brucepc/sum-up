<?php
namespace BPCI\SumUp\Customer;

interface AddressInterface
{
    function getLine1(): ?string;
    function setLine1(?string $line): self;
    function getLine2(): ?string;
    function setLine2(?string $line): self;
    function getCountry(): ?string;
    function setCountry(?string $country): self;
    function getPostalCode(): ?string;
    function setPostalCode(?string $code): self;
    function getCity(): ?string;
    function setCity(?string $city): self;
    function getState(): ?string;
    function setState(?string $state): self;
}