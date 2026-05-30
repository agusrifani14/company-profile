<?php
/**
 * pages/artikel.php - Halaman Daftar Artikel
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Artikel';

// Ambil artikel berdasarkan kategori atau slug
$kategori = $_GET['kategori'] ?? '';
$slug = $_GET['slug'] ?? '';
$artikel_detail = null;
$artikel_list = [];

try {
    if ($slug) {
        // Tampilkan artikel detail
        $stmt = $pdo->prepare("SELECT * FROM artikel WHERE slug = ? AND status = 'publish'");
        $stmt->execute([$slug]);
        $artikel_detail = $stmt->fetch();
    } else {
        // Tampilkan daftar artikel
        if ($kategori) {
            $stmt = $pdo->prepare("SELECT * FROM artikel WHERE kategori = ? AND status = 'publish' ORDER BY created_at DESC");
            $stmt->execute([$kategori]);
        } else {
            $stmt = $pdo->query("SELECT * FROM artikel WHERE status = 'publish' ORDER BY created_at DESC");
        }
        $artikel_list = $stmt->fetchAll();
    }
} catch (Exception $e) {
    // Error handling
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Artikel</li>
        </ol>
    </div>
</nav>

<?php if ($artikel_detail): ?>
    <!-- Artikel Detail -->
    <article class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="mb-3 fw-bold"><?php echo $artikel_detail['judul']; ?></h1>
                    <div class="text-muted mb-4">
                        <small>
                            <i class="bi bi-person"></i> <?php echo $artikel_detail['penulis']; ?> | 
                            <i class="bi bi-calendar"></i> <?php echo tanggalIndonesia(substr($artikel_detail['created_at'], 0, 10)); ?> |
                            <i class="bi bi-tag"></i> <span class="badge bg-primary"><?php echo $artikel_detail['kategori']; ?></span>
                        </small>
                    </div>
                    
                    <div class="artikel-content">
                        <?php echo $artikel_detail['konten']; ?>
                    </div>
                    
                    <hr class="my-5">
                    <a href="<?php echo APP_URL; ?>/pages/artikel.php" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left"></i> Kembali ke Artikel
                    </a>
                </div>
            </div>
        </div>
    </article>
<?php else: ?>
    <!-- Daftar Artikel -->
    <section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Artikel & Tips</h1>
            <p class="lead">Informasi terbaru seputar teknologi informasi</p>
        </div>
    </section>
    
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <?php foreach ($artikel_list as $artikel): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm border-0 artikel-card">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $artikel['judul']; ?></h5>
                            <p class="card-text text-muted"><?php echo substr(strip_tags($artikel['konten']), 0, 100); ?>...</p>
                            <div class="mb-3">
                                <span class="badge bg-primary"><?php echo $artikel['kategori']; ?></span>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> <?php echo tanggalIndonesia(substr($artikel['created_at'], 0, 10)); ?>
                            </small>
                            <br><br>
                            <a href="<?php echo APP_URL; ?>/pages/artikel.php?slug=<?php echo $artikel['slug']; ?>" class="btn btn-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
