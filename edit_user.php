<?php
require_once 'config/db.php';

$user = null;
$error_msg = '';
$success_msg = '';

// Ambil data user berdasarkan ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch user dari Supabase menggunakan REST API
    $result = supabase_fetch('/users', ['id' => 'eq.' . $id, 'select' => '*']);
    
    if (isset($result['error'])) {
        $error_msg = $result['error'];
    } elseif (!empty($result)) {
        $user = $result[0]; // Ambil user pertama dari hasil
    } else {
        header("Location: index.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

// Jika form disubmit untuk update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user) {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'Viewer';

    // Validasi input
    if (empty($nama) || empty($email)) {
        $error_msg = 'Nama dan Email tidak boleh kosong!';
    } else {
        // Gunakan Supabase REST API untuk update data
        $result = supabase_patch('/users', $user['id'], [
            'nama_user' => $nama,
            'email' => $email,
            'role' => $role,
        ]);

        if (isset($result['error'])) {
            $error_msg = $result['error'];
        } else {
            // Jika sukses, kembali ke index.php
            header("Location: index.php?success=1");
            exit;
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="flex flex-1 flex-col md:pl-64">
    <main class="flex-1 overflow-auto">
        <div class="py-6 px-4 sm:px-6 md:px-8">
            <div class="mx-auto max-w-2xl">
                <!-- Header -->
                <div class="mb-6">
                    <a href="index.php" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white shadow rounded-lg p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        <i class="fas fa-user-edit text-indigo-600 mr-2"></i>Edit User
                    </h2>

                    <!-- Error Message -->
                    <?php if (!empty($error_msg)): ?>
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                        <i class="fas fa-exclamation-circle mr-2"></i><?= htmlspecialchars($error_msg); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <?php if ($user): ?>
                    <form action="" method="POST" class="space-y-6">
                        <!-- User ID Display -->
                        <div class="p-3 bg-gray-50 rounded text-sm text-gray-600">
                            <i class="fas fa-id-card mr-2"></i>ID: #<?= htmlspecialchars($user['id']); ?>
                        </div>

                        <!-- Nama Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                name="nama" 
                                value="<?= htmlspecialchars($user['nama_user'] ?? ''); ?>"
                                required 
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            >
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input 
                                type="email" 
                                name="email" 
                                value="<?= htmlspecialchars($user['email'] ?? ''); ?>"
                                required 
                                placeholder="Masukkan email"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                            >
                        </div>

                        <!-- Role Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                            <select 
                                name="role" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition bg-white"
                            >
                                <option value="Viewer" <?= ($user['role'] ?? '') == 'Viewer' ? 'selected' : ''; ?>>Viewer (Hanya Baca)</option>
                                <option value="Editor" <?= ($user['role'] ?? '') == 'Editor' ? 'selected' : ''; ?>>Editor (Baca & Edit)</option>
                                <option value="Admin" <?= ($user['role'] ?? '') == 'Admin' ? 'selected' : ''; ?>>Admin (Akses Penuh)</option>
                            </select>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="index.php" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium"
                            >
                                <i class="fas fa-refresh mr-2"></i>Update Data
                            </button>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
