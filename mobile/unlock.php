<?php
require __DIR__ . '/../vendor/autoload.php';
include_once '../db.php';
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

$server   = '192.168.1.80';
$port     = 1883;
$mqtt = new MqttClient($server, $port);
$connectionSettings = (new ConnectionSettings)
    ->setUsername("admin")
    ->setPassword("superce11");            
function base32Decode($secret) {
    $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    $base32charsFlipped = array_flip(str_split($base32chars));
    $secret = strtoupper($secret);
    $paddingCharCount = substr_count($secret, '=');
    $allowedValues = [6,4,3,1,0];
    if (!in_array($paddingCharCount, $allowedValues)) return false;
    $secret = str_replace('=','', $secret);
    $binaryString = '';
    foreach (str_split($secret) as $char) {
        if (!isset($base32charsFlipped[$char])) return false;
        $binaryString .= str_pad(decbin($base32charsFlipped[$char]), 5, '0', STR_PAD_LEFT);
    }
    $eightBits = str_split($binaryString,8);
    $decoded = '';
    foreach ($eightBits as $bits) {
        if (strlen($bits) < 8) continue;
        $decoded .= chr(bindec($bits));
    }
    return $decoded;
}
function getTOTPCode($secret, $timeStep = 30, $digits = 6) {
    $secretKey = base32Decode($secret);
    if ($secretKey === false) return false;
    $time = floor(time() / $timeStep);
    $timeBytes = pack('N*', 0) . pack('N*', $time);
    $hash = hash_hmac('sha1', $timeBytes, $secretKey, true);
    $offset = ord(substr($hash, -1)) & 0x0F;
    $truncatedHash = substr($hash, $offset, 4);
    $value = unpack('N', $truncatedHash)[1] & 0x7FFFFFFF;
    $modulo = pow(10, $digits);
    return str_pad($value % $modulo, $digits, '0', STR_PAD_LEFT);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $code = $_POST['code'] ?? '';
    $stmt = $db->prepare("SELECT mobilecode FROM users WHERE name = :username AND enabled = 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        header("Location: /mobile/index.php?status=fail&message=" . urlencode("User not found"));
        exit;
    }
    $code = getTOTPCode($row['mobilecode']);
    if ($code === $_POST['code']) {
        $mqtt->connect($connectionSettings);
        $mqtt->publish('door/scan', '{"type": "mobile", "code": "'.$code.'"}', 1);
        $mqtt->disconnect();
        header("Location: /mobile/index.php?status=success");
    } else {
        header("Location: /mobile/index.php?status=fail&message=" . urlencode("Invalid code"));
    }
    exit;
}