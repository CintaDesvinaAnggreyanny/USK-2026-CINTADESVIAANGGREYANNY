<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$stmt = $conn->prepare("SELECT t.*, u.nama_lengkap FROM transaksi t JOIN users u ON t.user_id = u.id ORDER BY t.tanggal DESC LIMIT 50");
$stmt->execute();
$riwayat = $stmt->get_result();

require_once '../includes/header.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Quicksand:wght@400;600&display=swap');

    :root {
        --cokelat-gelap: #3E2723; --cokelat-medium: #5D4037;
        --hijau-tua: #2E7D32; --hijau-muda: #81C784;
        --krem-halus: #F9F5F0; --aksen-emas: #C5A059;
    }

    body {
        background: var(--krem-halus) url("https://www.transparenttextures.com/patterns/pinstripe.png");
        font-family: 'Quicksand', sans-serif;
        color: var(--cokelat-gelap);
    }

    .navbar-tradisional {
        background: linear-gradient(135deg, var(--hijau-tua) 0%, #1b5e20 100%) !important;
        border-bottom: 3px solid var(--aksen-emas);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .card-custom {
        border: none; border-radius: 20px;
        box-shadow: 0 10px 30px rgba(62, 39, 35, 0.05);
        background: #fff;
    }

    .card-header-ornamen {
        height: 8px;
        background: linear-gradient(90deg, var(--aksen-emas), var(--cokelat-medium), var(--hijau-tua));
        border-radius: 20px 20px 0 0;
    }

    h4 { font-family: 'Philosopher', sans-serif; color: var(--cokelat-gelap); font-weight: 700; }

    .table thead { background: #efebe9; color: var(--cokelat-gelap); border-bottom: 2px solid var(--aksen-emas); }
    .table-hover tbody tr:hover { background-color: #f1f8e9; transition: 0.3s; }

    .invoice-badge {
        background: #efebe9; color: var(--cokelat-gelap); font-weight: 700;
        padding: 5px 12px; border-radius: 8px; border: 1px solid var(--aksen-emas);
    }

    .btn-tambah-baru { background: var(--hijau-tua); color: #fff; border-radius: 10px; font-weight: 600; transition: 0.3s; border: none; }
    .btn-tambah-baru:hover { background: #1b5e20; color: #fff; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46, 125, 50, 0.2); }

    .btn-nota { background: var(--cokelat-medium); color: #fff; border-radius: 8px; transition: 0.3s; border: none; }
    .btn-nota:hover { background: var(--cokelat-gelap); color: #fff; }

    .text-total { color: var(--hijau-tua); font-weight: 700; }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fas fa-arrow-left me-2 text-warning"></i> Kembali ke Menu Utama
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">
    <div class="card card-custom">
        <div class="card-header-ornamen"></div>
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <h4 class="m-0 mb-3 mb-md-0"><i class="fas fa-history me-2 text-success"></i>Riwayat Penjualan</h4>
                <a href="transaksi.php" class="btn btn-tambah-baru px-4 py-2">
                    <i class="fas fa-plus-circle me-1"></i> Transaksi Baru
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="py-3">No. Invoice</th>
                            <th class="py-3">Tanggal & Waktu</th>
                            <th class="py-3">Petugas Kasir</th>
                            <th class="py-3">Total Belanja</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($riwayat->num_rows > 0): 
                            while($row = $riwayat->fetch_assoc()): ?>
                            <tr>
                                <td><span class="invoice-badge"><?= htmlspecialchars($row['kode_invoice']) ?></span></td>
                                <td class="text-muted small">
                                    <i class="far fa-clock me-1 text-warning"></i>
                                    <?= date('d M Y, H:i', strtotime($row['tanggal'])) ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-2"><i class="fas fa-user text-secondary" style="font-size: 0.8rem;"></i></div>
                                        <span class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']) ?></span>
                                    </div>
                                </td>
                                <td class="text-total">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <a href="nota.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-nota px-3">
                                        <i class="fas fa-receipt me-1"></i> Detail Nota
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-receipt fa-3x text-light mb-3 d-block"></i>
                                    <p class="text-muted m-0">Belum ada transaksi hari ini.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="text-center mt-4">
        <p class="text-muted small" style="letter-spacing: 2px;">WARTEG 88 - CATATAN TRANSAKSI DIGITAL</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>