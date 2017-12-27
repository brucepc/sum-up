<?php
namespace BPCI\SumUp\SDK\Client;

interface CostumerClientInterface
{
    static function create(Array $customer, ContextInterface $context, AccessToken $accessToken): Array;
}