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
    function getPayToEmail(): string;
    function setPayToEmail(string $email): CheckoutInterface;
    function getPayFromEmail(): string;
    function setPayFromEmail(string $email): CheckoutInterface;
    function getReference(): string;
    function setReference(string $reference): CheckoutInterface;
    function getDescription(): string;
    function setDescription(string $description): CheckoutInterface;
    function getRedirectUrl(): string;
    function setRedirectUrl(string $url): CheckoutInterface;
    function getValidUntil():string;
    function setValidUntil(string $timestamp): CheckoutInterface;
    function getTransactionCode(): string;
    function setTransactionCode(string $code): CheckoutInterface;
    function getTransactionId(): string;
    function setTransactionId(string $id): CheckoutInterface;
    function getTransactions(): Array;
    function setTransactions(Array $transactions): CheckoutInterface;
    function getToken(): string;
    function setToken(string $token): CheckoutInterface;
    function isValid(): bool;
}