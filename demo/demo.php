<?php

namespace Widi\JsonEncode;

require_once '../vendor/autoload.php';

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Widi\JsonEncode\Cache\ArrayCache;
use Widi\JsonEncode\Factory\JsonEncoderFactory;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
use Widi\JsonEncode\Strategy\DateTimeStrategy;
use Widi\JsonEncode\Strategy\DefaultStrategy;
use Widi\JsonEncode\Strategy\DoctrineCollectionStrategy;

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
        ],
        Collection::class => [
            'class' => DoctrineCollectionStrategy::class
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

$collection = new ArrayCollection([$provider, $tariffVersion]);

echo $encoder->encode($tariff) . PHP_EOL;

echo $encoder->encode($collection) . PHP_EOL;
