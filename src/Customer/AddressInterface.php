<?php
namespace BPCI\SumUp\Customer;

interface AddressInterface
{
    public function getLine1(): ?string;

    public function setLine1(?string $line): self;

    public function getLine2(): ?string;

    public function setLine2(?string $line): self;

    public function getCountry(): ?string;

    public function setCountry(?string $country): self;

    public function getPostalCode(): ?string;

    public function setPostalCode(?string $code): self;

    public function getCity(): ?string;

    public function setCity(?string $city): self;

    public function getState(): ?string;

    public function setState(?string $state): self;
}