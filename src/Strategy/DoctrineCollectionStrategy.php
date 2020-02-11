<?php

namespace Widi\JsonEncode\Strategy;

use Doctrine\Common\Collections\Collection;
use Widi\JsonEncode\Encoder\Core;

class DoctrineCollectionStrategy implements StrategyInterface
{
    public function createStdClass($value, Core $jsonEncoder, array $stack = [])
    {
        $instances = [];

        /** @var Collection $value */
        foreach ($value->toArray() as $item) {
            $instances[] = $jsonEncoder->encodeRecursive($item, $stack);
        }

        return $instances;
    }
}
