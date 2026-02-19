<?php
require_once 'config/db.php';

// Ambil data profil (karena cuma 1 admin, kita ambil id 1)
$result = supabase_fetch('/admin_profile', ['id' => 'eq.1', 'select' => '*']);
$profile = !empty($result) && !isset($result['error']) ? $result[0] : [
    'id' => 1,
    'nama' => 'Admin Dashboard',
    'email' => 'admin@rfxvisual.com',
    'bio' => 'Sistem manajemen dashboard',
    'lokasi' => 'Indonesia'
];

$success_msg = '';
$error_msg = '';

// Jika tombol simpan ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $lokasi = trim($_POST['lokasi'] ?? '');

    // Validasi
    if (empty($nama) || empty($email) || empty($bio) || empty($lokasi)) {
        $error_msg = 'Semua field harus diisi!';
    } else {
        // Update via Supabase REST API
        $update_result = supabase_patch('/admin_profile', 1, [
            'nama' => $nama,
            'email' => $email,
            'bio' => $bio,
            'lokasi' => $lokasi
        ]);

        // Cek apakah update berhasil
        if (!isset($update_result['error'])) {
            $success_msg = 'Profil berhasil diperbarui!';
            // Update local array untuk preview
            $profile = [
                'id' => 1,
                'nama' => $nama,
                'email' => $email,
                'bio' => $bio,
                'lokasi' => $lokasi
            ];
        } else {
            $error_msg = $update_result['error'] ?? 'Gagal mengupdate profil!';
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="flex flex-1 flex-col md:pl-64 bg-gray-50 min-h-screen">
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Pengaturan Profil</h1>

        <?php if($success_msg): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fa-solid fa-circle-check mr-2"></i> <?= htmlspecialchars($success_msg); ?>
            </div>
        <?php endif; ?>

        <?php if($error_msg): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> <?= htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
            <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
            
            <div class="px-8 pb-8">
                <div class="relative flex justify-between items-end -mt-12 mb-6">
                    <div class="h-24 w-24 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden flex items-center justify-center">
                        <i class="fa-solid fa-user-astronaut text-5xl text-indigo-200"></i>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($profile['nama'] ?? 'Admin'); ?></h2>
                    <p class="text-sm font-medium text-indigo-600 mb-1">Freelancer & Web Developer</p>
                    <p class="text-sm text-gray-500"><i class="fa-solid fa-location-dot mr-1"></i> <?= htmlspecialchars($profile['lokasi'] ?? 'Indonesia'); ?></p>
                </div>

                <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-100">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($profile['nama'] ?? ''); ?>" required class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? ''); ?>" required class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                        <input type="text" name="lokasi" value="<?= htmlspecialchars($profile['lokasi'] ?? ''); ?>" required class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bio Singkat</label>
                        <textarea name="bio" rows="3" required class="w-full rounded-lg border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 border outline-none transition-all"><?= htmlspecialchars($profile['bio'] ?? ''); ?></textarea>
                    </div>
                    <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                        <a href="javascript:history.back()" class="px-6 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-md shadow-indigo-500/30 transition-all">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>

