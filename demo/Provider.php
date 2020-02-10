<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

class Provider
{
    private $name;

    private $tariffVersion;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTariffVersion(): TariffVersion
    {
        return $this->tariffVersion;
    }

    public function setTariffVersion($tariffVersion)
    {
        $this->tariffVersion = $tariffVersion;

        return $this;
    }
}
