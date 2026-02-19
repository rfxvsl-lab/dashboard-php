<?php
// Load database configuration (Supabase REST API)
require_once 'config/db.php';

// 1. Ambil data pengguna dan hitung total
$users = supabase_fetch('/users', ['order' => 'id.desc']);
$jumlah_user = !isset($users['error']) && !empty($users) ? count($users) : 0;

// 2. Ambil data transaksi dan hitung total pendapatan
$transactions = supabase_fetch('/transactions', ['order' => 'tanggal.asc']);
$total_pendapatan = 0;
$labels = [];
$data_grafik = [];

if (!isset($transactions['error']) && !empty($transactions)) {
    foreach ($transactions as $row) {
        $total_pendapatan += $row['jumlah'] ?? 0;
        $labels[] = date('d M', strtotime($row['tanggal']));
        $data_grafik[] = $row['jumlah'] ?? 0;
    }
}

include 'includes/header.php';
// Add Chart.js library before sidebar
echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
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
                    <p class="text-gray-600 text-sm mt-1">Selamat datang di dashboard admin modern Anda</p>
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
                                </div>
                                <div class="bg-indigo-50 rounded-full p-4">
                                    <i class="fa-solid fa-users text-indigo-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Pendapatan Card -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg border-l-4 border-yellow-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-2">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
                                </div>
                                <div class="bg-yellow-50 rounded-full p-4">
                                    <i class="fa-solid fa-sack-dollar text-yellow-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sistem Info Card -->
                    <div class="stat-card bg-white overflow-hidden shadow rounded-lg border-l-4 border-purple-500">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Status Sistem</p>
                                    <p class="text-lg font-bold text-gray-900 mt-2"><i class="fa-solid fa-circle-check text-green-500"></i> Online</p>
                                    <p class="text-xs text-gray-500 mt-2">PHP <?= phpversion(); ?></p>
                                </div>
                                <div class="bg-purple-50 rounded-full p-4">
                                    <i class="fa-solid fa-server text-purple-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Revenue Chart Section -->
                <div class="mt-8 bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fa-solid fa-chart-line text-indigo-600 mr-2"></i> Grafik Pendapatan
                    </h2>
                    <div class="relative h-72 w-full">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <script>
                    const ctx = document.getElementById('revenueChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?= json_encode($labels); ?>,
                            datasets: [{
                                label: 'Pendapatan (Rp)',
                                data: <?= json_encode($data_grafik); ?>,
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#4f46e5',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                    labels: {
                                        font: { size: 12 },
                                        padding: 15
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>

                <!-- Users Table Section -->
                <div class="mt-12">
                    <div class="mx-auto max-w-7xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-lg leading-6 font-semibold text-gray-900">
                                    <i class="fa-solid fa-users mr-2 text-indigo-600"></i>Daftar Pengguna
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Data pengguna dari Supabase</p>
                            </div>
                            <a href="add_user.php" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                                <i class="fa-solid fa-plus mr-2"></i>Tambah User
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