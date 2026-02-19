<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
$quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

if (!$cart_id) {
    echo json_encode(['error' => 'Invalid cart id']);
    exit;
}

$res = supabase_patch('/carts', $cart_id, ['quantity' => $quantity]);

if (isset($res['error'])) {
    echo json_encode(['error' => true, 'msg' => $res['error']]);
} else {
    echo json_encode(['success' => true]);
}
