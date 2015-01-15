<?php


function stubRedirect($url) {
    echo "redirect to $url\n";
}

/**
 * @param $text
 * @return string
 * Replace directory separators i.e. '/' and '\' to DIRECTORY_SEPARATOR
 */
function replaceSeparators($text) {
    $text = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $text);
    $text = str_replace(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR, '//', $text);
    return $text;
}