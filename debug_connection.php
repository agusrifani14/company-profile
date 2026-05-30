<?php
echo "<h3>PHP Version</h3>";
echo phpversion() . "<br>";

echo "<h3>Checking config/koneksi.php</h3>";
$configContent = file_get_contents('config/koneksi.php');
echo "<pre>" . htmlspecialchars($configContent) . "</pre>";

echo "<h3>DSN that would be generated</h3>";
$dsn = "mysql:host=127.0.0.1;port=3305;dbname=db_company_profile;charset=utf8mb4";
echo $dsn . "<br>";

echo "<h3>Testing connection</h3>";
try {
    $pdo = new PDO($dsn, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "✅ SUCCESS - Connected to MySQL on port 3305";
} catch (PDOException $e) {
    echo "❌ ERROR: " . $e->getMessage();
}
