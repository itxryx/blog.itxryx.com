<?php
declare(strict_types=1);

use Itxryx\Blog\Utility\Logger;
use Dotenv\Dotenv;

define("START_MICRO_SEC", microtime(true));

try {
    require(__DIR__ . "/../vendor/autoload.php");

    // load env var
    try {
        $_ENV = getenv();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage();
    }

    // setup logger
    $logger = Logger::create();
    $logger->debug("=== request start ===");

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

    $memory = memory_get_peak_usage(false);
    $consume_ms = (microtime(true) - START_MICRO_SEC) * 1000;
    $logger->debug("=== request finish ===", [
        "consuming_time" => sprintf('%.2f', $consume_ms) . " ms",
        "memory" => sprintf('%.2f',$memory / 1024 / 1024)  . " MB"
    ]);
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
