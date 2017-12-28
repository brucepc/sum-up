<?php
namespace BPCI\SumUp\Customer\Card;

class Card implements CardInterface
{
    /**
     * Token
     *
     * @var string
     */
    private $token;

    /**
     * Active - state of token
     *
     * @var bool
     */
    private $active;

    /**
     * Type of token
     *
     * @var string
     */
    private $type;

    /**
     * Last 4 digits of card
     *
     * @var string
     */
    private $last4Digits;

    /**
     * Schema card mastercard, visa, etc...
     *
     * @var string
     */
    private $cardSchema;

    /**
     * Get token
     *
     * @return  string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token
     *
     * @param  string  $token  Token
     *
     * @return  self
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get active - state of token
     *
     * @return  bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set active - state of token
     *
     * @param  bool  $active  Active - state of token
     *
     * @return  self
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get type of token
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type of token
     *
     * @param  string  $type  Type of token
     *
     * @return  self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get last 4 digits of card
     *
     * @return  string
     */
    public function getLast4Digits()
    {
        return $this->last4Digits;
    }

    /**
     * Set last 4 digits of card
     *
     * @param  string  $last4Digits  Last 4 digits of card
     *
     * @return  self
     */
    public function setLast4Digits(string $last4Digits)
    {
        $this->last4Digits = $last4Digits;

        return $this;
    }

    /**
     * Get Card Schema
     *
     * @return  string
     */
    public function getCardType()
    {
        return $this->cardSchema;
    }

    /**
     * Set Card Schema
     *
     * @param  string  $cardSchema  Card Schema
     *
     * @return  self
     */
    public function setCardType(string $cardSchema)
    {
        $this->cardSchema = $cardSchema;

        return $this;
    }

    /**
     * Get Card array
     * e.g.: [
     *     'last_4_digits' => '0000',
     *     'type'          => 'Card Schema'
     * ]
     *
     * @see http://docs.sumup.com/rest-api/checkouts-api/#customers-payment-instruments-post
     * @return Array
     */
    public function getCard(): array
    {
        return [
            'last_4_digits' => $this->getLast4Digits(),
            'type' => $this->getCardType(),
        ];
    }

    /**
     * Set Card array
     *
     * @see http://docs.sumup.com/rest-api/checkouts-api/#customers-payment-instruments-post
     * @param array $data
     * @return self
     */
    public function setCard(array $data): self
    {
        $this->setLast4Digits($data['last_4_digits']);
        $this->setCardType($data['type']);
        return $this;
    }
}
