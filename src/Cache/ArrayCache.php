<?php
declare(strict_types=1);

namespace Widi\JsonEncode\Cache;


class ArrayCache implements CacheInterface
{
    private $cache = [];

    public function isClassCached(string $className): bool
    {
        return $this->cache[$className]['isCached'] ?? false;
    }

    public function setClassCached(string $className, bool $isCached): CacheInterface
    {
        $this->cache[$className]['isCached'] = $isCached;

        return $this;
    }

    public function setMethods(string $className, array $methods): CacheInterface
    {
        $this->cache[$className]['methods'] = $methods;
    }

    public function setPropertyName(string $className, string $method, string $propertyName): CacheInterface
    {
        $this->cache[$className]['properties'][$method] = $propertyName;
    }

    public function getMethods(string $className): array
    {
        if ($this->isClassCached($className)) {
            return $this->cache[$className]['methods'];
        }
    }

    public function getPropertyName(string $className, string $method): string
    {
        if ($this->isClassCached($className)) {
            return $this->cache[$className]['properties'][$method];
        }
    }

}