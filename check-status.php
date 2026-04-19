<?php
// File ini untuk cek apakah Under Attack Mode ON atau OFF
// Bisa diatur manual atau via database

header('Content-Type: application/json');

// ===== KONFIGURASI MODE =====
// Ganti ini ke true untuk aktifkan Under Attack Mode
$underAttackMode = false; // <-- GANTI INI UNTUK ON/OFF

// Atau baca dari file/database:
// $underAttackMode = file_exists(__DIR__ . '/.under-attack');

$response = [
    'under_attack' => $underAttackMode,
    'timestamp' => time(),
    'message' => $underAttackMode ? 'Under Attack Mode Active' : 'Normal Operation'
];

echo json_encode($response);
?>
