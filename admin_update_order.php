<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in']) || ($_SESSION['user_role'] ?? '') !== 'Admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$status = isset($_POST['status']) ? $_POST['status'] : '';

if (!$order_id || !$status) {
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$res = supabase_patch('/orders', $order_id, ['status' => $status]);

if (isset($res['error'])) {
    echo json_encode(['error' => true, 'msg' => $res['error']]);
} else {
    echo json_encode(['success' => true]);
}
