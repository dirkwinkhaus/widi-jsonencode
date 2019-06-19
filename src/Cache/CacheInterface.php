<?php
declare(strict_types=1);

namespace Widi\JsonEncode\Cache;

interface CacheInterface
{
    public function isClassCached(string $className): bool;
    public function setClassCached(string $className, bool $isCached): CacheInterface;
    public function setMethods(string $className, array $methods): CacheInterface;
    public function setPropertyName(string $className, string $method, string $propertyName): CacheInterface;
    public function getMethods(string $className): array;
    public function getPropertyName(string $className, string $method): string;
}