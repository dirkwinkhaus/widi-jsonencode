<?php

namespace Widi\JsonEncode\Strategy;

use DateTime;
use Widi\JsonEncode\Encoder\Core;

class DateTimeStrategy implements StrategyInterface
{
    private const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $format;

    public function __construct(array $options)
    {
        $this->format = $options['format'] ?? self::DEFAULT_FORMAT;
    }

    public function createStdClass($value, Core $jsonEncoder, array $stack = [])
    {
        /** @var DateTime $value */
        return $value->format($this->format);
    }
}
