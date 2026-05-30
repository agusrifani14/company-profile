<?php
/**
 * sidebar.php - Sidebar Kiri Navigasi
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
$base_url = (defined('APP_URL')) ? APP_URL : 'http://localhost/company-profile';
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- ============================================================
     SIDEBAR KIRI
     ============================================================ -->
<aside class="sidebar" id="mainSidebar">

  <!-- Sidebar: Artikel dengan Sub-menu Accordion -->
  <div class="sidebar-card">
    <div class="sidebar-card-header">
      <i class="bi bi-newspaper"></i> Artikel
    </div>
    <div class="sidebar-card-body">

      <!-- Toggle: Semua Artikel -->
      <a href="<?= $base_url ?>/pages/artikel.php"
         class="sidebar-nav-link <?= ($current_page==='artikel.php') ? 'active' : '' ?>">
        <i class="bi bi-grid-3x3-gap"></i> Semua Artikel
      </a>

      <!-- Accordion: Kategori Artikel -->
      <a href="#artikelKategori" class="sidebar-nav-link" data-bs-toggle="collapse" aria-expanded="true" style="justify-content:space-between;">
        <span><i class="bi bi-tags"></i> Kategori</span>
        <i class="bi bi-chevron-down chevron-icon" style="transition:transform 0.3s;font-size:0.75rem;"></i>
      </a>
      <div class="collapse show" id="artikelKategori">
        <ul class="sidebar-submenu">
          <li>
            <a href="<?= $base_url ?>/pages/artikel.php?kategori=Konsep+Teknologi+Informasi">
              <i class="bi bi-cpu"></i> Konsep Teknologi Informasi
            </a>
          </li>
          <li>
            <a href="<?= $base_url ?>/pages/artikel.php?kategori=Web+Development">
              <i class="bi bi-code-slash"></i> Web Development
            </a>
          </li>
          <li>
            <a href="<?= $base_url ?>/pages/artikel.php?kategori=Sistem+Informasi">
              <i class="bi bi-diagram-3"></i> Sistem Informasi
            </a>
          </li>
          <li>
            <a href="<?= $base_url ?>/pages/artikel.php?kategori=Keamanan+Website">
              <i class="bi bi-shield-check"></i> Keamanan Website
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div><!-- end sidebar-card Artikel -->

  <!-- Sidebar: Event -->
  <div class="sidebar-card">
    <div class="sidebar-card-header">
      <i class="bi bi-calendar-event"></i> Event & Kegiatan
    </div>
    <div class="sidebar-card-body">
      <a href="<?= $base_url ?>/pages/event.php"
         class="sidebar-nav-link <?= ($current_page==='event.php') ? 'active' : '' ?>">
        <i class="bi bi-calendar-check"></i> Semua Event
      </a>
      <a href="<?= $base_url ?>/pages/event.php?status=upcoming"
         class="sidebar-nav-link">
        <i class="bi bi-clock"></i> Upcoming Event
      </a>
      <a href="<?= $base_url ?>/pages/event.php?status=selesai"
         class="sidebar-nav-link">
        <i class="bi bi-check-circle"></i> Event Selesai
      </a>
    </div>
  </div>

  <!-- Sidebar: Gallery Foto -->
  <div class="sidebar-card">
    <div class="sidebar-card-header">
      <i class="bi bi-images"></i> Gallery Foto
    </div>
    <div class="sidebar-card-body">
      <a href="<?= $base_url ?>/pages/gallery.php"
         class="sidebar-nav-link <?= ($current_page==='gallery.php') ? 'active' : '' ?>">
        <i class="bi bi-grid"></i> Lihat Gallery
      </a>
    </div>
  </div>

  <!-- Sidebar: Klien Kami -->
  <div class="sidebar-card">
    <div class="sidebar-card-header">
      <i class="bi bi-people-fill"></i> Klien Kami
    </div>
    <div class="sidebar-card-body">
      <a href="<?= $base_url ?>/pages/klien.php"
         class="sidebar-nav-link <?= ($current_page==='klien.php') ? 'active' : '' ?>">
        <i class="bi bi-briefcase"></i> Daftar Klien
      </a>
    </div>
  </div>

  <!-- Sidebar: Login / Auth -->
  <div class="sidebar-card">
    <div class="sidebar-card-header">
      <i class="bi bi-person-circle"></i>
      <?= isset($_SESSION['user_id']) ? 'Akun Saya' : 'Akun' ?>
    </div>
    <div class="sidebar-card-body p-3">
      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Sudah login -->
        <div class="d-flex align-items-center gap-2 mb-3 p-2 rounded" style="background:rgba(26,86,219,0.06);">
          <div style="width:36px;height:36px;background:linear-gradient(135deg,#1a56db,#06b6d4);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.9rem;">
            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
          </div>
          <div>
            <div style="font-weight:600;font-size:0.85rem;"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></div>
            <div style="font-size:0.72rem;color:#64748b;"><?= ucfirst($_SESSION['user_role'] ?? '') ?></div>
          </div>
        </div>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
          <a href="<?= $base_url ?>/admin/dashboard.php" class="sidebar-auth-btn btn-signin mb-2">
            <i class="bi bi-speedometer2"></i> Dashboard Admin
          </a>
        <?php endif; ?>
        <a href="<?= $base_url ?>/auth/logout.php" class="sidebar-auth-btn btn-signup"
           style="color:#ef4444;border-color:#ef4444;"
           onclick="return confirm('Yakin ingin logout?')">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      <?php else: ?>
        <!-- Belum login -->
        <a href="<?= $base_url ?>/auth/login.php" class="sidebar-auth-btn btn-signin" id="sidebarLoginBtn">
          <i class="bi bi-box-arrow-in-right"></i> Sign In / Login
        </a>
        <a href="<?= $base_url ?>/auth/register.php" class="sidebar-auth-btn btn-signup" id="sidebarRegisterBtn">
          <i class="bi bi-person-plus"></i> Sign Up / Daftar
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Sidebar: Info Perusahaan -->
  <div class="sidebar-card">
    <div class="sidebar-card-header">
      <i class="bi bi-info-circle"></i> Info
    </div>
    <div class="sidebar-card-body p-3">
      <p style="font-size:0.82rem;color:#64748b;margin-bottom:10px;line-height:1.6;">
        <i class="bi bi-geo-alt text-primary me-1"></i>
        Jl. Demang IV No. 4023, Palembang, Sumatera Selatan
      </p>
      <p style="font-size:0.82rem;color:#64748b;margin-bottom:10px;">
        <i class="bi bi-telephone text-primary me-1"></i>
        +62 812-3456-7890
      </p>
      <p style="font-size:0.82rem;color:#64748b;margin-bottom:0;">
        <i class="bi bi-envelope text-primary me-1"></i>
        info@agustechsolution.com
      </p>
    </div>
  </div>

</aside><!-- end sidebar -->
