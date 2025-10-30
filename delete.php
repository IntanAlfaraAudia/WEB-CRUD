<?php
require 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    
    header("Location: index.php?msg=Layanan berhasil dihapus!");
    exit;
} else {
    header("Location: index.php");
    exit;
}