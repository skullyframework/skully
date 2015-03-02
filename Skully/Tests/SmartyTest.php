<?php

use Skully\Core\Config;
use Skully\Application;
//require_once dirname(__FILE__) . '/../Library/Smarty/libs/Smarty.class.php';

class SmartyTest extends PHPUnit_Framework_TestCase {
    public function testSmartyInstall() {
        $config = new Config();
        $config->setProtectedFromArray(array(
            'publicDir' => 'public/',
            'caching' => 1,
            'theme' => 'default',
            'basePath' => realpath(__DIR__.DIRECTORY_SEPARATOR.'App').DIRECTORY_SEPARATOR,
            'baseUrl' => 'http://localhost/skully/',
            'languages' => array('en' => array('value' => 'english', 'code' => 'en')),
            'urlRules' => array(
                '' => 'home/index',
                'admin' => 'admin/home/index'
            ),
            'namespace' => 'App'
        ));
        if (!file_exists(realpath(__DIR__.'/App/App/smarty/plugins'))) {
            mkdir('./App/App/smarty/plugins');
        }
        if (!file_exists(realpath(__DIR__.'/App/App/smarty/cache'))) {
            mkdir('./App/App/smarty/cache');
        }
        if (!file_exists(realpath(__DIR__.'/App/App/smarty/configs'))) {
            mkdir('./App/App/smarty/configs');
        }

        $app = new Application($config);
        $smarty = $app->getTemplateEngine()->getEngine();
        $errors = array();
        $smarty->testInstall($errors);
        echo "smarty errors: ";
        print_r($errors);
        $this->assertTrue(count($errors) <= 2);
    }
}
