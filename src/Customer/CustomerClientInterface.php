<?php
namespace BPCI\SumUp\Customer;

use BPCI\SumUp\SumUpClientInterface;

interface CostumerClientInterface extends SumUpClientInterface
{
    static function createCustomer(CustomerInterface $customer, ContextInterface $context, AccessToken $accessToken): Array;
}