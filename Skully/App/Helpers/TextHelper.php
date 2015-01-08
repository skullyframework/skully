<?php

namespace Skully\App\Helpers;

class TextHelper
{
    public static function isJson($string)
    {
//        $pcre_regex = '
//  /
//  (?(DEFINE)
//     (?<number>   -? (?= [1-9]|0(?!\d) ) \d+ (\.\d+)? ([eE] [+-]? \d+)? )
//     (?<boolean>   true | false | null )
//     (?<string>    " ([^"\\\\]* | \\\\ ["\\\\bfnrt\/] | \\\\ u [0-9a-f]{4} )* " )
//     (?<array>     \[  (?:  (?&json)  (?: , (?&json)  )*  )?  \s* \] )
//     (?<pair>      \s* (?&string) \s* : (?&json)  )
//     (?<object>    \{  (?:  (?&pair)  (?: , (?&pair)  )*  )?  \s* \} )
//     (?<json>   \s* (?: (?&number) | (?&boolean) | (?&string) | (?&array) | (?&object) ) \s* )
//  )
//  \A (?&json) \Z
//  /six
//';
//        return preg_match($pcre_regex, $string);
        try {
            $json = json_decode($string, true);
            return !empty($json) && is_array($json);
        }
        catch (\Exception $e) {
            return false;
        }
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
