<?php


namespace Tests;

require_once(dirname(__FILE__).'/App/include.php');
require_once(dirname(__FILE__) . '/App/testBootstrap.php');
require_once(dirname(__FILE__).'/functions.php');

use App\Application;
use RedBeanPHP\Facade as R;
use Skully\Core\Config;

abstract class DatabaseTestCase extends \PHPUnit_Framework_TestCase{
    /** @var Application */
    protected $app;

    protected $frozen = true;

    static $connection;

    protected function setUp()
    {
        $config = new Config();
        $config->setProtected('basePath', BASE_PATH);

        setCommonConfig($config);
        setUniqueConfig($config);

        Application::setupRedBean('sqlite:'.dirname(__FILE__).'/dbfile.txt', 'user','password', $this->frozen, 'sqlite');
        R::freeze(false);
        R::nuke();
        R::freeze($this->frozen);

        $this->app = __setupApp();

        /** $http Mock Http object. */
        $http = $this->getMock('Skully\Core\Http');
        $http->expects($this->any())
            ->method('redirect')
            ->will($this->returnCallback('stubRedirect'));
        $this->app->setHttp($http);
    }

    protected function migrate()
    {
        ob_start();
        $argv = array('db:migrate', '-t');
        require(BASE_PATH.'tools/dbmigrator/ruckus.php');
        ob_clean();
    }

}