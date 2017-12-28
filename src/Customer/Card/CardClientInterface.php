<?php
namespace BPCI\SumUp\Customer\Card;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\Customer\CustomerInterface;

interface CardClientInterface extends SumUpClientInterface{

    /**
     * Create a new card resource and fill the $card Object with response.
     *
     * @param CardInterface $card
     * @param CustomerInterface $costumer
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CardInterface
     */
    public static function create(CardInterface $card, CustomerInterface $costumer, ContextInterface $context, AccessToken $accessToken): CardInterface;

    /**
     * Retieve a card from server and fill the $card Object with response.
     *
     * @param CardInterface $card
     * @param CustomerInterface $customer
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CardInterface
     */
    public static function get(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): CardInterface;

    /**
     * Delete an card from server.
     *
     * @param CardInterface $card
     * @param CustomerInterface $customer
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return void
     */
    public static function delete(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): void;
}