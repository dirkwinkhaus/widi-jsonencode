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
     * @param class $provider
     *
     * @return TariffVersion
     */
    public function setProvider(provider $provider): TariffVersion
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * @return class
     */
    public function getProvider(): provider
    {
        return $this->provider;
    }
}
