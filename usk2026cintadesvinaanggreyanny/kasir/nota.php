<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: " . BASE_URL . "/auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT t.*, u.nama_lengkap FROM transaksi t JOIN users u ON t.user_id = u.id WHERE t.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$transaksi = $stmt->get_result()->fetch_assoc();

if (!$transaksi) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

$stmt_detail = $conn->prepare("SELECT d.*, m.nama_menu FROM detail_transaksi d JOIN menu m ON d.menu_id = m.id WHERE d.transaksi_id = ?");
$stmt_detail->bind_param("i", $id);
$stmt_detail->execute();
$details = $stmt_detail->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota - <?= htmlspecialchars($transaksi['kode_invoice']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f1f1f1; font-family: 'Courier New', Courier, monospace; }
        .receipt-container {
            max-width: 380px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        .dotted-line {
            border-top: 2px dotted #000;
            margin: 15px 0;
            opacity: 0.5;
        }
        .text-header { font-family: sans-serif; }
        @media print {
            body { background: #fff; }
            .receipt-container { 
                box-shadow: none; 
                margin: 0; 
                padding: 10px; 
                max-width: 100%; 
            }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="text-center mb-1 text-header">
        <h4 class="fw-bold mb-0">WARTEG 88</h4>
        <small class="d-block">Sajian Tradisional Indonesia</small>
        <small>Jl. Pahlawan No. 28, Samarinda</small>
    </div>
    
    <div class="dotted-line"></div>
    
    <div class="mb-2" style="font-size: 0.85rem;">
        <div class="d-flex justify-content-between"><span>Inv:</span><span><?= htmlspecialchars($transaksi['kode_invoice']) ?></span></div>
        <div class="d-flex justify-content-between"><span>Tgl:</span><span><?= date('d/m/Y H:i', strtotime($transaksi['tanggal'])) ?></span></div>
        <div class="d-flex justify-content-between"><span>Ksr:</span><span><?= htmlspecialchars($transaksi['nama_lengkap']) ?></span></div>
    </div>
    
    <div class="dotted-line"></div>
    
    <div style="font-size: 0.9rem;">
        <?php while($item = $details->fetch_assoc()): ?>
        <div class="mb-2">
            <div class="fw-bold text-uppercase"><?= htmlspecialchars($item['nama_menu']) ?></div>
            <div class="d-flex justify-content-between">
                <span><?= $item['qty'] ?> x <?= number_format($item['harga_satuan'],0,',','.') ?></span>
                <span><?= number_format($item['subtotal'],0,',','.') ?></span>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <div class="dotted-line"></div>
    
    <div class="d-flex justify-content-between fw-bold mb-1">
        <span>TOTAL</span>
        <span>Rp <?= number_format($transaksi['total_harga'],0,',','.') ?></span>
    </div>
    <div class="d-flex justify-content-between mb-1">
        <span>BAYAR</span>
        <span>Rp <?= number_format($transaksi['bayar'],0,',','.') ?></span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span>KEMBALI</span>
        <span>Rp <?= number_format($transaksi['kembalian'],0,',','.') ?></span>
    </div>
    
    <div class="dotted-line"></div>
    
    <div class="text-center mt-3 text-header">
        <small class="d-block fw-bold italic">Matur Nuwun!</small>
        <small>Simpan struk ini sebagai bukti pembayaran</small>
    </div>
</div>

<div class="text-center mt-4 no-print mb-5">
    <button onclick="window.print()" class="btn btn-dark shadow-sm me-2">
        <i class="fas fa-print me-2"></i> Cetak Struk
    </button>
    <a href="transaksi.php" class="btn btn-outline-success shadow-sm">
        <i class="fas fa-plus me-2"></i> Transaksi Baru
    </a>
</div>

</body>
</html>