<?php


namespace Skully\Tests\Views;

use \org\bovigo\vfs\vfsStream;
use \Skully\Core\Config;

require_once(realpath(dirname(__FILE__) . '/../') . '/realpath_custom.php');
require_once(realpath(dirname(__FILE__) . '/../') . '/App/include.php');

class ThemePluginTest extends \PHPUnit_Framework_TestCase {
    protected $root;
    protected function getStructure()
    {
        $path = realpath(dirname(__FILE__).'/../../../');
        $path_r = explode(DIRECTORY_SEPARATOR, $path);
        return array(
            'logs' => array(
                'error.log' => ''
            ),
            'public' => array(
                'images' => array(
                    'test.jpg' => 'test'
                ),
                'default' => array(
                    'App' => array(
                        'views' => array(
                            'themes' => array(
                                'skullyTheme.tpl' => '{theme_url path="resources/css/skully.css" arg1="arg1"}',
                                'defaultTheme.tpl' => '{theme_url path="resources/css/default.css"}',
                                'testTheme.tpl' => '{theme_url path="resources/css/test.css"}',
                                'testPublicUrl.tpl' => '{public_url path="images/test.jpg"}',
                                'testPublicUrlArgs.tpl' => '{public_url path="images/test.jpg" arg="arg1"}'
                            )
                        )
                    ),
                    'resources' => array(
                        'css' => array(
                            'default.css' => 'default'
                        )
                    )
                ),
                'test' => array(
                    'resources' => array(
                        'css' => array(
                            'test.css' => 'test'
                        )
                    )
                )
            ),
            'vendor' => array(
                'triodigital' => array(
                    'skully' => array(
                        'public' => array(
                            'default' => array(
                                'resources' => array(
                                    'css' => array(
                                        'skully.css' => 'skully'
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );
    }

    protected function getApp()
    {
        $structure = $this->getStructure();
        $this->root = vfsStream::setup('root', 777, $structure);
        $config = new Config();
        $config->setProtectedFromArray(array(
            'theme' => 'test',
            'language' => 'en',
            'languages' => array('en' => array('value' => 'english', 'code' => 'en' )),
            'basePath' => vfsStream::url('root'),
            'skullyBasePath' => vfsStream::url('root/vendor/triodigital/skully/'),
            'baseUrl' => 'http://localhost/skully/',
            'urlRules' => array(
                '' => 'home/index',
                'admin' => 'admin/home/index'
            )
        ));
        $_SESSION['language'] = 'id';
        setRealPath();
        $app = new \App\Application($config);
        unsetRealpath();
        $pluginsPath = realpath(__DIR__.'/../../App/smarty/plugins');
        setRealpath();
        $app->getTemplateEngine()->addPluginsDir($pluginsPath);
        return $app;
    }

    public function testThemeConstruct()
    {
        $path = realpath(dirname(__FILE__).'/../../../');
        $path_r = explode(DIRECTORY_SEPARATOR, $path);
        $app = $this->getApp();
        $this->assertEquals('vfs://root/public/', $app->getTheme()->getBasePath());
        unsetRealpath();
    }

    public function testGetUrl()
    {
        $path = realpath(dirname(__FILE__).'/../../../');
        $path_r = explode(DIRECTORY_SEPARATOR, $path);
        $app = $this->getApp();
        $this->assertEquals($app->config('baseUrl').'public/test/resources/css/test.css', $app->getTheme()->getUrl('resources/css/test.css'));
        $this->assertEquals($app->config('baseUrl').'public/default/resources/css/default.css', $app->getTheme()->getUrl('resources/css/default.css'));
        unsetRealpath();
    }

    public function testGetUrlFromPlugin()
    {
        $path = realpath(dirname(__FILE__).'/../../../');
        $path_r = explode(DIRECTORY_SEPARATOR, $path);
        $app = $this->getApp();
        $app->getTemplateEngine()->loadPlugin('smarty_function_theme_url');
        ob_start();
        $app->runControllerFromRawUrl('themes/testTheme');
        $output = ob_get_clean();
        $this->assertEquals($app->config('baseUrl').'public/test/resources/css/test.css', $output);

        ob_start();
        $app->runControllerFromRawUrl('themes/defaultTheme');
        $output = ob_get_clean();
        $this->assertEquals($app->config('baseUrl').'public/default/resources/css/default.css', $output);

        unsetRealpath();
    }

    public function testPublicUrl()
    {
        $app = $this->getApp();
        $app->getTemplateEngine()->loadPlugin('smarty_function_theme_url');

        ob_start();
        $app->runControllerFromRawUrl('themes/testPublicUrl');
        $output = ob_get_clean();
        $this->assertEquals($app->config('baseUrl').'public/images/test.jpg', $output);

        ob_start();
        $app->runControllerFromRawUrl('themes/testPublicUrlArgs');
        $output = ob_get_clean();
        $this->assertEquals($app->config('baseUrl').'public/images/test.jpg?arg=arg1', $output);
        unsetRealpath();
    }
}
 