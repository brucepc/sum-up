<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\Customer\Card\CardInterface;
use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\OAuth\AccessToken;

interface CustomerClientInterface extends SumUpClientInterface
{
    /**
     * Create a customer and fill the $customer Object with response.
     *
     * @param CustomerInterface $customer
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CustomerInterface
     */
    static function create(CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): ?CustomerInterface;
    
    /**
     * Create a customer card and fill the $card Object with response.
     *
     * @param CustomerInterface $customer
     * @param CardInterface $card
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return CardInterface
     */
    static function createCard(CustomerInterface $customer, CardInterface $card, ContextInterface $context, AccessToken $accessToken): ?CardInterface;
    
    /**
     * Delete a customer card.
     *
     * @param CustomerInterface $customer
     * @param CardInterface $card
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return void
     */
    static function deleteCard(CustomerInterface $customer, CardInterface $card, ContextInterface $context, AccessToken $accessToken): void;
    
    /**
     * This must return an Array of CardInterface
     *
     * @param CustomerInterface $customer
     * @param ContextInterface $context
     * @param AccessToken $accessToken
     * @return Array
     */
    static function getCards(CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): Array;
}