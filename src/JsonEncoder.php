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

    /**
     * JsonEncoder constructor.
     * @param MethodFilterInterface $methodFilter
     * @param CacheInterface $cache
     */
    public function __construct(
        MethodFilterInterface $methodFilter,
        ?CacheInterface $cache = null
    ) {
        $this->methodFilter = $methodFilter;
        $this->cache = $cache;
    }


    public function encode($value): string
    {
        return \json_encode($this->encodeRecursive($value));
    }

    private function encodeRecursive($value)
    {
        if (is_array($value)) {
            foreach ($value as &$item) {
                $item = $this->encodeRecursive($item);
            }

            return $value;
        } elseif (is_object($value)) {
            $instance = new \stdClass();

            $methods = $this->findFunctions($value);


            foreach ($methods as $method) {
                $propertyName = $this->getPropertyName($value, $method);
                $instance->$propertyName = $this->encodeRecursive($value->$method());
            }

            if ($this->cache instanceof CacheInterface) {
                $this->cache->setClassCached(get_class($value), true);
            }

            return $instance;
        }

        return $value;
    }

    private function findFunctions($class): array
    {
        $cacheIsActive = $this->cache instanceof CacheInterface;

        if ($cacheIsActive) {
            $className = get_class($class);

            if ($this->cache->isClassCached($className)) {
                return $this->cache->getMethods($className);
            }
        }

        $methods = get_class_methods($class);

        $filteredFunctions = $this->filterFunctions($methods);

        if ($cacheIsActive) {
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
        $cacheIsActive = $this->cache instanceof CacheInterface;

        if ($cacheIsActive) {
            $className = get_class($class);

            if ($this->cache->isClassCached($className)) {
                return $this->cache->getPropertyName($className, $method);
            }
        }

        $propertyName = $this->methodFilter->getPropertyName($method);

        if ($cacheIsActive) {
            $className = get_class($class);

            $this->cache->setPropertyName($className, $method, $propertyName);
        }

        return $propertyName;
    }
}