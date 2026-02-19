<?php
require_once 'config/db.php';

// Ambil data produk dari Supabase
$products = supabase_fetch('/products', ['order' => 'id.desc']);

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="flex flex-1 flex-col md:pl-64 bg-gray-50 min-h-screen">
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Produk</h1>
            <a href="add_product.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md shadow-indigo-500/30 transition-all">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Produk / Layanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    if (!isset($products['error']) && !empty($products)): 
                        foreach($products as $row):
                    ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($row['nama_produk'] ?? ''); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp <?= number_format($row['harga'] ?? 0, 0, ',', '.'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $row['stok'] ?? 0; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-700">
                                <?= htmlspecialchars($row['status'] ?? 'Tersedia'); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="edit_product.php?id=<?= $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 transition-colors" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <a href="delete_product.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk ini?')" class="text-red-600 hover:text-red-900 transition-colors" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-3xl mb-2 block text-gray-300"></i>
                            Belum ada data produk. Klik tombol "Tambah Produk" untuk menambah.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
