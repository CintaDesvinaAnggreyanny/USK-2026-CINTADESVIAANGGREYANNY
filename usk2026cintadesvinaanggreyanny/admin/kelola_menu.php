<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$query = "SELECT m.*, k.nama_kategori FROM menu m LEFT JOIN kategori k ON m.kategori_id = k.id ORDER BY m.id DESC";
$result = $conn->query($query);

require_once '../includes/header.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Quicksand:wght@400;600&display=swap');

    :root {
        --cokelat-gelap: #3E2723;
        --cokelat-medium: #5D4037;
        --hijau-tua: #2E7D32;
        --hijau-muda: #81C784;
        --krem-halus: #F9F5F0;
        --aksen-emas: #C5A059;
    }

    body {
        background: var(--krem-halus) url("https://www.transparenttextures.com/patterns/pinstripe.png");
        font-family: 'Quicksand', sans-serif;
        color: var(--cokelat-gelap);
    }

    .navbar-tradisional {
        background: linear-gradient(135deg, var(--cokelat-gelap) 0%, #4e342e 100%) !important;
        border-bottom: 3px solid var(--aksen-emas);
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(62, 39, 35, 0.05);
        overflow: hidden;
    }

    .card-header-ornamen {
        height: 8px;
        background: linear-gradient(90deg, var(--aksen-emas), var(--hijau-tua), var(--cokelat-medium));
    }

    h4 { font-family: 'Philosopher', sans-serif; font-weight: 700; }

    .table thead { background: #efebe9; }
    .table-hover tbody tr:hover { background-color: #f1f8e9; }

    .btn-tambah {
        background: var(--hijau-tua);
        color: white; border: none; border-radius: 8px;
        transition: 0.3s;
    }

    .btn-tambah:hover { background: #1b5e20; color: white; transform: translateY(-2px); }

    .btn-action { border-radius: 4px; transition: 0.2s; }
    .btn-edit-custom { color: var(--cokelat-medium); border: 1px solid var(--cokelat-medium); }
    .btn-edit-custom:hover { background: var(--cokelat-medium); color: white; }

    .btn-hapus-custom { color: #B71C1C; border: 1px solid #B71C1C; }
    .btn-hapus-custom:hover { background: #B71C1C; color: white; }

    .text-harga { color: var(--hijau-tua); font-weight: 700; }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-chevron-left me-2 text-warning"></i> Kembali ke Dashboard
    </a>
  </div>
</nav>

<div class="container mt-4 mb-5">
    <?php foreach(['success', 'error'] as $type): ?>
        <?php if (isset($_SESSION[$type])): ?>
            <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fas fa-<?= $type === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i> 
                <?= $_SESSION[$type]; unset($_SESSION[$type]); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <div class="card card-custom">
        <div class="card-header-ornamen"></div>
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <h4 class="m-0 mb-3 mb-md-0"><i class="fas fa-utensils me-2 text-success"></i>Daftar Menu Warteg 88</h4>
                <a href="tambah_menu.php" class="btn btn-tambah px-4 py-2 fw-bold">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Menu Baru
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="py-3 border-0">No</th>
                            <th class="py-3 border-0">Nama Menu</th>
                            <th class="py-3 border-0">Kategori</th>
                            <th class="py-3 border-0">Harga Satuan</th>
                            <th class="py-3 border-0">Status Stok</th>
                            <th class="py-3 border-0 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php $no = 1; while($row = $result->fetch_assoc()): ?>
                                <?php 
                                    if ($row['stok'] > 10) {
                                        $badge = ['bg-success', 'check', 'Tersedia'];
                                    } elseif ($row['stok'] > 0) {
                                        $badge = ['bg-warning', 'exclamation', 'Hampir Habis'];
                                    } else {
                                        $badge = ['bg-danger', 'times', 'Habis'];
                                    }
                                ?>
                                <tr>
                                    <td class="text-muted"><?= $no++ ?></td>
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($row['nama_menu']) ?></td>
                                    <td><span class="badge rounded-pill px-3" style="background:var(--aksen-emas)"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
                                    <td class="text-harga">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= $badge[0] ?>">
                                            <i class="fas fa-<?= $badge[1] ?> me-1"></i> <?= $badge[2] ?> (<?= $row['stok'] ?>)
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_menu.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-edit-custom px-3">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="aksi_menu.php?action=hapus&id=<?= $row['id'] ?>" class="btn btn-sm btn-hapus-custom px-3" onclick="return confirm('Hapus menu ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-light mb-3 d-block"></i>
                                    <span class="text-muted">Belum ada hidangan yang terdaftar.</span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>