<?php
declare(strict_types=1);

use Itxryx\Blog\Web\Dispatch;
use Itxryx\Blog\Web\Request;
use Itxryx\Blog\Utility\Logger;
use Dotenv\Dotenv;

define("START_MICRO_SEC", microtime(true));

ini_set("date.timezone", "Asia/Tokyo"); // タイムゾーンをTokyo（JST）に設定

ini_set("display_errors", "0"); // エラーを画面に出力しない
ini_set("display_startup_errors", "0"); // 起動で発生したエラーを画面に出力しない
ini_set("html_errors", "0"); // エラーメッセージにHTMLタグを含まない（プレーンテキスト）

error_reporting(E_ALL); // すべてのPHPエラーを拾う

try {
    require(__DIR__ . "/../vendor/autoload.php");

    // load env var
    try {
        $_ENV = getenv();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    } catch (Exception $e) {
        Logger::error(__FILE__ . ":" . __LINE__ . " Cannot load .env file");
    }

    ini_set("error_log", $_ENV["ERROR_LOG_FILE"]); // エラーログの出力先を変更

    Logger::debug("=== Request start ===");

    session_start();

    $req = new Request(
        $_SERVER,
        $_GET,
        $_POST,
        $_COOKIE,
        $_FILES,
        $_REQUEST,
        $_SESSION
    );
    $res = Dispatch::getResponse($req);

    $res->writeHeader();
    $res->writeBody();

    return;
} catch (Throwable $e) {
    // 異常終了
    $error_class_name = get_class($e);
    error_log("Uncaught Exception {$error_class_name}: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}\n{$e->getTraceAsString()}");

    echo "Internal Server Error";
    return;
}
