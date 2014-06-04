<?php


namespace Skully\App\Models\Traits;


use Skully\App\Helpers\TextHelper;

/**
 * Class HasTranslation
 * @package App\Models\Traits
 * Useful for classes having translated text as one of their fields.
 * A translated text contains a json with this format: {"lang1":"text", "lang2":"text"}
 */
trait HasTranslation {
    public function translate($field, $lang = null) {
        if (is_null($lang)) {
            /** @var \App\Models\BaseModel $this */
            $lang = $this->getApp()->config('language');
        }
        return TextHelper::modelTranslator($this->get($field), $lang);
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