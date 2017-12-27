<?php
namespace BPCI\SumUp\Checkout;

interface CheckoutInterface
{
    function getId(): string;
    function setId(string $id): CheckoutInterface;
    function getStatus(): string;
    function setStatus(string $status): CheckoutInterface;
    function getAmount(): number;
    function setAmount(number $amount): CheckoutInterface;
    function getFeeAmount(): number;
    function setFeeAmount(number $amount): CheckoutInterface;
    function getCurrency(): string;
    function setCurrency(string $currency): CheckoutInterface;
    function getPayTo(): string;
    function setPayTo(string $email): CheckoutInterface;
    function getPayFrom(): string;
    function setPayFrom(string $email): CheckoutInterface;
    function getReference(): string;
    function setReference(string $reference): CheckoutInterface;
    function getDescription(): string;
    function setDescription(string $description): CheckoutInterface;
    function getRedirectUrl(): string;
    function setRedirectUrl(string $url): CheckoutInterface;
    function isValid(): bool;
}