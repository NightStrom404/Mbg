<?php
header('Content-Type: text/plain');
header('Access-Control-Allow-Origin: *');

// ✅ SECRET KEY YANG BENAR
$secretKey = "0x4AAAAAACmUJApqFJoi7W6SxRXfjZ6wnvA";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "FAIL";
    exit;
}

$token = $_POST['token'] ?? '';
if (empty($token)) {
    echo "FAIL";
    exit;
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

$url = "https://challenges.cloudflare.com/turnstile/v0/siteverify";

$data = [
    'secret'   => $secretKey,
    'response' => $token,
    'remoteip' => $ip
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 || $response === false) {
    echo "FAIL";
    exit;
}

$result = json_decode($response, true);

if (isset($result['success']) && $result['success'] === true) {
    setcookie('__cf_verify_mbg', hash('sha256', $ip . $secretKey . time()), time() + 3600, '/');
    echo "OK";
} else {
    echo "FAIL";
}
?>
