<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/21/13
 * Time: 3:50 PM
 */

namespace Skully\Tests;

use Skully\Core\Config;
use Skully\Application;
use Skully\App\Controllers\HomeController;
use Skully\Core\ControllerFactory;

// Include Home2Controller, required for testing.
require_once('App/include.php');

class ControllerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Application
     */
    protected $app;

    public function setUp()
    {
        $config = new Config();
        $config->setProtectedFromArray(array(
            'basePath' => realpath(dirname(__FILE__).'/../../../../../../').'/',
            'baseUrl' => 'http://localhost/skully/',
            'urlRules' => array(
                '' => 'home/index'
            ),
            'theme' => 'default',
            'timezone' => 'Asia/Jakarta'
        ));
        $this->app = new Application($config);
    }

    public function testConstructDirect()
    {
        $controller = new HomeController($this->app, 'index', array('param1' => 'value'));
        $this->assertEquals('value', $controller->getParam('param1'));
        $this->assertEquals('index', $controller->getCurrentAction());
        $this->assertTrue(in_array(get_class($controller), array('Skully\App\Controllers\HomeController', 'App\Controllers\HomeController')));
//        $this->assertEquals('Skully\App\Controllers\HomeController', get_class($controller));
    }

    public function testConstructFromFactory()
    {
        $controller = ControllerFactory::create($this->app, 'Home', 'index', array('param1' => 'value'));
        $this->assertEquals('value', $controller->getParam('param1'));
        $this->assertEquals('index', $controller->getCurrentAction());
        $this->assertTrue(in_array(get_class($controller), array('Skully\App\Controllers\HomeController', 'App\Controllers\HomeController')));
//        $this->assertEquals('Skully\App\Controllers\HomeController', get_class($controller));
    }

    public function testConstruct()
    {
        /** @var $controller \Skully\App\Controllers\HomeController */
        $controller = $this->app->getController('Home', 'index', array('param1' => 'value'));
        $this->assertTrue(in_array(get_class($controller), array('Skully\\App\\Controllers\\HomeController', 'App\\Controllers\\HomeController') ));
        $this->assertEquals('value', $controller->getParam('param1'));
//        $this->assertEquals('Skully\App\Controllers\HomeController', get_class($controller));
    }

    public function testConstructShouldRemoveParams()
    {
        /** @var $controller \Skully\App\Controllers\HomeController */
        $controller = $this->app->getController('home', 'index', array('param1' => 1));
        $this->assertEquals(1, $controller->getParam('param1'));
        $controller = $this->app->getController('home', 'index', array('param2' => 1));
        $this->assertEmpty($controller->getParam('param1'));
        $this->assertEquals(1, $controller->getParam('param2'));
    }

    public function testFindLanguage()
    {
        $this->app->getConfigObject()->setPublic('language', 'Indonesian');
        $this->assertEquals('Indonesian', $this->app->getLanguage());
    }

    public function testRunActionShouldChangeCurrentAction()
    {
        $this->app->getController('Home2', 'index')->runAction('view');
        $this->assertEquals('view', $this->app->getController('Home2')->getCurrentAction());
    }

    /**
     * Test that given route is translated correctly.
     */
    public function testEmptyRoute()
    {
        $url = '?something=1';
        $controller = $this->app->getControllerFromRawUrl($url);
        $this->assertEquals('index', $controller->getCurrentAction());
    }

    public function testSingleRoute()
    {
        $url = 'home?something=1';
        $controller = $this->app->getControllerFromRawUrl($url);
        $this->assertEquals('index', $controller->getCurrentAction());
        $this->assertEquals('1', $controller->getParam('something'));
    }
    public function testNewsRoute()
    {
        $config = new Config();
        $config->setProtectedFromArray(array(
            'basePath' => realpath(dirname(__FILE__).'/../../../../../../').'/',
            'baseUrl' => 'http://localhost/skully/',
            'urlRules' => array(
                '' => 'home/index',
                'products/c/%cid' => 'products/viewCategory',
                'products/index' => 'products/index',
                'products/%id' => 'products/view',
                'cart/add' => 'checkout/cartAdd',
                'cart/index' => 'checkout/cart',
                'cart/update' => 'checkout/updateCart',
                'cart/remove' => 'checkout/removeItem',
                'cart/apply-coupon' => 'checkout/applyCoupon',
                'checkout/index' => 'checkout/checkout',
                'klikpay' => 'payment/klikpay',
                //admin
                'admin' => 'admin/home/index',
                'admin/index' => 'admin/home/index'
            ),
            'theme' => 'default',
            'timezone' => 'Asia/Jakarta'
        ));
        $app = new Application($config);

        $url = 'news/index?cid=1';
        $controller = $app->getControllerFromRawUrl($url);
        $this->assertEquals('index', $controller->getCurrentAction());
        $this->assertEquals('1', $controller->getParam('cid'));
    }

    public function testTwoItemsRoute()
    {
        $url = 'home/index';
        $controller = $this->app->getControllerFromRawUrl($url);
        $this->assertTrue(in_array(get_class($controller), array('Skully\App\Controllers\HomeController', 'App\Controllers\HomeController')));
        $this->assertEquals('index', $controller->getCurrentAction());
    }
    public function testThreeItemsRoute()
    {
        $url = 'admin/admins/index';
    }

    public function testRunCurrentAction()
    {
        $controller = $this->app->getControllerFromRawUrl('home/something');
        $output = $controller->runCurrentAction();
        $this->assertEquals('something', $output);
    }

    public function testRunAction()
    {
        $controller = $this->app->getControllerFromRawUrl('home/something');

    }

}