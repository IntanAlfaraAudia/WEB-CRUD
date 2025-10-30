<?php
require 'config/database.php';

$errors = [];
$input = [];

if ($_POST) {
    $input = [
        'name' => trim($_POST['name'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'category' => $_POST['category'] ?? '',
        'duration' => trim($_POST['duration'] ?? ''),
        'price' => trim($_POST['price'] ?? '')
    ];

    if (empty($input['name'])) $errors[] = "Nama wajib diisi.";
    if (empty($input['description'])) $errors[] = "Deskripsi wajib diisi.";
    if (!in_array($input['category'], ['facial','massage','body-treatment','hair-spa','nail-care'])) $errors[] = "Kategori tidak valid.";
    if (!is_numeric($input['duration']) || $input['duration'] <= 0) $errors[] = "Durasi harus angka positif.";
    if (!is_numeric($input['price']) || $input['price'] < 0) $errors[] = "Harga tidak valid.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO services (name, description, category, duration, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            htmlspecialchars($input['name']),
            htmlspecialchars($input['description']),
            $input['category'],
            (int)$input['duration'],
            (float)$input['price']
        ]);
        header("Location: index.php?msg=Layanan berhasil ditambahkan!");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Layanan - SpaFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gradient-to-br from-rose-50 via-pink-50 to-purple-50 min-h-screen">

<?php include 'navbar.php'; ?>

<div class="container mx-auto px-4 py-24 max-w-2xl">
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-purple-100">
        <h1 class="font-playfair text-4xl font-bold text-purple-800 mb-2 text-center">Tambah Layanan</h1>

        <?php if ($errors): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
            <ul class="list-disc list-inside"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <input type="text" name="name" value="<?= htmlspecialchars($input['name'] ?? '') ?>" placeholder="Nama Layanan" class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-4 focus:ring-purple-300" required>
            <textarea name="description" rows="4" placeholder="Deskripsi" class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-4 focus:ring-purple-300" required><?= htmlspecialchars($input['description'] ?? '') ?></textarea>
            <select name="category" class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-4 focus:ring-purple-300" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="facial" <?= ($input['category'] ?? '') == 'facial' ? 'selected' : '' ?>>Facial</option>
                <option value="massage" <?= ($input['category'] ?? '') == 'massage' ? 'selected' : '' ?>>Massage</option>
                <option value="body-treatment" <?= ($input['category'] ?? '') == 'body-treatment' ? 'selected' : '' ?>>Body Treatment</option>
                <option value="hair-spa" <?= ($input['category'] ?? '') == 'hair-spa' ? 'selected' : '' ?>>Hair Spa</option>
                <option value="nail-care" <?= ($input['category'] ?? '') == 'nail-care' ? 'selected' : '' ?>>Nail Care</option>
            </select>
            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="duration" value="<?= htmlspecialchars($input['duration'] ?? '') ?>" placeholder="Durasi (menit)" min="15" class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-4 focus:ring-purple-300" required>
                <input type="number" name="price" value="<?= htmlspecialchars($input['price'] ?? '') ?>" placeholder="Harga (Rp)" min="0" step="1000" class="w-full px-4 py-3 border border-purple-200 rounded-lg focus:ring-4 focus:ring-purple-300" required>
            </div>
            <div class="flex gap-3 pt-4">
                <a href="index.php" class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 rounded-lg transition">Kembali</a>
                <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 rounded-lg transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>