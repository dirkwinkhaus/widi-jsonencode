<?php

namespace Widi\JsonEncode\Factory;

use Psr\Container\ContainerInterface;
use Widi\JsonEncode\Cache\CacheInterface;
use Widi\JsonEncode\Encoder\Core;
use Widi\JsonEncode\Filter\MethodFilterInterface;
use Widi\JsonEncode\JsonEncoder;
use Widi\JsonEncode\JsonEncoderInterface;
use Widi\JsonEncode\Strategy\Factory\StrategyFactory;
use Widi\JsonEncode\Strategy\StrategyInterface;

class JsonEncoderFactory implements JsonEncoderFactoryInterface
{
    public function create(
        MethodFilterInterface $methodFilter,
        CacheInterface $cache,
        StrategyInterface $defaultStrategy,
        array $strategyMapping,
        bool $instanceMapping = true,
        ContainerInterface $container = null
    ): JsonEncoderInterface {
        $core = new Core(
            $methodFilter,
            $cache,
            new StrategyFactory($defaultStrategy, $strategyMapping, $instanceMapping, $container)
        );

        return new  JsonEncoder($core);
    }
}
