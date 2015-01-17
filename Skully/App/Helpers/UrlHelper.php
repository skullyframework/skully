<?php

namespace Skully\App\Helpers;

/**
 * Class UrlHelper
 * @package Skully\App\Helpers
 */
class UrlHelper {
    /**
     * @param $name
     * @param $id
     * @return string
     * "This is a product", 10 to this-is-a-product-10
     */
    public static function toPathId($name, $id)
    {
        $str = substr(strtolower($name), 0, 255);
        return str_replace(array(' ', '_'), '-', preg_replace('/[^a-z_ \-0-9]/i', '', $str)).'-'.$id;
    }

    /**
     * @param string $path
     * "this-is-a-product-10" to 10
     */
    public static function extractId($path)
    {
        $path_r = explode('-', $path);
        return $path_r[count($path_r)-1];
    }

    public static function isSecure() {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
    }
} 