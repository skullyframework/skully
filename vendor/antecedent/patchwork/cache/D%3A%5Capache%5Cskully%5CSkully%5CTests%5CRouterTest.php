<?php


namespace Skully\Tests; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\Core\Router;

class RouterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Router
     */
    protected $router;

    public function setUp()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $config_r = array(
            '' => 'home/index',
            'products/c/%cid' => 'products/viewCategory',
            'products/index' => 'products/index',
            'products/%id' => 'products/view',
            'products/%category/%id' => 'products/view2',
            'admin/loginProcess' => 'admin/admins/loginProcess',
            'admin/login' => 'admin/admins/login',
        );
        $this->router = new Router('/', 'http://localhost/skully/', $config_r);
    }
    public function testRawUrlWithTwoParams()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $routeAndParams = $this->router->rawUrlToRouteAndParams('products/categoryName/product-id');
        $this->assertEquals('products/view2', $routeAndParams['route']);
        $this->assertEquals('product-id', $routeAndParams['params']['id']);
        $this->assertEquals('categoryName', $routeAndParams['params']['category']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('products', $controllerAndAction['controller']);
        $this->assertEquals('view2', $controllerAndAction['action']);
    }
    public function testRawUrlToRouteAndParams()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $routeAndParams = $this->router->rawUrlToRouteAndParams('');
        $this->assertEquals('home/index', $routeAndParams['route']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('home', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);
    }

    public function testRawUrlToRouteAndParamsForEmptyUrlWithParams()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $routeAndParams = $this->router->rawUrlToRouteAndParams('?something=1');
        $this->assertEquals('home/index', $routeAndParams['route']);
        $this->assertEquals('1', $routeAndParams['params']['something']);
        $controllerAndAction = $this->router->RouteToControllerAndAction($routeAndParams['route']);
        $this->assertEquals('home', $controllerAndAction['controller']);
        $this->assertEquals('index', $controllerAndAction['action']);
    }

    public function testRawUrlToRouteAndParamsForIndexActionWithParams()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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

    public function testQueryStringShouldGetPriority() {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $routeAndParams = $this->router->rawUrlToRouteAndParams('products/12?id=15');
        $this->assertEquals('products/view', $routeAndParams['route']);
        $this->assertEquals('15', $routeAndParams['params']['id']);
    }

    public function testGetUrl() {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $url = $this->router->getUrl('home/index', array('something' => 1));
        $this->assertEquals('http://localhost/skully/?something=1', $url);

        $url = $this->router->getUrl('products/view', array('id' => 'something-1'));
        $this->assertEquals('http://localhost/skully/products/something-1', $url);
    }
}\Patchwork\Interceptor\applyScheduledPatches();
