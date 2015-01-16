<?php


namespace Skully\Core; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\ApplicationInterface;
use Skully\Exceptions\InvalidTemplateException;
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
    public static function setConfig($key, $value) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
                catch (InvalidTemplateException $e) {
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
}\Patchwork\Interceptor\applyScheduledPatches(); 