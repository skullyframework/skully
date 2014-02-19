<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/22/13
 * Time: 11:29 PM
 */

namespace Skully\App\Controllers\Admin;


class HomeController extends BaseController{
    public function index()
    {
        return $this->render('index');
    }
} 