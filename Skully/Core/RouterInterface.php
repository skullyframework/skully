<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/8/14
 * Time: 11:36 PM
 */

namespace Skully\Core;


interface RouterInterface {

    /**
     * @param $basePath
     * @param $baseUrl
     * @param $urlRules
     */
    public function __construct($basePath, $baseUrl, $urlRules);

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath);

    /**
     * @param array $urlRules
     */
    public function setUrlRules($urlRules);

    /**
     * @param $url
     * @return array
     * Convert given raw url into route: url we can use to find controllers, and its parameters.
     */
    public function rawUrlToRouteAndParams($url);

    /**
     * @param $route
     * @return array
     * Convert route into array of controllerStr and action.
     */
    public function routeToControllerAndAction($route);

    /**
     * @param null $route
     * @param array $parameters
     * @return string
     * Takes a route and parameters, returns url based from the mapping
     * If route is null, get current page's url instead.
     */
    public function getUrl($route = null, $parameters = array());
}