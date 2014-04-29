<?php
// First let's define our apps root directory
if (!defined('BASE_PATH')) {
    define("BASE_PATH", realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
}
$session_id = session_id();
session_start();
mb_internal_encoding("UTF-8");

require_once(BASE_PATH . 'include.php');
use Skully\Core\Config;

require_once( BASE_PATH.'config.common.php');
require_once( BASE_PATH.'config.unique.php');

if (!function_exists('__setupApp')) {
    function __setupApp() {
        $config = new Config();
        $config->setProtected('basePath', BASE_PATH);

        setCommonConfig($config);
        setUniqueConfig($config);
        return new \App\Application($config);
    }
}

if (!function_exists('errorHandler')) {

    function errorHandler($error_level, $error_message, $error_file, $error_line, $error_context)
    {
        $logger = new \Skully\Logging\Logger(BASE_PATH);
        $error = "lvl: " . $error_level . " | msg:" . $error_message . " | file:" . $error_file . " | ln:" . $error_line;
        $error .= "\nGET: " . print_r($_GET, true)."\n";
        $error .= "POST: " . print_r($_POST, true)."\n";
        ob_start();
//        debug_print_backtrace(1,8);
        $trace = ob_get_clean();
        $error .= "\n$trace\n";
        switch ($error_level) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_PARSE:
                $logger->log($error, "fatal");
                return false;
                break;
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                $logger->log($error, "error");
                return false;
                break;
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
//                $logger->log($error, "warn");
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
//                $logger->log($error, "info");
                break;
            case E_STRICT:
//                $logger->log($error, "debug");
                break;
            default:
//                return \Exception($error);
//                $logger->log($error, "warn");
        }
        /** Do not remove! Needed so try {} can be caught */
        return true;
    }

    function shutdownHandler() //will be called when php script ends.
    {
        $logger = new \Skully\Logging\Logger(BASE_PATH);
        $lasterror = error_get_last();
        switch ($lasterror['type'])
        {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_PARSE:
                $error = "[SHUTDOWN] lvl:" . $lasterror['type'] . " | file:" . $lasterror['file'] . " | ln:" . $lasterror['line'];
                $error .= "\nGET: " . print_r($_GET, true)."\n";
                $error .= "POST: " . print_r($_POST, true)."\n";
                $error .= $lasterror['message']."\n";
                ob_start();
                debug_print_backtrace(1,8);
                $trace = ob_get_clean();
                $error .= "$trace\n";

                $logger->log($error, "fatal");
        }
    }
    set_error_handler("errorHandler");
    register_shutdown_function("shutdownHandler");
}