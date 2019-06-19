# README 2bc
	<?php
	
	namespace Widi\JsonEncode;
	
	require_once '../vendor/autoload.php';
	
	use Widi\JsonEncode\Filter\GetIsHasMethodFilter;
	
	$encoder = new JsonEncoder(new GetIsHasMethodFilter());
	
	
	
	$provider = new Provider('providerName');
	$tariff = new Tariff('tariffName', $provider);
	
	
	echo $encoder->encode($tariff) . PHP_EOL;
	