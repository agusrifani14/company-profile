<?php
/**
 * index.php - Halaman Utama / Homepage
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'config/koneksi.php';

$page_title = 'Home';

// Ambil data untuk hero banner, produk terbaru, artikel terbaru, event
try {
    // Ambil produk (batas 6)
    $stmt_produk = $pdo->prepare("SELECT id, nama, deskripsi, gambar, icon FROM produk WHERE status = 'aktif' LIMIT 6");
    $stmt_produk->execute();
    $produk_list = $stmt_produk->fetchAll();
    
    // Ambil artikel terbaru (batas 3)
    $stmt_artikel = $pdo->prepare("SELECT id, judul, slug, deskripsi, gambar, created_at FROM artikel WHERE status = 'publish' ORDER BY created_at DESC LIMIT 3");
    $stmt_artikel->execute();
    $artikel_terbaru = $stmt_artikel->fetchAll();
    
    // Ambil event mendatang (batas 3)
    $stmt_event = $pdo->prepare("SELECT id, judul, deskripsi, tanggal, lokasi FROM event WHERE status = 'upcoming' ORDER BY tanggal ASC LIMIT 3");
    $stmt_event->execute();
    $event_mendatang = $stmt_event->fetchAll();
    
    // Hitung klien
    $stmt_klien = $pdo->query("SELECT COUNT(*) as total FROM klien");
    $klien_total = $stmt_klien->fetch()['total'];
    
} catch (Exception $e) {
    $produk_list = [];
    $artikel_terbaru = [];
    $event_mendatang = [];
    $klien_total = 0;
}

?>
<?php include 'includes/header.php'; ?>

<!-- ============================================================
     HERO SECTION / BANNER UTAMA
     ============================================================ -->
<section class="hero-section">
    <div class="container-fluid hero-content">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 col-md-8 mx-auto text-center text-lg-start px-4">
                <div class="hero-text" data-aos="fade-up">
                    <span class="hero-subtitle">
                        <i class="bi bi-lightning-charge"></i> Transformasi Digital Dimulai dari Sini
                    </span>
                    <h1 class="hero-title">
                        Solusi Teknologi Informasi Terpercaya
                    </h1>
                    <p class="hero-description">
                        Kami membantu bisnis Anda berkembang dengan layanan IT profesional, inovatif, dan terjangkau. Dari pembuatan website hingga sistem informasi terintegrasi.
                    </p>
                    <div class="hero-buttons gap-3 mt-4">
                        <a href="pages/produk.php" class="btn btn-primary btn-lg">
                            <i class="bi bi-arrow-right"></i> Lihat Produk/Jasa
                        </a>
                        <a href="pages/kontak.php" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-telephone"></i> Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-illustration">
                    <i class="bi bi-cpu" style="font-size: 20rem; color: rgba(26, 86, 219, 0.15);"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     STATISTIK / HIGHLIGHT
     ============================================================ -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card text-center">
                    <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="stat-number fw-bold text-primary">50+</div>
                    <div class="stat-label text-dark">Proyek Selesai</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card text-center">
                    <div class="stat-icon"><i class="bi bi-people"></i></div>
                    <div class="stat-number fw-bold text-primary"><?php echo $klien_total; ?>+</div>
                    <div class="stat-label text-dark">Klien Puas</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card text-center">
                    <div class="stat-icon"><i class="bi bi-award"></i></div>
                    <div class="stat-number fw-bold text-primary">8</div>
                    <div class="stat-label text-dark">Tahun Pengalaman</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card text-center">
                    <div class="stat-icon"><i class="bi bi-star-fill"></i></div>
                    <div class="stat-number fw-bold text-primary">4.9/5</div>
                    <div class="stat-label text-dark">Rating Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     PRODUK / JASA TERBARU
     ============================================================ -->
<section class="py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Produk & Layanan Kami</h2>
            <p class="section-subtitle">Solusi teknologi informasi lengkap untuk mengembangkan bisnis Anda</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($produk_list as $item): ?>
            <div class="col-lg-4 col-md-6">
                <div class="product-card h-100">
                    <div class="product-icon">
                        <i class="bi <?php echo $item['icon'] ?? 'bi-box'; ?>"></i>
                    </div>
                    <h5 class="product-title"><?php echo $item['nama']; ?></h5>
                    <p class="product-description"><?php echo substr($item['deskripsi'], 0, 100); ?>...</p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="pages/produk.php" class="btn btn-sm btn-primary">Detail</a>
                        <a href="pages/kontak.php" class="btn btn-sm btn-outline-primary">Konsultasi</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="pages/produk.php" class="btn btn-lg btn-primary">Lihat Semua Produk & Jasa</a>
        </div>
    </div>
</section>

<!-- ============================================================
     ARTIKEL TERBARU
     ============================================================ -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Artikel Terbaru</h2>
            <p class="section-subtitle">Tips, tren, dan insight seputar dunia teknologi informasi</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($artikel_terbaru as $artikel): ?>
            <div class="col-lg-4 col-md-6">
                <div class="article-card h-100">
                    <div class="article-image" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); height: 200px; border-radius: 8px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-file-text" style="font-size: 3rem; color: white; opacity: 0.5;"></i>
                    </div>
                    <h5 class="article-title"><?php echo $artikel['judul']; ?></h5>
                    <p class="article-excerpt"><?php echo substr(strip_tags($artikel['deskripsi']), 0, 80); ?>...</p>
                    <small class="text-muted">
                        <i class="bi bi-calendar"></i> <?php echo tanggalIndonesia(substr($artikel['created_at'], 0, 10)); ?>
                    </small>
                    <a href="pages/artikel.php?slug=<?php echo $artikel['slug']; ?>" class="btn btn-sm btn-primary mt-3">Baca Selengkapnya</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="pages/artikel.php" class="btn btn-lg btn-primary">Lihat Semua Artikel</a>
        </div>
    </div>
</section>

<!-- ============================================================
     EVENT MENDATANG
     ============================================================ -->
<section class="py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Event Mendatang</h2>
            <p class="section-subtitle">Jangan lewatkan event dan workshop teknologi kami</p>
        </div>
        
        <div class="row g-4">
            <?php foreach ($event_mendatang as $event): ?>
            <div class="col-lg-4 col-md-6">
                <div class="event-card h-100">
                    <div class="event-date">
                        <span class="event-day"><?php echo date('d', strtotime($event['tanggal'])); ?></span>
                        <span class="event-month"><?php echo strtoupper(substr('Jan Feb Mar Apr Mei Jun Jul Agu Sep Okt Nov Des', (date('m', strtotime($event['tanggal'])) - 1) * 3, 3)); ?></span>
                    </div>
                    <h5 class="event-title"><?php echo $event['judul']; ?></h5>
                    <p class="event-location"><i class="bi bi-geo-alt"></i> <?php echo $event['lokasi']; ?></p>
                    <p class="event-description"><?php echo substr($event['deskripsi'], 0, 100); ?>...</p>
                    <a href="pages/event.php" class="btn btn-sm btn-primary">Lihat Detail</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="pages/event.php" class="btn btn-lg btn-primary">Lihat Semua Event</a>
        </div>
    </div>
</section>

<!-- ============================================================
     CALL TO ACTION
     ============================================================ -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h2 class="mb-3">Siap Mengembangkan Bisnis Anda?</h2>
        <p class="mb-4" style="font-size: 1.1rem;">Hubungi kami sekarang untuk konsultasi gratis tentang solusi IT terbaik untuk perusahaan Anda.</p>
        <a href="pages/kontak.php" class="btn btn-light btn-lg">
            <i class="bi bi-envelope"></i> Hubungi Sekarang
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
