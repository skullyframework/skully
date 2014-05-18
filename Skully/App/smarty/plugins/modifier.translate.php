<?php

function smarty_modifier_translate($value, $lang) {
    $string = \Skully\App\Helpers\TextHelper::modelTranslator($value, $lang);
    return $string;
}