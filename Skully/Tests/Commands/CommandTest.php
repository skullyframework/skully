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
        $console = new Console($app, true);
        $output = $console->run("skully:encrypt password");
        $this->assertEquals("x0 z8=3F",trim($output->fetch()));
    }

    public function testRunningDecryptionCommand()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $output = $console->run("skully:decrypt \"x0 z8=3F\"");
        $this->assertEquals("password",trim($output->fetch()));
    }

    public function testRunningMigrationCommand()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $output = $console->run("skully:schema db:migrate");
        $this->assertEquals('', trim($output->fetch()));
    }

    public function testRunningGenerateCommand()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $output = $console->run("skully:schema db:generate test");
        $this->assertEquals('', trim($output->fetch()));
    }

    public function testPackCommand()
    {

    }
}
 