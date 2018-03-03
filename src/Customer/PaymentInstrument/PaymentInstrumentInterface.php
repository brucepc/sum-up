<?php

namespace BPCI\SumUp\Customer\PaymentInstrument;

/**
 * Interface PaymentInstrumentInterface
 * @package BPCI\SumUp\Customer\PaymentInstrument
 */
interface PaymentInstrumentInterface
{
    function __construct(?array $data);

    /**
     * @return null|string
     */
    function getToken():? string;

    /**
     * @param null|string $token
     * @return PaymentInstrumentInterface
     */
    function setToken(?string $token): self;

    /**
     * @return bool
     */
    function isActive(): bool;

    /**
     * @param bool|null $state
     * @return PaymentInstrumentInterface
     */
    function setActive(?bool $state): self;

    /**
     * @return null|string
     */
    function getType():? string;

    /**
     * @param null|string $type
     * @return PaymentInstrumentInterface
     */
    function setType(?string $type): self;

    /**
     * @return array|null
     */
    function getCard():? array;

    /**
     * @param array|null $data
     * @return PaymentInstrumentInterface
     */
    function setCard(?array $data): self;

    /**
     * @return null|string
     */
    function getLast4Digits():? string;

    /**
     * @param null|string $digits
     * @return PaymentInstrumentInterface
     */
    function setLast4Digits(?string $digits): self;

    /**
     * @return null|string
     */
    function getCardType():? string;

    /**
     * @param null|string $schema
     * @return PaymentInstrumentInterface
     */
    function setCardType(?string $schema): self;

}
