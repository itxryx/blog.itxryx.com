<?php
declare(strict_types=1);

namespace Itxryx\Blog\Utility;

use Monolog\Logger as MonologLogger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FilterHandler;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;

class Logger
{
    public static function create(): LoggerInterface {
        $logger = new MonologLogger('blog');

        $formatter = new LineFormatter(
            null,
            null,
            true,
            true
        );

        // DEBUG ~ NOTICE
        $debugHandler = new FilterHandler(
            new StreamHandler($_ENV["DEBUG_LOG_FILE"]),
            LogLevel::INFO,
            LogLevel::NOTICE
        );
        $debugHandler->setFormatter($formatter);
        $logger->pushHandler($debugHandler);

        // WARNING ~ CRITICAL
        $errorHandler = new FilterHandler(
            new StreamHandler($_ENV["ERROR_LOG_FILE"]),
            LogLevel::WARNING
        );
        $errorHandler->setFormatter($formatter);
        $logger->pushHandler($errorHandler);

        // QUERY LOG
        $queryHandler = new StreamHandler($_ENV["QUERY_LOG_FILE"]);
        $queryHandler->setFormatter($formatter);
        $logger->pushHandler($queryHandler);

        return $logger;
    }
}
