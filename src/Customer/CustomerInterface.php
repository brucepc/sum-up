<?php
namespace BPCI\SumUp\Customer;

interface CustomerInterface
{
    public function getCustomerId(): ?string;

    public function setCustomerId(?string $id): self;

    public function getName(): ?string;

    public function setName(?string $name): self;

    public function getPhone(): ?string;

    public function setPhone(?string $phone): self;

    public function getAddress(): AddressInterface;

    public function setAddress(AddressInterface $address): self;
}
