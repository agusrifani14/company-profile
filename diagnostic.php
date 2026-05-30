<?php
/**
 * diagnostic.php - Complete System Diagnostic
 * Check all components: Apache, MySQL, Files, Database
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

$diagnostics = [
    'apache' => [],
    'mysql' => [],
    'files' => [],
    'database' => [],
    'issues' => []
];

// === APACHE CHECKS ===
$diagnostics['apache']['server_software'] = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
$diagnostics['apache']['server_addr'] = $_SERVER['SERVER_ADDR'] ?? 'Unknown';
$diagnostics['apache']['server_port'] = $_SERVER['SERVER_PORT'] ?? 'Unknown';
$diagnostics['apache']['php_version'] = phpversion();
$diagnostics['apache']['document_root'] = $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown';
$diagnostics['apache']['script_filename'] = $_SERVER['SCRIPT_FILENAME'] ?? 'Unknown';

// === FILE CHECKS ===
$required_files = [
    'index.php' => 'Root index.php',
    'config/koneksi.php' => 'Database config',
    'includes/header.php' => 'Header include',
    'includes/footer.php' => 'Footer include',
    'auth/login.php' => 'Login page',
    'admin/dashboard.php' => 'Admin dashboard',
    'pages/produk.php' => 'Product page',
    'database.sql' => 'Database SQL file',
];

foreach ($required_files as $file => $desc) {
    $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
    $exists = file_exists($path);
    $diagnostics['files'][$file] = [
        'exists' => $exists,
        'path' => $path,
        'description' => $desc,
        'readable' => $exists && is_readable($path)
    ];
    if (!$exists) {
        $diagnostics['issues'][] = "Missing: $file ($desc)";
    }
}

// === MYSQL CHECKS ===
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3305', 'root', '');
    $diagnostics['mysql']['connection'] = 'Connected';
    $diagnostics['mysql']['host'] = '127.0.0.1';
    $diagnostics['mysql']['port'] = '3305';
    
    // Check database
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = 'db_company_profile'");
    $db_exists = $stmt->fetch()['count'] > 0;
    $diagnostics['mysql']['database_exists'] = $db_exists ? 'Yes' : 'No';
    
    if ($db_exists) {
        // Check tables
        $pdo->exec("USE db_company_profile");
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $diagnostics['mysql']['tables'] = $tables;
        $diagnostics['mysql']['table_count'] = count($tables);
        
        // Check for required tables
        $required_tables = ['users', 'produk', 'artikel', 'event', 'gallery', 'klien', 'upload_file'];
        foreach ($required_tables as $table) {
            if (!in_array($table, $tables)) {
                $diagnostics['issues'][] = "Missing table: $table";
            }
        }
    } else {
        $diagnostics['issues'][] = "Database 'db_company_profile' not found";
    }
    
} catch (PDOException $e) {
    $diagnostics['mysql']['connection'] = 'Failed';
    $diagnostics['mysql']['error'] = $e->getMessage();
    $diagnostics['issues'][] = "MySQL Connection Error: " . $e->getMessage();
}

// === CONFIG FILE CHECKS ===
$config_file = $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';
if (file_exists($config_file)) {
    $config_content = file_get_contents($config_file);
    $diagnostics['database']['config_file'] = 'Found';
    
    // Check for key configuration
    $checks = [
        'DB_HOST' => 'Database host defined',
        'DB_PORT' => 'Database port defined',
        'DB_NAME' => 'Database name defined',
        'APP_URL' => 'App URL defined',
    ];
    
    foreach ($checks as $key => $desc) {
        if (strpos($config_content, $key) !== false) {
            $diagnostics['database'][$key] = 'Found';
        } else {
            $diagnostics['database'][$key] = 'Missing';
            $diagnostics['issues'][] = "Config missing: $key";
        }
    }
} else {
    $diagnostics['issues'][] = "config/koneksi.php not found";
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Diagnostic - Agus Tech Solution</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header {
            background: linear-gradient(135deg, #1a56db 0%, #06b6d4 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .header h1 { font-size: 2rem; margin-bottom: 5px; }
        .header p { opacity: 0.9; }
        
        .diagnostic-section {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        .section-header {
            background: #f9f9f9;
            padding: 15px 20px;
            border-left: 4px solid #1a56db;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-content {
            padding: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-ok { background: #d1fae5; color: #065f46; }
        .status-error { background: #fee2e2; color: #7f1d1d; }
        .status-warning { background: #fef3c7; color: #92400e; }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table tr {
            border-bottom: 1px solid #eee;
        }
        
        .info-table tr:last-child {
            border-bottom: none;
        }
        
        .info-table th {
            text-align: left;
            padding: 12px;
            background: #f9f9f9;
            font-weight: 600;
            font-size: 14px;
        }
        
        .info-table td {
            padding: 12px;
        }
        
        .info-table td:first-child {
            width: 200px;
            font-weight: 500;
            color: #666;
        }
        
        .info-table td:nth-child(2) {
            color: #333;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        
        .issues-section {
            background: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .issues-section h3 {
            color: #7f1d1d;
            margin-bottom: 10px;
        }
        
        .issues-section ul {
            margin-left: 20px;
        }
        
        .issues-section li {
            color: #7f1d1d;
            margin-bottom: 5px;
        }
        
        .success-section {
            background: #d1fae5;
            border-left: 4px solid #059669;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            color: #065f46;
        }
        
        .code-block {
            background: #1f2937;
            color: #10b981;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            overflow-x: auto;
            margin: 10px 0;
        }
        
        .recommended-action {
            background: #dbeafe;
            border-left: 4px solid #1a56db;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
            color: #1e40af;
        }
        
        .recommended-action strong {
            display: block;
            margin-bottom: 5px;
        }
        
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 System Diagnostic Report</h1>
            <p>Agus Tech Solution - Complete Environment Check</p>
        </div>
        
        <?php if (count($diagnostics['issues']) > 0): ?>
        <div class="issues-section">
            <h3>⚠️ Issues Found (<?php echo count($diagnostics['issues']); ?>)</h3>
            <ul>
                <?php foreach ($diagnostics['issues'] as $issue): ?>
                <li><?php echo htmlspecialchars($issue); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php else: ?>
        <div class="success-section">
            <strong>✅ No Issues Found!</strong>
            Your system appears to be properly configured. You should be able to access the website.
        </div>
        <?php endif; ?>
        
        <!-- Apache Section -->
        <div class="diagnostic-section">
            <div class="section-header">
                <span>🖥️ Apache Configuration</span>
                <span class="status-badge status-ok">Running</span>
            </div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <th>Parameter</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Server Software</td>
                        <td><?php echo htmlspecialchars($diagnostics['apache']['server_software']); ?></td>
                    </tr>
                    <tr>
                        <td>Server Address</td>
                        <td><?php echo $diagnostics['apache']['server_addr']; ?></td>
                    </tr>
                    <tr>
                        <td>Server Port</td>
                        <td><?php echo $diagnostics['apache']['server_port']; ?> (<?php echo $diagnostics['apache']['server_port'] == 80 ? '✓ Default' : '⚠️ Custom'; ?>)</td>
                    </tr>
                    <tr>
                        <td>PHP Version</td>
                        <td><?php echo $diagnostics['apache']['php_version']; ?></td>
                    </tr>
                    <tr>
                        <td>Document Root</td>
                        <td><?php echo htmlspecialchars($diagnostics['apache']['document_root']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- MySQL Section -->
        <div class="diagnostic-section">
            <div class="section-header">
                <span>🗄️ MySQL Configuration</span>
                <span class="status-badge <?php echo $diagnostics['mysql']['connection'] == 'Connected' ? 'status-ok' : 'status-error'; ?>">
                    <?php echo $diagnostics['mysql']['connection']; ?>
                </span>
            </div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <th>Parameter</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Connection Status</td>
                        <td><?php echo $diagnostics['mysql']['connection']; ?></td>
                    </tr>
                    <?php if ($diagnostics['mysql']['connection'] == 'Connected'): ?>
                    <tr>
                        <td>Host</td>
                        <td><?php echo $diagnostics['mysql']['host']; ?></td>
                    </tr>
                    <tr>
                        <td>Port</td>
                        <td><?php echo $diagnostics['mysql']['port']; ?> (✓ Correct)</td>
                    </tr>
                    <tr>
                        <td>Database</td>
                        <td><?php echo $diagnostics['mysql']['database_exists'] ? '✓ db_company_profile' : '✗ Not found'; ?></td>
                    </tr>
                    <?php if ($diagnostics['mysql']['database_exists']): ?>
                    <tr>
                        <td>Tables Count</td>
                        <td><?php echo $diagnostics['mysql']['table_count']; ?>/7</td>
                    </tr>
                    <tr>
                        <td>Tables</td>
                        <td><?php echo implode(', ', $diagnostics['mysql']['tables']); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php else: ?>
                    <tr>
                        <td>Error</td>
                        <td style="color: #dc2626;"><?php echo htmlspecialchars($diagnostics['mysql']['error']); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        
        <!-- Files Section -->
        <div class="diagnostic-section">
            <div class="section-header">
                <span>📁 Required Files</span>
                <span class="status-badge status-ok"><?php echo count(array_filter($diagnostics['files'], fn($f) => $f['exists'])); ?>/<?php echo count($diagnostics['files']); ?></span>
            </div>
            <div class="section-content">
                <table class="info-table">
                    <tr>
                        <th>File</th>
                        <th>Status</th>
                        <th>Readable</th>
                    </tr>
                    <?php foreach ($diagnostics['files'] as $file => $info): ?>
                    <tr>
                        <td><?php echo $file; ?></td>
                        <td><?php echo $info['exists'] ? '✓ Found' : '✗ Missing'; ?></td>
                        <td><?php echo $info['readable'] ? '✓ Yes' : (($info['exists']) ? '✗ No' : '-'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        
        <!-- Recommendations -->
        <?php if (count($diagnostics['issues']) > 0): ?>
        <div class="diagnostic-section">
            <div class="section-header">
                <span>💡 Recommended Actions</span>
            </div>
            <div class="section-content">
                <?php if ($diagnostics['apache']['server_port'] != 80): ?>
                <div class="recommended-action">
                    <strong>Port Issue Detected</strong>
                    You're accessing on port <?php echo $diagnostics['apache']['server_port']; ?>. 
                    The default should be port 80. Check your XAMPP configuration.
                </div>
                <?php endif; ?>
                
                <?php if ($diagnostics['mysql']['connection'] != 'Connected'): ?>
                <div class="recommended-action">
                    <strong>MySQL Not Connected</strong>
                    1. Ensure MySQL is running in XAMPP Control Panel
                    2. Check that port 3305 is not blocked
                    3. Verify credentials (root / no password)
                </div>
                <?php endif; ?>
                
                <?php if (!empty($diagnostics['files']) && !array_reduce($diagnostics['files'], fn($c, $f) => $c && $f['exists'], true)): ?>
                <div class="recommended-action">
                    <strong>Missing Files</strong>
                    Some required files are missing. Ensure the project folder is complete.
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Quick Fix -->
        <div class="diagnostic-section">
            <div class="section-header">
                <span>⚡ Quick Fix Steps</span>
            </div>
            <div class="section-content">
                <ol style="margin-left: 20px; line-height: 2;">
                    <li>Ensure project is in: C:\xampp\htdocs\company-profile</li>
                    <li>XAMPP Control Panel → Start Apache (port 80)</li>
                    <li>XAMPP Control Panel → Start MySQL (port 3305)</li>
                    <li>Import database.sql into db_company_profile</li>
                    <li>Access: http://localhost/company-profile</li>
                    <li>Login: admin / password</li>
                </ol>
            </div>
        </div>
        
        <!-- Test URLs -->
        <div class="diagnostic-section">
            <div class="section-header">
                <span>🧪 Test URLs</span>
            </div>
            <div class="section-content">
                <p>Click these to test different parts of the website:</p>
                <div style="margin-top: 15px;">
                    <a href="<?php echo 'http://' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI']; ?>" 
                       style="display: inline-block; margin: 5px 0; padding: 10px 15px; background: #1a56db; color: white; text-decoration: none; border-radius: 6px;">
                        Refresh This Page
                    </a><br>
                    <a href="<?php echo 'http://' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . '/company-profile'; ?>" 
                       style="display: inline-block; margin: 5px 0; padding: 10px 15px; background: #06b6d4; color: white; text-decoration: none; border-radius: 6px;">
                        Homepage
                    </a><br>
                    <a href="<?php echo 'http://' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . '/company-profile/auth/login.php'; ?>" 
                       style="display: inline-block; margin: 5px 0; padding: 10px 15px; background: #10b981; color: white; text-decoration: none; border-radius: 6px;">
                        Login
                    </a>
                </div>
            </div>
        </div>
        
        <div class="footer">
            System Diagnostic Report | Agus Tech Solution
            <br>Generated: <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>
</html>
