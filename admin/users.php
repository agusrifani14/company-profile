<?php
/**
 * admin/users.php - Kelola Users
 */
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';
requireAdmin();

if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM users WHERE id = ? AND id != ?")->execute([$_GET['delete'], $_SESSION['user_id']]);
}

$users = $pdo->query("SELECT id, username, email, role, status FROM users ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Users - Admin</title>
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
        <a href="<?php echo APP_URL; ?>/admin/users.php" class="nav-link active"><i class="bi bi-people"></i> Users</a>
        <hr style="border-color: rgba(255,255,255,0.2);"><a href="<?php echo APP_URL; ?>/auth/logout.php" class="btn btn-light btn-sm w-100">Logout</a>
    </div>

    <div class="main-content">
        <h1 class="mb-4 fw-bold">Kelola Users</h1>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Daftar Users (Total: <?php echo count($users); ?>)</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><span class="badge bg-<?php echo $user['role'] == 'admin' ? 'danger' : 'success'; ?>"><?php echo ucfirst($user['role']); ?></span></td>
                            <td><span class="badge bg-<?php echo $user['status'] == 'aktif' ? 'success' : 'secondary'; ?>"><?php echo ucfirst($user['status']); ?></span></td>
                            <td>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                    <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger btn-delete" onclick="return confirm('Yakin hapus user ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">(Your Account)</span>
                                <?php endif; ?>
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
