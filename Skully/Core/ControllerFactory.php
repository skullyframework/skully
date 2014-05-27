<?php


namespace Skully\Core;

use Skully\ApplicationInterface;
use Skully\Exceptions\ThemeFileNotFoundException;
use Skully\Exceptions\PageNotFoundException;

/**
 * Class ControllerFactory
 * @package Skully\Core
 * It is strongly recommended to create Controller class only with this class, unless you really know what you're doing.
 */
class ControllerFactory {
    /**
     * @var array
     */
    private static $config = array('namespace' => 'App');

    /**
     * @param $key
     * @param $value
     */
    public static function setConfig($key, $value) {
        self::$config[$key] = $value;
    }
    /**
     * @param ApplicationInterface $app
     * @param string $controllerStr
     * @param array $additionalParams
     * @param string $actionStr
     * @return ControllerInterface|mixed|null
     * Create controller from system path e.g. controller/action.
     * Add additionalParams for well.. additional parameters.
     * actionStr is needed to load language for that action.
     */
    public static function create(ApplicationInterface $app, $controllerStr = '', $actionStr = null, $additionalParams = array())
    {
        $str_r = explode('\\', $controllerStr);
        if (!empty($str_r)) {
            foreach ($str_r as $index=>$str) {
                $str = ucfirst($str);
                $str_r[$index] = $str;
            }
            $controllerStr = implode('\\', $str_r);
        }
        if ($controllerStr[0] != '\\') {
            $controllerStr = ucfirst($controllerStr);
        }
        else {
            $controllerStr = ucfirst(substr($controllerStr,1));
        }
        $controllerStrComplete = self::$config['namespace'].'\Controllers\\'.$controllerStr.'Controller';

//      Controller not found, but we try to find view anyway.
        if (!class_exists($controllerStrComplete)) {
            $path = $app->getRouter()->getControllerPathFromClass($controllerStrComplete);
            $viewPath = empty($actionStr) ? 'index' : $actionStr;
            if ($viewPath[0] == '_') {
                $url = $app->getRouter()->getUrl($path."/$viewPath", $additionalParams);
                PageNotFoundException::alert($path."/$viewPath", $url);
            }
            else {
                try {
                    $completeViewPath = $path.DIRECTORY_SEPARATOR.$viewPath.'.tpl';
                    $app->getTemplateEngine()->display($completeViewPath);
                }
                catch (ThemeFileNotFoundException $e) {
                    $url = $app->getRouter()->getUrl($path."/$viewPath", $additionalParams);
                    PageNotFoundException::alert($path."/$viewPath", $url);
                }
            }
        }
        else {
            /* @var $controller ControllerInterface */
            $controller = new $controllerStrComplete($app, $actionStr, $additionalParams);
            return $controller;
        }
        return null;
    }
} 