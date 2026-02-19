<?php
session_start();
require_once 'config/db.php';

// Ambil data produk yang berstatus 'Tersedia' saja
$products = supabase_fetch('/products', ['status' => 'eq.Tersedia', 'order' => 'id.desc', 'limit' => '6']);
$products_list = !isset($products['error']) && !empty($products) ? $products : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFX Store - Layanan Digital Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-indigo-600 tracking-tight">
                        <i class="fa-solid fa-layer-group mr-2"></i>RFX Store
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#layanan" class="text-gray-600 hover:text-indigo-600 font-medium">Layanan</a>
                    <a href="#tentang" class="text-gray-600 hover:text-indigo-600 font-medium">Tentang</a>
                    
                    <?php if(isset($_SESSION['is_logged_in'])): ?>
                        <div class="relative group ml-4 pl-4 border-l border-gray-200">
                            <button class="flex items-center space-x-2 text-gray-700 font-medium">
                                <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-user text-sm"></i>
                                </div>
                                <span><?= htmlspecialchars($_SESSION['user_name']); ?></span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100">
                                <?php if($_SESSION['user_role'] === 'Admin'): ?>
                                    <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-gauge mr-2"></i> Admin Panel</a>
                                <?php endif; ?>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-bag-shopping mr-2"></i> Pesanan Saya</a>
                                <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 border-t"><i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="ml-4 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-5 py-2 rounded-full font-medium transition-colors">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 pt-20">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Tingkatkan Bisnis Anda</span>
                            <span class="block text-indigo-600 xl:inline">dengan Layanan Digital</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Kami menyediakan solusi pembuatan website profesional, desain grafis, dan kebutuhan digital lainnya untuk membantu bisnis Anda tumbuh lebih cepat.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="#layanan" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg transition-all">
                                    Lihat Katalog
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-indigo-50 flex items-center justify-center">
            <i class="fa-solid fa-laptop-code text-indigo-200 text-[15rem]"></i>
        </div>
    </div>

    <!-- Katalog Section -->
    <div id="layanan" class="bg-gray-50 py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">Katalog Kami</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Layanan & Produk Terbaik
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Pilih layanan yang sesuai dengan kebutuhan Anda dan mulai transformasi digital sekarang.
                </p>
            </div>

            <div class="mt-16 grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                <?php 
                if(!empty($products_list)):
                    foreach($products_list as $row): 
                ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white">
                        <i class="fa-solid fa-box-open text-5xl opacity-50"></i>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 leading-tight"><?= htmlspecialchars($row['nama_produk'] ?? 'Produk'); ?></h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Stok: <?= $row['stok'] ?? 0; ?>
                            </span>
                        </div>
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-2xl font-bold text-indigo-600">Rp <?= number_format($row['harga'] ?? 0, 0, ',', '.'); ?></span>
                            <button onclick="alert('Fitur Checkout akan segera hadir!')" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    endforeach; 
                else: 
                ?>
                <div class="col-span-full text-center py-10 text-gray-500">
                    <i class="fa-solid fa-inbox text-3xl mb-2 opacity-50 block"></i>
                    <p>Belum ada produk yang tersedia saat ini.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h3 class="text-2xl font-bold mb-4 tracking-tight">RFX Store</h3>
            <p class="text-gray-400 mb-6">Solusi digital terbaik untuk masa depan bisnis Anda.</p>
            <div class="flex justify-center space-x-6 mb-8">
                <a href="#" class="text-gray-400 hover:text-white transition"><i class="fa-brands fa-instagram text-2xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition"><i class="fa-brands fa-whatsapp text-2xl"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition"><i class="fa-brands fa-github text-2xl"></i></a>
            </div>
            <p class="text-gray-500 text-sm">
                &copy; <?= date('Y'); ?> RFX Visual. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
