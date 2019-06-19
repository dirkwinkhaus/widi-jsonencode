<?php

namespace Widi\JsonEncode;

require_once '../vendor/autoload.php';

use Widi\JsonEncode\Filter\GetIsHasMethodFilter;

$encoder = new JsonEncoder(new GetIsHasMethodFilter());



$provider = new Provider('providerName');
$tariff = new Tariff('tariffName', $provider);


$time_start = microtime();

echo $encoder->encode($tariff) . PHP_EOL;

$time_end = microtime();


echo ($time_end - $time_start) . PHP_EOL;