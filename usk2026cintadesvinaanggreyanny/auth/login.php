<?php
require_once '../config/database.php';

if (isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Warteg 88 Tradisional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher:wght@400;700&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-trad: #5D4037; 
            --secondary-trad: #8D6E63; 
            --accent-trad: #2E7D32; 
            --bg-trad: #F5F5DC; 
        }

        body {
            background-color: var(--bg-trad);
            background-image: url("https://www.transparenttextures.com/patterns/batik-dots.png");
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            background: #ffffff;
            border: 3px solid var(--primary-trad) !important;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .auth-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--primary-trad), var(--accent-trad), var(--primary-trad));
        }

        h1 {
            font-family: 'Philosopher', sans-serif;
            color: var(--primary-trad);
            letter-spacing: 1px;
        }

        .btn-tradisional {
            background-color: var(--primary-trad);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-tradisional:hover {
            background-color: var(--accent-trad);
            color: #fff;
            transform: translateY(-2px);
        }

        .form-control {
            border: 1px solid #d1ccc0;
            border-radius: 8px !important;
        }

        .form-control:focus {
            border-color: var(--secondary-trad);
            box-shadow: 0 0 0 0.25rem rgba(141, 110, 99, 0.25);
        }

        .alert-danger {
            background-color: #ffebee;
            border: 1px solid #c62828;
            color: #c62828;
            border-radius: 8px;
        }

        .trad-decoration {
            font-size: 0.8rem;
            color: var(--secondary-trad);
            text-transform: uppercase;
            letter-spacing: 2px;
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-7">
                <div class="card auth-card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <span class="trad-decoration">~ Sugeng Rawuh ~</span>
                            <h1 class="h2 fw-bold">Warteg 88</h1>
                            <div style="width: 50px; height: 2px; background: var(--secondary-trad); margin: 10px auto;"></div>
                            <p class="text-muted small">Silakan masuk untuk mengelola warung hari ini.</p>
                        </div>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger text-center small py-2">
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= BASE_URL ?>/auth/process_login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label small fw-bold text-secondary">Nama Pengguna</label>
                                <input type="text" class="form-control py-2" id="username" name="username" placeholder="Masukkan username..." required autofocus>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi</label>
                                <input type="password" class="form-control py-2" id="password" name="password" placeholder="Masukkan password..." required>
                            </div>
                            <button type="submit" class="btn btn-tradisional w-100 py-2 fw-bold shadow-sm">
                                LOGIN
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted" style="font-style: italic;">"Rasa Tradisional, Layanan Profesional"</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>