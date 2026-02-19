<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in']) || ($_SESSION['user_role'] ?? '') !== 'Admin') {
    header('Location: login.php');
    exit;
}

$orders = supabase_fetch('/orders', ['select' => '*', 'order' => 'created_at.desc']);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Orders | RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<?php include 'includes/header.php'; ?>
<div class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Manajemen Pesanan</h2>
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($orders) && !isset($orders['error'])): ?>
                    <?php foreach ($orders as $o): ?>
                        <tr class="border-t" data-order-id="<?= $o['id']; ?>">
                            <td class="p-3"><?= htmlspecialchars($o['id']); ?></td>
                            <td class="p-3"><?= htmlspecialchars($o['user_id']); ?></td>
                            <td class="p-3"><?= htmlspecialchars($o['created_at']); ?></td>
                            <td class="p-3">Rp <?= number_format($o['total'],0,',','.'); ?></td>
                            <td class="p-3">
                                <select class="order-status border px-2 py-1 rounded" data-order-id="<?= $o['id']; ?>">
                                    <?php
                                        $states = ['pending','processing','shipped','delivered','cancelled'];
                                        foreach($states as $s){
                                            $sel = ($o['status'] === $s) ? 'selected' : '';
                                            echo "<option value=\"$s\" $sel>" . ucfirst($s) . "</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                            <td class="p-3">
                                <a href="admin_order_detail.php?id=<?= $o['id']; ?>" class="text-indigo-600 mr-3">Lihat</a>
                                <button class="update-order-status bg-green-600 text-white px-3 py-1 rounded" data-order-id="<?= $o['id']; ?>">Simpan</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td class="p-3">Belum ada pesanan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
<script>
document.addEventListener('click', function(e){
    if(e.target.matches('.update-order-status')){
        const id = e.target.dataset.orderId;
        const sel = document.querySelector('.order-status[data-order-id="'+id+'"]');
        const status = sel.value;
        fetch('admin_update_order.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
            body: 'order_id='+encodeURIComponent(id)+'&status='+encodeURIComponent(status)
        }).then(r=>r.json()).then(data=>{
            if(data.success){ alert('Status diperbarui.'); location.reload(); } else { alert('Gagal: '+(data.msg||'')); }
        });
    }
});
</script>
</body>
</html>
