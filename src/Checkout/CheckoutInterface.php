<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\Customer\Card\CardInterface;

interface CheckoutInterface
{
    function getId(): ?string;
    function setId(string $id): self;
    function getStatus(): ?string;
    function setStatus(string $status): self;
    function getAmount(): ?float;
    function setAmount(float $amount): self;
    function getFeeAmount(): ?float;
    function setFeeAmount(float $amount): self;
    function getCurrency(): ?string;
    function setCurrency(string $currency): self;
    function getCustomer(): ?CustomerInterface;
    function setCustomer(CustomerInterface $customer): self;
    function getCard(): ?CardInterface;
    function setCard(CardInterface $card): self;
    function getPayToEmail(): ?string;
    function setPayToEmail(string $email): self;
    function getPayFromEmail(): ?string;
    function setPayFromEmail(string $email): self;
    function getReference(): ?string;
    function setReference(string $reference): self;
    function getDescription(): ?string;
    function setDescription(string $description): self;
    function getRedirectUrl(): ?string;
    function setRedirectUrl(string $url): self;
    function getValidUntil():string;
    function setValidUntil(string $timestamp): self;
    function getTransactionCode(): ?string;
    function setTransactionCode(string $code): self;
    function getTransactionId(): ?string;
    function setTransactionId(string $id): self;
    function getTransactions(): ?Array;
    function setTransactions(Array $transactions): self;
    function getToken(): ?string;
    function setToken(string $token): self;
    function isValid(): ?bool;
}