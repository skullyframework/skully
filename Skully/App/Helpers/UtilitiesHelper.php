<?php

namespace Skully\App\Helpers;

/**
 * Class UtilitiesHelper
 * @package App\Helpers
 */
class UtilitiesHelper {

    public static function toHash($password, $salt, $globalSalt) {
        return md5($password . $salt . $globalSalt);
    }

    /**
     * @param $array
     * @return array
     * array_unique for multidimensional array
     */
    public static function superArrayUnique($array)
    {
        $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

        foreach ($result as $key => $value) {
            if ( is_array($value) ) {
                $result[$key] = self::superArrayUnique($value);
            }
        }

        return array_values($result);
    }

    // Change "false" or "0" or '' to false, others to true (yes, -1 is true, see http://stackoverflow.com/questions/137487/null-vs-false-vs-0-in-php).
    public static function toBoolean($status) {
        if (in_array($status, array('', '0', 'false', 0, false, null), true)) {
            return false;
        }
        else {
            return true;
        }
    }

    public static function isValidJson($jsonText) {
        json_decode($jsonText);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function randomColor() {
        $letters = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
        $color = '#';
        for ($i = 0; $i < 6; $i++ ) {
            $color .= $letters[rand(0,15)];
        }
        return $color;
    }

    /**
     * @param $jsonString string
     * @param $assoc boolean
     * @return mixed
     * Decode json string. Useful for strings of entities returned from database
     * with array hydration.
     */
    public static function decodeJson($jsonString, $assoc = false)
    {
        return json_decode(stripslashes(stripslashes((trim($jsonString, '"')))), $assoc);
    }
}