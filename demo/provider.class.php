<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

class provider
{
    private $name;

    private $tariff_version;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_tariff_version(): tariff_version
    {
        return $this->tariff_version;
    }

    public function set_tariff_version(tariff_version $tariffVersion)
    {
        $this->tariff_version = $tariffVersion;

        return $this;
    }
}
