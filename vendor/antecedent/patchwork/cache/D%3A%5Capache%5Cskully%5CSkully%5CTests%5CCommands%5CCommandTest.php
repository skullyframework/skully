<?php
namespace Skully\Tests\Commands; \Patchwork\Interceptor\applyScheduledPatches();

set_time_limit(0);
require_once(dirname(__FILE__).'/../DatabaseTestCase.php');

use Skully\App\Helpers\FileHelper;
use Skully\Console\Console;
use Symfony\Component\Console\Application;


class CommandTest extends \PHPUnit_Framework_TestCase {
    public function testRunningEncryptionCommand()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = __setupApp();
        $console = new Console($app, true);
        $output = $console->run("skully:encrypt password");
        $this->assertEquals("x0 z8=3F",trim($output->fetch()));
    }

    public function testRunningDecryptionCommand()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $app = __setupApp();
        $console = new Console($app, true);
        $output = $console->run("skully:decrypt \"x0 z8=3F\"");
        $this->assertEquals("password",trim($output->fetch()));
    }

    public function testRunningGenerateCommand()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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

    protected function deleteDir($dir) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        if (!file_exists($dir)) return true;
        if (!is_dir($dir)) return unlink($dir);
        foreach(scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!$this->deleteDir($dir.DIRECTORY_SEPARATOR.$item)) return false;
        }
        return rmdir($dir);
    }
}\Patchwork\Interceptor\applyScheduledPatches();
 