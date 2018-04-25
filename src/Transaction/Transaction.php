<?php
/**
 * Created by PhpStorm.
 * User: bruce
 * Date: 28/03/18
 * Time: 19:39
 */

namespace BPCI\SumUp\Transaction;


use BPCI\SumUp\Customer\PaymentInstrument\PaymentInstrument;
use BPCI\SumUp\Traits\PropertyHandler;

/**
 * Class Transaction
 * @package BPCI\SumUp\Transaction
 */
class Transaction implements TransactionInterface
{
    use PropertyHandler;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $transactionCode;
    /**
     * @var string
     */
    protected $foreignTransactionId;
    /**
     * @var string
     */
    protected $merchantCode;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var float
     */
    protected $amount;
    /**
     * @var float
     */
    protected $vatAmount;
    /**
     * @var float
     */
    protected $tipAmount;
    /**
     * @var string
     */
    protected $currency;
    /**
     * @var \DateTime
     */
    protected $timestamp;
    /**
     * @var string
     */
    protected $lat;
    /**
     * @var string
     */
    protected $lon;
    /**
     * @var string
     */
    protected $horizontalAccuracy;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var string
     */
    protected $paymentType;
    /**
     * @var string
     */
    protected $simplePaymentType;
    /**
     * @var string
     */
    protected $entryMode;
    /**
     * @var string
     */
    protected $verificationMethod;
    /**
     * @var PaymentInstrument
     */
    protected $card;
    /**
     * @var array Elv bank account
     */
    protected $elvAccount;
    /**
     * @var array
     */
    protected $productSummary;
    /**
     * @var string
     */
    protected $localTime;
    /**
     * @var \DateTime The date of the payout
     */
    protected $payoutDate;
    /**
     * @var string Payout plan at the time the transaction was made
     */
    protected $payoutPlan;
    /**
     * @var string Payout type of the most recent paid-out for this transaction
     */
    protected $payoutType;
    /**
     * @var integer
     */
    protected $installmentsCount;
    /**
     * @var string Debit/Credit
     */
    protected $processAs;
    /**
     * @var array Purchase products
     */
    protected $products;
    /**
     * @var array A list of transaction events such as payouts, refunds and chargebacks
     */
    protected $transactionEvents;
    /**
     * @var string
     * CANCEL_FAILED|CANCELLED|CHARGEBACK|FAILED|REFUND_FAILED|REFUNDED|SUCCESSFUL
     */
    protected $simpleStatus;
    /**
     * @var array
     */
    protected $links;
    /**
     * @var array A list with transaction events
     */
    protected $events;
    /**
     * @var integer Number of payouts that were actually paid out &#40;excludes partial chargeback deductions
     */
    protected $payoutsReceived;
    /**
     * @var integer
     * Total number of payouts in which the transaction is to be paid out
     */
    protected $payoutsTotal;
    /**
     * @var array Location information
     */
    protected $location;
    /**
     * @var bool True if transaction is made in advanced mode
     */
    protected $taxEnabled;
    /**
     * @var string Authorization code
     */
    protected $authCode;
    /**
     * @var integer The internal transaction ID
     */
    protected $internalId;

    /**
     * Transaction constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this
            ->setId($data["id"] ?? null)
            ->setTransactionCode($data["transaction_code"] ?? null)
            ->setForeignTransactionId($data["foreign_transaction_id"] ?? $data['transaction_id'] ?? null)
            ->setMerchantCode($data["merchant_code"] ?? null)
            ->setUsername($data["username"] ?? null)
            ->setAmount($data["amount"] ?? null)
            ->setVatAmount($data["vat_amount"] ?? null)
            ->setTipAmount($data["tip_amount"] ?? null)
            ->setCurrency($data["currency"] ?? null)
            ->setTimestamp(new \DateTime($data["timestamp"] ?? null))
            ->setLat($data["lat"] ?? null)
            ->setLon($data["lon"] ?? null)
            ->setHorizontalAccuracy($data["horizontal_accuracy"] ?? null)
            ->setStatus($data["status"] ?? null)
            ->setPaymentType($data["payment_type"] ?? null)
            ->setSimplePaymentType($data["simple_payment_type"] ?? null)
            ->setEntryMode($data["entry_mode"] ?? null)
            ->setVerificationMethod($data["verification_method"] ?? null)
            ->setCard(new PaymentInstrument($data["card"] ?? null))
            ->setElvAccount($data["elv_account"] ?? null)
            ->setProductSummary($data["product_summary"] ?? null)
            ->setLocalTime($data["local_time"] ?? null)
            ->setPayoutDate(new \DateTime($data["payout_date"] ?? null))
            ->setPayoutPlan($data["payout_plan"] ?? null)
            ->setPayoutType($data["payout_type"] ?? null)
            ->setInstallmentsCount($data["installments_count"] ?? 1)
            ->setProcessAs($data["process_as"] ?? null)
            ->setProducts($data["products"] ?? null)
            ->setTransactionEvents($data["transaction_events"] ?? null)
            ->setSimpleStatus($data["simple_status"] ?? null)
            ->setLinks($data["links"] ?? null)
            ->setEvents($data["events"] ?? null)
            ->setPayoutsReceived($data["payouts_received"] ?? null)
            ->setPayoutsTotal($data["payouts_total"] ?? null)
            ->setLocation($data["location"] ?? null)
            ->setTaxEnabled($data["tax_enabled"] ?? null)
            ->setAuthCode($data["auth_code"] ?? null)
            ->setInternalId($data["internal_id"] ?? null);
    }

    /**
     * @return string
     */
    public function getId():? string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Transaction
     */
    public function setId(?string $id): Transaction
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionCode():? string
    {
        return $this->transactionCode;
    }

