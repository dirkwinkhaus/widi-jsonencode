<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

use PHPUnit\Framework\TestCase;
use Widi\JsonEncode\Cache\NoCache;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;

class JsonEncoderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldEncodeRecursiveObjectTree(): void
    {
        $encoder = new JsonEncoder(
            new GetIsHasMethodFilter(),
            new NoCache()
        );

        $provider      = new Provider('providerName');
        $tariffVersion = new TariffVersion('tariffVersionName');
        $tariff        = new Tariff(
            'tariffName',
            $provider,
            $tariffVersion
        );
        $provider->setTariffVersion($tariffVersion);
        $tariffVersion->setProvider($provider);

        $this->assertEquals($this->getExpected(), $encoder->encode($tariff));
    }

    public function getExpected(): string
    {
        return '{"name":"tariffName","provider":{"name":"providerName","tariffVersion":{"name":"tariffVersionName","provider":null}},"tariffVersion":{"name":"tariffVersionName","provider":{"name":"providerName","tariffVersion":null}}}';
    }
}