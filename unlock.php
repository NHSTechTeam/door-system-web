<?php 
require __DIR__ . '/vendor/autoload.php';
include_once 'db.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: /login/");
    exit;
}
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;
$server   = '192.168.1.21'; // MQTT broker
$port     = 1883;
$clientId = 'php-client';

try {
    $mqtt = new MqttClient($server, $port, $clientId);
    $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
        ->setUsername("admin")
        ->setPassword("superce11");
    $mqtt->connect($connectionSettings, true);

    $mqtt->publish('door/scan', '{"type": "WebUI", "code": "'.$_SESSION['displayname'].'"}', 0);

    echo "Message sent!\n";

    $mqtt->disconnect();
} catch (MqttClientException $e) {
    echo "Error: " . $e->getMessage();
}
if (isset($_GET['confirm'])) {
    
}


?>