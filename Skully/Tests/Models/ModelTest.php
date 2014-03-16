<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 3/12/14
 * Time: 4:13 PM
 */

require_once(dirname(__FILE__).'/../DatabaseTestCase.php');

use RedBean_Facade as R;

class ModelTest extends \PHPUnit_Framework_TestCase {
    protected function testCreateModel()
    {
        $app = __setupApp();
        R::freeze(false);
        $test = $app->createModel('testmodel');
        $test->name = "x";

    }
} 