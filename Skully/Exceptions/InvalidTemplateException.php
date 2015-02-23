<?php


namespace Skully\Exceptions;

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
    public static function throwError($e, $file) {
        if (strpos($e->getMessage(), 'Undefined index') !== false || strpos($e->getMessage(), 'Unable to load template file') !== false) {
            throw new self($e->getMessage() . " at file $file", self::$UNDEFINED_INDEX);
        }
        else {
            throw new self($e->getTraceAsString(), self::$OTHERS);
        }
    }
} 