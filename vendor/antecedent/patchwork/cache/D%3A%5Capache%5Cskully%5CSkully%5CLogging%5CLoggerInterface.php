<?php


namespace Skully\Logging; \Patchwork\Interceptor\applyScheduledPatches();


/**
 * Interface LoggerInterface
 * @package Skully\Core
 */
interface LoggerInterface {

    /**
     * @param string $basePath
     */
    public function __construct($basePath = '/');

    /**
     * @var string $message
     * @var string $code
     * @var boolean $asString
     * @return string|boolean
     * Use this instead of errorLog, so that messages triggered from cron may also be logged
     * Remember that php's thrown errors are still displayed in error log file configured from php.ini.
     */
    public function log($message, $code = 'error', $asString = false);

    /**
     * @param bool $asString
     * @return bool|string
     */
    public function debugBacktrace($asString = false);
}