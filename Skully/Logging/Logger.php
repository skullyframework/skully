<?php


namespace Skully\Logging;


/**
 * Class Logger
 * @package Skully\Core
 */
class Logger implements LoggerInterface{
    /**
     * @var string
     */
    protected $basePath = '/';

    /**
     * @param string $basePath
     */
    public function __construct($basePath = '/')
    {
        $this->basePath = $basePath;
    }

    /**
     * @var string $message
     * @var string $code
     * @var boolean $asString
     * @return string|boolean
     * Use this instead of errorLog, so that messages triggered from cron may also be logged
     * Remember that php's thrown errors are still displayed in error log file configured from php.ini.
     */
    public function log($message, $code = 'error', $asString = false)
    {
        date_default_timezone_set('Asia/Jakarta');
        $datetime = new \DateTime();
        if ($asString == false) {
            if (!file_exists($this->basePath.'logs')) {
                mkdir($this->basePath.'logs');
            }
            if (!file_exists($this->basePath.'logs/error.log')) {
                file_put_contents($this->basePath.'logs/error.log', '');
            }
            if (filesize($this->basePath.'logs/error.log') > 5000000) {
                $count = 1;
                while(file_exists($this->basePath.'logs/error'.$count.'.log')) {
                    $count+=1;
                }
                copy($this->basePath.'logs/error.log', $this->basePath.'logs/error'.$count.'.log');
                unlink($this->basePath.'logs/error.log');
            }
//            $this->prepend($this->basePath.'logs/error.log', "[".$datetime->format(\DateTime::COOKIE)." $code] ".$message."\n");
            file_put_contents($this->basePath.'logs/error.log', "[".$datetime->format(\DateTime::COOKIE)." $code] ".$message."\n", FILE_APPEND);
            return true;
        }
        else {
            return "[".$datetime->format(\DateTime::COOKIE)."] ".$message;
        }
    }

    /**
     * @param bool $asString
     * @return bool|string
     */
    public function debugBacktrace($asString = false)
    {
        $func = function($value) {
            $class = '';
            if (!empty($value['class']) && !is_string($value['class'])) {
                $class = get_class($value['class']);
            }
            elseif (!empty($value['class'])) {
                $class = $value['class'];
            }

            if (!empty($value['args'])) {
                foreach($value['args'] as $id => $arg) {
                    if (is_object($arg)) {
                        $value['args'][$id] = get_class($arg);
                    }
                    elseif (is_array($arg)) {
                        $value['args'][$id] = print_r($arg, true);
                    }
                }
            }

            if (!isset($value['type'])) {
                $type = '';
            }
            else {
                $type = $value['type'];
            }
            if (!isset($value['args'])) {
                $args = array();
            }
            else {
                $args = $value['args'];
            }

            if (!empty($value['file'])) {
                return $class.$type.$value['function'].'('.implode(', ',$args).') '.$value['file'].'('.$value['line'].')';
            }
            elseif (!empty($value['class'])) {
                return $class.$type.$value['function'].'('.implode(', ',$args).')';
            }
            else {
                return '(unknown file)' . $value['function'] . '('.implode(', ', $args).')';
            }
        };

        return $this->log("debug backtrace: " . print_r(array_map($func, debug_backtrace()), true), 'debug', $asString);
    }
    /**
     * @param $file
     * @param string $cache_new
     */
    protected function prepend($file, $cache_new = '')
    {
        $handle = fopen($file, "r+");
        $len = strlen($cache_new);
        $final_len = filesize($file) + $len;
        $cache_old = fread($handle, $len);
        rewind($handle);
        $i = 1;
        while (ftell($handle) < $final_len) {
            fwrite($handle, $cache_new);
            $cache_new = $cache_old;
            $cache_old = fread($handle, $len);
            fseek($handle, $i * $len);
            $i++;
        }
    }
} 