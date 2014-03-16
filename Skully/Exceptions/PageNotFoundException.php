<?php


namespace Skully\Exceptions;


class PageNotFoundException extends \Exception{
    protected $url = '';
    protected $route = '';

    /**
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * @param string $route  URL after processed with url rules (by method Router::UrlToRouteAndParams())
     * @param string $url Complete url similar to one returned by method Router::getUrl().
     * @throws PageNotFoundException
     */
    public static function alert($route, $url) {
        $e = new PageNotFoundException("Page $url not found");
        $e->setRoute($route);
        $e->setUrl($url);
        throw $e;
    }
} 