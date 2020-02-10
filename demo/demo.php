<?php

namespace Widi\JsonEncode;

require_once '../vendor/autoload.php';

use DateTime;
use Widi\JsonEncode\Cache\ArrayCache;
use Widi\JsonEncode\Factory\JsonEncoderFactory;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
use Widi\JsonEncode\Strategy\DateTimeStrategy;
use Widi\JsonEncode\Strategy\DefaultStrategy;

$encoderFactory = new JsonEncoderFactory();
$encoder = $encoderFactory->create(
    new GetIsHasMethodFilter(),
    new ArrayCache(true, false),
    new DefaultStrategy(true),
    [
        DateTime::class => [
            'class' => DateTimeStrategy::class,
            'options' => [
                'format' => 'd.m.Y'
            ]
        ]
    ],
    true
);

$provider = new Provider('providerName');
$tariffVersion = new TariffVersion('tariffVersionName');
$tariff = new Tariff(
    'tariffName',
    $provider,
    $tariffVersion
);
$provider->setTariffVersion($tariffVersion);
$tariffVersion->setProvider($provider);

echo $encoder->encode($tariff) . PHP_EOL;
