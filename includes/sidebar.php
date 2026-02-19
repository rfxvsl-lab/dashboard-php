<?php 
// Mendapatkan nama file yang sedang dibuka (misal: index.php atau profile.php)
$current_page = basename($_SERVER['PHP_SELF']); 
?>

<!-- Sidebar Navigation -->
<div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col shadow-xl border-r border-gray-100">
    <div class="flex min-h-0 flex-1 flex-col bg-[#1e1e2d]">
        <!-- Logo Section -->
        <div class="flex h-20 flex-shrink-0 items-center px-6">
            <h1 class="text-2xl font-bold text-white tracking-wide">
                <i class="fa-solid fa-rocket text-indigo-500 mr-2"></i> AdminPanel
            </h1>
        </div>
        
        <!-- Navigation Menu -->
        <div class="flex flex-1 flex-col overflow-y-auto pb-4">
            <nav class="flex-1 space-y-2 px-4 py-4">
                
                <!-- Dashboard & Users -->
                <a href="index.php" class="<?= $current_page == 'index.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <i class="fa-solid fa-gauge-high mr-3 flex-shrink-0 h-5 w-5 <?= $current_page == 'index.php' ? 'text-white' : 'text-gray-400 group-hover:text-white' ?>"></i>
                    Dashboard & Users
                </a>

                <!-- Manajemen Produk -->
                <a href="products.php" class="<?= $current_page == 'products.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <i class="fa-solid fa-box mr-3 flex-shrink-0 h-5 w-5 <?= $current_page == 'products.php' ? 'text-white' : 'text-gray-400 group-hover:text-white' ?>"></i>
                    Manajemen Produk
                </a>

            </nav>

            <!-- Footer Section (in sidebar) -->
            <div class="px-4 mt-auto space-y-2">
                <a href="profile.php" class="<?= $current_page == 'profile.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/40' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?> group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <i class="fa-solid fa-user-circle mr-3 flex-shrink-0 h-5 w-5 <?= $current_page == 'profile.php' ? 'text-white' : 'text-gray-400 group-hover:text-white' ?>"></i>
                    Profil Saya
                </a>

                <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar dari panel admin?')" class="text-red-400 hover:bg-red-500/10 hover:text-red-300 group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200">
                    <i class="fa-solid fa-right-from-bracket mr-3 flex-shrink-0 h-5 w-5 text-red-400 group-hover:text-red-300"></i>
                    Keluar
                </a>
            </div>
        </div>
    </div>
</div>
