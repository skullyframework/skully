<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/20/13
 * Time: 4:51 PM
 */

namespace Tests\Controllers;

use Skully\Application;
use Skully\Core\Config;

class ApplicationTest extends \PHPUnit_Framework_TestCase {


    /**
     * @var Application
     */
    protected $app;
    public function setUp()
    {
        $config = new Config();
        $config->setProtectedFromArray(array(
            'basePath' => '/',
            'urlRules' => array(
                '' => 'home/index'
            ),
            'timezone' => 'Asia/Jakarta'
        ));

        $this->app = new Application($config);
    }

    public function testGetConfig()
    {
        $this->app->getConfigObject()->setProtected('test1', 'value');
        $this->app->getConfigObject()->setPublic('test2', 'value2');
        $this->assertEquals('value', $this->app->config('test1'));
    }

    public function testConfigOverride()
    {
        $this->app->getConfigObject()->setProtected('override', '2');
        $this->app->getConfigObject()->setPublic('override', '1');
        $this->assertEquals('2', $this->app->config('override'));
    }

    public function testGetAppName()
    {
        $this->assertEquals('Skully', $this->app->getAppName());
    }

    /**
     * @expectedException \Skully\Exceptions\InvalidConfigException
     */
    public function testGetLanguageInvalidConfig()
    {
        $this->app->getXmlLang();
    }

    public function testIsAjax()
    {
        $this->assertFalse($this->app->isAjax());
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
        $this->assertTrue($this->app->isAjax());
    }

    public function testGetLanguage()
    {

    }

}
