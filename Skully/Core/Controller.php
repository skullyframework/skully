<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/21/13
 * Time: 3:06 PM
 */

namespace Skully\Core;

use Skully\ApplicationInterface;
use Skully\Core\Templating\TemplateEngineAdapterInterface;
use Skully\Exceptions\PageNotFoundException;
use Skully\Exceptions\ThemeFileNotFoundException;

/**
 * Class Controller
 * @package Skully\Core
 * Instance creation should only be done via ControllerFactory, unless you know what you are doing.
 */
class Controller extends ApplicationAware implements ControllerInterface {
    /**
     * @var array
     *
     */
    protected $params = array();
    /**
     * @var
     */
    protected $currentAction;
    /**
     * @var array
     */
    protected $lang = array();

    /** @var bool When true, stop doing runAction. Initiate this by calling $this->stopAction() at beforeAction method. */
    protected $stopAction = false;

    /** When this is called, stop doing runAction. Initiate this by calling $this->stopAction() at beforeAction method. */
    public function stopAction()
    {
        $this->stopAction = true;
    }
    /**
     * @param ApplicationInterface $app
     * @param null $additionalParams
     * @param string $action
     * $controllerStr uses similar format with one returned from Router, e.g. Home, Admin\Home
     */
    public function __construct(ApplicationInterface $app, $action = null, $additionalParams = null) {
        $this->setCurrentAction($action);
        $this->setApp($app);
        $this->setLanguage($this->app->getLanguage());
        $this->setParams($additionalParams);
    }

    /**
     * @return mixed
     */
    public function getCurrentAction()
    {
        return $this->currentAction;
    }


    /**
     *
     */
    public function runCurrentAction() {
        return $this->runAction($this->getCurrentAction());
    }

    /**
     * @param mixed $action
     */
    public function setCurrentAction($action) {
        $this->currentAction = $action;
    }

    /**
     * Get current route i.e. home/index
     * This should be called after currentAction is set.
     * @return string
     */
    public function getRoute()
    {
        return $this->getControllerPath().'/'.$this->getCurrentAction();
    }

    /**
     * Get current page's route and params.
     * This should be usable in Router's getUrl() method.
     * @return array
     */
    public function getRouteAndParams()
    {
        return $this->app->getRouter()->rawUrlToRouteAndParams($_GET['_url']);
    }
    /**
     * @param $action
     * @return mixed
     */
    public function runAction($action) {
        $value = null;
        $this->setCurrentAction($action);
        $this->stopAction = false;
        $this->beforeAction();
        if (!$this->stopAction) {
            if (method_exists($this, $action)) {
                $value = $this->$action();
            }
            else {
//          Action not found, but we check to see if view is available anyway.
                if ($action[0] == '_') {
                    $url = $this->app->getRouter()->getUrl($this->getControllerPath()."/$action", $this->getParams());
                    PageNotFoundException::alert($this->getControllerPath()."/$action", $url);
                }
                else {
                    try {
                        $this->render($action);
                    }
                    catch (ThemeFileNotFoundException $e) {
                        $url = $this->app->getRouter()->getUrl($this->getControllerPath()."/$action", $this->getParams());
                        PageNotFoundException::alert($this->getControllerPath()."/$action", $url);
                    }
                }
            }
            $this->afterAction();
        }
        else {
            $this->stopAction = false;
        }
        return $value;
    }

    /**
     * @param array $parameters
     * @return void
     */
    public function setParams($parameters)
    {
        if (!empty($parameters)) {
            $this->params = array_merge($this->params, $parameters);
        }
    }

    /**
     * @param $parameter
     * @return bool
     */
    public function hasParam($parameter)
    {
        return isset($this->params[$parameter]) && !is_null($this->params[$parameter]);
    }

    /**
     * Reset all of this controller's current parameters
     */
    public function resetParams()
    {
        $this->params = array();
    }

    /**
     * @param $method String null, POST, GET, REQUEST, or FILES
     * @return mixed
     * Get all params set for this controller.
     * Params here are combination of both GET and POST parameters.
     */
    public function getParams($method = null) {
        switch ($method) {
            case 'POST':
                return $_POST;
                break;
            case 'GET':
                $params = $_GET;
                unset($params['_url']);
                return $params;
                break;
            case 'REQUEST':
                return $_REQUEST;
                break;
            case 'FILES':
                return $_FILES;
                break;
            default:
                return $this->params;
                break;
        }
    }

