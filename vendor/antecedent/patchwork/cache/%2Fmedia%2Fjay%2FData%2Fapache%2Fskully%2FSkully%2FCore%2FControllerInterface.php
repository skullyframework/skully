<?php


namespace Skully\Core; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\ApplicationInterface;

/**
 * Interface ControllerInterface
 * @package Skully\Core
 */
interface ControllerInterface extends ApplicationAwareInterface {
    /** When this is called, stop doing runAction. Initiate this by calling $this->stopAction() at beforeAction method. */
    public function stopAction();
    /**
     * @param ApplicationInterface $app
     * @param null $additionalParams
     * @param string $action
     */
    public function __construct(ApplicationInterface $app, $action = null, $additionalParams = null);

    /**
     * Replace controller parameters with given parameters
     * @param array $parameters
     * @return mixed
     */
    public function setParams($parameters);

    /**
     * Reset all of this controller's current parameters
     */
    public function resetParams();

    /**
     * @param $params
     */
    public function addParams($params);

    /**
     * Get all params set for this controller.
     * Params here are combination of both GET and POST parameters.
     * @return mixed
     */
    public function getParams();

    /**
     * Return param with given key
     * Params here are combination of both GET and POST parameters.
     * @param $key
     * @return mixed
     */
    public function getParam($key);

    /**
     * @param $parameter
     * @return bool
     */
    public function hasParam($parameter);

    /**
     * Run this controller's currently set action (currentAction)
     * @return mixed
     */
    public function runCurrentAction();

    /**
     * Run an action and set currentAction to that.
     * @param $action
     * @return mixed
     */
    public function runAction($action);

    /**
     * Set current / last action being run by this controller.
     * This must also be set when runAction method is called.
     * @param mixed $currentAction
     */
    public function setCurrentAction($currentAction);

    /**
     * Get current route i.e. home/index
     * This should be called after currentAction is set.
     * @return string
     */
    public function getRoute();

    /**
     * Get current page's route and params.
     * This should be usable in Router's getUrl() method.
     * @return array
     */
    public function getRouteAndParams();

    /**
     * Set current / last action being run by this controller.
     * @return mixed
     */
    public function getCurrentAction();

    /**
     * Render a path on page.
     * @param $viewPath
     * @param array $assignParams
     * @return mixed
     */
    public function render($viewPath = null, $assignParams = array());

    /**
     * Fetch a path and return it as string.
     * @param $path
     * @param array $assignParams
     * @return mixed
     */
    public function fetch($path = null, $assignParams = array());

    /**
     * SubscribeController will return 'subscribe'
     * Admin\HomeController will return 'admin/home'
     * @return string
     */
    public function getControllerPath();

}