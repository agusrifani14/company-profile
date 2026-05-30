<?php
/**
 * pages/visi_misi.php - Halaman Visi & Misi
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Visi & Misi';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Visi & Misi</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Visi & Misi Kami</h1>
        <p class="lead">Komitmen kami untuk masa depan yang lebih baik</p>
    </div>
</section>

<!-- Visi & Misi Content -->
<section class="py-5">
    <div class="container">
        <!-- Visi -->
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6 order-lg-2">
                <h2 class="fw-bold mb-3" style="color: #1a56db;">
                    <i class="bi bi-eye"></i> Visi Kami
                </h2>
                <p class="fs-5 lh-lg">
                    Menjadi mitra teknologi terpercaya yang memberdayakan bisnis Indonesia untuk bertransformasi secara digital dan kompetitif di era globalisasi.
                </p>
                <p class="text-muted lh-lg">
                    Kami percaya bahwa teknologi informasi adalah kunci untuk membuka peluang tak terbatas bagi pertumbuhan dan inovasi bisnis. Dengan memahami kebutuhan unik setiap klien, kami berkomitmen untuk memberikan solusi yang tidak hanya efektif tetapi juga berkelanjutan.
                </p>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-eye" style="font-size: 8rem; color: white; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        
        <!-- Misi -->
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3" style="color: #06b6d4;">
                    <i class="bi bi-rocket"></i> Misi Kami
                </h2>
                <p class="fs-5 lh-lg">
                    Memberikan solusi teknologi informasi yang inovatif, berkualitas tinggi, dan terjangkau untuk membantu bisnis Indonesia berkembang pesat.
                </p>
            </div>
            <div class="col-lg-6">
                <div style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-rocket" style="font-size: 8rem; color: white; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        
        <!-- Misi Details -->
        <div class="bg-light p-5 rounded">
            <h3 class="fw-bold mb-4">Komitmen Kami Dalam Misi:</h3>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div style="font-size: 2rem; color: #1a56db; flex-shrink: 0;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Memberikan Solusi Terbaik</h5>
                            <p class="text-muted mb-0">Kami menganalisis kebutuhan mendalam setiap klien untuk memberikan solusi yang paling sesuai dan efektif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div style="font-size: 2rem; color: #06b6d4; flex-shrink: 0;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Inovasi Berkelanjutan</h5>
                            <p class="text-muted mb-0">Kami terus mengikuti perkembangan teknologi terbaru dan mengintegrasikannya dalam setiap solusi yang kami tawarkan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div style="font-size: 2rem; color: #059669; flex-shrink: 0;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Dukungan Profesional</h5>
                            <p class="text-muted mb-0">Tim kami siap memberikan dukungan penuh sebelum, selama, dan sesudah implementasi proyek.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-3">
                        <div style="font-size: 2rem; color: #f59e0b; flex-shrink: 0;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Harga Kompetitif</h5>
                            <p class="text-muted mb-0">Kami memberikan nilai terbaik untuk investasi Anda tanpa mengorbankan kualitas layanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
