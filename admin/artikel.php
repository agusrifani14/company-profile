<?php
/**
 * admin/artikel.php - Kelola Artikel
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

requireAdmin();

$page_title = 'Kelola Artikel';
$message = '';
$error = '';
$action = $_GET['action'] ?? '';

// Handle DELETE
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM artikel WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = 'Artikel berhasil dihapus!';
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

// Handle ADD/EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = clean($_POST['judul'] ?? '');
    $kategori = clean($_POST['kategori'] ?? '');
    $konten = $_POST['konten'] ?? ''; // Jangan clean konten HTML
    $penulis = clean($_POST['penulis'] ?? $_SESSION['username']);
    $status = clean($_POST['status'] ?? 'publish');
    
    if (!$judul || !$konten) {
        $error = 'Judul dan konten harus diisi!';
    } else {
        try {
            $slug = generateSlug($judul);
            
            if ($action == 'edit' && isset($_GET['id'])) {
                $stmt = $pdo->prepare("UPDATE artikel SET judul=?, slug=?, kategori=?, konten=?, penulis=?, status=? WHERE id=?");
                $stmt->execute([$judul, $slug, $kategori, $konten, $penulis, $status, $_GET['id']]);
                $message = 'Artikel berhasil diupdate!';
            } else {
                $stmt = $pdo->prepare("INSERT INTO artikel (judul, slug, kategori, konten, penulis, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$judul, $slug, $kategori, $konten, $penulis, $status]);
                $message = 'Artikel berhasil ditambahkan!';
            }
            $action = '';
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}

// Ambil data untuk edit
$edit_data = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM artikel WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $edit_data = $stmt->fetch();
}

// Ambil semua artikel
try {
    $stmt = $pdo->query("SELECT * FROM artikel ORDER BY created_at DESC");
    $artikel_list = $stmt->fetchAll();
} catch (Exception $e) {
    $artikel_list = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f5f7fa; }
        .sidebar { background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white; min-height: 100vh; padding: 20px; position: fixed; left: 0; top: 0; width: 250px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); margin: 10px 0; border-radius: 8px; padding: 10px 15px; transition: all 0.3s; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.2); color: white; }
        .main-content { margin-left: 250px; padding: 20px; }
        .top-bar { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); margin-bottom: 20px; }
        @media (max-width: 768px) { .sidebar { width: 100%; height: auto; position: relative; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="fw-bold mb-4"><i class="bi bi-cpu"></i> Agus Tech</h3>
        <nav class="nav flex-column">
            <a href="<?php echo APP_URL; ?>/admin/dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="<?php echo APP_URL; ?>/admin/produk.php" class="nav-link"><i class="bi bi-box"></i> Produk</a>
            <a href="<?php echo APP_URL; ?>/admin/artikel.php" class="nav-link active"><i class="bi bi-file-text"></i> Artikel</a>
            <a href="<?php echo APP_URL; ?>/admin/event.php" class="nav-link"><i class="bi bi-calendar-event"></i> Event</a>
        </nav>
        <hr style="border-color: rgba(255,255,255,0.2);">
        <a href="<?php echo APP_URL; ?>/auth/logout.php" class="btn btn-light btn-sm w-100">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <h1 class="mb-0 fw-bold"><?php echo $page_title; ?></h1>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if ($action == 'add' || $action == 'edit'): ?>
            <!-- Form Add/Edit -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo ($action == 'add') ? 'Buat Artikel Baru' : 'Edit Artikel'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Judul Artikel *</label>
                                <input type="text" name="judul" class="form-control" value="<?php echo $edit_data['judul'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-control">
                                    <option value="Konsep Teknologi Informasi" <?php echo ($edit_data['kategori'] ?? '') == 'Konsep Teknologi Informasi' ? 'selected' : ''; ?>>Konsep Teknologi Informasi</option>
                                    <option value="Web Development" <?php echo ($edit_data['kategori'] ?? '') == 'Web Development' ? 'selected' : ''; ?>>Web Development</option>
                                    <option value="Sistem Informasi" <?php echo ($edit_data['kategori'] ?? '') == 'Sistem Informasi' ? 'selected' : ''; ?>>Sistem Informasi</option>
                                    <option value="Keamanan Website" <?php echo ($edit_data['kategori'] ?? '') == 'Keamanan Website' ? 'selected' : ''; ?>>Keamanan Website</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konten *</label>
                                <textarea id="konten" name="konten" class="form-control" rows="10" required><?php echo $edit_data['konten'] ?? ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="publish" <?php echo ($edit_data['status'] ?? 'publish') == 'publish' ? 'selected' : ''; ?>>Publish</option>
                                    <option value="draft" <?php echo ($edit_data['status'] ?? '') == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="?" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- List Artikel -->
            <div class="col-lg-<?php echo ($action == 'add' || $action == 'edit') ? '4' : '12'; ?>">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Artikel</h5>
                        <a href="?action=add" class="btn btn-light btn-sm">+ Buat Artikel</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($artikel_list as $item): ?>
                                    <tr>
                                        <td><strong><?php echo substr($item['judul'], 0, 20); ?></strong></td>
                                        <td><small><?php echo $item['kategori']; ?></small></td>
                                        <td>
                                            <span class="badge bg-<?php echo $item['status'] == 'publish' ? 'success' : 'warning'; ?>">
                                                <?php echo ucfirst($item['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="?delete=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger btn-delete" onclick="return confirm('Yakin hapus artikel ini?');">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#konten' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>
