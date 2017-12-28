<?php

namespace BPCI\SumUp;

interface ContextInterface
{
    function __construct(Array $context);
    static function loadContextFromFile(string $filePath): self;
    function getContextData(): Array;
    function setIndexUri(number $index): self;
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