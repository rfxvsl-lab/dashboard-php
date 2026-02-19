<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Delete dari Supabase
    supabase_delete('/products', $id);
}

// Langsung kembalikan ke halaman produk
header("Location: products.php");
exit;
?>
