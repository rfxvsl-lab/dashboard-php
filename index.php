<?php
// Load database configuration (Supabase REST API)
require_once 'config/db.php';

// Include header with Tailwind + FontAwesome
include 'includes/header.php';

// Include sidebar navigation
include 'includes/sidebar.php';
?>

<!-- Main Content Area -->
<div class="flex flex-1 flex-col md:pl-64">
    <main class="flex-1 overflow-auto">
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
                    <p class="text-gray-600 text-sm mt-1">Welcome to your modern admin dashboard</p>
                </div>

                <!-- Statistics Cards Grid -->
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    
                    <!-- Total Users Card -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg border-l-4 border-indigo-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                                    <p class="text-4xl font-bold text-gray-900 mt-2"><?= $jumlah_user; ?></p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                                        <span class="text-green-600">+2 bulan ini</span>
                                    </p>
                                </div>
                                <div class="bg-indigo-50 rounded-full p-4">
                                    <i class="fas fa-users text-indigo-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                                Kelola semua users <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Total Visits Card (Mock Data) -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg border-l-4 border-green-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                                    <p class="text-4xl font-bold text-gray-900 mt-2">24.5k</p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                                        <span class="text-green-600">+12% bulan ini</span>
                                    </p>
                                </div>
                                <div class="bg-green-50 rounded-full p-4">
                                    <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                            <a href="#" class="text-sm font-medium text-green-600 hover:text-green-700">
                                Lihat analytics <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Revenue Card (Mock Data) -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg border-l-4 border-yellow-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Pendapatan</p>
                                    <p class="text-4xl font-bold text-gray-900 mt-2">$12,000</p>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        <span>Update: Hari ini</span>
                                    </p>
                                </div>
                                <div class="bg-yellow-50 rounded-full p-4">
                                    <i class="fas fa-sack-dollar text-yellow-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                            <a href="#" class="text-sm font-medium text-yellow-600 hover:text-yellow-700">
                                Detail transaksi <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Users Table Section -->
                <div class="mt-12">
                    <div class="mx-auto max-w-7xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg leading-6 font-semibold text-gray-900">
                                    <i class="fas fa-users mr-2 text-indigo-600"></i>Daftar Pengguna
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Data pengguna dari Supabase</p>
                            </div>
                            <a href="add_user.php" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah User
                            </a>
                        </div>

                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-semibold">
                                                        ID
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-semibold">
                                                        Nama
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-semibold">
                                                        Email
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-semibold">
                                                        Role
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-semibold">
                                                        <span class="sr-only">Aksi</span>Aksi
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <?php 
                                                if (!empty($users) && !isset($users['error'])): 
                                                    foreach($users as $row): 
                                                        // Determine role badge color
                                                        $roleColors = [
                                                            'Admin' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'icon' => 'fa-shield'],
                                                            'Editor' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'fa-pen'],
                                                            'Viewer' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'icon' => 'fa-eye'],
                                                        ];
                                                        $role = $row['role'] ?? 'Viewer';
                                                        $colors = $roleColors[$role] ?? $roleColors['Viewer'];
                                                ?>
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-semibold text-gray-900">#<?= htmlspecialchars($row['id']); ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                                    <i class="fas fa-user text-indigo-600 text-sm"></i>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    <?= htmlspecialchars($row['nama_user'] ?? 'N/A'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                        <?= htmlspecialchars($row['email'] ?? 'N/A'); ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $colors['bg'] . ' ' . $colors['text']; ?>">
                                                            <i class="fas <?= $colors['icon']; ?> mr-1"></i>
                                                            <?= htmlspecialchars($role); ?>
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                                        <a href="edit_user.php?id=<?= $row['id']; ?>" class="text-indigo-600 hover:text-indigo-900 transition" title="Edit">
                                                            <i class="fas fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="delete_user.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="text-red-600 hover:text-red-900 transition" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php 
                                                    endforeach; 
                                                else: 
                                                ?>
                                                <tr>
                                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                        <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                                        <p>Tidak ada data pengguna</p>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>