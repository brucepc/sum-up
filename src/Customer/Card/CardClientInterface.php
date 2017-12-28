<?php
namespace BPCI\SumUp\Customer\Card;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\SumUpClientInterface;
use BPCI\SumUp\OAuth\AccessToken;
use BPCI\SumUp\Customer\CustomerInterface;

interface CardClientInterface extends SumUpClientInterface{
    public static function createCard(CardInterface $card, CustomerInterface $costumer, ContextInterface $context, AccessToken $accessToken);
    public static function getCard(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken);
    public static function deleteCard(CardInterface $card, CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken);
}