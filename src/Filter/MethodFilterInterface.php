<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Filter;

interface MethodFilterInterface
{
    public function filter(): callable;

    public function getPropertyName(string $method): string;
}
