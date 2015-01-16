<?php


namespace Skully\Core; \Patchwork\Interceptor\applyScheduledPatches();


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
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->language = $language;
    }

    /**
     * @param array $additionalTranslations
     */
    public function addTranslations($additionalTranslations = array())
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->translations = array_merge($this->translations, $additionalTranslations);
    }
    /**
     * @param $value
     * @param array $args
     * @return mixed
     * Translate a value and replace its arguments.
     */
    public function translate($value, $args = array())
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
}\Patchwork\Interceptor\applyScheduledPatches(); 