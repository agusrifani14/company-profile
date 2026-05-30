<?php
/**
 * pages/gallery.php - Halaman Gallery dengan Carousel
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 * @noinspection PhpUndefinedClassInspection
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Gallery';

// Ambil gallery
try {
    $stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
    $gallery_list = $stmt->fetchAll();
} catch (Exception $e) {
    $gallery_list = [];
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Gallery</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Gallery Kami</h1>
        <p class="lead">Dokumentasi proyek dan kegiatan kami</p>
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php if (count($gallery_list) > 0): ?>
                <?php foreach ($gallery_list as $index => $project): ?>
                    <?php 
                        // Ambil gambar-gambar untuk project ini
                        $stmt = $pdo->prepare("SELECT * FROM gallery_images WHERE gallery_id = ? ORDER BY urutan");
                        $stmt->execute([$project['id']]);
                        $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    ?>
                    <div class="col-lg-4 col-md-6 gallery-item">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden">
                            <!-- Carousel untuk gambar -->
                            <?php if (count($images) > 0): ?>
                                <div id="carousel<?php echo $project['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner" style="height: 250px;">
                                        <?php foreach ($images as $key => $image): ?>
                                            <div class="carousel-item <?php echo ($key === 0) ? 'active' : ''; ?>" style="height: 250px;">
                                                <img src="<?php echo APP_URL; ?>/assets/uploads/<?php echo $image['gambar']; ?>" 
                                                     alt="<?php echo htmlspecialchars($project['judul']); ?>" 
                                                     class="d-block w-100 h-100" 
                                                     style="object-fit: cover;">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Navigation Controls -->
                                    <?php if (count($images) > 1): ?>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $project['id']; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $project['id']; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        </button>
                                        
                                        <!-- Indicators -->
                                        <div class="carousel-indicators position-absolute bottom-0" style="z-index: 10;">
                                            <?php foreach ($images as $key => $image): ?>
                                                <button type="button" data-bs-target="#carousel<?php echo $project['id']; ?>" data-bs-slide-to="<?php echo $key; ?>" 
                                                    class="<?php echo ($key === 0) ? 'active' : ''; ?>" 
                                                    aria-current="<?php echo ($key === 0) ? 'true' : 'false'; ?>"
                                                    style="width: 30px; height: 4px; margin: 0 3px;"></button>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Badge jumlah gambar -->
                                    <div class="position-absolute top-0 end-0 m-2" style="z-index: 5;">
                                        <span class="badge bg-dark" title="Jumlah foto">
                                            <i class="bi bi-images"></i> <?php echo count($images); ?>/4
                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 250px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-image" style="font-size: 4rem; color: white; opacity: 0.3;"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Card Content -->
                            <div class="card-body">
                                <h5 class="card-title fw-bold"><?php echo htmlspecialchars($project['judul']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($project['deskripsi'] ?? '(Tidak ada deskripsi)'); ?></p>
                                <span class="badge bg-primary"><i class="bi bi-tag"></i> <?php echo htmlspecialchars($project['kategori']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">Gallery belum ada data</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .carousel-control-prev, 
    .carousel-control-next {
        background: rgba(0, 0, 0, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.3s ease;
    }
    
    .carousel-control-prev:hover, 
    .carousel-control-next:hover {
        background: rgba(0, 0, 0, 0.6);
    }
    
    .carousel-indicators {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .carousel-indicators button {
        background-color: rgba(255, 255, 255, 0.6);
        border-radius: 2px;
        opacity: 0.8;
    }
    
    .carousel-indicators button.active {
        background-color: white;
        opacity: 1;
    }
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>
