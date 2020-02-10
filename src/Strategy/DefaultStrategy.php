<?php

namespace Widi\JsonEncode\Strategy;

use stdClass;
use Widi\JsonEncode\Encoder\Core;

class DefaultStrategy implements StrategyInterface
{
    public function createStdClass($value, Core $jsonEncoder, array $stack = [])
    {
        $instance = new stdClass();
        $methods = $jsonEncoder->findFunctions($value);

        foreach ($methods as $method) {
            $propertyName = $jsonEncoder->getPropertyName($value, $method);
            $instance->$propertyName = $jsonEncoder->encodeRecursive($value->$method(), $stack);
        }

        return $instance;
    }
}
