<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

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
        --aksen-emas: #706647;
    }

    body {
        background: var(--krem-halus) url("https://www.transparenttextures.com/patterns/pinstripe.png");
        font-family: 'Quicksand', sans-serif;
        color: var(--cokelat-gelap);
    }

    .navbar-tradisional {
        background: linear-gradient(135deg, var(--cokelat-gelap) 0%, #4e342e 100%) !important;
        border-bottom: 3px solid var(--aksen-emas);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .card-admin {
        border: none;
        border-radius: 20px !important;
        box-shadow: 0 10px 30px rgba(62, 39, 35, 0.1);
    }

    .border-ornamen {
        height: 10px;
        background: repeating-linear-gradient(45deg, var(--aksen-emas), var(--aksen-emas) 10px, var(--cokelat-gelap) 10px, var(--cokelat-gelap) 20px);
        border-radius: 20px 20px 0 0;
    }

    h2 { font-family: 'Philosopher', sans-serif; font-weight: 700; letter-spacing: 1px; }

    .menu-box {
        border: 2px solid #f0ede9;
        border-radius: 15px;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: white;
    }

    .menu-box:hover {
        transform: translateY(-10px);
        border-color: var(--hijau-muda);
        box-shadow: 0 15px 35px rgba(46, 125, 50, 0.15);
    }

    .btn-custom {
        border-radius: 10px;
        border: none;
        padding: 12px;
        transition: 0.3s;
        color: white;
        font-weight: bold;
    }

    .btn-cokelat { background-color: var(--cokelat-medium); }
    .btn-cokelat:hover { background-color: var(--cokelat-gelap); color: white; box-shadow: 0 5px 15px rgba(62, 39, 35, 0.3); }
    
    .btn-hijau { background-color: var(--hijau-tua); }
    .btn-hijau:hover { background-color: #1b5e20; color: white; box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3); }

    .icon-circle {
        width: 70px; height: 70px;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex; align-items: center; justify-content: center;
    }

    .bg-soft-green { background-color: #e8f5e9; color: var(--hijau-tua); }
    .bg-soft-brown { background-color: #efebe9; color: var(--cokelat-gelap); }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
        <i class="fas fa-utensils me-3 text-warning"></i>
        <span style="letter-spacing: 1px;">WARTEG 88 <small class="fw-light">ADMIN</small></span>
    </a>
    <div class="d-flex align-items-center">
        <div class="text-end me-3 d-none d-md-block">
            <span class="text-white-50 d-block" style="font-size: 0.6rem;">PENGELOLA</span>
            <span class="text-white fw-bold"><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></span>
        </div>
        <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-sm btn-outline-warning rounded-pill px-4">Keluar</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card card-admin">
                <div class="border-ornamen"></div>
                <div class="card-body p-5">
                    <div class="text-center mb-5">
                        <span class="badge mb-3" style="background: var(--aksen-emas); border-radius: 50px;">Panel Kendali</span>
                        <h2 class="display-6">Sugeng Rawuh, Admin</h2>
                        <p class="fst-italic" style="color: var(--aksen-emas);">"Nguri-uri Budaya Melalui Rasa, Sejahtera Bersama"</p>
                        <hr style="width: 60px; margin: 25px auto; border-top: 4px solid var(--hijau-muda);">
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="menu-box p-4 text-center h-100">
                                <div class="icon-circle bg-soft-green"><i class="fas fa-leaf fa-2x"></i></div>
                                <h4 class="fw-bold mb-2">Kelola Menu</h4>
                                <p class="text-muted small mb-4">Perbarui daftar sajian, stok lauk pauk, dan harga harian warteg.</p>
                                <a href="kelola_menu.php" class="btn btn-hijau btn-custom w-100">
                                    <i class="fas fa-mortar-pestle me-2"></i>Olah Menu
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="menu-box p-4 text-center h-100">
                                <div class="icon-circle bg-soft-brown"><i class="fas fa-scroll fa-2x"></i></div>
                                <h4 class="fw-bold mb-2">Laporan Penjualan</h4>
                                <p class="text-muted small mb-4">Rekapitulasi berkas transaksi dan pembukuan laba secara berkala.</p>
                                <a href="laporan_penjualan.php" class="btn btn-cokelat btn-custom w-100">
                                    <i class="fas fa-book me-2"></i>Buka Pembukuan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="small text-muted" style="letter-spacing: 4px; font-weight: 600;">
                    <span style="color: var(--cokelat-medium);">WARTEG</span> 88 — TRADISI RASA SEJATI
                </p>
                <p class="text-muted" style="font-size: 0.7rem;">&copy; 2026 Hak Cipta Terpelihara</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>