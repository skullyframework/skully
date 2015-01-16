<?php


namespace Skully\Tests\Views; \Patchwork\Interceptor\applyScheduledPatches();

use \org\bovigo\vfs\vfsStream;
use \Skully\Core\Config;

require_once(realpath(dirname(__FILE__) . '/../') . '/realpath_custom.php');
require_once(realpath(dirname(__FILE__) . '/../') . '/App/include.php');

class TranslatorPluginTest extends \PHPUnit_Framework_TestCase {
    protected $root;
    protected function getStructure()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $path = realpath(dirname(__FILE__).'/../../../');
        $path_r = explode(DIRECTORY_SEPARATOR, $path);
        return array(
            'App' => array(
                'smarty' => array(
                    'templates_c' => array()
                )
            ),
            'logs' => array(
                'error.log' => ''
            ),
            'public' => array(
                'default' => array(
                    'App' => array(
                        'views' => array(
                            'plugins' => array(
                                'lang.tpl' => '{lang value=three}',
                                'langArgs.tpl' => '{lang value=args arg=awesome}'
                            )
                        ),
                        'languages' => array(
                            'en' => array(
                                'plugins' => array(
                                    '_pluginsLang.json' => '{"three" : "app default en", "args": "Jay is {$arg}"}',
                                    'langLang.json' => '{"a_three" : "a app default en"}'
                                ),
                                'commonLang.json' => '{"c_three" : "c app default en", "big6" : "default", "big7": "default"}'
                            ),
                            'id' => array(
                                'plugins' => array(
                                    '_pluginsLang.json' => '{"four" : "app default id", "big1" : "controller", "big2": "controller"}',
                                    'langLang.json' => '{"a_four" : "a app default id", "big1" : "action"}'
                                ),
                                'commonLang.json' => '{"c_four" : "c app default id", "big1" : "common", "big2": "common", "big3": "common"}'
                            )
                        )
                    )
                ),
                'test' => array(
                    'App' => array(
                        'languages' => array(
                            'en' => array(
                                'plugins' => array(
                                    '_pluginsLang.json' => '{"five" : "app test en"}',
                                    'langLang.json' => '{"a_five" : "a app test en", "big4": "en", "big5": "en"}'
                                ),
                                'commonLang.json' => '{"c_five" : "c app test en", "big6" : "test"}'
                            ),
                            'id' => array(
                                'plugins' => array(
                                    '_pluginsLang.json' => '{"six" : "app test id"}',
                                    'langLang.json' => '{"a_six" : "a app test id"}'
                                ),
                                'commonLang.json' => '{"c_six" : "c app test id"}'
                            )
                        )
                    )
                )
            ),
        );
    }

    protected function getApp()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $structure = $this->getStructure();
        $this->root = vfsStream::setup('root', 777, $structure);
//        print_r(vfsStream::inspect(new vfsStreamStructureVisitor())->getStructure());
        $config = new Config();
        $config->setProtectedFromArray(array(
            'theme' => 'test',
            'language' => 'en',
            'languages' => array('en' => array('value' => 'english', 'code' => 'en')),
            'basePath' => vfsStream::url('root'),
            'skullyBasePath' => vfsStream::url('root/vendor/triodigital/skully/'),
            'baseUrl' => 'http://localhost/skully/',
            'urlRules' => array(
                '' => 'home/index',
                'admin' => 'admin/home/index'
            )
        ));
        $_SESSION['__language'] = 'id';
        $app = new \App\Application($config);

        unsetRealpath();
        $pluginsPath = realpath(__DIR__.'/../../App/smarty/plugins');
        setRealpath();
        $app->getTemplateEngine()->addPluginsDir($pluginsPath);

        return $app;
    }

    public function testPassAppToSmarty()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $smarty = $app->getTemplateEngine();
        $this->assertEquals($app, $smarty->getRegisteredObject('app'));
        unsetRealpath();
    }

    public function testPluginDefined()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        $smarty = $app->getTemplateEngine();
        $smarty->loadPlugin('smarty_function_lang', true);
        setRealpath();
        $this->assertTrue(function_exists('smarty_function_lang'));
        unsetRealpath();
    }

    public function testGetLanguageFromFile()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        setRealpath();
        $app = $this->getApp();
        $app->getControllerFromRawUrl('plugins/lang');

//      controller
        $this->assertEquals('app default en', $app->getTranslator()->translate('three'));
        $this->assertEquals('app default id', $app->getTranslator()->translate('four'));
        $this->assertEquals('app test en', $app->getTranslator()->translate('five'));
        $this->assertEquals('app test id', $app->getTranslator()->translate('six'));

//      common
        $this->assertEquals('c app default en', $app->getTranslator()->translate('c_three'));
        $this->assertEquals('c app default id', $app->getTranslator()->translate('c_four'));
        $this->assertEquals('c app test en', $app->getTranslator()->translate('c_five'));
        $this->assertEquals('c app test id', $app->getTranslator()->translate('c_six'));

//      action
        $this->assertEquals('a app default en', $app->getTranslator()->translate('a_three'));
        $this->assertEquals('a app default id', $app->getTranslator()->translate('a_four'));
        $this->assertEquals('a app test en', $app->getTranslator()->translate('a_five'));
        $this->assertEquals('a app test id', $app->getTranslator()->translate('a_six'));

//      action > controller > common
        $this->assertEquals('action', $app->getTranslator()->translate('big1'));
        $this->assertEquals('controller', $app->getTranslator()->translate('big2'));
        $this->assertEquals('common', $app->getTranslator()->translate('big3'));

//      id > en
        $this->assertEquals('en', $app->getTranslator()->translate('big5'));

//      test > default
        $this->assertEquals('test', $app->getTranslator()->translate('big6'));
        $this->assertEquals('default', $app->getTranslator()->translate('big7'));

//      arguments passing
        ob_start();
        $app->runControllerFromRawUrl('plugins/langArgs');
        $output = ob_get_clean();
        $this->assertEquals('Jay is awesome', $output);
        unsetRealpath();
        $smarty = $app->getTemplateEngine();
        $smarty->loadPlugin('smarty_function_lang', true);
        setRealpath();
        $this->assertTrue(function_exists('smarty_function_lang'));
        unsetRealpath();
    }

    public function testGetLanguageByRunningController()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = $this->getApp();
        setRealpath();
        ob_start();
        $app->runControllerFromRawUrl('plugins/lang');
        $output = ob_get_clean();
        $file = 'vfs://root/public/default/App/languages/en/plugins/_pluginsLang.json';
        $this->assertTrue(file_exists($file));
        $json = file_get_contents($file);
        $this->assertFalse(empty($json));
        $json_r = json_decode($json, true);
        $this->assertEquals('app default en', $json_r['three']);
        $this->assertEquals('app default en', $output);
        unsetRealpath();
    }
}\Patchwork\Interceptor\applyScheduledPatches();
