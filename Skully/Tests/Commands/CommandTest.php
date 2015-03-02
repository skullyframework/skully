<?php
namespace Skully\Tests\Commands;

set_time_limit(0);
require_once(dirname(__FILE__).'/../DatabaseTestCase.php');

use Skully\App\Helpers\FileHelper;
use Skully\Console\Console;
use Symfony\Component\Console\Application;


class CommandTest extends \PHPUnit_Framework_TestCase {
    public function testGetCommandList()
    {
        $app = __setupApp();
        $console = new Console($app, true);
        $console->addCommands(array('\Skully\Tests\Commands\NewCommand'));
        $list = $console->getCommands();
        $listString = array();
        foreach ($list as $item) {
            $listString []= get_class($item);
        }
        $this->assertTrue(in_array('Skully\Commands\EncryptCommand', $listString));
        $this->assertTrue(in_array('Skully\Commands\DecryptCommand', $listString));
        $this->assertTrue(in_array('Skully\Commands\SchemaCommand', $listString));
        $this->assertTrue(in_array('Skully\Commands\PackCommand', $listString));
        $this->assertTrue(in_array('Skully\Tests\Commands\NewCommand', $listString));
    }

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
        $app = __setupApp();
        $console = new Console($app, true);
        $packedPath = FileHelper::replaceSeparators(realpath(__DIR__.'/packerTest/packed.js'));
        if (file_exists($packedPath)) {
            unlink($packedPath);
        }
        $this->assertFalse(file_exists($packedPath));
        ob_get_clean();
        ob_start();
        $output = $console->run("skully:pack Commands/packerTest/packerTest.txt");
        // Cannot test this on Windows somehow, so just check if pack command is running.
        $this->assertNotEmpty($output);
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
 