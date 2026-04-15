<?php
$role = $_SESSION['role'] ?? 'Petugas';
$nama = $_SESSION['nama_lengkap'] ?? 'User';

setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id_ID.UTF-8', 'Indonesian');
$tanggal_sekarang = strftime('%A, %d %B %Y'); 
?>
<nav class="navbar navbar-expand bg-white topbar mb-4 static-top shadow-sm px-4">

    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3 text-brown">
        <i class="fa fa-bars"></i>
    </button>

    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100">
        <h5 class="mb-0 text-dark fw-bold" style="font-family: 'Philosopher', sans-serif;">
            Selamat Datang, <?= htmlspecialchars($nama) ?>!
        </h5>
        <small class="text-muted"><i class="far fa-clock me-1"></i> <?= $tanggal_sekarang ?></small>
    </div>

    <ul class="navbar-nav ms-auto">
    
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="text-end me-3 d-none d-lg-inline">
                    <p class="mb-0 small fw-bold text-dark"><?= htmlspecialchars($nama) ?></p>
                    <p class="mb-0 x-small text-muted" style="font-size: 0.7rem;"><?= ucfirst($role) ?></p>
                </div>
                <img class="img-profile rounded-circle border" 
                     src="<?= BASE_URL ?>/assets/img/default-avatar.png" 
                     width="40" height="40" 
                     alt="Profile"
                     style="object-fit: cover; border-color: #3E2723;">
            </a>
            
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 animated--grow-in mt-3" aria-labelledby="userDropdown">
                <li>
                    <h6 class="dropdown-header d-flex align-items-center py-3">
                        <i class="fas fa-user-shield me-2 text-brown"></i>
                        Status: <?= ucfirst($role) ?>
                    </h6>
                </li>
                <li><hr class="dropdown-divider my-0"></li>
                <li>
                    <a class="dropdown-item py-2" href="#">
                        <i class="fas fa-cog fa-sm fa-fw me-2 text-muted"></i> Pengaturan Akun
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-danger py-2" href="<?= BASE_URL ?>/auth/logout.php" onclick="return confirm('Yakin ingin keluar dari sistem?')">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Keluar (Logout)
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<style>
    .text-brown { color: #3E2723; }
    .x-small { font-size: 0.75rem; }
    .dropdown-item:active { background-color: #3E2723; }
    
    .animated--grow-in {
        animation-name: growIn;
        animation-duration: 200ms;
        animation-timing-function: transform cubic-bezier(.18,1.25,.4,1),opacity cubic-bezier(0,1,.4,1);
    }

    @keyframes growIn {
        0% { transform: scale(.9); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>