<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$order_id) {
    header('Location: orders.php');
    exit;
}

$order = supabase_fetch('/orders', ['id' => 'eq.' . $order_id, 'select' => '*']);
$order = is_array($order) && isset($order[0]) ? $order[0] : null;
if (!$order) {
    header('Location: orders.php');
    exit;
}

$items = supabase_fetch('/order_items', ['order_id' => 'eq.' . $order_id, 'select' => '*']);

?>
<?php include 'includes/site_header.php'; ?>
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Detail Pesanan #<?= htmlspecialchars($order['id']); ?></h2>
    <div class="bg-white p-6 rounded shadow">
        <p><strong>Tanggal:</strong> <?= htmlspecialchars($order['created_at']); ?></p>
        <p><strong>Total:</strong> Rp <?= number_format($order['total'],0,',','.'); ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($order['status']); ?></p>

        <h3 class="mt-6 font-semibold">Item:</h3>
        <ul class="mt-3">
            <?php if(is_array($items) && !isset($items['error'])): foreach($items as $it): ?>
                <li class="border-t py-3">Produk ID: <?= htmlspecialchars($it['product_id']); ?> — Qty: <?= intval($it['quantity']); ?> — Harga: Rp <?= number_format($it['price'],0,',','.'); ?></li>
            <?php endforeach; else: ?>
                <li>Tidak ada item.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
