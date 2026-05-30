<?php
/**
 * admin/event.php - Kelola Event
 * Project: Agus Tech Solution - Company Profile
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';
requireAdmin();

// Handle DELETE
if (isset($_GET['delete'])) {
    try {
        $pdo->prepare("DELETE FROM event WHERE id = ?")->execute([$_GET['delete']]);
        $message = 'Event berhasil dihapus!';
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

// Handle ADD/EDIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = clean($_POST['judul'] ?? '');
    $deskripsi = clean($_POST['deskripsi'] ?? '');
    $tanggal = clean($_POST['tanggal'] ?? '');
    $lokasi = clean($_POST['lokasi'] ?? '');
    $status = clean($_POST['status'] ?? 'upcoming');
    
    if ($judul && $deskripsi && $tanggal) {
        try {
            if (isset($_GET['id'])) {
                $pdo->prepare("UPDATE event SET judul=?, deskripsi=?, tanggal=?, lokasi=?, status=? WHERE id=?")->execute([$judul, $deskripsi, $tanggal, $lokasi, $status, $_GET['id']]);
                $message = 'Event berhasil diupdate!';
            } else {
                $pdo->prepare("INSERT INTO event (judul, deskripsi, tanggal, lokasi, status) VALUES (?, ?, ?, ?, ?)")->execute([$judul, $deskripsi, $tanggal, $lokasi, $status]);
                $message = 'Event berhasil ditambahkan!';
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    } else {
        $error = 'Isikan semua field yang wajib!';
    }
}

$events = $pdo->query("SELECT * FROM event ORDER BY tanggal DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Event - Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f5f7fa; }
        .sidebar { background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%); color: white; min-height: 100vh; padding: 20px; position: fixed; left: 0; top: 0; width: 250px; }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); margin: 10px 0; border-radius: 8px; padding: 10px 15px; transition: all 0.3s; }
        .sidebar .nav-link.active { background: rgba(255,255,255,0.2); color: white; }
        .main-content { margin-left: 250px; padding: 20px; }
        @media (max-width: 768px) { .sidebar { position: relative; width: 100%; } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="fw-bold mb-4"><i class="bi bi-cpu"></i> Agus Tech</h3>
        <nav class="nav flex-column">
            <a href="<?php echo APP_URL; ?>/admin/dashboard.php" class="nav-link"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="<?php echo APP_URL; ?>/admin/event.php" class="nav-link active"><i class="bi bi-calendar-event"></i> Event</a>
        </nav>
        <hr style="border-color: rgba(255,255,255,0.2);"><a href="<?php echo APP_URL; ?>/auth/logout.php" class="btn btn-light btn-sm w-100">Logout</a>
    </div>

    <div class="main-content">
        <h1 class="mb-4 fw-bold">Kelola Event</h1>
        <?php if (!empty($message)): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between">
                        <h5 class="mb-0">Daftar Event</h5>
                        <a href="?add=1" class="btn btn-light btn-sm">+ Tambah Event</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Judul</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?php echo $event['judul']; ?></td>
                                    <td><?php echo $event['tanggal']; ?></td>
                                    <td><span class="badge bg-<?php echo $event['status'] == 'upcoming' ? 'success' : 'secondary'; ?>"><?php echo $event['status']; ?></span></td>
                                    <td>
                                        <a href="?edit=<?php echo $event['id']; ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="?delete=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger btn-delete" onclick="return confirm('Yakin hapus event ini?');">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
