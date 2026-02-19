<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFX Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-indigo-600 tracking-tight">
                        <i class="fa-solid fa-layer-group mr-2"></i>RFX Store
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php#layanan" class="text-gray-600 hover:text-indigo-600 font-medium">Layanan</a>
                    <a href="index.php#tentang" class="text-gray-600 hover:text-indigo-600 font-medium">Tentang</a>
                    <?php if(isset($_SESSION['is_logged_in'])): ?>
                        <div class="relative group ml-4 pl-4 border-l border-gray-200">
                            <button class="flex items-center space-x-2 text-gray-700 font-medium">
                                <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-user text-sm"></i>
                                </div>
                                <span><?= htmlspecialchars($_SESSION['user_name']); ?></span>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100">
                                <?php if(($_SESSION['user_role'] ?? '') === 'Admin'): ?>
                                    <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-gauge mr-2"></i> Admin Panel</a>
                                <?php endif; ?>
                                <a href="orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fa-solid fa-bag-shopping mr-2"></i> Pesanan Saya</a>
                                <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 border-t"><i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="ml-4 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-5 py-2 rounded-full font-medium transition-colors">Masuk</a>
                    <?php endif; ?>
                    <a href="cart.php" class="ml-3 text-gray-700 hover:text-indigo-600"><i class="fa-solid fa-cart-shopping text-lg"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen">
