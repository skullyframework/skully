<?php
/**
 * Created by Trio Digital Agency.
 * Date: 3/1/15
 * Time: 6:26 PM
 */

namespace Skully\Tests\Commands;


use Skully\App\Helpers\FileHelper;

class CommandEnvironmentTest extends \PHPUnit_Framework_TestCase {
    public function testRunningCommandWithEnv()
    {
        // todo: No idea how to test console script. Let's do this later...

//        global $argv;
//        $argv = '-t';
//        $argv = array('-t');
//        $this->assertEquals(1,1);
//        require_once(realpath(__DIR__.'/../App/console'));
//        $this->assertEquals('test', $serverName);
    }

    /**
     * These two functions attempt to prove that running rm with php's shell_exec
     * gets executed after the function completed. Contrast this with php's unlink method.
     */
    public function testProofThatExecRemovalIsDoneLater1()
    {
        $dirpath = __DIR__.DIRECTORY_SEPARATOR.'testdir';
        shell_exec('mkdir '.$dirpath);
        // Although we ordered the system to create directory, file still does not exist.
        $this->assertTrue(file_exists($dirpath));
        // After directory created, we need to remove it.
        shell_exec('rm -rf '.$dirpath);
        $this->assertTrue(file_exists($dirpath));
    }

    public function testProofThatExecRemovalIsDoneLater2()
    {
        $dirpath = __DIR__.DIRECTORY_SEPARATOR.'testdir';
        $this->assertFalse(file_exists($dirpath));

        // We now try removing dir with removeFolder method, which uses php's unlink.
        shell_exec('mkdir '.$dirpath);
        $this->assertTrue(file_exists($dirpath));
        FileHelper::removeFolder($dirpath);
        $this->assertFalse(file_exists($dirpath));

        // And that, kids, is why you must always use FileHelper::removeFolder instead of rm.
    }

}
 