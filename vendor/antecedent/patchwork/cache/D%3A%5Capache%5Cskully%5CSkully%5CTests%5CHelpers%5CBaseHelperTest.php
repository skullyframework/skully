<?php


namespace Tests\Helpers; \Patchwork\Interceptor\applyScheduledPatches();

use \Skully\App\Helpers\UtilitiesHelper;

class BaseHelperTest extends \PHPUnit_Framework_TestCase {
    function testSuperArrayUnique() {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
}\Patchwork\Interceptor\applyScheduledPatches();
 