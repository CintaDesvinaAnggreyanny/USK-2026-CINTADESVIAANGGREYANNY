<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
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
        background: linear-gradient(90deg, var(--hijau-tua), var(--aksen-emas), var(--cokelat-medium));
    }

    h4 { font-family: 'Philosopher', sans-serif; font-weight: 700; letter-spacing: 1px; }

    .form-label {
        color: var(--cokelat-medium);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .form-control, .form-select {
        border: 2px solid #eee;
        border-radius: 12px;
        padding: 12px;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--hijau-muda);
        box-shadow: 0 0 0 0.25rem rgba(129, 199, 132, 0.15);
    }

    .btn-simpan {
        background: var(--hijau-tua);
        color: white; border: none; border-radius: 12px;
        padding: 15px; transition: 0.3s;
    }

    .btn-simpan:hover {
        background: #1b5e20; transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
    }

    .btn-batal {
        color: var(--cokelat-medium);
        border: 2px solid var(--cokelat-medium);
        border-radius: 12px; padding: 12px; transition: 0.3s;
    }

    .btn-batal:hover { background: var(--cokelat-medium); color: white; }

    .icon-box {
        width: 70px; height: 70px;
        background: #f1f8e9; color: var(--hijau-tua);
        border-radius: 50%; display: flex;
        align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="kelola_menu.php">
        <i class="fas fa-arrow-left me-2 text-warning"></i> Kembali ke Daftar Menu
    </a>
  </div>
</nav>

<div class="container mt-2 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-form">
                <div class="card-header-ornamen"></div>
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="icon-box">
                            <i class="fas fa-mortar-pestle fa-2x"></i>
                        </div>
                        <h4>Racik Menu Baru</h4>
                        <p class="text-muted small">Tambahkan hidangan spesial ke etalase Warteg 88</p>
                        <hr style="width: 60px; margin: 20px auto; border-top: 3px solid var(--aksen-emas); opacity: 1;">
                    </div>
                    
                    <form action="aksi_menu.php?action=tambah" method="POST">
                        <div class="mb-4">
                            <label class="form-label">Kategori Hidangan</label>
                            <select class="form-select" name="kategori_id" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                <?php while($k = $kategori_query->fetch_assoc()): ?>
                                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Nama Menu / Masakan</label>
                            <input type="text" class="form-control" name="nama_menu" placeholder="Contoh: Ayam Goreng Serundeng" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0 bg-light" style="border-radius: 12px 0 0 12px;">Rp</span>
                                    <input type="number" class="form-control border-start-0" name="harga" placeholder="0" min="0" style="border-radius: 0 12px 12px 0;" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Stok Harian (Porsi)</label>
                                <input type="number" class="form-control" name="stok" placeholder="0" min="0" required>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-3 mt-3">
                            <button type="submit" class="btn btn-simpan fw-bold">
                                <i class="fas fa-save me-2"></i>SIMPAN KE SISTEM
                            </button>
                            <a href="kelola_menu.php" class="btn btn-batal fw-bold text-center text-decoration-none">BATAL</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-4">
                <small class="text-muted italic">"Kualitas rasa adalah kunci kepuasan pelanggan."</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>