<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/20/13
 * Time: 12:27 AM
 */

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
 