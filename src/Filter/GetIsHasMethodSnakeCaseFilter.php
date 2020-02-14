<?php

declare(strict_types=1);

namespace Widi\JsonEncode\Filter;

class GetIsHasMethodSnakeCaseFilter implements MethodFilterInterface
{
    public function filter(): callable
    {
        return function (string $method) {
            return $this->isGetMethod($method) || $this->isHasMethod($method) || $this->isIsMethod($method);
        };
    }

    private function isGetMethod(string $method)
    {
        if (strlen($method) <= 4) {
            return false;
        }

        $substr = substr($method, 0, 4);
        if (($substr === 'get_') && (!is_numeric($method[4]))) {
            return true;
        }

        return false;
    }

    private function isHasMethod(string $method)
    {
        if (strlen($method) <= 4) {
            return false;
        }

        $substr = substr($method, 0, 4);
        if (($substr === 'has_') && (!is_numeric($method[4]))) {
            return true;
        }

        return false;
    }

    private function isIsMethod(string $method)
    {
        if (strlen($method) <= 3) {
            return false;
        }

        $substr = substr($method, 0, 3);
        if (($substr === 'is_') && (!is_numeric($method[3]))) {
            return true;
        }

        return false;
    }

    public function getPropertyName(string $method): string
    {
        if ($this->isGetMethod($method)) {
            return substr($method, 4);
        }

        if ($this->isHasMethod($method)) {
            return substr($method, 4);
        }

        if ($this->isIsMethod($method)) {
            return substr($method, 3);
        }

        return $method;
    }
}
