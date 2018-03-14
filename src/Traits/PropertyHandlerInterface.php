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
    public function fillProperties(array $data): void;

    public function fillProperty(string $property, $value): void;

    public function getPropertyArray(): array;
}
