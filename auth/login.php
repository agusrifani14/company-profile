<?php
/**
 * auth/login.php - Halaman Login
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

// Arahkan ke dashboard jika sudah login
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

requireGuest();

$error = '';
$success = '';

// Proses form login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (!$username || !$password) {
        $error = 'Username dan password harus diisi!';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, username, email, password, role FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect ke dashboard admin atau homepage
                if ($user['role'] === 'admin') {
                    redirect(APP_URL . '/admin/dashboard.php');
                } else {
                    redirect(APP_URL . '/index.php');
                }
            } else {
                $error = 'Username atau password salah!';
            }
        } catch (Exception $e) {
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}

$page_title = 'Login';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agus Tech Solution</title>
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
        
        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .login-header-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            margin-bottom: 5px;
        }
        
        .login-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .login-body {
            padding: 40px;
        }
        
        .form-control:focus {
            border-color: #1a56db;
            box-shadow: 0 0 0 0.2rem rgba(26, 86, 219, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 86, 219, 0.3);
            color: white;
        }
        
        .alert-custom {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }
        
        .login-footer {
            text-align: center;
            padding: 20px 40px;
            background: #f8f9fa;
            font-size: 0.9rem;
        }
        
        .login-footer a {
            color: #1a56db;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="login-header-icon">
                <i class="bi bi-cpu"></i>
            </div>
            <h1>Agus Tech</h1>
            <p>Solution</p>
        </div>
        
        <!-- Body -->
        <div class="login-body">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-custom" role="alert">
                    <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success alert-custom" role="alert">
                    <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label fw-600">Username atau Email</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username atau email" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label fw-600">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                
                <button type="submit" class="btn btn-login w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>
            
            <hr>
            
            <div class="text-center">
                <p class="mb-0">Belum punya akun? <a href="<?php echo APP_URL; ?>/auth/register.php">Daftar di sini</a></p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="login-footer">
            <p class="mb-0">Demo: username: <code>admin</code> | password: <code>password</code></p>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
