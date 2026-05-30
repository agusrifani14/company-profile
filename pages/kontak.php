<?php
/**
 * pages/kontak.php - Halaman Kontak
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

$page_title = 'Kontak Kami';
$message = '';

// Proses form kontak jika POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean($_POST['nama'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $no_telp = clean($_POST['no_telp'] ?? '');
    $pesan = clean($_POST['pesan'] ?? '');
    
    if ($nama && $email && $pesan) {
        // Simpan ke file log atau kirim email (sesuai kebutuhan)
        $message = 'Terima kasih! Pesan Anda telah kami terima. Kami akan menghubungi Anda segera.';
    } else {
        $message = 'Silakan isi semua field yang wajib!';
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="bg-light py-3">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo APP_URL; ?>/index.php">Home</a></li>
            <li class="breadcrumb-item active">Kontak</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Hubungi Kami</h1>
        <p class="lead">Siap membantu menjawab pertanyaan dan kebutuhan Anda</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Form -->
            <div class="col-lg-7">
                <h3 class="mb-4 fw-bold">Kirim Pesan</h3>
                
                <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="no_telp" name="no_telp">
                    </div>
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan *</label>
                        <textarea class="form-control" id="pesan" name="pesan" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-send"></i> Kirim Pesan
                    </button>
                </form>
            </div>
            
            <!-- Contact Info -->
            <div class="col-lg-5">
                <h3 class="mb-4 fw-bold">Informasi Kontak</h3>
                
                <div class="mb-4">
                    <h5 class="mb-2"><i class="bi bi-geo-alt-fill text-primary"></i> Alamat</h5>
                    <p class="text-muted">
                        Jl. Demang IV No. 4023<br>
                        Palembang, Sumatera Selatan 40123<br>
                        Indonesia
                    </p>
                </div>
                
                <div class="mb-4">
                    <h5 class="mb-2"><i class="bi bi-telephone-fill text-primary"></i> Telepon</h5>
                    <p class="text-muted">
                        <a href="tel:+622723456789" class="text-decoration-none">+62 272 3456789</a><br>
                        <a href="tel:+6281234567890" class="text-decoration-none">+62 812 3456 7890</a>
                    </p>
                </div>
                
                <div class="mb-4">
                    <h5 class="mb-2"><i class="bi bi-envelope-fill text-primary"></i> Email</h5>
                    <p class="text-muted">
                        <a href="mailto:info@agustechsolution.com" class="text-decoration-none">info@agustechsolution.com</a><br>
                        <a href="mailto:sales@agustechsolution.com" class="text-decoration-none">sales@agustechsolution.com</a>
                    </p>
                </div>
                
                <div class="mb-4">
                    <h5 class="mb-2"><i class="bi bi-clock-fill text-primary"></i> Jam Kerja</h5>
                    <p class="text-muted">
                        Senin - Jumat: 08:00 - 17:00<br>
                        Sabtu: 09:00 - 13:00<br>
                        Minggu: Tutup
                    </p>
                </div>
                
                <div>
                    <h5 class="mb-2"><i class="bi bi-chat-dots-fill text-primary"></i> Media Sosial</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
