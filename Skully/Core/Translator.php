<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/8/14
 * Time: 8:55 PM
 */

namespace Skully\Core;


/**
 * Class Translator
 * @package Skully\Core
 * Store all translations of a language.
 * Translations can store arguments, for example consider this translation item:
 * "description" => "Welcome to {$sitename}"
 * Then you can pass arguments to translate method:
 * $translator->translate('description', array('sitename' => 'hostingheroes.com'))
 */
class Translator implements TranslatorInterface{
    /**
     * @var string
     * Language this translator is translating into.
     */
    protected $language = 'en';

    /**
     * @var array
     * array('key' => 'translation of key')
     */
    protected $translations = array();

    /**
     * @param string $language
     */
    public function __construct($language = 'en')
    {
        $this->language = $language;
    }

    /**
     * @param array $additionalTranslations
     */
    public function addTranslations($additionalTranslations = array())
    {
        $this->translations = array_merge($this->translations, $additionalTranslations);
    }
    /**
     * @param $value
     * @param array $args
     * @return mixed
     * Translate a value and replace its arguments.
     */
    public function translate($value, $args = array())
    {
        if (!empty($this->translations[$value])) {
            $string = $this->translations[$value];
            if (!empty($args)) {
                foreach($args as $index => $arg) {
                    $string = str_replace('{$'.$index.'}', $arg, $string);
                }
            }
            return $string;
        }
        else {
            return $value;
        }
    }
} 