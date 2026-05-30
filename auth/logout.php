<?php
/**
 * auth/logout.php - Logout User
 * Project: Agus Tech Solution - Company Profile
 * Author : Agus Rifani
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/koneksi.php';

// Hapus session
session_destroy();
$_SESSION = [];

// Set cookie session ke waktu lampau
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke homepage
redirect(APP_URL . '/index.php?logout=success');
