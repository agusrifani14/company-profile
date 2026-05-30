<?php
/**
 * pages/klien.php - Halaman Klien
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Klien Kami';

// Ambil klien
try {
    $stmt = $pdo->query("SELECT * FROM klien ORDER BY created_at DESC");
    $klien_list = $stmt->fetchAll();
} catch (Exception $e) {
    $klien_list = [];
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Klien Kami</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Klien Kami</h1>
        <p class="lead">Perusahaan-perusahaan terpercaya yang telah bekerja sama dengan kami</p>
    </div>
</section>

<!-- Klien Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php if (count($klien_list) > 0): ?>
                <?php foreach ($klien_list as $klien): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div style="height: 100px; background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                                <?php if ($klien['logo']): ?>
                                    <img src="<?php echo APP_URL; ?>/assets/uploads/<?php echo $klien['logo']; ?>" alt="<?php echo $klien['nama']; ?>" style="max-height: 80px; max-width: 100%;">
                                <?php else: ?>
                                    <i class="bi bi-building" style="font-size: 3rem; color: white; opacity: 0.5;"></i>
                                <?php endif; ?>
                            </div>
                            <h5 class="card-title fw-bold"><?php echo $klien['nama']; ?></h5>
                            <p class="card-text text-muted"><?php echo $klien['deskripsi']; ?></p>
                            <?php if ($klien['website']): ?>
                                <a href="<?php echo $klien['website']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-globe"></i> Visit
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Daftar klien belum ada</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
