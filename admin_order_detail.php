<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in']) || ($_SESSION['user_role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$order_id) {
    header('Location: admin_orders.php');
    exit;
}

$order = supabase_fetch('/orders', ['id' => 'eq.' . $order_id, 'select' => '*']);
$order = is_array($order) && isset($order[0]) ? $order[0] : null;
if (!$order) {
    header('Location: admin_orders.php');
    exit;
}

$items = supabase_fetch('/order_items', ['order_id' => 'eq.' . $order_id, 'select' => '*']);

?>
<?php include 'includes/header.php'; ?>
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Detail Pesanan #<?= htmlspecialchars($order['id']); ?></h2>
    <div class="bg-white p-6 rounded shadow">
        <p><strong>User ID:</strong> <?= htmlspecialchars($order['user_id']); ?></p>
        <p><strong>Tanggal:</strong> <?= htmlspecialchars($order['created_at']); ?></p>
        <p><strong>Total:</strong> Rp <?= number_format($order['total'],0,',','.'); ?></p>
        <p class="mt-3"><strong>Status saat ini:</strong>
            <select id="admin-order-status" class="border px-2 py-1 rounded">
                <?php
                    $states = ['pending','processing','shipped','delivered','cancelled'];
                    foreach($states as $s){
                        $sel = ($order['status'] === $s) ? 'selected' : '';
                        echo "<option value=\"$s\" $sel>" . ucfirst($s) . "</option>";
                    }
                ?>
            </select>
            <button id="save-order-status" class="ml-3 bg-green-600 text-white px-3 py-1 rounded">Simpan</button>
        </p>

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
<script>
document.getElementById('save-order-status').addEventListener('click', function(){
    const status = document.getElementById('admin-order-status').value;
    fetch('admin_update_order.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
        body: 'order_id='+encodeURIComponent(<?= $order_id; ?>)+'&status='+encodeURIComponent(status)
    }).then(r=>r.json()).then(data=>{
        if(data.success){ alert('Status diperbarui.'); location.href='admin_orders.php'; } else { alert('Gagal: '+(data.msg||'')); }
    });
});
</script>
