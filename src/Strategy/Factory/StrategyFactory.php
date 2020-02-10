<?php

namespace Widi\JsonEncode\Strategy\Factory;

use Psr\Container\ContainerInterface;
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

    public function __construct(
        StrategyInterface $defaultStrategy,
        array $strategyMapping = [],
        ContainerInterface $container = null
    ) {
        $this->defaultStrategy = $defaultStrategy;
        $this->strategyMapping = $strategyMapping;
        $this->container = $container;
    }

    public function create($value): StrategyInterface
    {
        if (is_object($value)) {
            $className = get_class($value);
            if (isset($this->strategyMapping[$className])) {
                if ($this->container instanceof ContainerInterface
                    && $this->container->has($this->strategyMapping[$className]['class'])) {
                    return $this->container->get($this->strategyMapping[$className]['class']);
                }

                if (!class_exists($this->strategyMapping[$className]['class'])) {
                    throw new StrategyClassNotFoundException($className);
                }

                $options = $this->strategyMapping[$className]['options'] ?? [];
                return new $this->strategyMapping[$className]['class']($options);
            }
        }

        return $this->defaultStrategy;
    }
}
