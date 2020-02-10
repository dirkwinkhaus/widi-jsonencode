<?php

namespace Widi\JsonEncode\Strategy;

use Widi\JsonEncode\Encoder\Core;

interface StrategyInterface
{
    public function createStdClass($value, Core $jsonEncoder, array $stack = []);
}
