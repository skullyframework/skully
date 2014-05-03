<?php

namespace Tests;

require_once(dirname(__FILE__).'/DatabaseTestCase.php');

use RedBeanPHP\Facade as R;

class ModelTest extends \Tests\DatabaseTestCase {

    /**
     * Cant have camelcased beans
     * @expectedException \RedBeanPHP\RedException
     */
    public function testTwoWordsCamelcasedBean()
    {
        R::freeze(false);
        $testName = R::dispense('testName');
        $id = R::store($testName);
        R::load('testName', $id);
        R::freeze($this->frozen);
    }

    /**
     * Cant have underscored beans
     * @expectedException \RedBeanPHP\RedException
     */
    public function testTwoWordsUnderscoredBean()
    {
        R::freeze(false);
        $testName = R::dispense('test_name');
        $id = R::store($testName);
        R::load('test_name', $id);
        R::freeze($this->frozen);
    }

    public function testValidation()
    {
        $product = $this->app->createModel('testmodel');
        $this->assertEquals(array('name'), $product->validatesExistenceOf());
    }

    public function testCreateSuccess()
    {
        R::freeze(false);
        $testmodel = $this->app->createModel('testmodel', array('name' => 'test'));
        R::store($testmodel);
        $bean = R::findOne('testmodel');
        $this->assertEquals($bean->name, $testmodel->get('name'));
        R::freeze($this->frozen);
    }

    public function testMeta()
    {
        $this->migrate();
        R::exec(file_get_contents(dirname(__FILE__).'/db/foo.sql'));
        $test = R::findOne('foo');
        $test->box()->setMeta('test', array('test'));
        $exported = $test->box()->export(true);
        $this->assertEquals(array('test'), $exported['test']);
    }

    /**
     * Let's consider it RedBeanPHP's bug to use with SQLite for now...
     * todo: Fix SQLite bug
     * @expectedException \RedBeanPHP\RedException\SQL
     */
    public function testTitleField()
    {
        $this->migrate();
        $news = R::dispense('bar');
        $news->import(array('title' => 'test news', 'newscategory_id' => 1));
        R::store($news);
        $newsFound = R::findLast('bar');
        $this->assertEquals('test news', $newsFound->title);
    }
}
 