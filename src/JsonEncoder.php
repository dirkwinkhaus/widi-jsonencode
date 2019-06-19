<?php
declare(strict_types=1);

namespace Widi\JsonEncode;

use Widi\JsonEncode\Cache\CacheInterface;
use Widi\JsonEncode\Filter\MethodFilterInterface;

class JsonEncoder
{
    /** @var MethodFilterInterface  */
    private $methodFilter;

    /** @var CacheInterface */
    private $cache;

    public function __construct(
        MethodFilterInterface $methodFilter,
        CacheInterface $cache
    ) {
        $this->methodFilter = $methodFilter;
        $this->cache = $cache;
    }

    public function encode($value): string
    {
        return \json_encode($this->encodeRecursive($value));
    }

    public function transform($value)
    {
        return $this->encodeRecursive($value);
    }

    private function encodeRecursive($value, array $stack = [])
    {
        if (is_array($value)) {
            foreach ($value as &$item) {
                $item = $this->encodeRecursive($item);
            }

            return $value;
        } elseif (is_object($value)) {
            $objectHash = spl_object_hash($value);

            if (isset($stack[$objectHash])) {
                return null;
            } else {
                $stack[$objectHash] = true;
            }

            $instance = new \stdClass();

            $methods = $this->findFunctions($value);

            foreach ($methods as $method) {
                $propertyName = $this->getPropertyName($value, $method);
                $instance->$propertyName = $this->encodeRecursive($value->$method(), $stack);
            }

            return $instance;
        }

        return $value;
    }

    private function findFunctions($class): array
    {
        $cacheIsEnabled = $this->cache->isEnabled();

        if ($cacheIsEnabled) {
            $className = get_class($class);

            if ($this->cache->isClassMethodsCached($className)) {
                return $this->cache->getMethods($className);
            }
        }

        $methods = get_class_methods($class);

        $filteredFunctions = $this->filterFunctions($methods);

        if ($cacheIsEnabled) {
            $className = get_class($class);
            $this->cache->setMethods($className, $filteredFunctions);
        }

        return $filteredFunctions;
    }

    private function filterFunctions(array $methods)
    {
        return array_filter($methods, $this->methodFilter->filter());
    }

    private function getPropertyName($class, string $method): string
    {
        $cacheIsEnabled = $this->cache->isEnabled()
                          && $this->cache->isPropertyCacheEnabled();

        if ($cacheIsEnabled) {
            $className = get_class($class);

            if ($this->cache->isClassPropertiesCached($className, $method)) {
                return $this->cache->getPropertyName($className, $method);
            }
        }

        $propertyName = $this->methodFilter->getPropertyName($method);

        if ($cacheIsEnabled) {
            $className = get_class($class);

            $this->cache->setPropertyName($className, $method, $propertyName);
        }

        return $propertyName;
    }
}