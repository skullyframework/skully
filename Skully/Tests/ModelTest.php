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

    public function testValidatesExistenceOf()
    {
        $foo = $this->app->createModel('foo');
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertNotEmpty($foo->getErrors('name'));
        }
    }

    public function testValidatesExistenceOnUpdateOf()
    {
        $foo = $this->app->createModel('foo');
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertEmpty($foo->getErrors('exists_update'));
        }

        $foo->import(array(
            'name' => 'name',
            'exists_create' => 'exists_create'
        ));
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            print_r($foo->getErrors());
            $this->assertEmpty($foo->getErrors('exists_update'));
        }

        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            print_r($foo->getErrors());
            $this->assertNotEmpty($foo->getErrors('exists_update'));
        }
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
        R::freeze(false);
        $testmodel = $this->app->createModel('testmodel', array('name' => 'test'));
        R::store($testmodel);
        $bean = R::findOne('testmodel');
        $bean->box()->setMeta('test', array('test'));
        $exported = $bean->box()->export(true);
        $this->assertEquals(array('test'), $exported['test']);
        R::freeze($this->frozen);
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
 