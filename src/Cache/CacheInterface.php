<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Cache;

use Generator;
use Widi\JsonEncode\Strategy\StrategyInterface;

interface CacheInterface
{
    public function isEnabled(): bool;

    public function isPropertyCacheEnabled(): bool;

    public function isClassMethodsCached(string $className): bool;

    public function isClassPropertiesCached(string $className, string $method): bool;

    public function setMethods(string $className, array $methods): CacheInterface;

    public function getMethods(string $className): array;

    public function setPropertyName(string $className, string $method, string $propertyName): CacheInterface;

    public function getPropertyName(string $className, string $method): string;

    public function setStrategy(string $className, StrategyInterface $strategy): CacheInterface;

    public function getStrategy(string $className): ?StrategyInterface;

    public function setGeneratorContent(Generator $generator): CacheInterface;

    public function getGeneratorContent(Generator $generator);
}
