<?php
session_start();
require_once 'config/db.php';

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if (!isset($_SESSION['is_logged_in'])) {
    if ($isAjax) {
        echo json_encode(['error' => 'Unauthorized', 'redirect' => 'login.php']);
        exit;
    }
    header('Location: login.php');
    exit;
}

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;
$user_id = $_SESSION['user_id'];

if ($product_id <= 0) {
    if ($isAjax) { echo json_encode(['error' => 'Invalid product']); exit; }
    header('Location: products.php'); exit;
}

// Simpan ke tabel carts
$data = [
    'user_id' => $user_id,
    'product_id' => $product_id,
    'quantity' => $quantity,
    'created_at' => date('c')
];

$res = supabase_post('/carts', $data);

if ($isAjax) {
    if (isset($res['error'])) {
        echo json_encode(['error' => true, 'msg' => $res['error']]);
    } else {
        echo json_encode(['success' => true]);
    }
    exit;
}

header('Location: cart.php');
exit;
