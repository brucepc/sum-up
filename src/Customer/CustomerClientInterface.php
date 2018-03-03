<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\Customer\PaymentInstrument\PaymentInstrumentInterface;
use BPCI\SumUp\SumUpClientInterface;

interface CustomerClientInterface extends SumUpClientInterface
{
    /**
     * Create a customer and fill the $customer Object with response.
     *
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    function create(CustomerInterface $customer):? CustomerInterface;

    /**
     * @param CustomerInterface $customer
     * @return array
     */
    function getPaymentInstruments(CustomerInterface $customer): array;

    /**
     * @param CustomerInterface $customer
     * @param PaymentInstrumentInterface $instrument
     * @return bool
     */
    function disablePaymentInstrument(CustomerInterface $customer, PaymentInstrumentInterface $instrument): bool;

}
