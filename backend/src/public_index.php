<?php
declare(strict_types=1);

use Dotenv\Dotenv;

try {
    require(__DIR__ . "/../vendor/autoload.php");

    // load env var
    try {
        $_ENV = getenv();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    } catch (Exception $e) {
    }

    // connect to MySQL
    try {
        $dsn = $_ENV["DB_MYSQL_DSN"];
        $username = $_ENV["DB_MYSQL_USERNAME"];
        $password = $_ENV["DB_MYSQL_PASSWORD"];
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
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
