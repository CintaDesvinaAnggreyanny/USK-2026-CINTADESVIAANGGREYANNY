<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

require_once '../includes/header.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');

    :root {
        --primary-trad: #4E342E;
        --secondary-trad: #8D6E63;
        --accent-trad: #2E7D32;
        --bg-trad: #F9F7F2;
        --white: #ffffff;
    }

    body {
        background-color: var(--bg-trad);
        background-image: url("https://www.transparenttextures.com/patterns/pinstripe.png");
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--primary-trad);
    }

    .navbar-tradisional {
        background-color: var(--primary-trad) !important;
        border-bottom: 3px solid var(--accent-trad);
        padding: 0.8rem 0;
    }

    .navbar-brand {
        font-family: 'Playfair Display', serif;
        letter-spacing: 1px;
    }

    .card-tradisional {
        border: none;
        background-color: var(--white);
        border-radius: 24px !important;
        box-shadow: 0 10px 40px rgba(78, 52, 46, 0.08) !important;
    }

    .welcome-section {
        border-bottom: 1px dashed #E0E0E0;
    }

    .welcome-section h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--primary-trad);
    }

    .menu-container {
        display: flex;
        flex-direction: column;
        gap: 20px; 
    }

    .btn-custom {
        padding: 1.5rem 2rem;
        border-radius: 18px;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center; 
        justify-content: center; 
        text-decoration: none;
        width: 100%;
        position: relative;
    }

    .btn-custom i {
        font-size: 1.5rem;
        margin-right: 15px; 
    }

    .btn-text-wrapper {
        text-align: left; 
        min-width: 180px; 
    }

    .btn-mulai {
        background-color: var(--accent-trad);
        color: white;
    }

    .btn-mulai:hover {
        background-color: #1b5e20;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(46, 125, 50, 0.25);
    }

    .btn-riwayat {
        background-color: #F5F5F5;
        color: var(--primary-trad);
        border: 1px solid #EEEEEE;
    }

    .btn-riwayat:hover {
        background-color: #EEEEEE;
        color: var(--primary-trad);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .footer-minimalis {
        margin-top: 4rem;
        color: var(--secondary-trad);
        font-size: 0.75rem;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="fas fa-utensils me-2"></i> WARTEG 88
        </a>
        <div class="ms-auto d-flex align-items-center">
            <div class="text-end me-3 d-none d-md-block border-end pe-3">
                <small class="d-block text-white-50" style="font-size: 0.6rem; text-transform: uppercase;">Petugas Aktif</small>
                <span class="text-white fw-semibold" style="font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></span>
            </div>
            <a href="<?= BASE_URL ?>/auth/logout.php" class="btn btn-outline-light btn-sm px-4 rounded-pill">
                <i class="fas fa-power-off me-1"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8"> <div class="card card-tradisional overflow-hidden">
                <div class="welcome-section p-4 p-md-5 text-center">
                    <h2 class="mb-2">Sugeng Makarya, <?= explode(' ', htmlspecialchars($_SESSION['nama_lengkap']))[0] ?>!</h2>
                    <p class="text-muted small mb-0">"Melayani dengan sepenuh hati, rasa tradisi dalam tiap sajian."</p>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <div class="menu-container">
                        <a href="transaksi.php" class="btn-custom btn-mulai">
                            <i class="fas fa-cash-register"></i>
                            <div class="btn-text-wrapper">
                                <span class="d-block fw-bold fs-5">Transaksi Baru</span>
                                <small class="opacity-75">Input pesanan pelanggan</small>
                            </div>
                        </a>
                        
                        <a href="riwayat_transaksi.php" class="btn-custom btn-riwayat">
                            <i class="fas fa-history"></i>
                            <div class="btn-text-wrapper">
                                <span class="d-block fw-bold fs-5">Riwayat Nota</span>
                                <small class="text-muted">Lihat transaksi sebelumnya</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center footer-minimalis">
                <p>&copy; 2026 Warteg 88 — Tradisi Rasa Sejati</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>