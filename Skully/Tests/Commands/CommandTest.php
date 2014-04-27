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

    public function testRunningGenerateCommand()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $rconfig = $app->config('ruckusingConfig');

        $this->deleteDir($rconfig['migrations_dir']['default']);
        $this->assertFalse(file_exists($rconfig['migrations_dir']['default']));
        $output = $console->run("skully:schema db:generate test");
        $this->assertEquals('', trim($output->fetch()));
        $this->assertTrue(file_exists($rconfig['migrations_dir']['default']));
    }

    public function testPackCommand()
    {

    }

    protected function deleteDir($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach(scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!$this->deleteDir($dir.DIRECTORY_SEPARATOR.$item)) return false;
        }
        return rmdir($dir);
    }
}
 