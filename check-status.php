<?php
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate');

$underAttackMode = file_exists(__DIR__ . '/.under-attack');

echo json_encode([
    'under_attack' => $underAttackMode,
    'timestamp' => time(),
    'checked_at' => date('Y-m-d H:i:s')
]);
?>
