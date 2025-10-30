<?php
require 'config/database.php';

// --- PAGINATION ---
$limit = 5;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

// --- INISIALISASI ---
$search = trim($_GET['search'] ?? '');
$category = $_GET['category'] ?? '';

// --- VALIDASI KATEGORI ---
$allowed_categories = ['facial', 'massage', 'body-treatment', 'hair-spa', 'nail-care'];
if (!in_array($category, $allowed_categories)) {
    $category = '';
}

// --- BUILD WHERE & PARAMS ---
$where = "WHERE 1=1";
$params = [];

if ($search !== '') {
    $where .= " AND (LOWER(name) LIKE LOWER(:search) OR LOWER(description) LIKE LOWER(:search))";
    $params[':search'] = "%$search%";
}
if ($category !== '') {
    $where .= " AND category = :category";
    $params[':category'] = $category;
}

// --- TOTAL DATA ---
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM services $where");
$countStmt->execute($params);
$total = $countStmt->fetchColumn();
$pages = ceil($total / $limit);

// --- AMBIL DATA ---
$query = "SELECT * FROM services $where ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $limit);
$stmt->bindValue(':offset', $offset);

$stmt->execute();
$services = $stmt->fetchAll();

// --- DAFTAR KATEGORI ---
$catStmt = $pdo->query("SELECT DISTINCT category FROM services ORDER BY category");
$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPA Alfra - Layanan Spa Premium</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
        .bg-cream { background-color: #FFF5F5; }
        .bg-cream-light { background-color: #FDF2F8; }
        .text-pink-deep { color: #EC4899; }
        .text-brown-deep { color: #92400E; }
        .text-main { color: #92400E; }
        .border-pink-soft { border-color: #F9A8D4; }
        .hover-bg-cream-light:hover { background-color: #FDF2F8; }

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
    </style>
</head>
<body class="min-h-screen font-inter">

<!-- NAVBAR -->
<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-md z-50 shadow-lg border-b border-pink-soft">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <a href="index.php" class="flex items-center gap-2">
                <i class="fas fa-spa text-2xl text-pink-deep"></i>
                <span class="font-playfair text-xl font-bold text-brown-deep">SPA Alfra</span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#home" class="text-main hover:text-pink-deep transition">Home</a>
                <a href="#services" class="text-main hover:text-pink-deep transition">Layanan</a>
                <a href="#contact" class="text-main hover:text-pink-deep transition">Kontak</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="create.php" class="hidden md:block bg-gradient-to-r from-[#EC4899] to-[#F43F5E] text-white px-6 py-2 rounded-lg font-medium hover:shadow-xl transition transform hover:scale-105">
                    + Tambah
                </a>
                <button id="mobile-menu-btn" class="md:hidden p-2 text-brown-deep">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-pink-soft">
        <div class="px-4 py-2 space-y-2">
            <a href="#home" class="block py-2 text-main hover-bg-cream-light px-4 rounded">Home</a>
            <a href="#services" class="block py-2 text-main hover-bg-cream-light px-4 rounded">Layanan</a>
            <a href="#contact" class="block py-2 text-main hover-bg-cream-light px-4 rounded">Kontak</a>
            <a href="create.php" class="block py-2 text-pink-deep font-medium bg-cream-light px-4 rounded">+ Tambah Layanan</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section id="home" class="pt-20 pb-16 bg-gradient-to-r bg-cream-light to-[#FFF5F5]">
    <div class="container mx-auto px-4 text-center">
        <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-[#EC4899] to-[#F43F5E] flex items-center justify-center shadow-2xl animate-float">
            <i class="fas fa-spa text-5xl text-white"></i>
        </div>
        <h1 class="font-playfair text-5xl md:text-6xl font-bold text-brown-deep mb-4">
            Selamat Datang di <span class="text-pink-deep">SPA Alfra</span>
        </h1>
        <p class="text-xl text-main mb-8 max-w-2xl mx-auto">Layanan spa premium dengan sentuhan hangat dan elegan</p>
        <a href="#services" class="inline-block bg-gradient-to-r from-[#EC4899] to-[#F43F5E] text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition transform hover:scale-105">
            Lihat Layanan
        </a>
    </div>
</section>

<!-- Toast -->
<div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>

<!-- SEARCH + FILTER -->
<section id="services" class="py-16">
    <div class="container mx-auto px-4 max-w-6xl">
        <form method="GET" id="search-form" class="mb-8">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- SEARCH -->
                <div class="flex-1 relative">
                    <input type="text" name="search" id="search-input" value="<?= htmlspecialchars($search) ?>" placeholder="Cari nama atau deskripsi..." 
                           class="w-full pl-12 pr-6 py-4 bg-white/90 backdrop-blur-sm border border-pink-soft rounded-xl input-focus text-main placeholder:text-main/50">
                    <button type="submit" class="absolute left-4 top-5 text-pink-deep">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
                </div>

                <!-- FILTER KATEGORI -->
                <select name="category" onchange="document.getElementById('search-form').submit()" class="px-6 py-4 bg-white/90 backdrop-blur-sm border border-pink-soft rounded-xl text-main">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                            <?= htmlspecialchars(ucwords(str_replace('-', ' ', $cat))) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- TAMBAH -->
                <a href="create.php" class="bg-gradient-to-r from-[#EC4899] to-[#F43F5E] text-white font-semibold px-8 py-4 rounded-xl flex items-center gap-2 shadow-lg hover:shadow-xl transition transform hover:scale-105 whitespace-nowrap">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </form>

        <!-- HASIL -->
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            <?php if ($services): ?>
                <?php foreach ($services as $s): ?>
                <div class="service-card p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#EC4899] to-[#F43F5E] flex items-center justify-center shadow-lg animate-float">
                            <i class="fas fa-spa text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-cream-light text-pink-deep">
                                    <?= htmlspecialchars(ucwords(str_replace('-', ' ', $s['category']))) ?>
                                </span>
                                <span class="text-xs text-main"><?= htmlspecialchars($s['duration']) ?> menit</span>
                            </div>
                            <h3 class="text-xl font-semibold text-brown-deep mb-2">
                                <a href="detail.php?id=<?= $s['id'] ?>" class="hover:text-pink-deep transition">
                                    <?= htmlspecialchars($s['name']) ?>
                                </a>
                            </h3>
                            <p class="text-main text-sm mb-4 line-clamp-2"><?= htmlspecialchars($s['description']) ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-pink-deep">Rp <?= number_format($s['price'], 0, ',', '.') ?></span>
                                <div class="flex gap-2">
                                    <a href="detail.php?id=<?= $s['id'] ?>" class="w-8 h-8 rounded-lg flex items-center justify-center text-pink-deep hover-bg-cream-light"><i class="fas fa-eye"></i></a>
                                    <a href="update.php?id=<?= $s['id'] ?>" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#D4A574] hover-bg-cream-light"><i class="fas fa-edit"></i></a>
                                    <form action="delete.php" method="POST" class="inline">
                                        <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                        <button type="submit" onclick="return confirmDelete('<?= addslashes(htmlspecialchars($s['name'])) ?>')" 
                                                class="w-8 h-8 rounded-lg flex items-center justify-center text-[#F43F5E] hover:bg-[#F9A8D4]/20">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-16">
                    <i class="fas fa-spa text-6xl text-[#F9A8D4]/30 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-main">Tidak ada hasil ditemukan</h3>
                    <p class="text-main/70 mt-2">Coba kata kunci lain atau hapus filter</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- PAGINATION -->
        <?php if ($pages > 1): ?>
        <div class="flex justify-center mt-12 gap-2">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a href="?page=<?= $i ?>&search=<?= rawurlencode($search) ?>&category=<?= rawurlencode($category) ?>" 
                   class="px-4 py-2 rounded-lg font-medium <?= $i == $page ? 'bg-[#EC4899] text-white' : 'bg-white text-main hover-bg-cream-light border border-pink-soft' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CONTACT -->
<section id="contact" class="py-16 bg-cream">
    <div class="container mx-auto px-4 text-center">
        <h2 class="font-playfair text-3xl font-bold text-brown-deep mb-4">Hubungi Kami</h2>
        <p class="text-main mb-8">Siap untuk pengalaman spa yang hangat?</p>
        <div class="flex justify-center gap-8 text-main">
            <div><i class="fas fa-phone"></i> +6285651197947</div>
            <div><i class="fas fa-envelope"></i> SPAalfra@gmail.com</div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/main.js"></script>

<script>
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') document.getElementById('search-form').submit();
});

function confirmDelete(name) {
    return Swal.fire({
        title: 'Hapus layanan?',
        text: `"${name}" akan dihapus permanen!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#EC4899'
    }).then(r => r.isConfirmed);
}
</script>

<?php if (isset($_GET['msg'])): ?>
<script>showToast('<?= htmlspecialchars($_GET['msg']) ?>', 'success');</script>
<?php endif; ?>

</body>
</html>