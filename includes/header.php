<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Admin Dashboard</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .sidebar-active {
            @apply bg-gray-900 text-white;
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            @apply shadow-lg transform -translate-y-1;
        }
    </style>
</head>
<body class="h-full bg-gray-100">
<div class="min-h-full">
