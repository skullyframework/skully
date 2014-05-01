<?php

namespace Skully\App\Helpers;

class TextHelper
{
    public static function isJson($string)
    {
        return !preg_match('/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/',
            preg_replace('/"(\\.|[^"\\])*"/g', '', $string));
    }

    public static function modelTranslator($json, $lang)
    {
        if (TextHelper::isJson($json)) {
            $array = json_decode($json, true);
            return $array[$lang];
        }
        else {
            return $json;
        }
    }
}
