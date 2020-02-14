<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

class tariff
{
    /** @var string */
    private $name;

    /** @var provider */
    private $provider;
    /**
     * @var tariff_version
     */
    private $tariff_version;

    public function __construct(string $name, provider $provider, tariff_version $tariff_version)
    {
        $this->name = $name;
        $this->provider = $provider;
        $this->tariff_version = $tariff_version;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_provider(): provider
    {
        return $this->provider;
    }

    public function get_tariff_version(): tariff_version
    {
        return $this->tariff_version;
    }
}
