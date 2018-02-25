<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\Customer\Card\CardInterface;
use BPCI\SumUp\OAuth\AccessToken;

interface CustomerClientInterface extends SumUpClientInterface
{
    /**
     * Create a customer and fill the $customer Object with response.
     *
     * @param CustomerInterface $customer
     * @param AccessToken $accessToken
     * @return CustomerInterface
     */
    function create(CustomerInterface $customer, AccessToken $accessToken):? CustomerInterface;

    /**
     * Create a customer card and fill the $card Object with response.
     *
     * @param CustomerInterface $customer
     * @param CardInterface $card
     * @param AccessToken $accessToken
     * @return CardInterface
     */
    function createCard(CustomerInterface $customer, CardInterface $card, AccessToken $accessToken):? CardInterface;

    /**
     * Delete a customer card.
     *
     * @param CustomerInterface $customer
     * @param CardInterface $card
     * @param AccessToken $accessToken
     * @return void
     */
    function deleteCard(CustomerInterface $customer, CardInterface $card, AccessToken $accessToken): void;

    /**
     * This must return an Array of CardInterface
     *
     * @param CustomerInterface $customer
     * @param AccessToken $accessToken
     * @return array
     */
    function getCards(CustomerInterface $customer, AccessToken $accessToken): array;
}
