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

// Proses update
if ($_POST) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = (int)$_POST['price'];
    $duration = (int)$_POST['duration'];
    $category = $_POST['category'];

    $stmt = $pdo->prepare("UPDATE services SET name = ?, description = ?, price = ?, duration = ?, category = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $duration, $category, $id]);

    header("Location: detail.php?id=$id&msg=Berhasil diperbarui!");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= htmlspecialchars($service['name']) ?> - SPA Alfra</title>
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

        .input-focus {
            border: 1px solid #fce7f3 !important;
            transition: all 0.3s ease !important;
        }
        .input-focus:focus {
            border-color: #f9a8d4 !important;
            box-shadow: 0 0 0 4px rgba(249, 168, 212, 0.2) !important;
            outline: none;
        }
    </style>
</head>
<body class="min-h-screen font-inter">

<!-- NAVBAR (SAMA) -->
<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-md z-50 shadow-lg border-b border-pink-soft">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="index.php" class="flex items-center gap-2">
                <i class="fas fa-spa text-2xl text-pink-deep"></i>
                <span class="font-playfair text-xl font-bold text-brown-deep">SPA Alfra</span>
            </a>
            <a href="detail.php?id=<?= $id ?>" class="text-main hover:text-pink-deep transition">Lihat Detail</a>
        </div>
    </div>
</nav>

<!-- FORM EDIT -->
<section class="pt-24 pb-16">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-pink-soft">
            <h1 class="font-playfair text-3xl font-bold text-brown-deep mb-8 text-center">Edit Layanan</h1>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-main font-medium mb-2">Nama Layanan</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($service['name']) ?>" required
                           class="w-full px-4 py-3 border border-pink-soft rounded-xl input-focus text-main">
                </div>

                <div>
                    <label class="block text-main font-medium mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" required
                              class="w-full px-4 py-3 border border-pink-soft rounded-xl input-focus text-main resize-none"><?= htmlspecialchars($service['description']) ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-main font-medium mb-2">Harga (Rp)</label>
                        <input type="number" name="price" value="<?= $service['price'] ?>" required min="0"
                               class="w-full px-4 py-3 border border-pink-soft rounded-xl input-focus text-main">
                    </div>
                    <div>
                        <label class="block text-main font-medium mb-2">Durasi (menit)</label>
                        <input type="number" name="duration" value="<?= $service['duration'] ?>" required min="1"
                               class="w-full px-4 py-3 border border-pink-soft rounded-xl input-focus text-main">
                    </div>
                </div>

                <div>
                    <label class="block text-main font-medium mb-2">Kategori</label>
                    <select name="category" required class="w-full px-4 py-3 border border-pink-soft rounded-xl text-main">
                        <?php
                        $cats = ['facial', 'massage', 'body-treatment', 'hair-spa', 'nail-care'];
                        foreach ($cats as $cat):
                        ?>
                            <option value="<?= $cat ?>" <?= $service['category'] === $cat ? 'selected' : '' ?>>
                                <?= ucwords(str_replace('-', ' ', $cat)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex gap-4 justify-center pt-4">
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-[#EC4899] to-[#F43F5E] text-white rounded-xl font-semibold hover:shadow-xl transition transform hover:scale-105">
                        Simpan Perubahan
                    </button>
                    <a href="detail.php?id=<?= $id ?>" 
                       class="px-8 py-3 bg-white border-2 border-pink-soft text-pink-deep rounded-xl font-medium hover:bg-cream-light transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

</body>
</html>