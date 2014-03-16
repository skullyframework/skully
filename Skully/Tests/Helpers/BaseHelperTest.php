<?php


namespace Tests\Helpers;

use \Skully\App\Helpers\UtilitiesHelper;

class BaseHelperTest extends \PHPUnit_Framework_TestCase {
    function testSuperArrayUnique() {
        $array = array('1', '1', array('2', '2'));
        $array = UtilitiesHelper::superArrayUnique($array);
        $this->assertEquals("Array
(
    [0] => 1
    [1] => Array
        (
            [0] => 2
        )

)
", print_r($array, true));
    }
}
 