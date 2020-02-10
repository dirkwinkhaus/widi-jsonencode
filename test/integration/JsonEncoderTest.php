<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

use DateTime;
use PHPUnit\Framework\TestCase;
use Widi\JsonEncode\Cache\ArrayCache;
use Widi\JsonEncode\Cache\NoCache;
use Widi\JsonEncode\Factory\JsonEncoderFactory;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
use Widi\JsonEncode\Strategy\DateTimeStrategy;
use Widi\JsonEncode\Strategy\DefaultStrategy;

class JsonEncoderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldEncodeRecursiveObjectTree(): void
    {
        $encoderFactory = new JsonEncoderFactory();
        $encoder = $encoderFactory->create(
            new GetIsHasMethodFilter(),
            new ArrayCache(true, false),
            new DefaultStrategy(),
            [
                DateTime::class => [
                    'class' => DateTimeStrategy::class,
                    'options' => [
                        'format' => 'd.m.Y'
                    ]
                ]
            ]
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
