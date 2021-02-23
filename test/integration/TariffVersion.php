<?php
declare(strict_types=1);

namespace Widi\JsonEncode;

use Generator;

class TariffVersion
{
    private string $name;

    private Provider $provider;

    private Generator $values;

    public function __construct(string $name, Generator $values)
    {
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setProvider(provider $provider): TariffVersion
    {
        $this->provider = $provider;

        return $this;
    }

    public function getProvider(): provider
    {
        return $this->provider;
    }

    public function getValues(): Generator
    {
        return $this->values;
    }
}
