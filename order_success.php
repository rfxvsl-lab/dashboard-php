<?php
session_start();
require_once 'config/db.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
<?php include 'includes/site_header.php'; ?>
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white p-6 rounded shadow text-center">
        <h2 class="text-2xl font-semibold">Terima kasih! Pesanan Anda telah diterima.</h2>
        <?php if ($order_id): ?>
            <p class="mt-3">Nomor Pesanan: <strong><?= htmlspecialchars($order_id); ?></strong></p>
        <?php endif; ?>
        <a href="orders.php" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded">Lihat Pesanan Saya</a>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
