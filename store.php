<?php
session_start();
require_once 'config/db.php';

// Ambil semua produk tersedia
$products = supabase_fetch('/products', ['status' => 'eq.Tersedia', 'order' => 'id.desc']);

include 'includes/site_header.php';
?>
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-6">Katalog Lengkap</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php if (!isset($products['error']) && !empty($products)): foreach($products as $p): ?>
        <div class="bg-white rounded-2xl shadow p-4 flex flex-col">
            <div class="h-40 bg-indigo-50 rounded mb-4 flex items-center justify-center">
                <i class="fa-solid fa-box-open text-indigo-300 text-5xl"></i>
            </div>
            <h3 class="text-lg font-bold mb-2"><?= htmlspecialchars($p['nama_produk'] ?? 'Produk'); ?></h3>
            <div class="text-indigo-600 font-semibold mb-4">Rp <?= number_format($p['harga'] ?? 0,0,',','.'); ?></div>
            <div class="mt-auto flex items-center justify-between">
                <form class="add-to-cart-form" method="POST" action="add_to_cart.php">
                    <input type="hidden" name="product_id" value="<?= $p['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Tambah ke Keranjang</button>
                </form>
                <a href="order_detail.php?id=<?= $p['id']; ?>" class="text-gray-600">Detail</a>
            </div>
        </div>
        <?php endforeach; else: ?>
        <div class="col-span-full text-center text-gray-500">Belum ada produk tersedia.</div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>

<script>
document.addEventListener('submit', function(e){
    if(e.target.matches('.add-to-cart-form')){
        e.preventDefault();
        const form = e.target;
        const fd = new FormData(form);
        fetch(form.action, {method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(r=>r.json()).then(data=>{
                if(data.success){ alert('Berhasil ditambahkan ke keranjang'); } else if(data.redirect){ window.location = data.redirect; } else { alert('Gagal: '+(data.msg||'')); }
            }).catch(()=>alert('Gagal koneksi'));
    }
});
</script>
