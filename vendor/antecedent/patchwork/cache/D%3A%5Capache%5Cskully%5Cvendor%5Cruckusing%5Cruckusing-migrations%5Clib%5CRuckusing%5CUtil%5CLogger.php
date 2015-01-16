<?php
 \Patchwork\Interceptor\applyScheduledPatches();
/**
 * Ruckusing
 *
 * @category  Ruckusing
 * @package   Ruckusing_Util
 * @author    Cody Caughlan <codycaughlan % gmail . com>
 * @link      https://github.com/ruckus/ruckusing-migrations
 */

/**
 * Ruckusing_Util_Logger
 *
 * @category Ruckusing
 * @package  Ruckusing_Util
 * @author   Cody Caughlan <codycaughlan % gmail . com>
 * @link      https://github.com/ruckus/ruckusing-migrations
 */
class Ruckusing_Util_Logger
{
    /**
     * Instance of logger
     *
     * @var Ruckusing_Util_Logger
     */
    private static $_instance;

    /**
     * file
     *
     * @var string
     */
    private $_file = '';

    /**
     * File descriptor
     *
     * @var resource
     */
    private $_fp;

    /**
     * Creates an instance of Ruckusing_Util_Logger
     *
     * @param string $file the path to log to
     *
     * @return Ruckusing_Util_Logger
     */
    public function __construct($file)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->_file = $file;
        $this->_fp = fopen($this->_file, "a+");
    }

    /**
     * Close the file descriptor
     *
     * @return void
     */
    public function __destruct()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->close();
    }

    /**
     * Singleton for the instance
     *
     * @param string $logfile the path to log to
     *
     * @return object
     */
    public static function instance($logfile)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if (self::$_instance !== NULL) {
            return $instance;
        }
        $instance = new Ruckusing_Util_Logger($logfile);

        return $instance;
    }

    /**
     * Log a message
     *
     * @param string $msg message to log
     */
    public function log($msg)
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if ($this->_fp) {
            $ts = date('M d H:i:s', time());
            $line = sprintf("%s [info] %s\n", $ts, $msg);
            fwrite($this->_fp, $line);
        } else {
            throw new Ruckusing_Exception(
                    sprintf("Error: logfile '%s' not open for writing!", $this->_file),
                    Ruckusing_Exception::INVALID_LOG
            );
        }

    }

    /**
     * Close the log file handler
     */
    public function close()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if ($this->_fp) {
            $closed = fclose($this->_fp);
            if ($closed) {
                $this->_fp = null;
                self::$_instance = null;
            } else {
                throw new Ruckusing_Exception(
                        'Error closing the log file',
                        Ruckusing_Exception::INVALID_LOG
                );
            }
        }
    }

}\Patchwork\Interceptor\applyScheduledPatches();
