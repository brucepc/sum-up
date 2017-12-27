<?php
namespace BPCI\SumUp\Exception;

class BadRequestException extends \RuntimeException{
    public function __construct(string $message, int $code = 500, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}