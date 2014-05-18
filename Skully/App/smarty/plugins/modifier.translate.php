<?php

function smarty_modifier_translate($value, $lang) {
    $string = \App\Helpers\TextHelper::modelTranslator($value, $lang);
    return $string;
}