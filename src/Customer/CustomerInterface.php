<?php
namespace BPCI\SumUp\Customer;

interface CustomerInterface
{
    function getCustomerId(): ?string;
    function setCustomerId(?string $id): self;
    function getName(): ?string;
    function setName(?string $name): self;
    function getPhone(): ?string;
    function setPhone(?string $phone): self;
    function getAddress(): AddressInterface;
    function setAddress(AddressInterface $address): self;
    function isValid(): bool;
}
