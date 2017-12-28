<?php
namespace BPCI\SumUp\Customer\Card;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\OAuth\AccessToken;


class CardClient implements CardClientInterface
{
    function create(CardInterface $card, ContextInterface $context, AccessToken $accessToken)
    {

    }

    static function getScopes(): Array{
        return [
            'payment_instruments'
        ];
    }

}