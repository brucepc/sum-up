<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Customer\Card\Card;
use BPCI\SumUp\Customer\Customer;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Exception\InvalidCheckoutException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\Customer\Card\CardInterface;
use BPCI\SumUp\Traits\PropertyHandler;
use BPCI\SumUp\Utils\Currency;
use BPCI\SumUp\Utils\Hydrator;

/**
 */
class Checkout implements CheckoutInterface
{
	use PropertyHandler;

	const PENDING = 'PENDING';
	const COMPLETED = 'COMPLETED';
	const FAILED = 'FAILED';

	protected $id;
	protected $status;
	protected $amount;
	protected $feeAmount;
	protected $currency;
	protected $payToEmail;
	protected $payFromEmail;
	protected $description;
	protected $redirectUrl;
	protected $validUntil;
	protected $token;
	protected $transactionId;
	protected $transactionCode;
	protected $type;
	protected $installments;

	/**
	 * Checkout reference
	 *
	 * @var string
	 */
	protected $reference;

	/**
	 * Customer
	 *
	 * @var null|Customer
	 */
	protected $customer;

	/**
	 * Card
	 *
	 *
	 * @var null|Card
	 */
	protected $card;


	/**
	 * checkout constructor
	 *
	 * @param array $data
	 */
	public function __construct(array $data = null) {
		if ($data !== null) {
			$this->setAmount($data['amount']??null);
			$this->setPayToEmail($data['pay_to_email']??null);
			$this->setCheckoutReference($data['checkout_reference']??null);
			$this->setCurrency($data['currency']??null);
			$this->setDescription($data['description']??null);
			$this->setFeeAmount($data['fee_amount']??null);
			$this->setPayFromEmail($data['pay_from_mail']??null);
			$this->setId($data['id']??null);
			$this->setRedirectUrl($data['redirect_url']??null);
			$this->setStatus($data['status']??null);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function isValid(): bool {
		return $this->getReference() !== null
			&& $this->getAmount() !== null
			&& $this->getPayToEmail() !== null
			&& Currency::isValid($this->getCurrency());
	}

	/**
	 * @inheritDoc
	 */
	public function getId():? string {
		return $this->id;
	}

	/**
	 * @inheritDoc
	 */
	public function setId(?string $id): CheckoutInterface {
		$this->id = $id;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getStatus():? string {
		return $this->status;
	}

	/**
	 * @inheritDoc
	 */
	public function setStatus(?string $status): CheckoutInterface {
		$this->status = $status;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAmount():? float {
		return $this->amount;
	}

	/**
	 * @inheritDoc
	 */
	public function setAmount(float $amount): CheckoutInterface {
		$this->amount = $amount > 0 ? $amount : null;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getCurrency():? string {
		return $this->currency;
	}

	/**
	 * @inheritDoc
	 */
	public function setCurrency(?string $currency): CheckoutInterface {
		$this->currency = $currency;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getPayToEmail():? string {
		return $this->payToEmail;
	}

	/**
	 * @inheritDoc
	 */
	public function setPayToEmail(string $email): CheckoutInterface {
		$this->payToEmail = trim($email) === '' ? null : $email;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getCheckoutReference():? string {
		return $this->reference;
	}

	/**
	 * @inheritDoc
	 */
	public function setCheckoutReference(string $reference): CheckoutInterface {
		$this->reference = trim($reference) === '' ? null : $reference;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDescription():? string {
		return $this->description;
	}

	/**
	 * @inheritDoc
	 */
	public function setDescription(?string $description): CheckoutInterface {
		$this->description = $description;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFeeAmount():? float {
		return $this->feeAmount;
	}

	/**
	 * @inheritDoc
	 */
	public function setFeeAmount(?float $fee): CheckoutInterface {
		$this->feeAmount = $fee;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getPayFromEmail():? string {
		return $this->payFromEmail;
	}

	/**
	 * @inheritDoc
	 */
	public function setPayFromEmail(?string $email): CheckoutInterface {
		$this->payFromEmail = $email;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getRedirectUrl():? string {
		return $this->redirectUrl;
	}

	/**
	 * @inheritDoc
	 */
	public function setRedirectUrl(?string $url): CheckoutInterface {
		$this->redirectUrl = $url;
		return $this;
	}

	function getValidUntil():? string {
		return $this->validUntil;
	}

	function setValidUntil(?string $timestamp): CheckoutInterface {
		$this->validUntil = $timestamp;
		return $this;
	}

	function getTransactionCode():? string {
		return $this->transactionCode;
	}

	function setTransactionCode(?string $code): CheckoutInterface {
		$this->transactionCode = $code;
		return $this;
	}

	function getTransactionId():? string {
		return $this->transactionId;
	}

	function setTransactionId(?string $id): CheckoutInterface {
		$this->transactionId = $id;
		return $this;
	}

	function getTransactions():? array {
//        return $this->transactions;
		//TODO remember myself whats is it.
		return [];
	}

	function setTransactions(?Array $transactions): CheckoutInterface {
//        $this->transactions = $transactions;
		//TODO remember myself whats is it.
		return $this;
	}

	function getToken():? string {
		return $this->token;
	}

	function setToken(?string $token): CheckoutInterface {
		$this->token = $token;
		return $this;
	}

	/**
	 * Get customer
	 * @return CustomerInterface|null
	 */
	public function getCustomer(): ?CustomerInterface
	{
		return $this->customer;
	}

	/**
	 * Set customer
	 *
	 * @param  null|CustomerInterface  $customer  Customer
	 *
	 * @return  CheckoutInterface
	 */
	public function setCustomer(?CustomerInterface $customer): CheckoutInterface
	{
		$this->customer = $customer;

		return $this;
	}

	/**
	 * Get card
	 *
	 * @return  null|CardInterface
	 */
	public function getCard(): ?CardInterface
	{
		return $this->card;
	}

	/**
	 * Set card
	 *
	 * @param  null|CardInterface  $card
	 *
	 * @return  CheckoutInterface
	 */
	public function setCard(?CardInterface $card): CheckoutInterface
	{
		$this->card = $card;

		return $this;
	}

	/**
	 * Get checkout reference
	 *
	 * @return  string
	 */
	public function getReference(): ?string
	{
		return $this->reference;
	}

	/**
	 * Set checkout reference
	 *
	 * @param  string  $reference  Checkout reference
	 *
	 * @return  CheckoutInterface
	 */
	public function setReference(?string $reference): CheckoutInterface
	{
		$this->reference = $reference;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getType():? string
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 * @return CheckoutInterface
	 */
	public function setType(?string $type = null): CheckoutInterface
	{
		$this->type = $type;

		return $this;
	}

	public function setInstallments(?string $installments): CheckoutInterface{
		$this->installments = $installments;
		return $this;
	}

	public function getInstallments(): string
	{
		return $this->installments;
	}

}
