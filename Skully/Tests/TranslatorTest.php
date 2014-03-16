<?php


namespace Skully\Tests;

use Skully\Core\Translator;

class TranslatorTest extends \PHPUnit_Framework_TestCase {
    public function testTranslate()
    {
        $translator = new Translator('en');
        $translator->addTranslations(array('description' => 'Welcome to {$sitename}'));
        $this->assertEquals('Welcome to hostingheroes.com', $translator->translate('description', array('sitename' => 'hostingheroes.com')));
        $this->assertEquals('something', $translator->translate('something'));
    }
}
 