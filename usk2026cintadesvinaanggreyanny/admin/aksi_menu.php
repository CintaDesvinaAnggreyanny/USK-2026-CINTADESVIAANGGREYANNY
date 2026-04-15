<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$action = $_GET['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = $_POST['id'] ?? null;
    $kategori_id = $_POST['kategori_id'] ?? null;
    $nama_menu   = $_POST['nama_menu'] ?? '';
    $harga       = $_POST['harga'] ?? 0;
    $stok        = $_POST['stok'] ?? 0;

    if ($action === 'tambah') {
        $stmt = $conn->prepare("INSERT INTO menu (kategori_id, nama_menu, harga, stok) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $kategori_id, $nama_menu, $harga, $stok);
        
        $_SESSION[$stmt->execute() ? 'success' : 'error'] = $stmt->error ? "Gagal menambah menu: $conn->error" : "Menu '$nama_menu' berhasil ditambahkan.";

    } elseif ($action === 'edit') {
        $stmt = $conn->prepare("UPDATE menu SET kategori_id = ?, nama_menu = ?, harga = ?, stok = ? WHERE id = ?");
        $stmt->bind_param("isiii", $kategori_id, $nama_menu, $harga, $stok, $id);
        
        $_SESSION[$stmt->execute() ? 'success' : 'error'] = $stmt->error ? "Gagal mengubah menu: $conn->error" : "Menu '$nama_menu' berhasil diupdate.";
    }
} 

elseif ($action === 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT nama_menu FROM menu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $menu = $stmt->get_result()->fetch_assoc();

    if ($menu) {
        $nama = $menu['nama_menu'];
        $stmt_del = $conn->prepare("DELETE FROM menu WHERE id = ?");
        $stmt_del->bind_param("i", $id);
        
        if ($stmt_del->execute()) {
            $_SESSION['success'] = "Menu '$nama' berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Gagal menghapus menu. Data mungkin terkait dengan riwayat transaksi.";
        }
    }
}

header("Location: kelola_menu.php");
exit;