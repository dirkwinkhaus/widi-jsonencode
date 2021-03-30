<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

use stdClass;
use Widi\JsonEncode\Encoder\Core;

use function json_encode;

class JsonEncoder implements JsonEncoderInterface
{
    /**
     * @var Core
     */
    private $core;

    public function __construct(Core $core)
    {
        $this->core = $core;
    }

    public function encode($value): string
    {
        return json_encode($this->toStdClass($value));
    }

    /** @inheritDoc */
    public function toStdClass($value)
    {
        return $this->core->encodeRecursive($value);
    }
}
