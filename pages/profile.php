<?php
/**
 * pages/profile.php - Halaman Profile Perusahaan
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Profile Perusahaan';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Profile Perusahaan</h1>
        <p class="lead">Mengenal lebih jauh tentang Agus Tech Solution</p>
    </div>
</section>

<!-- Profile Content -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Tentang Agus Tech Solution</h2>
                <p>Agus Tech Solution adalah perusahaan yang bergerak di bidang Teknologi Informasi dan Layanan Digital. Kami telah melayani berbagai klien dari berbagai industri selama lebih dari 8 tahun.</p>
                <p>Dengan tim profesional dan berpengalaman, kami siap memberikan solusi teknologi terbaik yang disesuaikan dengan kebutuhan bisnis Anda.</p>
            </div>
            <div class="col-lg-6">
                <div style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-building" style="font-size: 8rem; color: white; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        
        <!-- Sejarah -->
        <div class="row g-5 mb-5">
            <div class="col-lg-6">
                <div style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock-history" style="font-size: 8rem; color: white; opacity: 0.3;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-3">Sejarah Singkat</h2>
                <p>Agus Tech Solution didirikan pada tahun 2016 oleh Agus Rifani dengan visi untuk membawa perubahan digital di Indonesia. Dimulai dari layanan web development sederhana, kami berkembang menjadi perusahaan yang menyediakan solusi IT komprehensif.</p>
                <p>Perjalanan kami penuh dengan pembelajaran dan inovasi, menghasilkan portfolio yang mengesankan dengan berbagai proyek sukses dari startup hingga perusahaan besar.</p>
            </div>
        </div>
        
        <!-- Nilai Perusahaan -->
        <div class="bg-light p-5 rounded mb-5">
            <h3 class="fw-bold mb-4 text-center">Nilai-Nilai Perusahaan</h3>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div>
                        <i class="bi bi-hand-thumbs-up" style="font-size: 3rem; color: #1a56db;"></i>
                        <h5 class="mt-3 fw-bold">Integritas</h5>
                        <p class="text-muted">Kami selalu menjunjung tinggi kejujuran dan transparansi dalam setiap transaksi bisnis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <i class="bi bi-lightning-charge" style="font-size: 3rem; color: #06b6d4;"></i>
                        <h5 class="mt-3 fw-bold">Inovasi</h5>
                        <p class="text-muted">Kami terus berinovasi mengikuti perkembangan teknologi terkini untuk memberikan solusi terdepan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <i class="bi bi-people" style="font-size: 3rem; color: #059669;"></i>
                        <h5 class="mt-3 fw-bold">Kolaborasi</h5>
                        <p class="text-muted">Kami percaya bahwa kerja sama tim yang solid menghasilkan hasil yang luar biasa.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tim -->
        <h3 class="fw-bold mb-4 text-center">Tim Profesional Kami</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow text-center">
                    <div class="card-body">
                        <i class="bi bi-person-circle" style="font-size: 4rem; color: #1a56db;"></i>
                        <h5 class="mt-3">Agus Rifani</h5>
                        <p class="text-muted small">Founder & CEO</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow text-center">
                    <div class="card-body">
                        <i class="bi bi-person-circle" style="font-size: 4rem; color: #06b6d4;"></i>
                        <h5 class="mt-3">Tim Developer</h5>
                        <p class="text-muted small">Expert Web & Mobile</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow text-center">
                    <div class="card-body">
                        <i class="bi bi-person-circle" style="font-size: 4rem; color: #059669;"></i>
                        <h5 class="mt-3">Tim Support</h5>
                        <p class="text-muted small">Dedicated Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
