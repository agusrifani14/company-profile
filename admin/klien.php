<?php
/**
 * admin/klien.php - Kelola Klien
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';
requireAdmin();

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM klien WHERE id = ?")->execute([$_GET['delete']]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean($_POST['nama'] ?? '');
    $website = clean($_POST['website'] ?? '');
    $deskripsi = clean($_POST['deskripsi'] ?? '');
    
    if ($nama) {
        if (isset($_GET['id'])) {
            $pdo->prepare("UPDATE klien SET nama=?, website=?, deskripsi=? WHERE id=?")->execute([$nama, $website, $deskripsi, $_GET['id']]);
        } else {
            $pdo->prepare("INSERT INTO klien (nama, website, deskripsi) VALUES (?, ?, ?)")->execute([$nama, $website, $deskripsi]);
        }
    }
}

$klien = $pdo->query("SELECT * FROM klien ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Klien - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f5f7fa; }
        .sidebar { background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white; min-height: 100vh; padding: 20px; position: fixed; left: 0; top: 0; width: 250px; }
        .main-content { margin-left: 250px; padding: 20px; }
        @media (max-width: 768px) { .sidebar { position: relative; width: 100%; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="fw-bold mb-4"><i class="bi bi-cpu"></i> Agus Tech</h3>
        <a href="<?php echo APP_URL; ?>/admin/dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="<?php echo APP_URL; ?>/admin/klien.php" class="nav-link active"><i class="bi bi-building"></i> Klien</a>
        <hr style="border-color: rgba(255,255,255,0.2);"><a href="<?php echo APP_URL; ?>/auth/logout.php" class="btn btn-light btn-sm w-100">Logout</a>
    </div>

    <div class="main-content">
        <h1 class="mb-4 fw-bold">Kelola Klien</h1>

        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h5 class="mb-0">Daftar Klien</h5>
                <a href="#addForm" class="btn btn-light btn-sm">+ Tambah Klien</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Nama</th><th>Website</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($klien as $item): ?>
                        <tr>
                            <td><?php echo $item['nama']; ?></td>
                            <td><?php echo $item['website'] ?: '-'; ?></td>
                            <td>
                                <a href="?delete=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger btn-delete" onclick="return confirm('Yakin hapus klien ini?');">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
