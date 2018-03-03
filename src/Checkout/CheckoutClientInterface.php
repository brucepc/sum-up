<?php

namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\SumUpClientInterface;

interface CheckoutClientInterface extends SumUpClientInterface
{
	/**
     * Create a checkout
     *
     * @param CheckoutInterface $checkout
     * @return CheckoutInterface
     * @see http://docs.sumup.com/rest-api/checkouts-api/#checkouts-create-checkout-post
     */
    public function create(CheckoutInterface $checkout):? CheckoutInterface;

    /**
     * Complete a checkout
     *
     * @param CheckoutInterface $checkout
     * @return CheckoutInterface
     * @see http://docs.sumup.com/rest-api/checkouts-api/#checkouts-complete-checkout-put
     */
    public function complete(CheckoutInterface $checkout):? CheckoutInterface;

    /**
     * @param CheckoutInterface $checkout
     * @return string
	 */
    static function getCompleteUrl(CheckoutInterface $checkout): string;

}
