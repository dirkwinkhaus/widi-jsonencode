<?php
declare(strict_types=1);

namespace Widi\JsonEncode;

class Provider
{
    private $name;

    /**
     * Provider constructor.
     * @param $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }
}