    /**
     * @param string $transactionCode
     * @return Transaction
     */
    public function setTransactionCode(?string $transactionCode): Transaction
    {
        $this->transactionCode = $transactionCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getForeignTransactionId():? string
    {
        return $this->foreignTransactionId;
    }

    /**
     * @param string $foreignTransactionId
     * @return Transaction
     */
    public function setForeignTransactionId(?string $foreignTransactionId): Transaction
    {
        $this->foreignTransactionId = $foreignTransactionId;

        return $this;
    }

    public function getTransactionId():? string
    {
        return $this->getForeignTransactionId();
    }

    public function setTransactionId(string $id): TransactionInterface
    {
        $this->setForeignTransactionId($id);

        return $this;
    }

    /**
     * @return string
     */
    public function getMerchantCode():? string
    {
        return $this->merchantCode;
    }

    /**
     * @param string $merchantCode
     * @return Transaction
     */
    public function setMerchantCode(?string $merchantCode): Transaction
    {
        $this->merchantCode = $merchantCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername():? string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Transaction
     */
    public function setUsername(?string $username): Transaction
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transaction
     */
    public function setAmount(?float $amount): Transaction
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getVatAmount(): float
    {
        return $this->vatAmount;
    }

    /**
     * @param float $vatAmount
     * @return Transaction
     */
    public function setVatAmount(?float $vatAmount): Transaction
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    /**
     * @return float
     */
    public function getTipAmount(): float
    {
        return $this->tipAmount;
    }

    /**
     * @param float $tipAmount
     * @return Transaction
     */
    public function setTipAmount(?float $tipAmount): Transaction
    {
        $this->tipAmount = $tipAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency():? string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency(?string $currency): Transaction
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): ? \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     * @return Transaction
     */
    public function setTimestamp(? \DateTime $timestamp): Transaction
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return string
     */
    public function getLat():? string
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     * @return Transaction
     */
    public function setLat(?string $lat): Transaction
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * @return string
     */
    public function getLon():? string
    {
        return $this->lon;
    }

    /**
     * @param string $lon
     * @return Transaction
     */
    public function setLon(?string $lon): TransactionInterface
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * @return string
     */
    public function getHorizontalAccuracy():? string
    {
        return $this->horizontalAccuracy;
    }

    /**
     * @param string $horizontalAccuracy
     * @return Transaction
     */
    public function setHorizontalAccuracy(?string $horizontalAccuracy): TransactionInterface
    {
        $this->horizontalAccuracy = $horizontalAccuracy;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus():? string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Transaction
     */
    public function setStatus(?string $status): Transaction
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType():? string
    {
        return $this->paymentType;
    }

    /**
     * @param string $paymentType
     * @return Transaction
     */
    public function setPaymentType(?string $paymentType): Transaction
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getSimplePaymentType():? string
    {
        return $this->simplePaymentType;
    }

    /**
     * @param string $simplePaymentType
     * @return Transaction
     */
    public function setSimplePaymentType(?string $simplePaymentType): Transaction
    {
        $this->simplePaymentType = $simplePaymentType;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntryMode():? string
    {
        return $this->entryMode;
    }

    /**
     * @param string $entryMode
     * @return Transaction
     */
    public function setEntryMode(?string $entryMode): Transaction
    {
        $this->entryMode = $entryMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getVerificationMethod():? string
    {
        return $this->verificationMethod;
    }

    /**
     * @param string $verificationMethod
     * @return Transaction
     */
    public function setVerificationMethod(?string $verificationMethod): Transaction
    {
        $this->verificationMethod = $verificationMethod;

        return $this;
    }

    /**
     * @return PaymentInstrument
     */
    public function getCard(): PaymentInstrument
    {
        return $this->card;
    }

    /**
     * @param PaymentInstrument $card
     * @return Transaction
     */
    public function setCard(?PaymentInstrument $card): Transaction
    {
        $this->card = $card;

        return $this;
    }

    /**
     * @return array
     */
    public function getElvAccount(): array
    {
        return $this->elvAccount;
    }

    /**
     * @param array $elvAccount
     * @return Transaction
     */
    public function setElvAccount(?array $elvAccount): Transaction
    {
        $this->elvAccount = $elvAccount;

        return $this;
    }

    /**
     * @return array
     */
    public function getProductSummary(): array
    {
        return $this->productSummary;
    }

    /**
     * @param array $productSummary
     * @return Transaction
     */
    public function setProductSummary(?array $productSummary): Transaction
    {
        $this->productSummary = $productSummary;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocalTime():? string
    {
        return $this->localTime;
    }

    /**
     * @param string $localTime
     * @return Transaction
     */
    public function setLocalTime(?string $localTime): Transaction
    {
        $this->localTime = $localTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPayoutDate(): ? \DateTime
    {
        return $this->payoutDate;
    }

    /**
     * @param \DateTime $payoutDate
     * @return Transaction
     */
    public function setPayoutDate(? \DateTime $payoutDate): Transaction
    {
        $this->payoutDate = $payoutDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayoutPlan():? string
    {
        return $this->payoutPlan;
    }

    /**
     * @param string $payoutPlan
     * @return Transaction
     */
    public function setPayoutPlan(?string $payoutPlan): Transaction
    {
        $this->payoutPlan = $payoutPlan;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayoutType():? string
    {
        return $this->payoutType;
    }

    /**
     * @param string $payoutType
     * @return Transaction
     */
    public function setPayoutType(?string $payoutType): Transaction
    {
        $this->payoutType = $payoutType;

        return $this;
    }

    /**
     * @return int
     */
    public function getInstallmentsCount(): int
    {
        return $this->installmentsCount;
    }

    /**
     * @param int $installmentsCount
     * @return Transaction
     */
    public function setInstallmentsCount(?int $installmentsCount): Transaction
    {
        $this->installmentsCount = $installmentsCount;

        return $this;
    }

    /**
     * @return string
     */
    public function getProcessAs():? string
    {
        return $this->processAs;
    }

    /**
     * @param string $processAs
     * @return Transaction
     */
    public function setProcessAs(?string $processAs): Transaction
    {
        $this->processAs = $processAs;

        return $this;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $products
     * @return Transaction
     */
    public function setProducts(?array $products): Transaction
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @return array
     */
    public function getTransactionEvents(): array
    {
        return $this->transactionEvents;
    }

    /**
     * @param array $transactionEvents
     * @return Transaction
     */
    public function setTransactionEvents(?array $transactionEvents): Transaction
    {
        $this->transactionEvents = $transactionEvents;

        return $this;
    }

    /**
     * @return string
     */
    public function getSimpleStatus():? string
    {
        return $this->simpleStatus;
    }

    /**
     * @param string $simpleStatus
     * @return Transaction
     */
    public function setSimpleStatus(?string $simpleStatus): Transaction
    {
        $this->simpleStatus = $simpleStatus;

        return $this;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param array $links
     * @return Transaction
     */
    public function setLinks(?array $links): Transaction
    {
        $this->links = $links;

        return $this;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param array $events
     * @return Transaction
     */
    public function setEvents(?array $events): Transaction
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return int
     */
    public function getPayoutsReceived(): int
    {
        return $this->payoutsReceived;
    }

    /**
     * @param int $payoutsReceived
     * @return Transaction
     */
    public function setPayoutsReceived(?int $payoutsReceived): Transaction
    {
        $this->payoutsReceived = $payoutsReceived;

        return $this;
    }

    /**
     * @return int
     */
    public function getPayoutsTotal(): int
    {
        return $this->payoutsTotal;
    }

    /**
     * @param int $payoutsTotal
     * @return Transaction
     */
    public function setPayoutsTotal(?int $payoutsTotal): Transaction
    {
        $this->payoutsTotal = $payoutsTotal;

        return $this;
    }

    /**
     * @return array
     */
    public function getLocation(): array
    {
        return $this->location;
    }

    /**
     * @param array $location
     * @return Transaction
     */
    public function setLocation(?array $location): Transaction
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTaxEnabled(): bool
    {
        return $this->taxEnabled;
    }

    /**
     * @param bool $taxEnabled
     * @return Transaction
     */
    public function setTaxEnabled(?bool $taxEnabled): Transaction
    {
        $this->taxEnabled = $taxEnabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthCode():? string
    {
        return $this->authCode;
    }

    /**
     * @param string $authCode
     * @return Transaction
     */
    public function setAuthCode(?string $authCode): Transaction
    {
        $this->authCode = $authCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getInternalId(): int
    {
        return $this->internalId;
    }

    /**
     * @param int $internalId
     * @return Transaction
     */
    public function setInternalId(?int $internalId): Transaction
    {
        $this->internalId = $internalId;

        return $this;
    }
}