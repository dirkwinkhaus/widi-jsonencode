<?php

namespace Widi\JsonEncode\Strategy\Factory;

use Psr\Container\ContainerInterface;
use Widi\JsonEncode\Exception\NoStrategyClassCreatedException;
use Widi\JsonEncode\Exception\StrategyClassNotFoundException;
use Widi\JsonEncode\Strategy\StrategyInterface;

class StrategyFactory implements StrategyFactoryInterface
{
    /** @var StrategyInterface */
    private $defaultStrategy;

    /** @var array */
    private $strategyMapping;

    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * @var bool
     */
    private $instanceMapping;

    public function __construct(
        StrategyInterface $defaultStrategy,
        array $strategyMapping = [],
        bool $instanceMapping = true,
        ContainerInterface $container = null
    ) {
        $this->defaultStrategy = $defaultStrategy;
        $this->strategyMapping = $strategyMapping;
        $this->container = $container;
        $this->instanceMapping = $instanceMapping;
    }

    public function create($value): StrategyInterface
    {
        if (is_object($value)) {
            $className = get_class($value);
            if (isset($this->strategyMapping[$className])) {
                return $this->createStrategy($className, $this->strategyMapping[$className]);
            }

            if ($this->instanceMapping) {
                foreach ($this->strategyMapping as $class => $config) {
                    if (is_subclass_of($value, $class)) {
                        return $this->createStrategy($className, $this->strategyMapping[$class]);
                    }
                }
            }
        }

        return $this->defaultStrategy;
    }

    private function createStrategy(string $className, array $mapping)
    {
        if ($this->container instanceof ContainerInterface
            && $this->container->has($mapping['class'])) {
            return $this->container->get($mapping['class']);
        }

        if (!class_exists($mapping['class'])) {
            throw new StrategyClassNotFoundException($className);
        }

        $options = $mapping['options'] ?? null;

        $strategy = new $mapping['class']($options);

        if (!$strategy instanceof StrategyInterface) {
            throw new NoStrategyClassCreatedException($className);
        }

        return $strategy;
    }
}
