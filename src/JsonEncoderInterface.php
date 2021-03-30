<?php

namespace Widi\JsonEncode;

use stdClass;

interface JsonEncoderInterface
{
    public function encode($value): string;

    /**
     * @return array|stdClass
     */
    public function toStdClass($value);
}
