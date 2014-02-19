<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/8/14
 * Time: 10:02 PM
 */

namespace Skully\Core;

/**
 * Interface TranslatorInterface
 * @package Skully\Core
 * Store all translations of a language.
 * Translations can store arguments, for example consider this translation item:
 * "description" => "Welcome to {$sitename}"
 * Then you can pass arguments to translate method:
 * $translator->translate('description', array('sitename' => 'hostingheroes.com'))
 */
interface TranslatorInterface {

    /**
     * @param string $language
     */
    public function __construct($language = 'en');

    /**
     * @param array $additionalTranslations
     */
    public function addTranslations($additionalTranslations = array());

    /**
     * @param $value
     * @param array $args
     * @return mixed
     * Translate a value and replace its arguments.
     */
    public function translate($value, $args = array());
}