<?php

namespace Widi\JsonEncode;

require_once '../vendor/autoload.php';

use Widi\JsonEncode\Cache\ArrayCache;
use Widi\JsonEncode\Filter\GetIsHasMethodFilter;

$config = require 'performanceConfig.php';

$runs = $config['start'];

echo $config['text'];

file_put_contents(
    'performance.log',
    $config['text']
);

$distance = "\t\t\t";

$loop = 0;
while ($runs < $config['end']) {
    $progress = floor(100 / ($config['end'] - $config['start'] / $config['step']) * $runs);

    $loopInfo = 'Loop: ' . $loop . ' ('.$progress.'%)' . PHP_EOL;
    echo $loopInfo;
    file_put_contents(
        'performance.log',
        $loopInfo,
        FILE_APPEND
    );
    for ($variation = 0; $variation <3; $variation++) {

        if ($variation === 0) {
            $cacheEnables = false;
            $methodCacheEnabled = false;
        }
        if ($variation === 1) {
            $cacheEnables = true;
            $methodCacheEnabled = false;
        }
        if ($variation === 2) {
            $cacheEnables = true;
            $methodCacheEnabled = true;
        }

        $cycles = $runs;

        $encoder = new JsonEncoder(
            new GetIsHasMethodFilter(),
            new ArrayCache($cacheEnables, $methodCacheEnabled)
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

        $start = microtime(true);

        for ($cycle = 0; $cycle < $cycles; $cycle++) {
            $encoder->encode($tariff);
        }

        $duration = microtime(true) - $start;

        $result = sprintf(
            "Variation: %d $distance Cycles: %d $distance Cache: %d $distance  MethodCache: %d $distance Duration: %f ms\n",
            $variation,
            $cycles,
            $cacheEnables,
            $methodCacheEnabled,
            $duration
        );

        echo $result;

        file_put_contents(
            'performance.log',
            $result,
            FILE_APPEND
        );

        if ($variation === 2) {
            $line = '________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________' . PHP_EOL;
            echo $loopInfo;
            file_put_contents(
                'performance.log',
                $line,
                FILE_APPEND
            );
        }
    }

    $runs += $config['step'];
    $loop++;
}