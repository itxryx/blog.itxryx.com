<?php
try {
    $dsn = 'mysql:host=mysql;port=3306;dbname=dev;charset=utf8mb4';
    $username = 'user';
    $password = 'password';
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
    echo "MySQL connected successfully.";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

