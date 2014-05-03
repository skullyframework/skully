<?php

namespace Skully\App\Helpers;

use Skully\Core\ApplicationAwareHelper;

class TimeHelper extends ApplicationAwareHelper{

    public static function isEmpty($date)
    {
        if ($date == '0000-00-00 00:00:00' || empty($date)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Retrieve date string from input, convert to string acceptable in database.
     * @param $date string
     * @return string
     */
    public static function toDb($date) {
        if (empty($date)) {
            return '0000-00-00 00:00:00';
        }
        else {
            return self::date(\DateTime::ISO8601, strtotime($date));
        }
    }

    // PHP date function with a twist. With standard function, null returned year 1970 date. With this, returns '' instead.
    public static function date($format, $timestamp) {
        if (empty($timestamp)) {
            return '';
        }
        else {
            return date($format, $timestamp);
        }
    }
}