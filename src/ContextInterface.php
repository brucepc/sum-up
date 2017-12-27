<?php

namespace BPCI\SumUp\SDK;

interface ContextInterface
{
    function __construct(Array $context);
    static function loadContextFromFile(string $filePath): ContextInterface;
    function getContextData(): Array;
    function setIndexUri(number $index): ContextInterface;
    function getId();
    function getName();
    function getClientId();
    function getClientSecret();
    function getApplicationType();
    function getRedirectUris();
    function getRedirectUri();
    function getCorsUris();
    function getAPIVersion();
    function getEntrypoint();
}