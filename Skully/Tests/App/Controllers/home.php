<?php


namespace App\Controllers;


class HomeController extends \App\Controllers\BaseController {
    public function index()
    {
        $this->render();
    }

    public function something()
    {
        return 'something';
    }

    public function error()
    {
        $this->render();
    }
    public function undefinedIndexError()
    {
        $this->app->getTemplateEngine()->assign(array(
            'stuff' => array()
        ));
        $this->render();
    }

    public function testNoCacheFetch()
    {
        $this->app->getLogger()->log("test is " . $this->getParam('test'));
        $this->app->getTemplateEngine()->assign('test', $this->getParam('test'));
        $content = $this->fetch('_content');
        $this->app->getTemplateEngine()->assign('content', $content);
        $this->render('testNoCacheFetch');
    }
}