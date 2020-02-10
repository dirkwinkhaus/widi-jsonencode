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
    /**
     * @var \DateTime
     */
    private $searchAt;

    /**
     * MyModel constructor.
     * @param \DateTime $searchAt
     */
    public function __construct(\DateTime $searchAt)
    {
        $this->searchAt = $searchAt;
    }

    /**
     * @return \DateTime
     */
    public function getSearchAt(): \DateTime
    {
        return $this->searchAt;
    }

}


$model = new MyModel(new \DateTime());

$encoderFactory = new JsonEncoderFactory();
$encoder = $encoderFactory->create(
    new GetIsHasMethodFilter(),
    new ArrayCache(true, false),
    new DefaultStrategy(),
    [
        \DateTime::class => [
            'class' => DateTimeStrategy::class,
        ]
    ]
);

echo $encoder->encode($model) . PHP_EOL;
