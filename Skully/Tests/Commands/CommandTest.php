<?php
namespace Skully\Tests\Commands;

set_time_limit(0);
require_once(dirname(__FILE__).'/../DatabaseTestCase.php');

use Skully\Console\Console;
use Symfony\Component\Console\Application;


class CommandTest extends \PHPUnit_Framework_TestCase {
    public function testRunningEncryptionCommand()
    {
        $app = __setupApp();
        $console = new Console(true);
        $output = $console->run($app, "skully:encrypt password");
        $this->assertEquals("x0 z8=3F",trim($output->fetch()));
    }

    public function testRunningMigrationCommand()
    {

    }
}
 