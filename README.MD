# Widi\Json-Encode
A light deep json encoder which avoids recursive encoding.

## Usage
	<?php
	
	namespace Widi\JsonEncode;
	
	require_once '../vendor/autoload.php';
	
	use Widi\JsonEncode\Cache\ArrayCache;
	use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
	
	$encoder = new JsonEncoder(
		new GetIsHasMethodFilter(),
		new ArrayCache(true, false)
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