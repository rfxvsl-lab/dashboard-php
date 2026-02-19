<?php
session_start();

// Jika pengguna sudah login, langsung arahkan ke dashboard
if(isset($_SESSION['is_logged_in'])) {
    header("Location: index.php");
    exit;
}

$error = '';

// Jika tombol login ditekan
if(isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // SETUP KREDENSIAL LOGIN
    // Kamu bisa mengganti email dan password ini sesuai keinginanmu
    if($email == 'admin@rfxvisual.com' && $password == 'admin123') {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header("Location: index.php");
        exit;
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
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl max-w-sm w-full border border-gray-100">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 mb-4">
                <i class="fa-solid fa-lock text-2xl text-indigo-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">AdminPanel</h1>
            <p class="text-sm text-gray-500 mt-2">Silakan masuk ke akun Anda</p>
        </div>
        
        <?php if($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r">
                <p class="text-red-700 text-sm font-medium"><i class="fa-solid fa-circle-exclamation mr-2"></i> <?= htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="admin@rfxvisual.com" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-key text-gray-400"></i>
                    </div>
                    <input type="password" name="password" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-medium hover:bg-indigo-700 transition-colors shadow-md shadow-indigo-500/30 mt-6">
                <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Masuk Sekarang
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
