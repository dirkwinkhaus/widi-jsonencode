<?php

namespace Widi\JsonEncode;

interface JsonEncoderInterface
{
    public function encode($value): string;
}
