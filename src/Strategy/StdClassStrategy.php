<?php

namespace Widi\JsonEncode\Strategy;

use stdClass;
use Widi\JsonEncode\Encoder\Core;

class StdClassStrategy implements StrategyInterface
{
    /** @var bool */
    private $showNullValue;

    public function __construct(array $options = [])
    {
        $this->showNullValue = $options['showNullValue'] ?? true;
    }

    public function createStdClass($value, Core $jsonEncoder, array $stack = [])
    {
        $instance = new stdClass();
        $properties = array_keys(get_object_vars($value));

        foreach ($properties as $propertyName) {
            $propertyValue = $jsonEncoder->encodeRecursive($value->$propertyName, $stack);
            if (($this->showNullValue === true) || ($propertyValue !== null)) {
                $instance->$propertyName = $propertyValue;
            }
        }

        return $instance;
    }
}
