SPA Alfra — Sistem Manajemen Layanan Spa

**SPA Alfra** adalah aplikasi web berbasis PHP Native yang digunakan untuk mengelola daftar layanan spa & kecantikan.
Aplikasi ini mendukung proses CRUD, filter kategori, pencarian layanan, pagination, serta tampilan antarmuka modern dengan Tailwind CSS.

Aplikasi ini dibuat untuk kebutuhan pembelajaran dan implementasi dasar konsep CRUD + UI modern dalam pemrograman web.

---

## Fitur Utama

| Fitur            | Keterangan                                                                  |
| ---------------- | --------------------------------------------------------------------------- |
| CRUD Layanan Spa | Tambah, tampilkan, ubah, hapus data layanan                                 |
| Pencarian        | Cari layanan berdasarkan nama / deskripsi                                   |
| Filter Kategori  | Filter layanan seperti facial, massage, body treatment, hair spa, nail care |
| Pagination       | Navigasi data secara bertahap                                               |
| Detail Layanan   | Tampilkan informasi layanan secara lengkap                                  |
| UI Modern        | Tampilan clean + animasi lembut bertema spa                                 |
| SweetAlert       | Konfirmasi & notifikasi lebih interaktif                                    |

---

## Teknologi yang Digunakan

* PHP Native (PDO)
* MySQL / MariaDB
* Tailwind CSS
* SweetAlert JS
* Font Awesome
* Laragon (Development local server)

---

## ⚙️ Instalasi

### 1️. Clone Repository

```bash
git clone https://github.com/IntanAlfaraAudia/WEB-CRUD.git
```

### 2️. Pindahkan ke Folder Laragon

```
C:\laragon\www\spa-alfra
```

### 3️.Buat Database Baru

Nama database (opsional bebas):

```
spa_alfra
```

### 4️. Import File SQL

Import file SQL dari folder `database/` ke phpMyAdmin.

### 5️. Konfigurasi Koneksi Database

Buka file `config/database.php` dan sesuaikan:

```php
<?php
$host = 'localhost';
$dbname = 'spa_alfra';
$username = 'root'; 
$password = '';     

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
```

### 6️. Jalankan di Browser

```
http://localhost/spa-alfra
```

---

## Struktur Folder

```
SPA-Alfra
├── assets
│   ├── css
│   └── js
├── config
│   └── database.php
├── index.php
├── create.php
├── update.php
├── delete.php
├── detail.php
└── README.md
```

---

## 🌱 Variabel Koneksi (Manual .env Style)

```
DB_HOST=localhost
DB_NAME=spa_alfra
DB_USER=root
DB_PASS=
```

---

## Screenshot

```Beranda
<img width="1892" height="945" alt="image" src="https://github.com/user-attachments/assets/71f9ff19-51c5-4be2-bebc-4333ccb94d8f" />

<img width="1887" height="936" alt="image" src="https://github.com/user-attachments/assets/b9587976-8ba1-45fe-8243-54f84f26ac09" />


```

---
## 👤 Author

Nama: **Intan Alfara Audia**
NIM : 2409106008
Kelas: A 24 Informatika 

---
