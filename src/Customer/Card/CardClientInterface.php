<?php
namespace BPCI\SumUp\Customer\Card;

use BPCI\SumUp\ContextInterface;
use BPCI\SumUp\OAuth\AccessToken;

interface CardClientInterface{
    public function generateToken(Array $cardData, $costumer, ContextInterface $context, AccessToken $accessToken);
}