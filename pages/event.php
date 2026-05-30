<?php
/**
 * pages/event.php - Halaman Event
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Event';

// Ambil event
try {
    $stmt = $pdo->query("SELECT * FROM event ORDER BY tanggal ASC");
    $event_list = $stmt->fetchAll();
} catch (Exception $e) {
    $event_list = [];
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Event</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Event & Workshop</h1>
        <p class="lead">Acara dan pelatihan teknologi untuk meningkatkan skill Anda</p>
    </div>
</section>

<!-- Events Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($event_list as $event): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="badge bg-<?php echo ($event['status'] == 'upcoming') ? 'success' : 'secondary'; ?>">
                                <?php echo ucfirst($event['status']); ?>
                            </span>
                        </div>
                        <h5 class="card-title fw-bold"><?php echo $event['judul']; ?></h5>
                        <p class="card-text text-muted"><?php echo $event['deskripsi']; ?></p>
                        
                        <div class="mb-3">
                            <p class="mb-2">
                                <strong><i class="bi bi-calendar-event text-primary"></i> Tanggal:</strong><br>
                                <?php echo tanggalIndonesia($event['tanggal']); ?>
                            </p>
                            <?php if ($event['waktu_event']): ?>
                                <p class="mb-2">
                                    <strong><i class="bi bi-clock text-primary"></i> Waktu:</strong><br>
                                    <?php echo substr($event['waktu_event'], 0, 5); ?>
                                </p>
                            <?php endif; ?>
                            <p>
                                <strong><i class="bi bi-geo-alt text-primary"></i> Lokasi:</strong><br>
                                <?php echo $event['lokasi']; ?>
                            </p>
                        </div>
                        
                        <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#eventModal<?php echo $event['id']; ?>">
                            Lihat Detail & Daftar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="eventModal<?php echo $event['id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><?php echo $event['judul']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Tanggal:</strong> <?php echo tanggalIndonesia($event['tanggal']); ?></p>
                            <p><strong>Lokasi:</strong> <?php echo $event['lokasi']; ?></p>
                            <p><strong>Deskripsi:</strong><br><?php echo nl2br($event['deskripsi']); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="<?php echo APP_URL; ?>/pages/kontak.php" class="btn btn-primary">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
