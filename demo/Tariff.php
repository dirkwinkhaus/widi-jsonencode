<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

class Tariff
{
    /** @var string */
    private $name;

    /** @var Provider */
    private $provider;
    /**
     * @var TariffVersion
     */
    private $tariffVersion;

    public function __construct(string $name, Provider $provider, TariffVersion $tariffVersion)
    {
        $this->name = $name;
        $this->provider = $provider;
        $this->tariffVersion = $tariffVersion;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Provider
     */
    public function getProvider(): Provider
    {
        return $this->provider;
    }

    /**
     * @return TariffVersion
     */
    public function getTariffVersion(): TariffVersion
    {
        return $this->tariffVersion;
    }
}
