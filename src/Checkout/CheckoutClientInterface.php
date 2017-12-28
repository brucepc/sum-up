<?php

namespace BPCI\SumUp\Checkout;

use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\SumUpClientInterface;

interface CheckoutClientInterface extends SumUpClientInterface
{
    /**
     * Create a checkout 
     *
     * @param CheckoutInterface $checkout
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CheckoutInterface
     */
    static public function create(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface;

    /**
     * Retrieve a checkout from sumup.com server
     *
     * @param string $id
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CheckoutInterface
     */
    static public function get(string $id, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface;

    /**
     * Complete a checkout
     *
     * @param CheckoutInterface $checkout
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CheckoutInterface
     */
    static public function complete(CheckoutInterface $checkout, ContextInterface $context, AccessToken $accessToken = null): CheckoutInterface;

    /**
     * Generate body to request a new checkout.
     *
     * @param CheckoutInterface $checkout
     * @return Array
     */
    static function getCheckoutBody(CheckoutInterface $checkout): Array;

    /**
     * Generate a body to a complete checkout request.
     *
     * @param CheckoutInterface $chekcout
     * @return Array
     */
    static function getCompleteCheckoutBody(CheckoutInterface $chekcout): Array;

}