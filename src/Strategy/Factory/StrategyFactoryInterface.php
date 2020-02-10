<?php

namespace Widi\JsonEncode\Strategy\Factory;

use Widi\JsonEncode\Strategy\StrategyInterface;

interface StrategyFactoryInterface
{
    public function create($value): StrategyInterface;
}
