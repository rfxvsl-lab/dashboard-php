<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil keranjang
$carts = supabase_fetch('/carts', ['user_id' => 'eq.' . $user_id, 'select' => '*']);
if (!is_array($carts) || isset($carts['error']) || empty($carts)) {
    header('Location: cart.php');
    exit;
}

$items = [];
$total = 0.00;
foreach ($carts as $c) {
    $prod = supabase_fetch('/products', ['id' => 'eq.' . intval($c['product_id']), 'select' => '*']);
    $product = is_array($prod) && isset($prod[0]) ? $prod[0] : null;
    $price = $product['harga'] ?? 0;
    $subtotal = $price * intval($c['quantity']);
    $items[] = ['cart_id' => $c['id'], 'product_id' => $c['product_id'], 'quantity' => $c['quantity'], 'price' => $price];
    $total += $subtotal;
}

// Buat order
$order_data = [
    'user_id' => $user_id,
    'total' => number_format($total, 2, '.', ''),
    'status' => 'pending',
    'created_at' => date('c')
];

$order_res = supabase_post('/orders', $order_data);

if (!is_array($order_res) || isset($order_res['error'])) {
    die('Gagal membuat order.');
}

$created_order = isset($order_res[0]) ? $order_res[0] : $order_res;
$order_id = $created_order['id'] ?? ($created_order['order_id'] ?? null);

if (!$order_id) {
    die('Gagal mendapatkan ID order.');
}

// Buat order_items dan hapus cart
foreach ($items as $it) {
    $oi = [
        'order_id' => $order_id,
        'product_id' => $it['product_id'],
        'quantity' => $it['quantity'],
        'price' => $it['price']
    ];
    supabase_post('/order_items', $oi);
    // hapus cart item
    supabase_delete('/carts', $it['cart_id']);
}

header('Location: order_success.php?order_id=' . urlencode($order_id));
exit;
