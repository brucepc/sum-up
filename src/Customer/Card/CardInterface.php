<?php

namespace BPCI\SumUp\Customer\Card;

interface CardInterface
{
    function getToken():string;
    function setToken(string $token): self;
    function isActive(): bool;
    function setActive(bool $state): self;
    function getType(): string;
    function setType(string $type): self;
    function getCard(): Array;
    function setCard(Array $data): self;
    function getLast4Digits(): string;
    function setLast4Digits(string $digits): self;
    function getCardType(): string;
    function setCardType(string $schema): self;
}