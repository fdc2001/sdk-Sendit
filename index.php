<?php
// test file
require 'vendor/autoload.php';
use Filipeclemente\USendItSdk\Client;
use Filipeclemente\USendItSdk\Sms;

$client = new Client();
$client->setUsername('')->setPassword('')->setSender('SmsTeste')->enableSandbox();

$sms = new Sms();
$sms->setDestinatitary('351910000000')->setPartnerEventId(123)->setText('Hello World!')->setPriority(10);


$response = $client->send($sms);
//$response = $client->getSchedule(123);


if ($response->hasError()){
    echo $response->getErrorMessage();
}
echo PHP_EOL;

