<?php
/**
 * koneksi.php
 * Konfigurasi koneksi database PDO MySQL untuk Hosting InfinityFree
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 * @noinspection PhpUndefinedClassInspection, PhpUndefinedConstantInspection
 */

// ============================================================
// Konfigurasi Database Hosting InfinityFree
// ============================================================
// PENTING:
// 1. DB_NAME wajib diganti sesuai nama database asli di InfinityFree.
// 2. Contoh DB_NAME: if0_42027793_company_profile
// 3. Jangan gunakan db_company_profile atau if0_42027793_XXX di hosting.
// ============================================================

define('DB_HOST', 'sql312.infinityfree.com');
define('DB_PORT', '3306');
define('DB_USER', 'if0_42027793');
define('DB_PASS', 'yHAjaZEM4AYN');
define('DB_NAME', 'if0_42027793_company_profile');
define('DB_CHARSET', 'utf8mb4');

// ============================================================
// Koneksi PDO
// ============================================================
/** @var PDO $pdo */
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new \PDO($dsn, DB_USER, DB_PASS, $options);

} catch (\PDOException $e) {
    die('<div style="font-family:sans-serif;background:#fee;border:1px solid #f00;padding:20px;margin:20px;border-radius:8px;">
        <h3>⚠️ Database Connection Error</h3>
        <p><strong>Pesan:</strong> ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>
        <p>Periksa kembali <code>DB_HOST</code>, <code>DB_USER</code>, <code>DB_PASS</code>, dan terutama <code>DB_NAME</code>.</p>
        <p>Database harus dibuat dari Control Panel InfinityFree, lalu file SQL diimport melalui phpMyAdmin.</p>
    </div>');
}

// ============================================================
// Konfigurasi Aplikasi
// ============================================================
define('APP_NAME', 'Agus Tech Solution');

// GANTI dengan domain/subdomain InfinityFree kamu.
// Contoh: https://agusrifani.great-site.net/company-profile
define('APP_URL', 'https://agusrifani14.gamer.gd/company-profile');

define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', APP_URL . '/assets/uploads/');

// ============================================================
// Helper Functions
// ============================================================

function clean($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        redirect(APP_URL . '/auth/login.php?msg=Silakan login terlebih dahulu');
    }
}

function requireGuest() {
    if (isLoggedIn()) {
        if (isAdmin()) {
            redirect(APP_URL . '/admin/dashboard.php');
        } else {
            redirect(APP_URL . '/index.php');
        }
    }
}

function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = trim(preg_replace('/[\s-]+/', ' ', $text));
    $text = preg_replace('/\s+/', '-', $text);
    return $text;
}

function tanggalIndonesia($tanggal) {
    $bulan = array(
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    );

    $explode = explode('-', $tanggal);
    return $explode[2] . ' ' . $bulan[(int)$explode[1]] . ' ' . $explode[0];
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function formatTanggal($date) {
    $bulan = [
        1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
        5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
        9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
    ];
    $d = date('j', strtotime($date));
    $m = $bulan[(int)date('n', strtotime($date))];
    $y = date('Y', strtotime($date));
    return "$d $m $y";
}

function makeSlug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', '-', $str);
    return trim($str, '-');
}

function uploadGambar($file, $subfolder = '') {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $maxSize = 5 * 1024 * 1024;

    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > $maxSize) {
        return false;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        return false;
    }

    $dir = UPLOAD_DIR . ($subfolder ? $subfolder . '/' : '');
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $newName = uniqid('img_', true) . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], $dir . $newName)) {
        return ($subfolder ? $subfolder . '/' : '') . $newName;
    }

    return false;
}

function truncate($text, $limit = 150) {
    $text = strip_tags($text);
    if (strlen($text) <= $limit) return $text;
    return substr($text, 0, $limit) . '...';
}
?>
