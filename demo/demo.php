<?php

namespace Widi\JsonEncode;

require_once '../vendor/autoload.php';
require_once 'provider.class.php';
require_once 'tariff.class.php';
require_once 'tariff_version.class.php';
require_once 'generator_model.class.php';

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Generator;
use generator_model;
use Widi\JsonEncode\Cache\ArrayCache;
use Widi\JsonEncode\Factory\JsonEncoderFactory;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
use Widi\JsonEncode\Filter\GetIsHasMethodSnakeCaseFilter;
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

$collection = new ArrayCollection([1, 2]);

echo $encoder->encode($collection) . PHP_EOL;


$encoderSnakeCase = $encoderFactory->create(
    new GetIsHasMethodSnakeCaseFilter(),
    new ArrayCache(true, false),
    new DefaultStrategy(true),
    [
        DateTime::class => [
            'class' => DateTimeStrategy::class,
            'options' => [
                'format' => 'd.m.Y'
            ]
        ],
    ],
    true
);

$provider = new provider('providerName');
$tariffVersion = new tariff_version('tariffVersionName');
$tariff = new tariff(
    'tariffName',
    $provider,
    $tariffVersion
);
$provider->set_tariff_version($tariffVersion);
$tariffVersion->set_provider($provider);

echo $encoderSnakeCase->encode($tariff) . PHP_EOL;

function generate(): Generator {
    yield ['a', 'b', 'c'];
    yield ['d', 'e', 'f'];
    yield ['g', 'h', 'i'];
}

$generatorModel = new generator_model(1, 'name', generate());

echo $encoderSnakeCase->encode($generatorModel) . PHP_EOL;
