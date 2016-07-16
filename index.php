<?php
//include_once('Converse/Client.php');
//namespace UsamaNoman\Wit;
//use UsamaNoman\Wit\Converse\Client;
require 'vendor/autoload.php';
require 'vendor/usama-wit-php.php';


use GuzzleHttp\Client;

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://httpbin.org',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

$client = new \GuzzleHttp\Client(['base_uri' => 'http://httpbin.org']);
$json=$client->request(
	'GET'
);
//return $json->getBody();

echo $json->getBody();

//$client = new \UsamaNoman\Wit\Converse\Client();
//echo $client->hello();



?>