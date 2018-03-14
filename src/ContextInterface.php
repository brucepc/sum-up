<?php

namespace BPCI\SumUp;

interface ContextInterface
{
    public function __construct(Array $context);
    static function loadContextFromFile(string $filePath): self;

    public function getContextData(): Array;

    public function setIndexUri(int $index): self;

    public function getId();

    public function getName();

    public function getClientId();

    public function getClientSecret();

    public function getApplicationType();

    public function getRedirectUris();

    public function getRedirectUri();

    public function getCorsUris();
}