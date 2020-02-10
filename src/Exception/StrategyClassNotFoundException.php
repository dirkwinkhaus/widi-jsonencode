<?php


namespace Widi\JsonEncode\Exception;

use Exception;

class StrategyClassNotFoundException extends Exception implements JsonEncoderExceptionInterface
{
    public function __construct(string $className)
    {
        parent::__construct('Strategy class not found: ' . $className, 1);
    }
}
