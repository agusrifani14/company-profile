<?php
/**
 * admin/gallery.php - Kelola Gallery dengan Multiple Gambar
 * @noinspection PhpUndefinedClassInspection
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';
requireAdmin();

$message = '';
$error = '';

// Handle tambah project
// @noinspection PhpUndefinedVariableInspection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_project') {
    $judul = trim($_POST['judul'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $kategori = trim($_POST['kategori'] ?? 'Umum');
    
    if (empty($judul)) {
        $error = 'Judul project harus diisi!';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO gallery (judul, deskripsi, kategori) VALUES (?, ?, ?)");
            $stmt->execute([$judul, $deskripsi, $kategori]);
            $message = 'Project berhasil ditambahkan! Sekarang upload gambar untuk project ini.';
        } catch (Exception $e) {
            $error = 'Gagal menambah project: ' . $e->getMessage();
        }
    }
}

// Handle upload gambar
// @noinspection PhpUndefinedVariableInspection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_gambar') {
    $gallery_id = (int)($_POST['gallery_id'] ?? 0);
    
    if ($gallery_id <= 0) {
        $error = 'Project tidak valid!';
    } else {
        // Cek jumlah gambar yang ada
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM gallery_images WHERE gallery_id = ?");
        $stmt->execute([$gallery_id]);
        $count = $stmt->fetchColumn();
        if ($count >= 4) {
            $error = 'Sudah ada 4 gambar untuk project ini. Hapus salah satu jika ingin menambah!';
        } elseif (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] === UPLOAD_ERR_NO_FILE) {
            $error = 'Pilih foto terlebih dahulu!';
        } else {
            $file = $_FILES['gambar'];
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            
            if (!in_array($file['type'], $allowed)) {
                $error = 'Format foto harus JPG, PNG, GIF, atau WebP!';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $error = 'Ukuran foto maksimal 5MB!';
            } else {
                $uploads_dir = __DIR__ . '/../assets/uploads';
                if (!is_dir($uploads_dir)) {
                    mkdir($uploads_dir, 0755, true);
                }
                
                $filename = uniqid('gallery_') . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_path = $uploads_dir . '/' . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    try {
                        $urutan = $count + 1;
                        $stmt = $pdo->prepare("INSERT INTO gallery_images (gallery_id, gambar, urutan) VALUES (?, ?, ?)");
                        $stmt->execute([$gallery_id, $filename, $urutan]);
                        $message = 'Gambar berhasil diupload! (' . $urutan . '/4)';
                    } catch (Exception $e) {
                        unlink($file_path);
                        $error = 'Gagal menyimpan ke database: ' . $e->getMessage();
                    }
                } else {
                    $error = 'Gagal upload foto!';
                }
            }
        }
    }
}

// Handle hapus gambar
if (isset($_GET['delete_image'])) {
    $image_id = $_GET['delete_image'];
    $stmt = $pdo->prepare("SELECT gambar, gallery_id FROM gallery_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch(\PDO::FETCH_ASSOC);
    if ($image) {
        $file_path = __DIR__ . '/../assets/uploads/' . $image['gambar'];
        if (file_exists($file_path)) unlink($file_path);
        $pdo->prepare("DELETE FROM gallery_images WHERE id = ?")->execute([$image_id]);
        header('Location: gallery.php');
        exit;
    }
}

// Handle hapus project
if (isset($_GET['delete_project'])) {
    $id = $_GET['delete_project'];
    // Ambil semua gambar project
    $stmt = $pdo->prepare("SELECT gambar FROM gallery_images WHERE gallery_id = ?");
    $stmt->execute([$id]);
    $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($images as $img) {
        $file_path = __DIR__ . '/../assets/uploads/' . $img['gambar'];
        if (file_exists($file_path)) unlink($file_path);
    }
    // Hapus project dan gambar dari DB
    $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
    header('Location: gallery.php');
    exit;
}

// Ambil semua project
$gallery = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Gallery - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f5f7fa; }
        .sidebar { background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white; min-height: 100vh; padding: 20px; position: fixed; left: 0; top: 0; width: 250px; }
        .main-content { margin-left: 250px; padding: 20px; }
        .form-control:focus, .form-select:focus { border-color: #1a56db; box-shadow: 0 0 0 0.2rem rgba(26, 86, 219, 0.25); }
        .btn-success { background: #10b981; border-color: #10b981; }
        .btn-success:hover { background: #059669; border-color: #059669; }
        @media (max-width: 768px) { 
            .sidebar { position: relative; width: 100%; } 
            .main-content { margin-left: 0; } 
            .table { font-size: 0.875rem; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="fw-bold mb-4"><i class="bi bi-cpu"></i> Agus Tech</h3>
        <a href="<?php echo APP_URL; ?>/admin/dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="<?php echo APP_URL; ?>/admin/gallery.php" class="nav-link active"><i class="bi bi-image"></i> Gallery</a>
        <hr style="border-color: rgba(255,255,255,0.2);"><a href="<?php echo APP_URL; ?>/auth/logout.php" class="btn btn-light btn-sm w-100">Logout</a>
    </div>

    <div class="main-content">
        <h1 class="mb-4 fw-bold">Kelola Gallery</h1>

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Form Tambah Project -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Project Baru</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add_project">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="judul" class="form-label fw-bold">Judul Project</label>
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: Website E-Commerce XYZ" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Contoh: Website, Mobile App" value="Umum">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Project</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan project ini..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="bi bi-plus-circle"></i> Buat Project</button>
                </form>
            </div>
        </div>

        <!-- Daftar Project -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Project & Gambar</h5>
            </div>
            <div class="card-body">
                <?php if (count($gallery) > 0): ?>
                    <?php foreach ($gallery as $project): ?>
                        <?php 
                            $stmt = $pdo->prepare("SELECT * FROM gallery_images WHERE gallery_id = ? ORDER BY urutan");
                            $stmt->execute([$project['id']]);
                            $images = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                            $img_count = count($images);
                        ?>
                        <div class="card mb-3 border-left-primary" style="border-left: 4px solid #1a56db;">
                            <div class="card-header bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><strong><?php echo htmlspecialchars($project['judul']); ?></strong></h6>
                                        <small class="text-muted">
                                            <i class="bi bi-tag"></i> <?php echo htmlspecialchars($project['kategori']); ?> | 
                                            <i class="bi bi-images"></i> <?php echo $img_count; ?>/4 Gambar
                                        </small>
                                    </div>
                                    <a href="?delete_project=<?php echo $project['id']; ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Yakin hapus project ini beserta semua gambarnya?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3"><?php echo htmlspecialchars($project['deskripsi'] ?? '(Tidak ada deskripsi)'); ?></p>
                                
                                <!-- Gallery Gambar -->
                                <div class="row g-2 mb-3">
                                    <?php foreach ($images as $img): ?>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="position-relative">
                                                <img src="<?php echo APP_URL; ?>/assets/uploads/<?php echo $img['gambar']; ?>" 
                                                     alt="Gambar <?php echo $img['urutan']; ?>" 
                                                     class="img-fluid rounded"
                                                     style="width: 100%; height: 150px; object-fit: cover;">
                                                <small class="position-absolute top-0 start-0 bg-dark text-white px-2 py-1 rounded m-1">#<?php echo $img['urutan']; ?></small>
                                                <a href="?delete_image=<?php echo $img['id']; ?>" 
                                                   class="btn btn-sm btn-danger position-absolute bottom-0 end-0 m-1"
                                                   onclick="return confirm('Hapus gambar ini?');"
                                                   title="Hapus gambar">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Form Upload Gambar (jika belum 4) -->
                                <?php if ($img_count < 4): ?>
                                    <form method="POST" enctype="multipart/form-data" class="d-flex gap-2">
                                        <input type="hidden" name="action" value="upload_gambar">
                                        <input type="hidden" name="gallery_id" value="<?php echo $project['id']; ?>">
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm" name="gambar" accept="image/*" required>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-cloud-upload"></i> Upload Gambar (<?php echo $img_count; ?>/4)
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle"></i> Sudah ada 4 gambar. Hapus salah satu jika ingin menambah.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-3">Belum ada project. Buat project di atas terlebih dahulu!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
