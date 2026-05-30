<?php
/**
 * header.php - Bagian Header & Navigasi Utama
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) session_start();

// Tentukan halaman aktif
$current_page = basename($_SERVER['PHP_SELF']);
$base_url = (defined('APP_URL')) ? APP_URL : 'http://localhost/company-profile';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Agus Tech Solution - Layanan Teknologi Informasi Profesional. Pembuatan website, aplikasi, sistem informasi, dan konsultasi IT.">
  <meta name="keywords" content="website, aplikasi, sistem informasi, IT, teknologi, Palembang, developer">
  <meta name="author" content="Agus Rifani">

  <!-- Open Graph -->
  <meta property="og:title" content="Agus Tech Solution - IT Services">
  <meta property="og:description" content="Layanan teknologi informasi profesional untuk bisnis Anda.">
  <meta property="og:type" content="website">

  <title><?= isset($page_title) ? $page_title . ' | ' : '' ?>Agus Tech Solution</title>

  <!-- Bootstrap 5 CSS CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">

  <!-- Favicon (inline SVG as data URI) -->
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%231a56db'/><text y='72' x='14' font-size='60' font-weight='900' fill='white' font-family='monospace'>AT</text></svg>">
</head>
<body class="page-fade">

<!-- ============================================================
     NAVBAR UTAMA
     ============================================================ -->
<nav class="navbar-main">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap gap-2">

    <!-- Brand / Logo + Nama Perusahaan -->
    <a href="<?= $base_url ?>/index.php" class="navbar-brand-wrap">
      <!-- Logo SVG inline -->
      <div class="navbar-logo-svg">AT</div>
      <div class="navbar-title">
        <span class="company-name">Agus Tech Solution</span>
        <span class="company-tagline">IT Services &amp; Digital Solutions</span>
      </div>
    </a>

    <!-- Toggle Mobile -->
   <button class="btn btn-sm d-lg-none me-2" id="mobileSidebarToggle" type="button" aria-label="Buka menu navigasi">
    <i class="bi bi-list fs-5"></i>
  </button>

    <!-- Navigasi Horizontal -->
    <ul class="navbar-nav-main d-none d-lg-flex flex-wrap" id="mainNavbar">

      <!-- Home -->
      <li class="nav-item <?= ($current_page === 'index.php' || $current_page === 'home.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/index.php"><i class="bi bi-house-door"></i> Home</a>
      </li>

      <!-- Profile -->
      <li class="nav-item <?= ($current_page === 'profile.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/profile.php"><i class="bi bi-building"></i> Profile</a>
      </li>

      <!-- Visi Misi -->
      <li class="nav-item <?= ($current_page === 'visi_misi.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/visi_misi.php"><i class="bi bi-bullseye"></i> Visi &amp; Misi</a>
      </li>

      <!-- Produk / Jasa -->
      <li class="nav-item <?= ($current_page === 'produk.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/produk.php"><i class="bi bi-grid"></i> Produk/Jasa</a>
      </li>

      <!-- Artikel Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?= ($current_page === 'artikel.php') ? 'active' : '' ?>"
           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-newspaper"></i> Artikel
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="<?= $base_url ?>/pages/artikel.php">
            <i class="bi bi-grid-3x3-gap"></i> Semua Artikel</a></li>
          <li><hr class="dropdown-divider" style="border-color:rgba(255,255,255,0.1)"></li>
          <li><a class="dropdown-item" href="<?= $base_url ?>/pages/artikel.php?kategori=Konsep+Teknologi+Informasi">
            <i class="bi bi-cpu"></i> Konsep Teknologi Informasi</a></li>
          <li><a class="dropdown-item" href="<?= $base_url ?>/pages/artikel.php?kategori=Web+Development">
            <i class="bi bi-code-slash"></i> Web Development</a></li>
          <li><a class="dropdown-item" href="<?= $base_url ?>/pages/artikel.php?kategori=Sistem+Informasi">
            <i class="bi bi-diagram-3"></i> Sistem Informasi</a></li>
          <li><a class="dropdown-item" href="<?= $base_url ?>/pages/artikel.php?kategori=Keamanan+Website">
            <i class="bi bi-shield-check"></i> Keamanan Website</a></li>
        </ul>
      </li>

      <!-- Event -->
      <li class="nav-item <?= ($current_page === 'event.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/event.php"><i class="bi bi-calendar-event"></i> Event</a>
      </li>

      <!-- Gallery -->
      <li class="nav-item <?= ($current_page === 'gallery.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/gallery.php"><i class="bi bi-images"></i> Gallery</a>
      </li>

      <!-- Klien -->
      <li class="nav-item <?= ($current_page === 'klien.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/klien.php"><i class="bi bi-people"></i> Klien</a>
      </li>

      <!-- About -->
      <li class="nav-item <?= ($current_page === 'about.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/about.php"><i class="bi bi-info-circle"></i> About</a>
      </li>

      <!-- Kontak -->
      <li class="nav-item <?= ($current_page === 'kontak.php') ? 'active' : '' ?>">
        <a href="<?= $base_url ?>/pages/kontak.php"><i class="bi bi-envelope"></i> Kontak</a>
      </li>

      <!-- Auth: tampilkan sesuai status login -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <li class="nav-item">
            <a href="<?= $base_url ?>/admin/dashboard.php" style="background:rgba(26,86,219,0.25);">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a href="<?= $base_url ?>/auth/logout.php" style="background:rgba(239,68,68,0.2);color:rgba(252,165,165,1) !important;">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a href="<?= $base_url ?>/auth/login.php" style="background:rgba(26,86,219,0.25);">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </a>
        </li>
      <?php endif; ?>

    </ul><!-- end navbar nav -->
  </div>
</nav>
<!-- END NAVBAR -->
