<?php

declare(strict_types=1);

namespace Widi\JsonEncode;

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
        return json_encode($this->core->encodeRecursive($value));
    }
}
