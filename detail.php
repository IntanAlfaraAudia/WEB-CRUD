<?php
require 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if (!$service) {
    header("Location: index.php?msg=Layanan tidak ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($service['name']) ?> - SPA Alfra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .bg-cream { background-color: #FFF5F5; }
        .bg-cream-light { background-color: #FDF2F8; }
        .text-pink-deep { color: #EC4899; }
        .text-brown-deep { color: #92400E; }
        .text-main { color: #92400E; }
        .border-pink-soft { border-color: #F9A8D4; }

        /* BACKGROUND BERGERAK */
        body {
            background: linear-gradient(-45deg, #FFF5F5, #FDF2F8, #FCE7F3, #FCE7F3);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .card-glow {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(249, 168, 212, 0.3);
            box-shadow: 0 20px 40px rgba(212, 165, 116, 0.15);
        }
    </style>
</head>
<body class="min-h-screen font-inter">

<!-- NAVBAR (SAMA DENGAN INDEX) -->
<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-md z-50 shadow-lg border-b border-pink-soft">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="index.php" class="flex items-center gap-2">
                <i class="fas fa-spa text-2xl text-pink-deep"></i>
                <span class="font-playfair text-xl font-bold text-brown-deep">SPA Alfra</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="index.php" class="text-main hover:text-pink-deep transition">Kembali</a>
            </div>
        </div>
    </div>
</nav>

<!-- DETAIL CONTENT -->
<section class="pt-24 pb-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="card-glow rounded-3xl p-8 md:p-12 animate-fadeIn">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- ICON -->
                <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-gradient-to-br from-[#EC4899] to-[#F43F5E] flex items-center justify-center shadow-xl animate-float mx-auto md:mx-0">
                    <i class="fas fa-spa text-white text-4xl md:text-5xl"></i>
                </div>

                <!-- INFO -->
                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-wrap items-center gap-3 justify-center md:justify-start mb-4">
                        <span class="px-4 py-2 rounded-full text-sm font-medium bg-cream-light text-pink-deep">
                            <?= htmlspecialchars(ucwords(str_replace('-', ' ', $service['category']))) ?>
                        </span>
                        <span class="text-sm text-main flex items-center gap-1">
                            <i class="fas fa-clock"></i> <?= htmlspecialchars($service['duration']) ?> menit
                        </span>
                    </div>

                    <h1 class="font-playfair text-3xl md:text-4xl font-bold text-brown-deep mb-4">
                        <?= htmlspecialchars($service['name']) ?>
                    </h1>

                    <p class="text-main text-lg leading-relaxed mb-6">
                        <?= nl2br(htmlspecialchars($service['description'])) ?>
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 items-center md:items-start">
                        <div>
                            <span class="text-3xl md:text-4xl font-bold text-pink-deep">
                                Rp <?= number_format($service['price'], 0, ',', '.') ?>
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <a href="update.php?id=<?= $service['id'] ?>" 
                               class="px-6 py-3 bg-gradient-to-r from-[#D4A574] to-[#92400E] text-white rounded-xl font-medium hover:shadow-xl transition transform hover:scale-105">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="index.php" 
                               class="px-6 py-3 bg-white border-2 border-pink-soft text-pink-deep rounded-xl font-medium hover:bg-cream-light transition">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .animate-float { animation: float 3s ease-in-out infinite; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    
    body {
        background: linear-gradient(-45deg, #FFF5F5, #FDF2F8, #FCE7F3, #FCE7F3);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>

</body>
</html>