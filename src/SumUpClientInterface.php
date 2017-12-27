<?php
namespace BPCI\SumUp;

interface SumUpClientInterface
{
    /**
     * Shows in an array all scopes required by the client
     *
     * @return Array
     */
    static function getScopes(): Array;
}