<?php
header('Content-Type: application/json');

$secretKey = "0x4AAAAAAC_ync8iinI3Oxflz08KHg0qJUI";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false]);
    exit;
}

$token = $_POST['token'] ?? '';
if (!$token) {
    echo json_encode(["success" => false]);
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '';

$ch = curl_init("https://challenges.cloudflare.com/turnstile/v0/siteverify");
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'secret' => $secretKey,
        'response' => $token,
        'remoteip' => $ip
    ]),
    CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (!empty($result['success'])) {
    setcookie('__cf_verify_mbg', '1', time()+1800, '/', '', true, true);

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
