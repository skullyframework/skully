<?php


namespace Skully\Exceptions; \Patchwork\Interceptor\applyScheduledPatches();

/**
 * Class InvalidTemplateException
 * @package Skully\Exceptions
 * Exceptions thrown when a thing goes wrong in template file.
 * This is needed so that PHPUnit shows the troubling template file.
 */
/**
 * Class InvalidTemplateException
 * @package Skully\Exceptions
 */
class InvalidTemplateException extends \Exception {
    /**
     * @var int
     */
    static $UNDEFINED_INDEX = 1;
    /**
     * @var int
     */
    static $OTHERS = 99;

    /**
     * @param \Exception $e
     * @param $file
     * @throws InvalidTemplateException
     */
    public static function throwError($e, $file) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if (strpos($e->getMessage(), 'Undefined index') !== false) {
            throw new self($e->getMessage() . " at file $file", self::$UNDEFINED_INDEX);
        }
        else {
            throw new self($e->getTraceAsString(), self::$OTHERS);
        }
    }
}\Patchwork\Interceptor\applyScheduledPatches(); 