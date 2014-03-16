<?php


namespace Skully\Core;


/**
 * Class Http
 * Needed so we can mock redirect in PHPUnit (otherwise redirect() method will break our testing.
 * @package Skully\Core
 */
class Http {
    /**
     * @param $url
     * @return null
     */
    public function redirect($url)
    {
        header('Location: '.$url);
        exit;
    }
} 