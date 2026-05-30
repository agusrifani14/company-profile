<?php
/**
 * admin/dashboard.php - Admin Dashboard
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

requireAdmin();

$page_title = 'Dashboard Admin';

// Hitung statistik
try {
    $produk_count = $pdo->query("SELECT COUNT(*) as total FROM produk")->fetch()['total'];
    $artikel_count = $pdo->query("SELECT COUNT(*) as total FROM artikel")->fetch()['total'];
    $event_count = $pdo->query("SELECT COUNT(*) as total FROM event")->fetch()['total'];
    $klien_count = $pdo->query("SELECT COUNT(*) as total FROM klien")->fetch()['total'];
    $users_count = $pdo->query("SELECT COUNT(*) as total FROM users")->fetch()['total'];
} catch (Exception $e) {
    $produk_count = $artikel_count = $event_count = $klien_count = $users_count = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Agus Tech Solution</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f7fa;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            color: white;
            min-height: 100vh;
            padding: 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            margin: 10px 0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }
        
        .stat-card .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a56db;
        }
        
        .stat-card .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .top-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="mb-4">
            <h3 class="fw-bold mb-2" style="font-size: 1.2rem;">
                <i class="bi bi-cpu"></i> Agus Tech
            </h3>
            <small>Admin Panel</small>
        </div>
        
        <nav class="nav flex-column">
            <a href="<?php echo APP_URL; ?>/admin/dashboard.php" class="nav-link active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?php echo APP_URL; ?>/admin/produk.php" class="nav-link">
                <i class="bi bi-box"></i> Produk
            </a>
            <a href="<?php echo APP_URL; ?>/admin/artikel.php" class="nav-link">
                <i class="bi bi-file-text"></i> Artikel
            </a>
            <a href="<?php echo APP_URL; ?>/admin/event.php" class="nav-link">
                <i class="bi bi-calendar-event"></i> Event
            </a>
            <a href="<?php echo APP_URL; ?>/admin/gallery.php" class="nav-link">
                <i class="bi bi-image"></i> Gallery
            </a>
            <a href="<?php echo APP_URL; ?>/admin/klien.php" class="nav-link">
                <i class="bi bi-building"></i> Klien
            </a>
            <a href="<?php echo APP_URL; ?>/admin/users.php" class="nav-link">
                <i class="bi bi-people"></i> Users
            </a>
        </nav>
        
        <hr style="border-color: rgba(255,255,255,0.2);">
        
        <div>
            <p class="small mb-2">Logged in as:</p>
            <p class="fw-bold small"><?php echo $_SESSION['username']; ?></p>
            <a href="<?php echo APP_URL; ?>/auth/logout.php" class="btn btn-light btn-sm w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h1 class="mb-0 fw-bold">Dashboard</h1>
                <small class="text-muted">Selamat datang, <?php echo $_SESSION['username']; ?></small>
            </div>
            <div>
                <button class="btn btn-primary">
                    <i class="bi bi-question-circle"></i> Bantuan
                </button>
            </div>
        </div>
        
        <!-- Statistics Row -->
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Produk</div>
                            <div class="stat-number"><?php echo $produk_count; ?></div>
                        </div>
                        <i class="bi bi-box" style="font-size: 2rem; color: #1a56db; opacity: 0.3;"></i>
                    </div>
                    <a href="<?php echo APP_URL; ?>/admin/produk.php" class="btn btn-sm btn-outline-primary mt-3">
                        Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Artikel</div>
                            <div class="stat-number"><?php echo $artikel_count; ?></div>
                        </div>
                        <i class="bi bi-file-text" style="font-size: 2rem; color: #06b6d4; opacity: 0.3;"></i>
                    </div>
                    <a href="<?php echo APP_URL; ?>/admin/artikel.php" class="btn btn-sm btn-outline-primary mt-3">
                        Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Event</div>
                            <div class="stat-number"><?php echo $event_count; ?></div>
                        </div>
                        <i class="bi bi-calendar-event" style="font-size: 2rem; color: #f59e0b; opacity: 0.3;"></i>
                    </div>
                    <a href="<?php echo APP_URL; ?>/admin/event.php" class="btn btn-sm btn-outline-primary mt-3">
                        Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Klien</div>
                            <div class="stat-number"><?php echo $klien_count; ?></div>
                        </div>
                        <i class="bi bi-building" style="font-size: 2rem; color: #059669; opacity: 0.3;"></i>
                    </div>
                    <a href="<?php echo APP_URL; ?>/admin/klien.php" class="btn btn-sm btn-outline-primary mt-3">
                        Kelola
                    </a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Users</div>
                            <div class="stat-number"><?php echo $users_count; ?></div>
                        </div>
                        <i class="bi bi-people" style="font-size: 2rem; color: #dc2626; opacity: 0.3;"></i>
                    </div>
                    <a href="<?php echo APP_URL; ?>/admin/users.php" class="btn btn-sm btn-outline-primary mt-3">
                        Kelola
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Additional Info -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="stat-card">
                    <h5 class="fw-bold mb-3">Informasi Sistem</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Versi PHP:</strong> <?php echo phpversion(); ?></li>
                        <li class="mb-2"><strong>Database:</strong> MySQL</li>
                        <li class="mb-2"><strong>Server:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
                        <li><strong>Tanggal:</strong> <?php echo date('d F Y H:i'); ?></li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="stat-card">
                    <h5 class="fw-bold mb-3">Panduan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">✓ Kelola produk dan jasa yang ditawarkan</li>
                        <li class="mb-2">✓ Publikasikan artikel dan tips teknologi</li>
                        <li class="mb-2">✓ Buat dan kelola event/workshop</li>
                        <li class="mb-2">✓ Kelola data klien dan galeri</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
