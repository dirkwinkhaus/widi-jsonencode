<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

class tariff_version
{
    /** @var string */
    private $name;

    /** @var provider */
    private $provider;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_provider(): provider
    {
        return $this->provider;
    }

    public function set_provider(provider $provider): tariff_version
    {
        $this->provider = $provider;

        return $this;
    }
}
