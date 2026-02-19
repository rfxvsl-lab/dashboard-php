<?php
session_start();
require_once 'config/db.php';

// Jika sudah login, cek role untuk diarahkan ke tempat yang benar
if(isset($_SESSION['is_logged_in'])) {
    if($_SESSION['user_role'] === 'Admin') {
        header("Location: dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$error = '';

if(isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Cek ke tabel users di Supabase
    $result = supabase_fetch('/users', ['email' => 'eq.' . $email, 'select' => '*']);
    
    if (!empty($result) && !isset($result['error'])) {
        $user = $result[0];
        
        // Verifikasi password (gunakan password_hash untuk production)
        if($user['password'] === $password) {
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'] ?? 'Viewer';
            $_SESSION['user_name'] = $user['nama_user'] ?? 'User';

            // LOGIKA PERCABANGAN (ADMIN VS USER)
            if(($user['role'] ?? 'Viewer') === 'Admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "Email atau Password salah!";
        }
    } else {
        $error = "Email atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full border border-gray-100">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
                <i class="fa-solid fa-lock text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Selamat Datang</h1>
            <p class="text-sm text-gray-500 mt-2">Masuk untuk melanjutkan</p>
        </div>
        
        <?php if($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
                <p class="text-red-700 text-sm font-medium"><i class="fa-solid fa-circle-exclamation mr-2"></i> <?= htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
            </div>
            <button type="submit" name="login" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-md mt-6">
                <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Masuk
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500">
                <strong>Demo Credentials:</strong><br>
                Email: <code class="bg-gray-100 px-2 py-1 rounded">admin@rfxvisual.com</code><br>
                Password: <code class="bg-gray-100 px-2 py-1 rounded">admin123</code>
            </p>
        </div>
    </div>
</body>
</html>
