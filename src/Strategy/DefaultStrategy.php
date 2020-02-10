<?php

namespace Widi\JsonEncode\Strategy;

use stdClass;
use Widi\JsonEncode\Encoder\Core;

class DefaultStrategy implements StrategyInterface
{
    /** @var bool */
    private $showNullValue;

    /**
     * DefaultStrategy constructor.
     * @param bool $showNullValue
     */
    public function __construct(bool $showNullValue = true)
    {
        $this->showNullValue = $showNullValue;
    }

    public function createStdClass($value, Core $jsonEncoder, array $stack = [])
    {
        $instance = new stdClass();
        $methods = $jsonEncoder->findFunctions($value);

        foreach ($methods as $method) {
            $propertyName = $jsonEncoder->getPropertyName($value, $method);
            $propertyValue = $jsonEncoder->encodeRecursive($value->$method(), $stack);
            if (($this->showNullValue === true) || ($propertyValue !== null)) {
                $instance->$propertyName = $propertyValue;
            }
        }

        return $instance;
    }
}
