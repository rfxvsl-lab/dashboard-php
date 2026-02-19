<?php
// db.php

// Use Supabase REST API (PostgREST) instead of direct PostgreSQL connection.
// Optionally load environment from .env when using vlucas/phpdotenv (composer).
$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
    if (class_exists(\Dotenv\Dotenv::class)) {
        try {
            \Dotenv\Dotenv::createImmutable(__DIR__)->load();
        } catch (\Exception $e) {
            // .env not found or error loading; continue with fallback
        }
    }
}

// Provide `SUPABASE_URL` and `SUPABASE_KEY` (anon or service role) via environment.
// Check $_ENV first (set by Dotenv), then fallback to getenv()
$supabase_url = $_ENV['SUPABASE_URL'] ?? getenv('SUPABASE_URL') ?: 'https://czhkrhtbplafrpevaqst.supabase.co';
$supabase_key = $_ENV['SUPABASE_KEY'] ?? getenv('SUPABASE_KEY') ?: ($_ENV['SUPABASE_ANON_KEY'] ?? getenv('SUPABASE_ANON_KEY'));

if (!$supabase_key) {
    die("Koneksi Gagal: SUPABASE_KEY environment variable not set. Set SUPABASE_KEY (anon public key) and optionally SUPABASE_URL.");
}

// Fetch users via Supabase REST API
$endpoint = rtrim($supabase_url, '/') . '/rest/v1/users?select=*';
$headers = [
    "apikey: $supabase_key",
    "Authorization: Bearer $supabase_key",
    "Accept: application/json",
];

$opts = [
    'http' => [
        'method' => 'GET',
        'header' => implode("\r\n", $headers) . "\r\n",
        'timeout' => 10,
    ],
];

$context = stream_context_create($opts);
$result = @file_get_contents($endpoint, false, $context);
if ($result === false) {
    $err = error_get_last();
    $msg = isset($err['message']) ? $err['message'] : 'failed to fetch from Supabase REST API';
    die("Koneksi Gagal: " . $msg);
}

$users = json_decode($result, true);
if (!is_array($users)) {
    $users = [];
}

$jumlah_user = count($users);
?>