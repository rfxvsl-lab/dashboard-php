<?php
// config/db.php - Supabase REST API connection

// Load environment from .env via vlucas/phpdotenv (for local development)
$autoload = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
    if (class_exists(\Dotenv\Dotenv::class)) {
        try {
            \Dotenv\Dotenv::createImmutable(__DIR__ . '/..')->safeLoad();
        } catch (\Exception $e) {
            // .env not found or error loading - continue (Vercel will use env vars)
        }
    }
}

// Load Supabase credentials from Environment Variables
// Priority: getenv() > $_ENV > fallback
// Vercel automatically provides these via Environment Variables panel
$supabase_url = getenv('SUPABASE_URL') ?: ($_ENV['SUPABASE_URL'] ?? null);
$supabase_key = getenv('SUPABASE_KEY') ?: ($_ENV['SUPABASE_KEY'] ?? getenv('SUPABASE_ANON_KEY') ?: ($_ENV['SUPABASE_ANON_KEY'] ?? null));

// Validate credentials exist
if (!$supabase_url || !$supabase_key) {
    die("❌ Koneksi Gagal: Environment variables not configured.\n\n" .
        "Required variables:\n" .
        "• SUPABASE_URL (e.g., https://xxxxx.supabase.co)\n" .
        "• SUPABASE_KEY (anon/public key)\n\n" .
        "On Vercel: Add these in Settings > Environment Variables\n" .
        "Locally: Create a .env file with these variables");
}

// Helper function to fetch from Supabase REST API
function supabase_fetch($endpoint_path, $query_params = []) {
    global $supabase_url, $supabase_key;
    
    $url = rtrim($supabase_url, '/') . '/rest/v1' . $endpoint_path;
    if (!empty($query_params)) {
        $url .= '?' . http_build_query($query_params);
    }
    
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
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        $err = error_get_last();
        $msg = isset($err['message']) ? $err['message'] : 'failed to fetch from Supabase REST API';
        return ['error' => "Koneksi Gagal: " . $msg];
    }

    $data = json_decode($result, true);
    return is_array($data) ? $data : [];
}

// Helper function to POST (Create) data to Supabase REST API
function supabase_post($endpoint_path, $data) {
    global $supabase_url, $supabase_key;
    
    $url = rtrim($supabase_url, '/') . '/rest/v1' . $endpoint_path;
    $json_data = json_encode($data);
    
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation",
    ];

    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers) . "\r\n",
            'content' => $json_data,
            'timeout' => 10,
        ],
    ];

    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        $err = error_get_last();
        $msg = isset($err['message']) ? $err['message'] : 'failed to POST to Supabase REST API';
        return ['error' => "Koneksi Gagal: " . $msg];
    }

    $data = json_decode($result, true);
    return is_array($data) ? $data : ['success' => true];
}

// Helper function to PATCH (Update) data in Supabase REST API
function supabase_patch($endpoint_path, $id, $data) {
    global $supabase_url, $supabase_key;
    
    $url = rtrim($supabase_url, '/') . '/rest/v1' . $endpoint_path . "?id=eq." . $id;
    $json_data = json_encode($data);
    
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
        "Prefer: return=representation",
    ];

    $opts = [
        'http' => [
            'method' => 'PATCH',
            'header' => implode("\r\n", $headers) . "\r\n",
            'content' => $json_data,
            'timeout' => 10,
        ],
    ];

    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        $err = error_get_last();
        $msg = isset($err['message']) ? $err['message'] : 'failed to PATCH to Supabase REST API';
        return ['error' => "Koneksi Gagal: " . $msg];
    }

    $data = json_decode($result, true);
    return is_array($data) ? $data : ['success' => true];
}

// Helper function to DELETE data from Supabase REST API
function supabase_delete($endpoint_path, $id) {
    global $supabase_url, $supabase_key;
    
    $url = rtrim($supabase_url, '/') . '/rest/v1' . $endpoint_path . "?id=eq." . $id;
    
    $headers = [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
    ];

    $opts = [
        'http' => [
            'method' => 'DELETE',
            'header' => implode("\r\n", $headers) . "\r\n",
            'timeout' => 10,
        ],
    ];

    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        $err = error_get_last();
        $msg = isset($err['message']) ? $err['message'] : 'failed to DELETE from Supabase REST API';
        return ['error' => "Koneksi Gagal: " . $msg];
    }

    return ['success' => true];
}

// Fetch users from Supabase
$users = supabase_fetch('/users', ['select' => '*']);
$jumlah_user = is_array($users) && !isset($users['error']) ? count($users) : 0;
