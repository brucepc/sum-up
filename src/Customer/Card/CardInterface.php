<?php

namespace BPCI\SumUp\Customer\Card;

interface CardInterface
{
    function getToken():string;
    function setToken(string $token): CardInterface;
    function isActive(): bool;
    function setActive(bool $state): CardInterface;
    function getType(): string;
    function setType(string $type): CardInterface;
    function getCard(): Array;
    function setCard(Array $data): CardInterface;
    function getLast4Digits(): string;
    function setLast4Digits(string $digits): CardInterface;
    function getCardType(): string;
    function setCardType(string $schema): CardInterface;
}