<?php
try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;port=3305;dbname=db_company_profile;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo 'SUCCESS - Connected to MySQL on port 3305';
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
