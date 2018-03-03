<?php

namespace BPCI\SumUp\Customer\PaymentInstrument;

use BPCI\SumUp\Customer\CustomerInterface;
use BPCI\SumUp\SumUpClientInterface;

/**
 * Interface PaymentInstrumentClientInterface
 * @package BPCI\SumUp\Customer\PaymentInstrument
 */
interface PaymentInstrumentClientInterface extends SumUpClientInterface
{
    /**
     * Retrieve a card from server and fill the $card Object with response.
     */
    public function get(): array;

    /**
     * Delete an card from server.
     *
     * @param PaymentInstrumentInterface $card
     * @return bool
     */
    public function disable(PaymentInstrumentInterface $card):? bool;

    /**
     * @param CustomerInterface $customer
     * @return PaymentInstrumentClientInterface
     */
    public function setCustomer(CustomerInterface $customer): self;

    /**
     * @return CustomerInterface
     */
    public function getCustomer(): CustomerInterface;

}
