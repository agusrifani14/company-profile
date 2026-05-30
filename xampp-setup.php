<?php
/**
 * xampp-setup.php - XAMPP Configuration Guide
 * Debugging & Setup Instructions
 */

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>XAMPP Setup - Agus Tech Solution</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        h1 { color: #1a56db; }
        h2 { color: #06b6d4; margin-top: 30px; }
        .step { background: #f9f9f9; padding: 15px; margin: 15px 0; border-left: 4px solid #1a56db; }
        .code { background: #333; color: #0f0; padding: 15px; border-radius: 4px; font-family: monospace; overflow-x: auto; }
        .success { color: #059669; font-weight: bold; }
        .error { color: #dc2626; font-weight: bold; }
        .warning { color: #f59e0b; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        table th { background: #1a56db; color: white; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 XAMPP Setup untuk Agus Tech Solution</h1>
        
        <h2>📋 Checklist Setup XAMPP</h2>
        <div class='step'>
            <strong>1. XAMPP Installation Folder</strong><br>
            Default: <code>C:\\xampp</code><br>
            Status: ";
            
            if (file_exists('C:\\xampp')) {
                echo "<span class='success'>✓ XAMPP Terinstall</span>";
            } else {
                echo "<span class='error'>✗ XAMPP Tidak Ditemukan di C:\\xampp</span>";
            }
            
            echo "</div>
        
        <div class='step'>
            <strong>2. Project Folder Location</strong><br>
            Seharusnya: <code>C:\\xampp\\htdocs\\company-profile</code><br>
            Atau: <code>D:\\myproject\\company-profile</code> (untuk custom drive)<br>
            Current: <code>" . getcwd() . "</code><br>
            Status: ";
            
            if (file_exists(getcwd() . '/index.php')) {
                echo "<span class='success'>✓ index.php Ditemukan</span>";
            } else {
                echo "<span class='error'>✗ index.php Tidak Ditemukan</span>";
            }
            
            echo "</div>
        
        <div class='step'>
            <strong>3. Apache Port Configuration</strong><br>
            <table>
                <tr>
                    <th>Port</th>
                    <th>URL</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>80 (Default)</td>
                    <td>http://localhost/company-profile</td>
                    <td>Rekomendasi</td>
                </tr>
                <tr>
                    <td>8080 (Custom)</td>
                    <td>http://localhost:8080/company-profile</td>
                    <td>Jika Apache running di 8080</td>
                </tr>
                <tr>
                    <td>3000 (Node.js)</td>
                    <td>http://localhost:3000</td>
                    <td>Jangan pakai untuk PHP</td>
                </tr>
            </table>
        </div>
        
        <h2>🚀 Cara Mengakses Website</h2>
        
        <div class='step'>
            <strong>Option 1: XAMPP Control Panel</strong>
            <ol>
                <li>Buka XAMPP Control Panel</li>
                <li>Klik <strong>Start</strong> pada Apache</li>
                <li>Klik <strong>Start</strong> pada MySQL</li>
                <li>Buka browser: <code>http://localhost/company-profile</code></li>
            </ol>
        </div>
        
        <div class='step'>
            <strong>Option 2: PowerShell Command</strong>
            <div class='code'>
# Jalankan XAMPP Apache
cd C:\\xampp
.\\apache_start.bat

# Di terminal baru, jalankan MySQL
cd C:\\xampp
.\\mysql_start.bat

# Akses di browser
http://localhost/company-profile
            </div>
        </div>
        
        <div class='step'>
            <strong>Option 3: Folder Di Custom Drive (D:)</strong>
            <p>Jika project berada di D:\\myproject\\company-profile:</p>
            <div class='code'>
# Edit C:\\xampp\\apache\\conf\\httpd.conf
# Cari line: DocumentRoot \"C:/xampp/htdocs\"
# Ganti dengan: DocumentRoot \"D:/myproject\"

# Atau buat Virtual Host di httpd-vhosts.conf
&lt;VirtualHost *:80&gt;
    ServerName company-profile.local
    DocumentRoot \"D:/myproject/company-profile\"
&lt;/VirtualHost&gt;

# Edit C:\\Windows\\System32\\drivers\\etc\\hosts
# Tambahkan: 127.0.0.1  company-profile.local

# Akses di browser: http://company-profile.local
            </div>
        </div>
        
        <h2>🔐 Database Configuration</h2>
        
        <div class='step'>
            <strong>MySQL Connection Details:</strong>
            <table>
                <tr><th>Parameter</th><th>Value</th><th>Status</th></tr>";
            
            // Check database connection
            try {
                $pdo = new PDO('mysql:host=127.0.0.1;port=3305;dbname=db_company_profile;charset=utf8mb4', 'root', '');
                $status = "<span class='success'>✓ Connected</span>";
            } catch (Exception $e) {
                $status = "<span class='error'>✗ Failed: " . $e->getMessage() . "</span>";
            }
            
            echo "
                <tr><td>Host</td><td>127.0.0.1</td><td>Gunakan IP, bukan localhost</td></tr>
                <tr><td>Port</td><td>3305</td><td>Non-standard XAMPP port</td></tr>
                <tr><td>Database</td><td>db_company_profile</td><td>Harus sudah ada</td></tr>
                <tr><td>Username</td><td>root</td><td>Default XAMPP</td></tr>
                <tr><td>Password</td><td>(kosong)</td><td>Default XAMPP</td></tr>
                <tr><td>Connection</td><td>PDO MySQL</td><td>" . $status . "</td></tr>
            </table>
        </div>
        
        <h2>⚠️ Troubleshooting</h2>
        
        <div class='step'>
            <strong class='error'>Error: 404 Not Found</strong>
            <p>Solusi:</p>
            <ul>
                <li>✓ Pastikan Apache sudah running (XAMPP Control Panel)</li>
                <li>✓ Periksa apakah project folder di htdocs</li>
                <li>✓ Cek port yang digunakan (80 atau 8080)</li>
                <li>✓ Reload halaman (Ctrl+R atau Ctrl+F5)</li>
                <li>✓ Cek folder permissions (read-accessible)</li>
            </ul>
        </div>
        
        <div class='step'>
            <strong class='error'>Error: Database Connection Failed</strong>
            <p>Solusi:</p>
            <ul>
                <li>✓ Pastikan MySQL sudah running (XAMPP Control Panel)</li>
                <li>✓ Verify port 3305 (bukan 3306)</li>
                <li>✓ Jalankan database.sql di phpMyAdmin</li>
                <li>✓ Periksa config/koneksi.php - DSN harus correct</li>
                <li>✓ Test connection: run test_connection.php</li>
            </ul>
        </div>
        
        <h2>🧪 Testing Files</h2>
        <div class='step'>
            Ada 2 file testing yang bisa diakses:
            <ul>
                <li><code>test_connection.php</code> - Test database connection</li>
                <li><code>debug_connection.php</code> - Debug database issues</li>
                <li><code>xampp-setup.php</code> - Setup guide (halaman ini)</li>
            </ul>
            Akses: <code>http://localhost/company-profile/test_connection.php</code>
        </div>
        
        <h2>📝 Quick Setup Steps</h2>
        
        <div class='step'>
            <strong>Step 1: Copy Project ke htdocs</strong>
            <div class='code'>
# Copy seluruh folder company-profile ke:
C:\\xampp\\htdocs\\company-profile
            </div>
        </div>
        
        <div class='step'>
            <strong>Step 2: Start XAMPP Services</strong>
            <div class='code'>
1. Buka XAMPP Control Panel
2. Klik Start pada Apache (Port 80)
3. Klik Start pada MySQL (Port 3305)
            </div>
        </div>
        
        <div class='step'>
            <strong>Step 3: Create Database</strong>
            <div class='code'>
1. Buka http://localhost/phpmyadmin
2. Buat database baru: db_company_profile
3. Import file database.sql
            </div>
        </div>
        
        <div class='step'>
            <strong>Step 4: Access Website</strong>
            <div class='code'>
http://localhost/company-profile
            </div>
        </div>
        
        <div class='step'>
            <strong>Step 5: Login Admin</strong>
            <div class='code'>
URL: http://localhost/company-profile/auth/login.php
Username: admin
Password: password
            </div>
        </div>
        
        <h2>✅ Verification Checklist</h2>
        
        <div class='step'>
            <input type='checkbox'> Apache running di port 80<br>
            <input type='checkbox'> MySQL running di port 3305<br>
            <input type='checkbox'> Project di C:\\xampp\\htdocs\\company-profile<br>
            <input type='checkbox'> Database db_company_profile sudah dibuat<br>
            <input type='checkbox'> database.sql sudah di-import<br>
            <input type='checkbox'> Bisa akses http://localhost/company-profile<br>
            <input type='checkbox'> Bisa login dengan admin/password<br>
            <input type='checkbox'> Database connection working<br>
        </div>
        
        <hr>
        <p style='text-align: center; color: #999; margin-top: 40px;'>
            Agus Tech Solution - XAMPP Setup Guide<br>
            Last Updated: May 28, 2026
        </p>
    </div>
</body>
</html>";
?>
