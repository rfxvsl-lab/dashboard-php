<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$orders = supabase_fetch('/orders', ['user_id' => 'eq.' . $user_id, 'select' => '*', 'order' => 'created_at.desc']);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya | RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<?php include 'includes/site_header.php'; ?>
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Pesanan Saya</h2>
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($orders) && !isset($orders['error'])): ?>
                    <?php foreach ($orders as $o): ?>
                        <tr class="border-t">
                            <td class="p-3"><?= htmlspecialchars($o['id']); ?></td>
                            <td class="p-3"><?= htmlspecialchars($o['created_at']); ?></td>
                            <td class="p-3">Rp <?= number_format($o['total'],0,',','.'); ?></td>
                            <td class="p-3"><?= htmlspecialchars($o['status']); ?></td>
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
</body>
</html>
