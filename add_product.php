<?php
require_once 'config/db.php';

$error_msg = '';

// Jika tombol "Simpan Produk" ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_produk = trim($_POST['nama_produk'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $stok = trim($_POST['stok'] ?? '');
    $status = $_POST['status'] ?? 'Tersedia';

    // Validasi
    if (empty($nama_produk) || empty($harga) || empty($stok)) {
        $error_msg = 'Semua field harus diisi!';
    } else {
        // Insert ke Supabase
        $result = supabase_post('/products', [
            'nama_produk' => $nama_produk,
            'harga' => intval($harga),
            'stok' => intval($stok),
            'status' => $status
        ]);
        
        // Jika sukses, redirect ke products.php
        if (!isset($result['error'])) {
            header("Location: products.php?success=1");
            exit;
        } else {
            $error_msg = $result['error'] ?? 'Gagal menyimpan produk!';
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="flex flex-1 flex-col md:pl-64 bg-gray-50 min-h-screen">
    <main class="flex-1 p-8">
        
        <div class="mb-8">
            <a href="products.php" class="text-gray-500 hover:text-indigo-600 transition-colors text-sm font-medium mb-4 inline-block">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Produk
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Produk / Layanan</h1>
        </div>

        <?php if (!empty($error_msg)): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
            <i class="fa-solid fa-circle-exclamation mr-2"></i> <?= htmlspecialchars($error_msg); ?>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
            <div class="p-8">
                <form action="" method="POST" class="space-y-6">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk / Layanan</label>
                        <input type="text" name="nama_produk" required placeholder="Contoh: Jasa Foto RFX Visual atau Robux Premium" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga" required placeholder="150000" class="w-full rounded-lg border-gray-200 bg-gray-50 pl-12 pr-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok</label>
                            <input type="number" name="stok" required placeholder="10" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Produk</label>
                        <select name="status" class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all cursor-pointer">
                            <option value="Tersedia">Tersedia</option>
                            <option value="Pre-Order">Pre-Order</option>
                            <option value="Habis">Habis</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <a href="products.php" class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-all shadow-md shadow-indigo-500/30">
                            Simpan Produk
                        </button>
                    </div>

                </form>
            </div>
        </div>
        
    </main>
</div>

<?php include 'includes/footer.php'; ?>
