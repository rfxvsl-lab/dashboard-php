<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['is_logged_in'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil isi keranjang user
$carts = supabase_fetch('/carts', ['user_id' => 'eq.' . $user_id, 'select' => '*']);
$items = [];
$total = 0.00;

if (is_array($carts) && !isset($carts['error'])) {
    foreach ($carts as $c) {
        $prod = supabase_fetch('/products', ['id' => 'eq.' . intval($c['product_id']), 'select' => '*']);
        $product = is_array($prod) && isset($prod[0]) ? $prod[0] : null;
        $price = $product['harga'] ?? 0;
        $subtotal = $price * intval($c['quantity']);
        $items[] = [
            'cart_id' => $c['id'],
            'product_id' => $c['product_id'],
            'name' => $product['nama_produk'] ?? 'Produk',
            'price' => $price,
            'quantity' => $c['quantity'],
            'subtotal' => $subtotal
        ];
        $total += $subtotal;
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang | RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
<?php include 'includes/site_header.php'; ?>
<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">Keranjang Saya</h2>

    <?php if (empty($items)): ?>
        <div class="bg-white p-6 rounded shadow">Keranjang kosong. Kunjungi <a href="products.php" class="text-indigo-600">produk</a>.</div>
    <?php else: ?>
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-3">Produk</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Qty</th>
                        <th class="p-3">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                    <tr class="border-t" data-cart-id="<?= $it['cart_id']; ?>">
                        <td class="p-3"><?= htmlspecialchars($it['name']); ?></td>
                        <td class="p-3">Rp <?= number_format($it['price'],0,',','.'); ?></td>
                        <td class="p-3">
                            <div class="flex items-center space-x-2">
                                <input type="number" min="1" value="<?= intval($it['quantity']); ?>" class="w-20 px-2 py-1 border rounded qty-input" data-cart-id="<?= $it['cart_id']; ?>">
                                <button class="update-qty bg-indigo-600 text-white px-3 py-1 rounded text-sm" data-cart-id="<?= $it['cart_id']; ?>">Update</button>
                                <button class="remove-item text-red-600 px-3 py-1 rounded text-sm" data-cart-id="<?= $it['cart_id']; ?>">Hapus</button>
                            </div>
                        </td>
                        <td class="p-3">Rp <span class="item-subtotal"><?= number_format($it['subtotal'],0,',','.'); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="p-4 text-right">
                <div class="text-lg font-semibold">Total: Rp <?= number_format($total,0,',','.'); ?></div>
                <form action="checkout.php" method="POST">
                    <button type="submit" class="mt-3 inline-block bg-indigo-600 text-white px-4 py-2 rounded">Checkout</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>

<script>
document.addEventListener('click', function(e){
    if(e.target.matches('.update-qty')){
        const id = e.target.dataset.cartId;
        const input = document.querySelector('.qty-input[data-cart-id="'+id+'"]');
        const qty = parseInt(input.value) || 1;
        fetch('update_cart.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
            body: 'cart_id='+encodeURIComponent(id)+'&quantity='+encodeURIComponent(qty)
        }).then(r=>r.json()).then(data=>{
            if(data.success){ location.reload(); } else { alert('Gagal update qty'); }
        });
    }

    if(e.target.matches('.remove-item')){
        if(!confirm('Hapus item dari keranjang?')) return;
        const id = e.target.dataset.cartId;
        fetch('remove_from_cart.php', {
            method: 'POST',
            headers: {'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
            body: 'cart_id='+encodeURIComponent(id)
        }).then(r=>r.json()).then(data=>{
            if(data.success){ location.reload(); } else { alert('Gagal menghapus'); }
        });
    }
});
</script>
