<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: kelola_menu.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$menu_data = $stmt->get_result()->fetch_assoc();

if (!$menu_data) {
    $_SESSION['error'] = "Data menu tidak ditemukan.";
    header("Location: kelola_menu.php");
    exit;
}

$kategori_query = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");

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

    .card-form {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(62, 39, 35, 0.1);
        overflow: hidden;
    }

    .card-header-ornamen {
        height: 10px;
        background: linear-gradient(90deg, #D32F2F, var(--aksen-emas), var(--cokelat-medium));
    }

    h4 {
        font-family: 'Philosopher', sans-serif;
        color: var(--cokelat-gelap);
        font-weight: 700;
    }

    .form-label {
        color: var(--cokelat-medium);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control, .form-select {
        border: 2px solid #eee;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--aksen-emas);
        box-shadow: 0 0 0 0.25rem rgba(197, 160, 89, 0.15);
    }

    .btn-update {
        background-color: var(--cokelat-medium);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 15px;
        transition: 0.3s;
    }

    .btn-update:hover {
        background-color: var(--cokelat-gelap);
        color: white;
        transform: translateY(-2px);
    }

    .btn-batal {
        background-color: transparent;
        color: #777;
        border: none;
        text-decoration: underline;
    }

    .icon-edit-box {
        width: 60px;
        height: 60px;
        background-color: #fff3e0;
        color: var(--aksen-emas);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="kelola_menu.php">
        <i class="fas fa-arrow-left me-2 text-warning"></i> Kembali ke Pengaturan Menu
    </a>
  </div>
</nav>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-form">
                <div class="card-header-ornamen"></div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="icon-edit-box">
                            <i class="fas fa-pen-fancy fa-2x"></i>
                        </div>
                        <h4>Sesuaikan Hidangan</h4>
                        <p class="text-muted small">Ubah detail menu agar informasi tetap akurat</p>
                    </div>
                    
                    <form action="aksi_menu.php?action=edit" method="POST">
                        <input type="hidden" name="id" value="<?= $menu_data['id'] ?>">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kelompok Kategori</label>
                            <select class="form-select" name="kategori_id" required>
                                <?php while($k = $kategori_query->fetch_assoc()): ?>
                                    <option value="<?= $k['id'] ?>" <?= $k['id'] == $menu_data['kategori_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['nama_kategori']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Menu Utama</label>
                            <input type="text" class="form-control" name="nama_menu" value="<?= htmlspecialchars($menu_data['nama_menu']) ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Harga Saat Ini (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">Rp</span>
                                    <input type="number" class="form-control border-start-0" name="harga" value="<?= $menu_data['harga'] ?>" min="0" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold">Update Stok Porsi</label>
                                <input type="number" class="form-control" name="stok" value="<?= $menu_data['stok'] ?>" min="0" required>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-update fw-bold">
                                <i class="fas fa-sync-alt me-2"></i>PERBARUI DATA MENU
                            </button>
                            <a href="kelola_menu.php" class="btn btn-batal">Batalkan Perubahan</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="alert mt-4 border-0 text-center" style="background-color: #fffde7; border-radius: 15px;">
                <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Perubahan harga langsung diterapkan pada sistem kasir.</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>