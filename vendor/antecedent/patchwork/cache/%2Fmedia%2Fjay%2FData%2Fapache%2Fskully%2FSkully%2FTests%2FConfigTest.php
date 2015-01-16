<?php


namespace Skully\Tests; \Patchwork\Interceptor\applyScheduledPatches();


use Skully\Core\Config;
use \Skully\Application;

/**
 * Class ConfigTest
 * @package Tests\Others
 * Testing Skully Framework's Config class
 */
class ConfigTest extends \PHPUnit_Framework_TestCase {

    public function testSetProtected()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $config = new Config();
        $config->setProtected('test', 'value');
        $this->assertEquals('value', $config->get('test'));
    }
    public function testSetPublic()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $config = new Config();
        $config->setPublic('test', 'value');
        $this->assertEquals('value', $config->get('test'));
    }
    public function testSetProtectedFromArray()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $config = new Config();
        $config->setProtectedFromArray(array('test2' => 'value'));
        $this->assertEquals('value', $config->get('test2'));
    }
    public function testSetPublicFromArray()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $config = new Config();
        $config->setPublicFromArray(array('test' => 'value'));
        $this->assertEquals('value', $config->getPublic('test'));
    }

    /**
     * @expectedException \Skully\Exceptions\InvalidConfigException
     * This is exactly the reason why you do not want singleton in your apps.
     * Imagine if Application::construct() calls for Application's static instance.
     * Somewhere in the code config for this object might have been created which makes
     * the object valid. In that case there is no way to test if
     * Exception can be called when class uses Singleton pattern.
     */
    public function testApplicationWithoutConfigMustThrowError()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
//        This is the old code. With this code it is not possible to test Exceptions.
//        $app = Application::construct(Config::construct());
        $app = new Application(new Config());
        $app->getRouter();
    }

}\Patchwork\Interceptor\applyScheduledPatches();
 