<?php


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