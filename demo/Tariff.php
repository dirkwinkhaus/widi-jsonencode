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
     * Tariff constructor.
     * @param string $name
     * @param Provider $provider
     */
    public function __construct(string $name, Provider $provider)
    {
        $this->name = $name;
        $this->provider = $provider;
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
}