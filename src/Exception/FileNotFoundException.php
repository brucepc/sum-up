<?php

namespace BPCI\SumUp\SDK\Exception;

class FileNotFoundException extends \RuntimeException{
    private $path;
    public function __construct(string $message, int $code = 0, \Exception $previous = null, string $path = null)
    {
        $this->path = $path;
        parent::__construct($message, $code, $previous);
    }
    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    } 
}