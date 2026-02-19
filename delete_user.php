<?php
require_once 'config/db.php';

// Mengecek apakah ada ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Gunakan Supabase REST API untuk delete data
    $result = supabase_delete('/users', $id);
    
    if (isset($result['error'])) {
        // Jika ada error, simpan pesan error ke session dan kembali
        session_start();
        $_SESSION['error'] = $result['error'];
    }
}

// Langsung kembalikan ke halaman utama
header("Location: index.php");
exit;
?>
