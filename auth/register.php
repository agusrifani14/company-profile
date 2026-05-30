<?php
/**
 * auth/register.php - Halaman Registrasi User Baru
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

requireGuest();

$error = '';
$success = '';

// Proses form registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean($_POST['nama'] ?? '');
    $username = clean($_POST['username'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // Validasi
    if (!$nama || !$username || !$email || !$password) {
        $error = 'Semua field harus diisi!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } elseif ($password !== $password_confirm) {
        $error = 'Password tidak cocok!';
    } else {
        try {
            // Cek username sudah ada
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $error = 'Username atau email sudah terdaftar!';
            } else {
                // Insert user baru
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (nama, username, email, password, role, status) VALUES (?, ?, ?, ?, 'user', 'aktif')");
                $stmt->execute([$nama, $username, $email, $hashed_password]);
                
                $success = 'Registrasi berhasil! Silakan login dengan akun Anda.';
                // Redirect ke login setelah 2 detik
                header("Refresh: 2; url=" . APP_URL . "/auth/login.php");
            }
        } catch (Exception $e) {
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}

$page_title = 'Daftar';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Agus Tech Solution</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .register-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .register-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            margin-bottom: 5px;
        }
        
        .register-body {
            padding: 40px;
        }
        
        .form-control:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 0.2rem rgba(26, 86, 219, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 86, 219, 0.3);
            color: white;
        }
        
        .register-footer {
            text-align: center;
            padding: 20px 40px;
            background: #f8f9fa;
            font-size: 0.9rem;
        }
        
        .register-footer a {
            color: #1a56db;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Header -->
        <div class="register-header">
            <div style="font-size: 2.5rem; margin-bottom: 10px;">
                <i class="bi bi-cpu"></i>
            </div>
            <h1>Daftar Akun Baru</h1>
            <p class="mb-0">Bergabunglah dengan komunitas kami</p>
        </div>
        
        <!-- Body -->
        <div class="register-body">
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nama" class="form-label fw-600">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div class="mb-3">
                    <label for="username" class="form-label fw-600">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label fw-600">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label fw-600">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                </div>
                
                <div class="mb-3">
                    <label for="password_confirm" class="form-label fw-600">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ulangi password" required>
                </div>
                
                <button type="submit" class="btn btn-register w-100 mb-3">
                    <i class="bi bi-person-plus"></i> Daftar
                </button>
            </form>
        </div>
        
        <!-- Footer -->
        <div class="register-footer">
            <p class="mb-0">Sudah punya akun? <a href="<?php echo APP_URL; ?>/auth/login.php">Login di sini</a></p>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
