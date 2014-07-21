<?php
namespace Skully\App\Controllers;

use Skully\Core\Controller;

class BaseController extends Controller {
    /** @var  \Skully\Application */
    protected $app;

    /**
     * Following code is used to support setting message and error after redirect.
     * Override this in your own BaseController as required.
     */
    protected function showSetMessages() {
        if (!empty($_SESSION['message'])) {
            $this->app->getTemplateEngine()->assign(array('message' => $_SESSION['message']));
            unset($_SESSION['message']);
        }
        if (!empty($_SESSION['error'])) {
            $this->app->getTemplateEngine()->assign(array('error' => $_SESSION['error']));
            unset($_SESSION['error']);
        }

    }

    protected function beforeAction()
    {

    }

    protected function beforeRender()
    {
        $this->setDefaultAssign();
    }

    protected function setDefaultAssign()
    {
        $this->showSetMessages();

        if (!($this->app->configIsEmpty('localTest'))) {
            $this->app->getTemplateEngine()->assign(array('localTest' => $this->app->config('localTest')));
        }
        $this->app->getTemplateEngine()->assign(array(
            'isLogin' => false,
            'baseUrl' => $this->app->config('baseUrl'),
            'themeUrl' => $this->app->getTheme()->getPublicBaseUrl(),
            'xmlLang' => $this->app->getXmlLang(),
            'language' => $this->app->getLanguage(),
            'clientConfig' => $this->app->clientConfig(),
            'isAjax' => $this->app->isAjax(),
            'params' => $this->params,
            'route' => $this->getControllerPath(),
            'action' => $this->getCurrentAction(),
        ));

        $this->setAdditionalAssign();
    }

    /**
     * @param null $viewPath
     * @param array $assignParams
     * @return void
     */
    public function render($viewPath = null, $assignParams = array())
    {
        $this->setDefaultAssign();
        parent::render($viewPath, $assignParams);
    }

    /**
     * @param $viewPath
     * @return string
     * @param array $assignParams
     */
    public function fetch($viewPath = null, $assignParams = array())
    {
        $this->setDefaultAssign();
        return parent::fetch($viewPath, $assignParams);
    }

    protected function setAdditionalAssign(){

    }
}