<?php
namespace Skully\Tests\Command;

require_once(dirname(__FILE__).'/../DatabaseTestCase.php');

use Skully\Core\Command;


class CommandTest extends \PHPUnit_Framework_TestCase {
    public function testAddingAndRunningCommand()
    {
        $command = new Command();
        $command->run();
    }
}
 