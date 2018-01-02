<?php
namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\Exception\BadRequestException;
use BPCI\SumUp\Exception\InvalidCheckoutException;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\OAuth\AuthenticationHelper;
use BPCI\SumUp\SumUp;
use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\Customer\Card\CardInterface;
use BPCI\SumUp\Utils\ResponseWrapper;

class Checkout implements CheckoutInterface
{
    const PENDING = 'PENDING';
    const COMPLETED = 'COMPLETED';
    const FAILED = 'FAILED';

    private $id;
    private $status;
    private $amount;
    private $feeAmount;
    private $currency;
    private $payTo;
    private $payFromEmail;
    private $description;
    private $redirectUrl;
    /**
     * Checkout reference
     *
     * @var string
     */
    private $reference;

    /**
     * Customer
     *
     * @var null|Customer
     */
    private $customer;

    /**
     * Card
     *
     * 
     * @var null|Card
     */
    private $card;


    /**
     * checkout constructor
     *
     * @param array $data
     */
    public function __construct(array $data = null) {
        if ($data !== null) {
            $this->setAmount($data['amount']);
            $this->setPayToEmail($data['pay_to_email']);
            $this->setCheckoutReference($data['checkout_reference']);
            $this->setCurrency($data['currency']);
            $this->setDescription($data['description']);
            $this->setFeeAmount($data['fee_amount']);
            $this->setPayFromEmail($data['pay_from_mail']);
            $this->setId($data['id']);
            $this->setRedirectUrl($data['redirect_url']);
            $this->setStatus($data['status']);
        }
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool {
        return $this->getReference() !== null
        && $this->getAmount() !== null
        && $this->getPayToEMail() !== null
        && Currency::isValid($this->getCurrency());
    }

    /**
     * @inheritDoc
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setId(string $id): CheckoutInterface {
        $this->id = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function setStatus(string $status): CheckoutInterface {
        $this->status = $status;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAmount(): float {
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
    public function getCurrency(): string {
        return $this->currency;
    }

    /**
     * @inheritDoc
     */
    public function setCurrency(string $currency): CheckoutInterface {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPayToEmail(): string {
        return $this->payTo;
    }

    /**
     * @inheritDoc
     */
    public function setPayToEmail(string $email): CheckoutInterface {
        $this->payTo = trim($email) === '' ? null : $email;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCheckoutReference(): string {
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
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): CheckoutInterface {
        $this->description = $description;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFeeAmount(): float {
        return $this->fee;
    }

    /**
     * @inheritDoc
     */
    public function setFeeAmount(float $fee): CheckoutInterface {
        return $this->fee = $fee;
    }

    /**
     * @inheritDoc
     */
    public function getPayFromEmail(): string {
        return $this->payFrom;
    }

    /**
     * @inheritDoc
     */
    public function setPayFromEmail(string $email): CheckoutInterface {
        $this->payFrom = $email;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl(): string {
        return $this->redirectUrl;
    }

    /**
     * @inheritDoc
     */
    public function setRedirectUrl(string $url): CheckoutInterface {
        $this->redirectUrl = $url;
        return $this;
    }
    
    function getValidUntil():string {
        return $this->validUntil;
    }
    
    function setValidUntil(string $timestamp): CheckoutInterface {
        $this->validUntil = $timestamp;
        return $this;
    }

    function getTransactionCode(): string {
        return $this->transactionCode;
    }

    function setTransactionCode(string $code): CheckoutInterface {
        $this->transactionCode = $code;
    }
    
    function getTransactionId(): string {
        return $this->transactionId;
    }

    function setTransactionId(string $id): CheckoutInterface {
        $this->transactionId = $id;
        return $this;
    }

    function getTransactions(): Array {
        return $this->transactions;
    }

    function setTransactions(Array $transactions): CheckoutInterface {
        $this->transactions = $transactions;
        return $this;
    }

    function getToken(): string {
        return $this->token;
    }

    function setToken(string $token): CheckoutInterface {
        $this->token = $token;
        return $this;
    }

    /**
     * Get customer
     *
     * @return  null|Customer
     */ 
    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    /**
     * Set customer
     *
     * @param  null|Customer  $customer  Customer
     *
     * @return  self
     */ 
    public function setCustomer(CustomerInterface $customer): CheckoutInterface
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get card
     *
     * @return  null|Card
     */ 
    public function getCard(): ?CardInterface
    {
        return $this->card;
    }

    /**
     * Set card
     *
     * @param  null|Card  $card 
     *
     * @return  self
     */ 
    public function setCard(CardInterface $card): CheckoutInterface
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
     * @return  self
     */ 
    public function setReference(string $reference): CheckoutInterface
    {
        $this->reference = $reference;

        return $this;
    }
}
