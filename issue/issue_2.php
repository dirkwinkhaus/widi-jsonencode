<?php


namespace Widi\JsonEncode;

use Widi\JsonEncode\Cache\ArrayCache;
use Widi\JsonEncode\Factory\JsonEncoderFactory;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
use Widi\JsonEncode\Strategy\DateTimeStrategy;
use Widi\JsonEncode\Strategy\DefaultStrategy;

require_once '../vendor/autoload.php';

class MyModel
{
    public function get(): int
    {
        return 2;
    }

    public function geta(): int
    {
        return 2;
    }

    public function getB(): int
    {
        return 2;
    }

}

$model = new MyModel();

$encoderFactory = new JsonEncoderFactory();
$encoder = $encoderFactory->create(
    new GetIsHasMethodFilter(),
    new ArrayCache(true, false),
    new DefaultStrategy(),
    [
        \DateTime::class => [
            'class' => DateTimeStrategy::class,
        ]
    ],
    true
);

echo $encoder->encode($model) . PHP_EOL;
