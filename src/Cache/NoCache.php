<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Cache;

use Widi\JsonEncode\Strategy\StrategyInterface;

class NoCache implements CacheInterface
{
    public function isEnabled(): bool
    {
        return false;
    }

    public function isPropertyCacheEnabled(): bool
    {
        return false;
    }

    public function isClassMethodsCached(string $className): bool
    {
        return false;
    }

    public function setClassCached(string $className, bool $isCached): CacheInterface
    {
        return $this;
    }

    public function setMethods(string $className, array $methods): CacheInterface
    {
        return $this;
    }

    public function getMethods(string $className): array
    {
        return [];
    }

    public function setPropertyName(string $className, string $method, string $propertyName): CacheInterface
    {
        return $this;
    }

    public function getPropertyName(string $className, string $method): string
    {
        return '';
    }

    public function isClassPropertiesCached(string $className, string $method): bool
    {
        return false;
    }

    public function setStrategy(string $className, StrategyInterface $strategy): CacheInterface
    {
        return $this;
    }

    public function getStrategy(string $className): ?StrategyInterface
    {
        return null;
    }
}
