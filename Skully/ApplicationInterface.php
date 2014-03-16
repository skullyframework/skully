<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/19/13
 * Time: 11:46 PM
 */

namespace Skully;
use Skully\Core\ControllerInterface;
use Skully\Core\ConfigInterface;
use Skully\Core\Http;
use Skully\Core\Router;
use Skully\Core\RouterInterface;
use Skully\Core\TranslatorInterface;
use Skully\Core\RepositoryInterface;


/**
 * Interface ApplicationInterface
 * @package Skully\Framework
 * Dependency Injection Container of entire Skully application
 * Implement this method if you need another set of classes.
 */
interface ApplicationInterface {

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config);


    /**
     * @param $key
     * @return mixed
     * Get configurations attached to this application
     */
    public function config($key);

    /**
     * @param $rawUrl
     * @param array $additionalParams
     * @return null
     * @throws \Skully\Exceptions\PageNotFoundException
     * Get controller from raw url e.g. thisurl/is/good
     * Rules will be applied to the url before controller is called.
     */
    public function runControllerFromRawUrl($rawUrl, $additionalParams = array());

    /**
     * @param ConfigInterface $config
     * @return mixed
     * Set the whole config object.
     */
    public function setConfig(ConfigInterface $config);

    /**
     * @return mixed
     * Get the whole config object.
     */
    public function getConfigObject();


    /**
     * @param $controllerStr
     * @param string $actionStr
     * @param array $additionalParams
     * @return ControllerInterface
     * Get controller from a $controllerStr ('App\HomeController' for example),
     * also set its initial action if actionStr is provided, which can be run later by calling method $controller->runCurrentAction().
     */
    public function getController($controllerStr, $actionStr = '', $additionalParams = array());

    /**
     * @param $repositoryStr
     * @return mixed|null|RepositoryInterface
     */
    public function getRepository($repositoryStr);

    /**
     * @return array|mixed
     * Get current language based on session.
     * Setup session from get parameter when needed
     */
    public function getLanguage();

    /**
     * @param $theme
     * @return mixed
     */
    public function setTheme($theme);

    /**
     * @return \Skully\Core\Theme\Theme
     */
    public function getTheme();

    /**
     * @param null $key
     * @return mixed
     * "Safe" config(s) to be displayed in client.
     */
    public function clientConfig($key = null);

    /**
     * @param $key
     * @return mixed
     * Check if config is empty, since we cannot use !empty(config($key))
     */
    public function configIsEmpty($key);

    /**
     * @param $url
     * @param array $additionalParams
     * @return mixed
     */
    public function getControllerFromRawUrl($url, $additionalParams = array());

    /**
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router);

    /**
     * @return Router
     * @throws Exceptions\InvalidConfigException
     */
    public function getRouter();

    /**
     * @return mixed
     * Get Application's name
     */
    public function getAppName();

    /**
     * @return string|null
     * Get current xmlLang based on session.
     * Setup session from get parameter when needed
     */
    public function getXmlLang();

    /**
     * @return bool
     * Was the request made via ajax?
     */
    public function isAjax();

    /**
     * @return \Skully\Core\Templating\SmartyAdapter
     */
    public function getTemplateEngine();

    /**
     * @param TranslatorInterface $translator
     * @return void
     */
    public function setTranslator(TranslatorInterface $translator);

    /**
     * @return \Skully\Core\TranslatorInterface
     */
    public function getTranslator();

    /**
     * @param $path
     * @param $language
     * Add language file into translator object. $path is relative to
     * 'public/languages/[language]/' directory.
     */
    public function addLangfile($path, $language);

    /**
     * @param \Skully\Logging\LoggerInterface $logger
     */
    public function setLogger($logger);

    /**
     * @return \Skully\Logging\LoggerInterface
     */
    public function getLogger();

    /**
     * @return Http
     */
    public function getHttp();

    /**
     * @param $http
     */
    public function setHttp($http);

    /**
     * Redirect to path within application
     * @param string $path
     * @param array $params
     * @return null
     */
    public function redirect($path = '', $params = array());

    /**
     * Redirect to url outside application
     * @param string $url
     * @return null
     */
    public function aRedirect($url);

    /**
     * @param string $dsn
     * @param $user
     * @param string $password
     * @param bool $isDevMode
     */
    public static function setupRedBean($dsn, $user, $password = '', $isDevMode = false);

    /**
     * Creates a model
     * @param $name
     * @param array $attributes
     * @return \Skully\\App\Models\BaseModel
     * @throws \Exception
     */
    public function createModel($name, $attributes = array());

    /**
     * Can be extended to use DBSession
     * @return mixed
     */
    public function getSession();

    /**
     * Get value from php.ini file, or from 'ini' config if server does not allow it.
     * @param $var
     * @return mixed
     */
    public function iniGet($var);
}