    /**
     * @param $params
     */
    public function addParams($params) {
        $this->params = array_merge($this->getParams(), $params);
    }

    /**
     * @param $key
     * @return mixed
     * Return param with given key
     * Params here are combination of both GET and POST parameters.
     */
    public function getParam($key) {
        return (isset($this->params[$key])) ? $this->params[$key] : null;
    }

    /**
     * @param $language
     * Set this controller's language
     */
    protected function setLanguage($language) {
        $path = $this->getControllerPath();
        $path_r = explode(DIRECTORY_SEPARATOR, $path);
        $pathSoFar = '';
        $actionStr = $this->getCurrentAction();
        foreach($path_r as $pathItem) {
            $pathSoFar .= $pathItem . DIRECTORY_SEPARATOR;
            $this->app->addLangfile($pathSoFar.'_'.$pathItem, $this->app->config('language'));

        }
        if (!empty($actionStr)) {
            $this->app->addLangfile($pathSoFar.$actionStr, $this->app->config('language'));
        }
        $pathSoFar = '';
        foreach($path_r as $pathItem) {
            $pathSoFar .= $pathItem . DIRECTORY_SEPARATOR;
            $this->app->addLangfile($pathSoFar.'_'.$pathItem, $language);
        }
        if (!empty($actionStr)) {
            $this->app->addLangfile($pathSoFar.$actionStr, $language);
        }
    }

    /**
     * @param null $viewPath
     * @param array $assignParams
     * @return void
     */
    public function render($viewPath = null, $assignParams = array())
    {
        $this->app->getTemplateEngine()->assign($assignParams);
        if (empty($viewPath)) {
            $viewPath = $this->getCurrentAction();
            $completePath = $this->getActionTemplate($viewPath);
        }
        else {
            if ($viewPath[0] == '/' || $viewPath[0] == '\\') {
                $completePath = substr($viewPath, 1).'.tpl';
            }
            else {
                $completePath = $this->getActionTemplate($viewPath);
            }
        }
        $this->app->getTemplateEngine()->display($completePath);
    }

    /**
     * @param $viewPath
     * @return string
     */
    public function fetch($viewPath = null)
    {
        if (empty($viewPath)) {
            $viewPath = $this->getCurrentAction();
            $completePath = $this->getActionTemplate($viewPath);
        }
        else {
            if ($viewPath[0] == '/' || $viewPath[0] == '\\') {
                $completePath = substr($viewPath, 1).'.tpl';
            }
            else {
                $completePath = $this->getActionTemplate($viewPath);
            }
        }
        $this->app->getLogger()->log("fetching $completePath");
        return $this->app->getTemplateEngine()->fetch($completePath);
    }

    /**
     * @return string
     * SubscribeController will return 'subscribe'
     * Admin\HomeController will return 'admin/home'
     */
    public function getControllerPath() {
        $class = get_class($this);
        return $this->app->getRouter()->getControllerPathFromClass($class);
    }


    /**
     * @param $viewPath
     * @return string
     * Get template path of an action
     */
    protected function getActionTemplate($viewPath)
    {
        $path = $this->getControllerPath();
        return $path.DIRECTORY_SEPARATOR.$viewPath.'.tpl';
    }
    /**
     * @param string $message Message to display.
     * @param string $as Display as what? E.g. 'message', 'notice' or 'error', can be used
     *        for design.
     * Use this to set notification messages before redirect.
     * To show message / error in this page right away,
     * use showMessage
     */
    public function setMessage($message, $as = 'message') {
        $_SESSION[$as] = $message;
    }

    /**
     * @param string $message Message to display.
     * @param string $as Display as what? E.g. 'message', 'notice' or 'error', can be used
     *        for design.
     * Display message / error in this page.
     */
    public function showMessage($message, $as = 'message') {
        $this->app->getTemplateEngine()->assign(array($as => $message));
    }

    /**
     * Following code is used to support setting message and error after redirect.
     * Override this in your own BaseController as required.
     */
    protected function showSetMessages() {
    }

    /**
     * To be overridden in controllers.
     * Get current action with $this->getCurrentAction() here.
     */
    protected function beforeAction()
    {
        if (!empty($this->params['_language'])) {
            $_SESSION['language'] = $this->params['_language'];
        }
        return true;
    }

    /**
     * To be overridden in controllers.
     * Get current action with $this->getCurrentAction() here.
     */
    protected function afterAction()
    {

    }
}