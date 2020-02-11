<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Encoder;

use Widi\JsonEncode\Cache\CacheInterface;
use Widi\JsonEncode\Filter\MethodFilterInterface;
use Widi\JsonEncode\Strategy\Factory\StrategyFactoryInterface;

class Core
{
    /** @var MethodFilterInterface */
    private $methodFilter;

    /** @var CacheInterface */
    private $cache;

    /** @var StrategyFactoryInterface */
    private $strategyFactory;

    public function __construct(
        MethodFilterInterface $methodFilter,
        CacheInterface $cache,
        StrategyFactoryInterface $strategyFactory
    ) {
        $this->methodFilter = $methodFilter;
        $this->cache = $cache;
        $this->strategyFactory = $strategyFactory;
    }

    public function encodeRecursive($value, array $stack = [])
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

            $className = get_class($value);
            $strategy = $this->cache->getStrategy($className) ??
                $this->strategyFactory->create($value);

            $this->cache->setStrategy($className, $strategy);

            return $strategy->createStdClass($value, $this, $stack);
        }

        return $value;
    }

    public function findFunctions($class): array
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

    public function getPropertyName($class, string $method): string
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
