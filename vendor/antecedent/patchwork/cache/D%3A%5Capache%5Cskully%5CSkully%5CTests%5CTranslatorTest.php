<?php


namespace Skully\Tests; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\Core\Translator;

class TranslatorTest extends \PHPUnit_Framework_TestCase {
    public function testTranslate()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $translator = new Translator('en');
        $translator->addTranslations(array('description' => 'Welcome to {$sitename}'));
        $this->assertEquals('Welcome to hostingheroes.com', $translator->translate('description', array('sitename' => 'hostingheroes.com')));
        $this->assertEquals('something', $translator->translate('something'));
    }
}\Patchwork\Interceptor\applyScheduledPatches();
 