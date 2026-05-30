<?php
/**
 * admin/produk.php - Kelola Produk/Jasa
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

requireAdmin();

$page_title = 'Kelola Produk';
$message = '';
$error = '';
$action = $_GET['action'] ?? '';

// Handle DELETE 
if (isset($_GET['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM produk WHERE id = ?");
        $stmt->execute([$_GET['delete']]);
        $message = 'Produk berhasil dihapus!';
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

// Handle ADD/EDIT create
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean($_POST['nama'] ?? '');
    $kategori = clean($_POST['kategori'] ?? '');
    $deskripsi = clean($_POST['deskripsi'] ?? '');
    $harga = clean($_POST['harga'] ?? '');
    $icon = clean($_POST['icon'] ?? 'bi-box');
    $fitur = clean($_POST['fitur'] ?? '');
    $status = clean($_POST['status'] ?? 'aktif');
    
    if (!$nama || !$deskripsi) {
        $error = 'Nama dan deskripsi harus diisi!';
    } else {
        try {
            if ($action == 'edit' && isset($_GET['id'])) {
                $stmt = $pdo->prepare("UPDATE produk SET nama=?, kategori=?, deskripsi=?, harga=?, icon=?, fitur=?, status=? WHERE id=?");
                $stmt->execute([$nama, $kategori, $deskripsi, $harga, $icon, $fitur, $status, $_GET['id']]);
                $message = 'Produk berhasil diupdate!';
            } else {
                $stmt = $pdo->prepare("INSERT INTO produk (nama, kategori, deskripsi, harga, icon, fitur, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nama, $kategori, $deskripsi, $harga, $icon, $fitur, $status]);
                $message = 'Produk berhasil ditambahkan!';
            }
            $action = '';
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}

// Ambil data untuk edit untuk bagian read
$edit_data = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produk WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $edit_data = $stmt->fetch();
}

// Ambil semua produk read
try {
    $stmt = $pdo->query("SELECT * FROM produk ORDER BY created_at DESC");
    $produk_list = $stmt->fetchAll();
} catch (Exception $e) {
    $produk_list = [];
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
            <a href="<?php echo APP_URL; ?>/admin/produk.php" class="nav-link active"><i class="bi bi-box"></i> Produk</a>
            <a href="<?php echo APP_URL; ?>/admin/artikel.php" class="nav-link"><i class="bi bi-file-text"></i> Artikel</a>
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
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?php echo ($action == 'add') ? 'Tambah Produk' : 'Edit Produk'; ?></h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">Nama Produk *</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo $edit_data['nama'] ?? ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" name="kategori" class="form-control" value="<?php echo $edit_data['kategori'] ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi *</label>
                                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo $edit_data['deskripsi'] ?? ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="text" name="harga" class="form-control" value="<?php echo $edit_data['harga'] ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Icon (Bootstrap Icon)</label>
                                <input type="text" name="icon" class="form-control" value="<?php echo $edit_data['icon'] ?? 'bi-box'; ?>" placeholder="bi-box">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Fitur (pisahkan dengan koma)</label>
                                <textarea name="fitur" class="form-control" rows="3"><?php echo $edit_data['fitur'] ?? ''; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="aktif" <?php echo ($edit_data['status'] ?? 'aktif') == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                                    <option value="nonaktif" <?php echo ($edit_data['status'] ?? '') == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
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

            <!-- List Produk -->
            <div class="col-lg-<?php echo ($action == 'add' || $action == 'edit') ? '6' : '12'; ?>">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Produk</h5>
                        <a href="?action=add" class="btn btn-light btn-sm">+ Tambah Produk</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produk_list as $item): ?>
                                    <tr>
                                        <td><strong><?php echo $item['nama']; ?></strong></td>
                                        <td><?php echo $item['kategori']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $item['status'] == 'aktif' ? 'success' : 'danger'; ?>">
                                                <?php echo ucfirst($item['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="?delete=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger btn-delete" onclick="return confirm('Yakin hapus item ini?');">
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
</body>
</html>
