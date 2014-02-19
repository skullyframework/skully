<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/7/14
 * Time: 2:31 PM
 */

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
}