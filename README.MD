# Widi\Json-Encode
A light weight deep json encoder which avoids recursive encoding.

## Encoder
Use the encoder like this:

	public function encode($value): string;  // => json string
	
## Encoder Factory
The encoder Factory brings it all together. You may provide a dependency container to get strategies from it.
It accepts container implementing "psr/container". Instance mapping will enable to look for class children of 
mapped classes. For instance if you extend DateTime it will not be recognized by the mapper if instance mapping
ist not enabled. By default it is enabled. You can disable it to be faster at serialization. 

    $encoder = $encoderFactory->create(
        new GetIsHasMethodFilter(),
        new ArrayCache(true, false),
        new DefaultStrategy(false),
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
        true,
        $dependencyContainer
    );


## Filter
The filter figures out which methods are important to get information from. You 
may write your own by using the MethodFilterInterface. Included is a filter 
to call any is*, get*, has* method of an object. There are two filters provided:
- GetIsHasMethodFilter
- GetIsHasMethodSnakeCaseFilter
And you can easily define your own filter by using the filter interface.

## Cache
The cache will keep information about filtered methods and optionally even 
property names. The package includes an array cache an a no-cache cache like a
null cache. You may write your own by using the CacheInterface.

## Strategy
There is a default strategy and a strategy for handling datetime objects. You may add 
your own if necessary. Via class name and optional instance mapping the defined strategy
will be found. Instance mapping can be disabled by the 5th argument of the encoder factory.  

## Usage
	<?php
	
	namespace Widi\JsonEncode;
	
	require_once '../vendor/autoload.php';
	
	use Widi\JsonEncode\Cache\ArrayCache;
	use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
	
    $encoderFactory = new JsonEncoderFactory();
    $encoder = $encoderFactory->create(
        new GetIsHasMethodFilter(),
        new ArrayCache(true, false),
        new DefaultStrategy(false),
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
	
	$provider = new Provider('providerName');
	$tariffVersion = new TariffVersion('tariffVersionName');
	$tariff = new Tariff(
		'tariffName',
		$provider,
		$tariffVersion
	);
	$provider->setTariffVersion($tariffVersion);
	$tariffVersion->setProvider($provider);
	
	echo $encoder->encode($tariff) . PHP_EOL;
