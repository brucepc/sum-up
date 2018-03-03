<?php
/**
 * Created by PhpStorm.
 * User: brucepc
 * Date: 26/02/18
 * Time: 11:57
 */

namespace BPCI\SumUp\Traits;


interface PropertyHandlerInterface
{
    function fillProperties(array $data): void;

    function fillProperty(string $property, $value): void;

    function getPropertyArray(): array;
}
