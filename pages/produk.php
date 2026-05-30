<?php
/**
 * pages/produk.php - Halaman Produk/Jasa
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Produk & Jasa';

// Ambil semua produk
try {
    $stmt = $pdo->query("SELECT * FROM produk WHERE status = 'aktif' ORDER BY created_at DESC");
    $produk_list = $stmt->fetchAll();
} catch (Exception $e) {
    $produk_list = [];
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Produk & Jasa</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title mb-3">Produk & Jasa Kami</h1>
            <p class="hero-description">Solusi teknologi informasi lengkap untuk kesuksesan bisnis Anda dengan harga kompetitif</p>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="py-5">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Solusi Bisnis Terpadu</h2>
            <p class="section-subtitle">Pilih layanan yang sesuai dengan kebutuhan perusahaan Anda</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($produk_list as $produk): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card product-card h-100">
                    <div class="card-header">
                        <div class="stat-icon" style="background: transparent; color: white; font-size: 2rem;">
                            <i class="bi <?php echo $produk['icon'] ?? 'bi-box'; ?>"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                        <p class="card-text"><?php echo substr($produk['deskripsi'], 0, 150); ?></p>
                        
                        <?php if ($produk['fitur']): ?>
                            <div class="mb-3">
                                <strong class="d-block mb-2">Fitur Utama:</strong>
                                <ul class="small ps-3">
                                    <?php 
                                    $fitur_list = array_slice(explode(',', $produk['fitur']), 0, 3);
                                    foreach ($fitur_list as $fitur): 
                                    ?>
                                        <li class="mb-1">✓ <?php echo trim($fitur); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($produk['harga']): ?>
                            <p class="fw-bold text-primary mb-3" style="font-size: 1.2rem;"><?php echo $produk['harga']; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="card-body pt-0">
                        <a href="<?php echo APP_URL; ?>/pages/kontak.php" class="btn btn-primary w-100">
                            <i class="bi bi-telephone"></i> Konsultasi Gratis
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if (count($produk_list) == 0): ?>
        <div class="text-center py-5">
            <p class="text-muted">Belum ada produk tersedia</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
