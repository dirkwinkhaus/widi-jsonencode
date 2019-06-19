<?php
declare(strict_types=1);

namespace Widi\JsonEncode\Cache;

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
}