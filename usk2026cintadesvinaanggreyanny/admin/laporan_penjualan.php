<?php
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01'); 
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); 

$query = "SELECT t.*, u.nama_lengkap FROM transaksi t JOIN users u ON t.user_id = u.id WHERE DATE(t.tanggal) BETWEEN ? AND ? ORDER BY t.tanggal DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$riwayat = $stmt->get_result();

$total_pendapatan = 0;
$total_transaksi = 0;
while ($row = $riwayat->fetch_assoc()) {
    $total_pendapatan += $row['total_harga'];
    $total_transaksi++;
}

$riwayat->data_seek(0);

require_once '../includes/header.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');

    :root {
        --cokelat-kayu: #3d2b1f;
        --hijau-hutan: #2D5A27;
        --emas-pudar: #C5A059;
        --krem-lembut: #FDFaf5;
    }

    body {
        background: var(--krem-lembut) url("https://www.transparenttextures.com/patterns/natural-paper.png");
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--cokelat-kayu);
    }

    .navbar-tradisional {
        background: var(--cokelat-kayu) !important;
        border-bottom: 4px solid var(--emas-pudar);
        padding: 1rem 0;
    }

    .filter-section {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 20px;
        border-top: 5px solid var(--hijau-hutan);
    }

    .stat-card-new {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border: 1px solid rgba(197, 160, 89, 0.2);
    }
    
    .label-stat { font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; letter-spacing: 1px; }
    .value-stat { font-family: 'Crimson Pro', serif; font-size: 2.2rem; font-weight: 700; }

    .card-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .invoice-text { 
        background: #f1f8f1; 
        color: var(--hijau-hutan); 
        padding: 4px 10px; 
        border-radius: 6px; 
        font-weight: 700; 
        font-family: monospace;
    }

    .btn-print {
        background: var(--emas-pudar);
        color: white;
        border-radius: 50px;
        padding: 8px 25px;
        font-weight: 600;
        border: none;
    }

    @media print {
        .no-print { display: none !important; }
        body { background: white; }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-tradisional mb-4 no-print">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <i class="fas fa-chevron-left me-3 text-warning"></i> 
            <span style="font-family: 'Crimson Pro'; font-size: 1.5rem;">Laporan Penjualan</span>
        </a>
    </div>
</nav>

<div class="container mt-2 mb-5">
    <div class="filter-section mb-4 no-print">
        <form action="" method="GET" class="row align-items-center">
            <div class="col-md-1 d-none d-md-block text-center">
                <i class="fas fa-calendar-alt fa-2x text-muted"></i>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold">DARI TANGGAL</label>
                <input type="date" class="form-control" name="start_date" 
                       value="<?= htmlspecialchars($start_date) ?>" onchange="this.form.submit()">
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold">SAMPAI TANGGAL</label>
                <input type="date" class="form-control" name="end_date" 
                       value="<?= htmlspecialchars($end_date) ?>" onchange="this.form.submit()">
            </div>
            <div class="col-md-1 text-center small text-muted">
                <i class="fas fa-sync-alt fa-spin"></i>
            </div>
        </form>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="stat-card-new">
                <p class="label-stat mb-1">Total Pendapatan</p>
                <h2 class="value-stat m-0" style="color: var(--hijau-hutan);">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h2>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="stat-card-new">
                <p class="label-stat mb-1">Jumlah Transaksi</p>
                <h2 class="value-stat m-0" style="color: var(--cokelat-kayu);"><?= $total_transaksi ?> <small class="text-muted fs-5">Nota</small></h2>
            </div>
        </div>
    </div>

    <div class="card card-table">
        <div class="p-4 d-flex justify-content-between align-items-center border-bottom bg-light">
            <h5 class="m-0 fw-bold" style="font-family: 'Crimson Pro';">
                <i class="fas fa-receipt me-2 text-success"></i>Rincian Penjualan
            </h5>
            <button onclick="window.print()" class="btn btn-print no-print">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center py-3">No</th>
                        <th>No. Invoice</th>
                        <th>Waktu</th>
                        <th>Kasir</th>
                        <th class="text-end px-4">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total_transaksi > 0): ?>
                        <?php $no = 1; while($row = $riwayat->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++ ?></td>
                            <td><span class="invoice-text"><?= htmlspecialchars($row['kode_invoice']) ?></span></td>
                            <td>
                                <div class="fw-bold small"><?= date('d M Y', strtotime($row['tanggal'])) ?></div>
                                <div class="text-muted extra-small" style="font-size: 0.7rem;"><?= date('H:i', strtotime($row['tanggal'])) ?> WIB</div>
                            </td>
                            <td><i class="fas fa-user-circle me-1 text-muted"></i> <?= htmlspecialchars($row['nama_lengkap']) ?></td>
                            <td class="text-end px-4 fw-bold" style="color: var(--hijau-hutan);">
                                Rp <?= number_format($row['total_harga'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <tr class="bg-light fw-bold">
                            <td colspan="4" class="text-end py-4 text-uppercase">Total Keseluruhan</td>
                            <td class="text-end px-4 py-4 fs-4" style="color: var(--hijau-hutan); font-family: 'Crimson Pro';">
                                Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">Tidak ada catatan transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>