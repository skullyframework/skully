<?php


namespace Skully\Tests;

use Skully\Core\Router;

class RouterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Router
     */
    protected $router;

    public function setUp()
    {
        $config_r = array(
            '' => 'home/index',
            'products/c/%cid' => 'products/viewCategory',
            'products/index' => 'products/index',
            'products/%id' => 'products/view',
            'admin/loginProcess' => 'admin/admins/loginProcess',
            'admin/login' => 'admin/admins/login',
        );
        $this->router = new Router('/', 'http://localhost/skully/', $config_r);
    }
    public function testRawUrlToRouteAndParams()
    {
        $routeAndParams = $this->router->rawUrlToRouteAndParams('products/12?categoryId=15');
        $this->assertEquals('products/view', $routeAndParams['route']);
        $this->assertEquals('12', $routeAndParams['params']['id']);
        $this->assertEquals('15', $routeAndParams['params']['categoryId']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('products', $controllerAndAction['controller']);
        $this->assertEquals('view', $controllerAndAction['action']);

        $routeAndParams = $this->router->rawUrlToRouteAndParams('admin/login');
        $this->assertEquals('admin/admins/login', $routeAndParams['route']);
    }

    public function testRawUrlToRouteAndParamsForEmptyUrl()
    {
        $routeAndParams = $this->router->rawUrlToRouteAndParams('');
        $this->assertEquals('home/index', $routeAndParams['route']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('home', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);
    }

    public function testRawUrlToRouteAndParamsForEmptyUrlWithParams()
    {
        $routeAndParams = $this->router->rawUrlToRouteAndParams('?something=1');
        $this->assertEquals('home/index', $routeAndParams['route']);
        $this->assertEquals('1', $routeAndParams['params']['something']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('home', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);
    }

    public function testRawUrlToRouteAndParamsForIndexActionWithParams()
    {
        $routeAndParams = $this->router->rawUrlToRouteAndParams('home?something=1');
        $this->assertEquals('home/index', $routeAndParams['route']);
        $this->assertEquals('1', $routeAndParams['params']['something']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('home', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);

        $routeAndParams = $this->router->rawUrlToRouteAndParams('home/?something=1');
        $this->assertEquals('home/index', $routeAndParams['route']);
        $this->assertEquals('1', $routeAndParams['params']['something']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('home', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);
    }

    public function testQueryStringShouldGetPriority() {
        $routeAndParams = $this->router->rawUrlToRouteAndParams('products/12?id=15');
        $this->assertEquals('products/view', $routeAndParams['route']);
        $this->assertEquals('15', $routeAndParams['params']['id']);
    }

    public function testGetUrl() {
        $url = $this->router->getUrl('home/index', array('something' => 1));
        $this->assertEquals('http://localhost/skully/?something=1', $url);

        $url = $this->router->getUrl('products/view', array('id' => 'something-1'));
        $this->assertEquals('http://localhost/skully/products/something-1', $url);
    }
}
