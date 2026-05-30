<?php
/**
 * pages/about.php - Halaman About Us
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';
$page_title = 'About Us';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">About Us</li>
        </ol>
    </div>
</nav>

<!-- Hero -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Tentang Agus Tech Solution</h1>
        <p class="lead">Mitra teknologi terpercaya untuk transformasi digital bisnis Anda</p>
    </div>
</section>

<!-- Content -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Siapa Kami?</h2>
                <p>Agus Tech Solution adalah perusahaan layanan teknologi informasi yang didirikan dengan misi untuk membantu bisnis Indonesia bertransformasi secara digital.</p>
                <p>Dengan pengalaman lebih dari 8 tahun, kami telah membantu ratusan klien dari berbagai industri mencapai tujuan bisnis mereka melalui solusi teknologi yang inovatif dan terpercaya.</p>
                <p>Tim kami terdiri dari profesional bersertifikat di bidang web development, mobile app development, dan sistem informasi.</p>
            </div>
            <div class="col-lg-6">
                <div style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people-fill" style="font-size: 8rem; color: white; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <!-- Why Choose Us -->
        <h2 class="fw-bold mb-5 text-center">Mengapa Memilih Agus Tech Solution?</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div><i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #1a56db;"></i></div>
                    <div>
                        <h5 class="fw-bold">Tim Profesional</h5>
                        <p class="text-muted">Tim kami terdiri dari developer berpengalaman dan bersertifikat internasional.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div><i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #06b6d4;"></i></div>
                    <div>
                        <h5 class="fw-bold">Solusi Customized</h5>
                        <p class="text-muted">Kami memberikan solusi yang disesuaikan dengan kebutuhan unik bisnis Anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div><i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #059669;"></i></div>
                    <div>
                        <h5 class="fw-bold">Support 24/7</h5>
                        <p class="text-muted">Tim support kami siap membantu Anda kapan saja Anda membutuhkan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div><i class="bi bi-check-circle-fill" style="font-size: 2rem; color: #f59e0b;"></i></div>
                    <div>
                        <h5 class="fw-bold">Harga Kompetitif</h5>
                        <p class="text-muted">Kami menawarkan harga terbaik tanpa mengorbankan kualitas layanan.</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5">

   <!-- Achievement -->
        <h2 class="fw-bold mb-5 text-center">Pencapaian Kami</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="bg-light p-4 rounded">
                    <h3 class="fw-bold text-primary mb-2">50+</h3>
                    <p>Proyek Selesai dengan Sukses</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light p-4 rounded">
                    <h3 class="fw-bold text-primary mb-2">30+</h3>
                    <p>Klien Puas & Setia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-light p-4 rounded">
                    <h3 class="fw-bold text-primary mb-2">8</h3>
                    <p>Tahun Pengalaman</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
