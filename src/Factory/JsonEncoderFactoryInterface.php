<?php

namespace Widi\JsonEncode\Factory;

use Psr\Container\ContainerInterface;
use Widi\JsonEncode\Cache\CacheInterface;
use Widi\JsonEncode\Filter\MethodFilterInterface;
use Widi\JsonEncode\JsonEncoderInterface;
use Widi\JsonEncode\Strategy\StrategyInterface;

interface JsonEncoderFactoryInterface
{
    public function create(
        MethodFilterInterface $methodFilter,
        CacheInterface $cache,
        StrategyInterface $defaultStrategy,
        array $strategyMapping,
        bool $instanceMapping = true,
        ContainerInterface $container = null
    ): JsonEncoderInterface;
}
