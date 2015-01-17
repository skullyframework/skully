<?php


namespace Skully\Core;
use Skully\App\Helpers\UrlHelper;


/**
 * Class Router
 * @package Skully\Core
 */
class Router implements RouterInterface {

    /**
     * @var array
     * Url rules used in this application
     */
    protected $urlRules = array();

    /**
     * @var string
     * Base path of the application
     */
    protected $basePath = '/';

    /**
     * @var string
     */
    protected $baseUrl = 'http://yoursite.com/';

    /**
     * @param $basePath
     * @param $baseUrl
     * @param $urlRules
     */
    public function __construct($basePath, $baseUrl, $urlRules) {
        $this->basePath = $basePath;
        $this->baseUrl = $baseUrl;
        $this->urlRules = $urlRules;
    }
    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param array $urlRules
     */
    public function setUrlRules($urlRules)
    {
        $this->urlRules = $urlRules;
    }

    /**
     * @param $url
     * @return array
     * Convert given raw url into route: url we can use to find controllers, and its parameters.
     */
    public function rawUrlToRouteAndParams($url)
    {
        $url = str_replace('.php', '', trim($url, '/'));
        $params = array();
        $urlRules = $this->urlRules;
        $parsedUrl = parse_url($url);

        $route = '';
        if (!empty($parsedUrl['path'])) {
            $route = trim($parsedUrl['path'], '/');
        }
        $url_r = explode('/', $route);

        if (!empty($urlRules)) {
            // displayedPath Examples: %path/subscribe, subscribe/index, subscribe
            foreach($urlRules as $displayedPath => $systemPath) {
                // First of all, compare the number of elements, this is to avoid url something/is opens up displayedPath something/is/wrong page

                // Split the displayed path: %path / subscribe
                $displayedPath_r = explode('/', $displayedPath);

                if (count($displayedPath_r) == count($url_r)) {
                    // If displayed path has no % and == url, set it as path
                    if (strpos($displayedPath, '%') === false) {
                        if ($displayedPath == $route) {
                            $route = $systemPath;
                            break;
                        }
                        else {
                            if ($displayedPath == $route) {
                                $route = $systemPath;
                                break;
                            }
                        }
                    }
                    else {
                        // for each of displayed path element, compare with url.
                        // if all parts are correct, then it is correct.
                        $correct = true;
                        $params = array();
                        foreach($displayedPath_r as $key => $element) {
                            if (substr($element, 0, 1) == '%') {
                                $params[substr($element, 1)] = $url_r[$key];
                            }
                            else {
                                if (!empty($url_r[$key]) && strcmp($element, $url_r[$key]) != 0) {
                                    $correct = false;
                                    break;
                                }
                            }
                        }
                        if ($correct) {
                            $route = $systemPath;
                            break;
                        }
                    }
                }
            }
        }

        $output = array();
        if (!empty($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $output);
        }
        $params = array_merge($params, $output);

        $route_r = explode('/', $route);
        if (!empty($route_r) && count($route_r)== 1) {
            $route .= '/index';
        }
        return array('route' => $route, 'params' => $params);
    }


    /**
     * @param $route
     * @return array
     * Convert route into array of controllerStr and action.
     */
    public function routeToControllerAndAction($route)
    {
        // Path is something like controller/action or prefix/controller/action
        $path_r = explode('/', $route);

        $controllerStr = '';
        $actionStr = 'index';
        if (!empty($path_r) && count($path_r)>= 2) {
            foreach($path_r as $index => $path) {
                if ($index == count($path_r)-1) {
                    $actionStr = $path;
                }
                else {
                    $controllerStr.= '\\'.$path;
                }
            }
            $controllerStr = substr($controllerStr, 1);
        }
        elseif (!empty($path_r) && count($path_r)== 1) {
            $controllerStr = $path_r[0];
        }
        return array('controller' => $controllerStr, 'action' => $actionStr);
    }

    /**
     * @param null $route
     * @param array $parameters
     * @param boolean $ssl
     * @return string
     * Takes a route and parameters, returns url based from the mapping
     * If route is null, get current page's url instead.
     * Can also take external URL - useful for urls which https/http can change according to current page.
     */
    public function getUrl($route = null, $parameters = array(), $ssl = null) {
        if ($route == null) {
            $pageURL = 'http';
            if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
            $pageURL .= "://";
            if ($_SERVER["SERVER_PORT"] != "80") {
                $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
            } else {
                $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            }
            return $this->setHttps($pageURL,$ssl).(!empty($parameters)?"?".http_build_query($parameters):'');
        }
        else {
            $answer = $route;
            $urlRules = $this->urlRules;
            $internal = (strpos($route, 'https://') !== 0 && strpos($route, 'http://') !== 0);
            if (!empty($urlRules)) {
                foreach($urlRules as $displayedPath => $systemPath) {

                    if ($systemPath == $route) {
                        $answer = $displayedPath;
                        $internal = true;
                        break;
                    }
                }
                preg_match_all('/%[\w+]*/', $answer, $params);

                if(!empty($params)){
                    foreach($params as $pars){
                        foreach($pars as $param){
                            $temp = substr($param, 1);
                            if(isset($parameters[$temp])){
                                // Put URL special cases here, for example if you need to replace spaces with dash

                                // Special cases END
                                $answer = str_replace($param, $parameters[$temp], $answer);
                                unset($parameters[$temp]);
                            }
                        }
                    }
                }
            }

            if ($internal) {
                $base = $this->setHttps($this->baseUrl, $ssl);
            }
            else {
                $base = '';
            }
            return $base.$answer.(!empty($parameters)?"?".http_build_query($parameters):'');
        }
    }

    private function setHttps($url, $ssl) {
        if ($ssl === true || UrlHelper::isSecure()) {
            $url = str_replace('http://', 'https://', $url);
        }
        elseif ($ssl === false) {
            $url = str_replace('https://', 'http://', $url);
        }
        return $url;
    }

    /**
     * @param $class
     * @return string
     * SubscribeController will return 'subscribe'
     * Admin\HomeController will return 'admin/home'
     */
    public function getControllerPathFromClass($class)
    {
        // Namespace example: App\Controllers\SomethingController
        // Removes the first 'Controllers/' in class name.
        $path = substr($class, strpos($class, 'Controllers')+12);
        // Removes the last 'Controller' in class name.
        $path = substr($path, 0, strpos($path, 'Controller'));
        $path_r = explode('\\', $path);
        foreach ($path_r as $index => $pathItem) {
            $path_r[$index] = lcfirst($pathItem);
        }
        return implode(DIRECTORY_SEPARATOR, $path_r);
    }
}