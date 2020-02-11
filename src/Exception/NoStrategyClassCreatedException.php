<?php


namespace Widi\JsonEncode\Exception;

use Exception;

class NoStrategyClassCreatedException extends Exception implements JsonEncoderExceptionInterface
{
    public function __construct(string $className)
    {
        parent::__construct('Class is not type of strategy: ' . $className, 1);
    }
}
