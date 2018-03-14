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
    public function getId(): ?string;

	/**
	 * @param string $id
	 * @return CheckoutInterface
	 */
    public function setId(string $id): self;

	/**
	 * @return null|string
	 */
    public function getStatus(): ?string;

	/**
	 * @param string $status
	 * @return CheckoutInterface
	 */
    public function setStatus(string $status): self;


	/**
	 * @param float $amount
	 * @return CheckoutInterface
	 */
    public function setAmount(float $amount): self;

	/**
	 * @return float
	 */
    public function getAmount():? float;

	/**
	 * @return float|null
	 */
    public function getFeeAmount():? float;

	/**
	 * @param float $amount
	 * @return CheckoutInterface
	 */
    public function setFeeAmount(float $amount): self;

	/**
	 * @return null|string
	 */
    public function getCurrency(): ?string;

	/**
	 * @param string $currency
	 * @return CheckoutInterface
	 */
    public function setCurrency(string $currency): self;

	/**
	 * @return CustomerInterface|null
	 */
    public function getCustomer(): ?CustomerInterface;

	/**
	 * @param CustomerInterface $customer
	 * @return CheckoutInterface
	 */
    public function setCustomer(CustomerInterface $customer): self;

	/**
     * @return PaymentInstrumentInterface|null
	 */
    public function getCard(): ?PaymentInstrumentInterface;

	/**
     * @param PaymentInstrumentInterface $card
	 * @return CheckoutInterface
	 */
    public function setCard(PaymentInstrumentInterface $card): self;

	/**
	 * @return null|string
	 */
    public function getPayToEmail(): ?string;

	/**
	 * @param string $email
	 * @return CheckoutInterface
	 */
    public function setPayToEmail(string $email): self;

	/**
	 * @return null|string
	 */
    public function getPayFromEmail(): ?string;

	/**
	 * @param string $email
	 * @return CheckoutInterface
	 */
    public function setPayFromEmail(string $email): self;

	/**
	 * @return null|string
	 */
    public function getReference(): ?string;

	/**
	 * @param string $reference
	 * @return CheckoutInterface
	 */
    public function setReference(string $reference): self;

	/**
	 * @return null|string
	 */
    public function getDescription(): ?string;

	/**
	 * @param string $description
	 * @return CheckoutInterface
	 */
    public function setDescription(string $description): self;

	/**
	 * @return null|string
	 */
    public function getRedirectUrl(): ?string;

	/**
	 * @param string $url
	 * @return CheckoutInterface
	 */
    public function setRedirectUrl(string $url): self;

	/**
	 * @return string
	 */
    public function getValidUntil():? string;

	/**
	 * @param string $timestamp
	 * @return CheckoutInterface
	 */
    public function setValidUntil(string $timestamp): self;

	/**
	 * @return null|string
	 */
    public function getTransactionCode(): ?string;

	/**
	 * @param string $code
	 * @return CheckoutInterface
	 */
    public function setTransactionCode(string $code): self;

	/**
	 * @return null|string
	 */
    public function getTransactionId(): ?string;

	/**
	 * @param string $id
	 * @return CheckoutInterface
	 */
    public function setTransactionId(string $id): self;

	/**
	 * @return array|null
	 */
    public function getTransactions(): ?array;

	/**
	 * @param array $transactions
	 * @return CheckoutInterface
	 */
    public function setTransactions(array $transactions): self;

	/**
	 * @return null|string
	 */
    public function getToken(): ?string;

	/**
	 * @param string $token
	 * @return CheckoutInterface
	 */
    public function setToken(string $token): self;

	/**
     * @return bool
	 */
    public function isValid(): bool;

	/**
	 * @param string|null $type
	 * @return CheckoutInterface
	 */
    public function setType(string $type = null): self;

	/**
	 * @return null|string
	 */
    public function getType():? string;

    public function setInstallments(?string $installments):? self;

    public function getInstallments():? string;

}
