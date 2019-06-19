<?php
declare(strict_types=1);

namespace Widi\JsonEncode\Filter;

class GetIsHasMethodFilter implements MethodFilterInterface
{
    public function filter(): callable
    {
        return function (string $method) {
            return $this->isGetMethod($method) || $this->isHasMethod($method) || $this->isIsMethod($method);
        };
    }

    public function getPropertyName(string $method): string
    {
        if ($this->isGetMethod($method)) {
            return lcfirst(substr($method, 3));
        }

        if ($this->isHasMethod($method)) {
            return lcfirst(substr($method, 3));
        }

        if ($this->isIsMethod($method)) {
            return lcfirst(substr($method, 2));
        }

        return $method;
    }

    private function isGetMethod(string $method)
    {
        $substr = substr($method, 0, 3);
        if (($substr === 'get') && (ctype_upper($method[3]))) {
            return true;
        }

        return false;
    }

    private function isHasMethod(string $method)
    {
        $substr = substr($method, 0, 3);
        if (($substr === 'has') && (ctype_upper($method[3]))) {
            return true;
        }

        return false;
    }

    private function isIsMethod(string $method)
    {
        $substr = substr($method, 0, 2);
        if (($substr === 'is') && (ctype_upper($method[2]))) {
            return true;
        }

        return false;
    }
}