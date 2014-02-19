<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/20/13
 * Time: 5:18 PM
 */

namespace Skully\App\Controllers;

use Skully\Core\Controller;

class BaseController extends Controller {
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
}