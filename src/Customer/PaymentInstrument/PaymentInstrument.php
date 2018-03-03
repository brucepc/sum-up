<?php

namespace BPCI\SumUp\Customer\PaymentInstrument;

/**
 * Class PaymentInstrument
 * @package BPCI\SumUp\Customer\PaymentInstrument
 */
class PaymentInstrument implements PaymentInstrumentInterface
{
    /**
     * Token
     *
     * @var string
     */
    protected $token;

    /**
     * Active - state of token
     *
     * @var bool
     */
    protected $active;

    /**
     * Type of token
     *
     * @var string
     */
    protected $type;

    /**
     * Last 4 digits of card
     *
     * @var string
     */
    protected $last4Digits;

    /**
     * Schema card mastercard, visa, etc...
     *
     * @var string
     */
    protected $cardSchema;

    protected $customer;

    public function __construct(?array $data = [])
    {
        $this->setToken($data['token']??null);
        $this->setActive($data['active']??null);
        $this->setType($data['type']??null);
        $this->setCard($data['card']??null);
    }

    /**
     * Get token
     *
     * @return  string
     */
    public function getToken():? string
    {
        return $this->token;
    }

    /**
     * Set token
     *
     * @param  string  $token  Token
     *
     * @return PaymentInstrumentInterface
     */
    public function setToken(?string $token): PaymentInstrumentInterface
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get active - state of token
     *
     * @return  bool
     */
    public function getActive():? bool
    {
        return $this->active;
    }

    /**
     * Set active - state of token
     *
     * @param  bool  $active  Active - state of token
     *
     * @return PaymentInstrumentInterface
     */
    public function setActive(?bool $active): PaymentInstrumentInterface
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get type of token
     *
     * @return  string
     */
    public function getType():? string
    {
        return $this->type;
    }

    /**
     * Set type of token
     *
     * @param  string  $type  Type of token
     *
     * @return PaymentInstrumentInterface
     */
    public function setType(?string $type): PaymentInstrumentInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get last 4 digits of card
     *
     * @return  string
     */
    public function getLast4Digits():? string
    {
        return $this->last4Digits;
    }

    /**
     * Set last 4 digits of card
     *
     * @param  string  $last4Digits  Last 4 digits of card
     *
     * @return PaymentInstrumentInterface
     */
    public function setLast4Digits(?string $last4Digits): PaymentInstrumentInterface
    {
        $this->last4Digits = $last4Digits;

        return $this;
    }

    /**
     * Get PaymentInstrument Schema
     *
     * @return  string
     */
    public function getCardType():? string
    {
        return $this->cardSchema;
    }

    /**
     * Set PaymentInstrument Schema
     *
     * @param  string $cardSchema PaymentInstrument Schema
     *
     * @return PaymentInstrumentInterface
     */
    public function setCardType(?string $cardSchema): PaymentInstrumentInterface
    {
        $this->cardSchema = $cardSchema;

        return $this;
    }

    /**
     * Get PaymentInstrument array
     * e.g.: [
     *     'last_4_digits' => '0000',
     *     'type'          => 'PaymentInstrument Schema'
     * ]
     *
     * @see http://docs.sumup.com/rest-api/checkouts-api/#customers-payment-instruments-post
     * @return array
     */
    public function getCard():? array
    {
        return [
            'last_4_digits' => $this->getLast4Digits(),
            'type' => $this->getCardType(),
        ];
    }

    /**
     * Set PaymentInstrument array
     *
     * @see http://docs.sumup.com/rest-api/checkouts-api/#customers-payment-instruments-post
     * @param array $data
     * @return PaymentInstrumentInterface
     */
    public function setCard(?array $data): PaymentInstrumentInterface
    {
        $this->setLast4Digits($data['last_4_digits']);
        $this->setCardType($data['type']);
        return $this;
    }

    /**
     * @return bool
     */
    function isActive(): bool
    {
        return $this->active??false;
    }
}
