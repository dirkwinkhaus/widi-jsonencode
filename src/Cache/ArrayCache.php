<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Cache;

use Widi\JsonEncode\Strategy\StrategyInterface;

class ArrayCache implements CacheInterface
{
    /** @var array */
    private $cache = [];

    /** @var bool */
    private $enabled;

    /** @var bool */
    private $propertyCacheEnabled;

    public function __construct(bool $enabled, bool $propertyCacheEnabled)
    {
        $this->enabled = $enabled;
        $this->propertyCacheEnabled = $propertyCacheEnabled;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function isPropertyCacheEnabled(): bool
    {
        return $this->propertyCacheEnabled;
    }

    public function isClassPropertiesCached(string $className, string $method): bool
    {
        return $this->isClassCached($className) && isset($this->cache[$className]['properties'][$method]);
    }

    public function isClassCached(string $className): bool
    {
        return isset($this->cache[$className]);
    }

    public function setMethods(string $className, array $methods): CacheInterface
    {
        $this->cache[$className]['methods'] = $methods;

        return $this;
    }

    public function getMethods(string $className): array
    {
        if ($this->isClassMethodsCached($className)) {
            return $this->cache[$className]['methods'];
        }

        return [];
    }

    public function isClassMethodsCached(string $className): bool
    {
        return $this->isClassCached($className) && isset($this->cache[$className]['methods']);
    }

    public function setPropertyName(string $className, string $method, string $propertyName): CacheInterface
    {
        $this->cache[$className]['properties'][$method] = $propertyName;

        return $this;
    }

    public function getPropertyName(string $className, string $method): string
    {
        if ($this->isClassPropertiesCached($className, $method)) {
            return $this->cache[$className]['properties'][$method];
        }
    }

    public function setStrategy(string $className, StrategyInterface $strategy): CacheInterface
    {
        $this->cache[$className]['strategy'] = $strategy;

        return $this;
    }

    public function getStrategy(string $className): ?StrategyInterface
    {
        if ($this->isClassStrategyCached($className)) {
            return $this->cache[$className]['strategy'];
        }

        return null;
    }

    public function isClassStrategyCached(string $className): bool
    {
        return $this->isClassCached($className) && isset($this->cache[$className]['strategy']);
    }
}
