<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\Customer\PaymentInstrument\PaymentInstrumentInterface;

/**
 * Interface CheckoutInterface
 * @package BPCI\SumUp\Checkout
 */
interface CheckoutInterface
{
	/**
	 * @return null|string
	 */
	function getId(): ?string;

	/**
	 * @param string $id
	 * @return CheckoutInterface
	 */
	function setId(string $id): self;

	/**
	 * @return null|string
	 */
	function getStatus(): ?string;

	/**
	 * @param string $status
	 * @return CheckoutInterface
	 */
	function setStatus(string $status): self;


	/**
	 * @param float $amount
	 * @return CheckoutInterface
	 */
	function setAmount(float $amount): self;

	/**
	 * @return float
	 */
	function getAmount():? float;

	/**
	 * @return float|null
	 */
    function getFeeAmount():? float;

	/**
	 * @param float $amount
	 * @return CheckoutInterface
	 */
	function setFeeAmount(float $amount): self;

	/**
	 * @return null|string
	 */
	function getCurrency(): ?string;

	/**
	 * @param string $currency
	 * @return CheckoutInterface
	 */
	function setCurrency(string $currency): self;

	/**
	 * @return CustomerInterface|null
	 */
	function getCustomer(): ?CustomerInterface;

	/**
	 * @param CustomerInterface $customer
	 * @return CheckoutInterface
	 */
	function setCustomer(CustomerInterface $customer): self;

	/**
     * @return PaymentInstrumentInterface|null
	 */
    function getCard(): ?PaymentInstrumentInterface;

	/**
     * @param PaymentInstrumentInterface $card
	 * @return CheckoutInterface
	 */
    function setCard(PaymentInstrumentInterface $card): self;

	/**
	 * @return null|string
	 */
	function getPayToEmail(): ?string;

	/**
	 * @param string $email
	 * @return CheckoutInterface
	 */
	function setPayToEmail(string $email): self;

	/**
	 * @return null|string
	 */
	function getPayFromEmail(): ?string;

	/**
	 * @param string $email
	 * @return CheckoutInterface
	 */
	function setPayFromEmail(string $email): self;

	/**
	 * @return null|string
	 */
	function getReference(): ?string;

	/**
	 * @param string $reference
	 * @return CheckoutInterface
	 */
	function setReference(string $reference): self;

	/**
	 * @return null|string
	 */
	function getDescription(): ?string;

	/**
	 * @param string $description
	 * @return CheckoutInterface
	 */
	function setDescription(string $description): self;

	/**
	 * @return null|string
	 */
	function getRedirectUrl(): ?string;

	/**
	 * @param string $url
	 * @return CheckoutInterface
	 */
	function setRedirectUrl(string $url): self;

	/**
	 * @return string
	 */
	function getValidUntil():? string;

	/**
	 * @param string $timestamp
	 * @return CheckoutInterface
	 */
	function setValidUntil(string $timestamp): self;

	/**
	 * @return null|string
	 */
	function getTransactionCode(): ?string;

	/**
	 * @param string $code
	 * @return CheckoutInterface
	 */
	function setTransactionCode(string $code): self;

	/**
	 * @return null|string
	 */
	function getTransactionId(): ?string;

	/**
	 * @param string $id
	 * @return CheckoutInterface
	 */
	function setTransactionId(string $id): self;

	/**
	 * @return array|null
	 */
	function getTransactions(): ?array;

	/**
	 * @param array $transactions
	 * @return CheckoutInterface
	 */
	function setTransactions(array $transactions): self;

	/**
	 * @return null|string
	 */
	function getToken(): ?string;

	/**
	 * @param string $token
	 * @return CheckoutInterface
	 */
	function setToken(string $token): self;

	/**
	 * @return bool|null
	 */
	function isValid(): ?bool;

	/**
	 * @param string|null $type
	 * @return CheckoutInterface
	 */
	function setType(string $type = null): self;

	/**
	 * @return null|string
	 */
	function getType():? string;

	function setInstallments(?string $installments):? self;
	function getInstallments():? string;

}
