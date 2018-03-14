<?php

namespace BPCI\SumUp\Customer\PaymentInstrument;

/**
 * Interface PaymentInstrumentInterface
 * @package BPCI\SumUp\Customer\PaymentInstrument
 */
interface PaymentInstrumentInterface
{
    public function __construct(?array $data);

    /**
     * @return null|string
     */
    public function getToken():? string;

    /**
     * @param null|string $token
     * @return PaymentInstrumentInterface
     */
    public function setToken(?string $token): self;

    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @param bool|null $state
     * @return PaymentInstrumentInterface
     */
    public function setActive(?bool $state): self;

    /**
     * @return null|string
     */
    public function getType():? string;

    /**
     * @param null|string $type
     * @return PaymentInstrumentInterface
     */
    public function setType(?string $type): self;

    /**
     * @return array|null
     */
    public function getCard():? array;

    /**
     * @param array|null $data
     * @return PaymentInstrumentInterface
     */
    public function setCard(?array $data): self;

    /**
     * @return null|string
     */
    public function getLast4Digits():? string;

    /**
     * @param null|string $digits
     * @return PaymentInstrumentInterface
     */
    public function setLast4Digits(?string $digits): self;

    /**
     * @return null|string
     */
    public function getCardType():? string;

    /**
     * @param null|string $schema
     * @return PaymentInstrumentInterface
     */
    public function setCardType(?string $schema): self;

}
