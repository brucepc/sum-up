<?php

namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\ContextInterface;

interface CheckoutClientInterface extends SumUpClientInterface
{

	/**
     * Create a checkout
     *
     * @param CheckoutInterface $checkout
     * @param AccessToken $accessToken
     * @return CheckoutInterface
     */
    public function create(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface;

    /**
     * Retrieve a checkout from sumup.com server
     *
     * @param CheckoutInterface $checkout
     * @param AccessToken $accessToken
     * @return CheckoutInterface
     */
    public function get(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface;

    /**
     * Complete a checkout
     *
     * @param CheckoutInterface $checkout
     * @param AccessToken $accessToken
     * @return CheckoutInterface
     */
    public function complete(CheckoutInterface $checkout, AccessToken $accessToken = null):? CheckoutInterface;

    /**
     * Generate body to request a new checkout.
     *
     * @param CheckoutInterface $checkout
     * @return array
     */
    static function getCheckoutBody(CheckoutInterface $checkout): array;

	/**
	 * Generate a body to a complete checkout request.
	 *
	 * @param CheckoutInterface $checkout
	 * @return array
	 */
    static function getCompleteCheckoutBody(CheckoutInterface $checkout): array;

}
