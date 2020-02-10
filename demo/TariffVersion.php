<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

class TariffVersion
{
    /** @var string */
    private $name;

    /** @var Provider */
    private $provider;

    /**
     * Tariff constructor.
     * @param string $name
     * @param Provider $provider
     */
    public function __construct(string $name)
    {
        $this->name = $name;
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
     * @param Provider $provider
     *
     * @return TariffVersion
     */
    public function setProvider(Provider $provider): TariffVersion
    {
        $this->provider = $provider;

        return $this;
    }
}
