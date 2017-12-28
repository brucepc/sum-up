<?php
namespace BPCI\SumUp\Customer;

class CustomerClient implements CustomerClientInterface, Card\CardClientInterface
{
    public static function createCard(CardInterface $card, CustomerInterface $costumer, ContextInterface $context, AccessToken $accessToken)
    {
        //TODO Implement this method
    }
    public static function getCard(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken)
    {
        //TODO Implement this method
    }
    public static function deleteCard(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken)
    {
        //TODO Implement this method
    }
    public static function createCustomer(CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): Array
    {
        //TODO Implement this method
    }
}