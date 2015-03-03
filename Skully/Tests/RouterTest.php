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
            'products/%category/%id' => 'products/view2',
            'admin' => 'admin/home/index',
            'admin/loginProcess' => 'admin/admins/loginProcess',
            'admin/login' => 'admin/admins/login'
        );

        $rewrites = array(
            "admin" => "addminn"
        );

        $subDomains = array(
            "news" => "news.domain.com"
        );

        $this->router = new Router('/', 'http://localhost/skully/', $config_r, $rewrites);
        $this->router->setSubDomains($subDomains);
    }
    public function testRawUrlWithTwoParams()
    {
        $routeAndParams = $this->router->rawUrlToRouteAndParams('products/categoryName/product-id');
        $this->assertEquals('products/view2', $routeAndParams['route']);
        $this->assertEquals('product-id', $routeAndParams['params']['id']);
        $this->assertEquals('categoryName', $routeAndParams['params']['category']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('products', $controllerAndAction['controller']);
        $this->assertEquals('view2', $controllerAndAction['action']);
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

        //with urlRewrite, access to normal url would be disabled  and routed to home/index
        $routeAndParams = $this->router->rawUrlToRouteAndParams('admin/login');
//        $this->assertEquals('admin/admins/login', $routeAndParams['route']);
        $this->assertEquals('home/index', $routeAndParams['route']);
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

    public function testRawUrlToRouteAndParamsRewrite(){
        $routeAndParams = $this->router->rawUrlToRouteAndParams('addminn/login');
        $this->assertEquals('admin/admins/login', $routeAndParams['route']);
        $this->assertEquals(0, count($routeAndParams['params']));
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('admin\admins', $controllerAndAction['controller']);
        $this->assertEquals('login', $controllerAndAction['action']);


        $routeAndParams = $this->router->rawUrlToRouteAndParams('addminn/test/edit?id=1');
        $this->assertEquals('admin/test/edit', $routeAndParams['route']);
        $this->assertEquals(1, $routeAndParams['params']['id']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('admin\test', $controllerAndAction['controller']);
        $this->assertEquals('edit', $controllerAndAction['action']);

        $routeAndParams = $this->router->rawUrlToRouteAndParams('addminn/addminn/index');
        $this->assertEquals('admin/addminn/index', $routeAndParams['route']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('admin\addminn', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);

        $routeAndParams = $this->router->rawUrlToRouteAndParams('addminna/addminn/index');
        $this->assertEquals('addminna/addminn/index', $routeAndParams['route']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('addminna\addminn', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);
    }

    public function testGetUrlRewrite() {
        $url = $this->router->getUrl('admin/home/index', array('something' => 1));
        $this->assertEquals('http://localhost/skully/addminn?something=1', $url);

        $url = $this->router->getUrl('admin/admin/index', array('something' => 1));
        $this->assertEquals('http://localhost/skully/addminn/admin/index?something=1', $url);

        $url = $this->router->getUrl('admin/admins/loginProcess', array('id' => 'something-1'));
        $this->assertEquals('http://localhost/skully/addminn/loginProcess?id=something-1', $url);

        $url = $this->router->getUrl('admina/home/index', array('something' => 1));
        $this->assertEquals('http://localhost/skully/admina/home/index?something=1', $url);
    }

    public function testGetUrlSubDomain() {
        $url = $this->router->getUrl('news/index', array('something' => 1));
        $this->assertEquals('http://news.domain.com/index?something=1', $url);
    }
}
