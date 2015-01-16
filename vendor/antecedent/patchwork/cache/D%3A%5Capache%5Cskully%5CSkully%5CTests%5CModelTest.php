<?php

namespace Tests; \Patchwork\Interceptor\applyScheduledPatches();


use RedBeanPHP\Facade as R;
use Skully\App\Helpers\FileHelper;

require_once(FileHelper::replaceSeparators(dirname(__FILE__).'/DatabaseTestCase.php'));

class ModelTest extends \Tests\DatabaseTestCase {

    /**
     * Cant have camelcased beans
     * @expectedException \RedBeanPHP\RedException
     */
    public function testTwoWordsCamelcasedBean()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        R::freeze(false);
        $testName = R::dispense('test_name');
        $id = R::store($testName);
        R::load('test_name', $id);
        R::freeze($this->frozen);
    }

    public function testValidatesExistenceOf()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $foo = $this->app->createModel('foo');
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertNotEmpty($foo->getErrors('name'));
        }
    }

    public function testValidatesExistence()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        R::freeze(false);
        $foo = $this->app->createModel('foo');
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertNotEmpty($foo->getErrors('name'));
            $this->assertNotEmpty($foo->getErrors('exists_create'));
            $this->assertEmpty($foo->getErrors('exists_update'));
        }

        $foo->import(array(
            'name' => 'name',
            'exists_create' => 'exists_create'
        ));
        R::store($foo);
        $this->assertNotEmpty($foo->getID());
        $this->assertEmpty($foo->getErrors('name'));
        $this->assertEmpty($foo->getErrors('exists_create'));
        $this->assertEmpty($foo->getErrors('exists_update'));

        // Must change an attribute otherwise RedBean does not want to update.
        $foo->set('name', 'name2');
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertEmpty($foo->getErrors('name'));
            $this->assertEmpty($foo->getErrors('exists_create'));
            $this->assertNotEmpty($foo->getErrors('exists_update'));
        }
        R::freeze($this->frozen);
    }

    public function testValidatesUniqueness()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        R::freeze(false);
        $foo1 = $this->app->createModel('foo', array(
            'name' => 'a',
            'exists_create' => 'b',
            'exists_update' => 'c',
            'unique' => 'unique',
            'unique_create' => 'unique_create',
            'unique_update' => 'unique_update'
        ));
        R::store($foo1);
        $this->assertNotEmpty($foo1->getID());
        $rows = R::findAll('foo', "`unique` = ?", array('unique'));
        $this->assertEquals(1, count($rows));

        $foo = $this->app->createModel('foo', array(
            'name' => 'a',
            'exists_create' => 'b',
            'exists_update' => 'c',
            'unique' => 'unique',
            'unique_create' => 'unique_create',
            'unique_update' => 'unique_update'
        ));
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertNotEmpty($foo->getErrors('unique'));
            $this->assertNotEmpty($foo->getErrors('unique_create'));
            $this->assertEmpty($foo->getErrors('unique_update'));
        }

        $foo->import(array(
            'unique' => 'unique1',
            'unique_create' => 'unique_create1'
        ));
        R::store($foo);
        $this->assertNotEmpty($foo->getID());
        $this->assertEmpty($foo->getErrors('unique'));
        $this->assertEmpty($foo->getErrors('unique_create'));
        $this->assertEmpty($foo->getErrors('unique_update'));

        // Must change an attribute otherwise RedBean does not want to update.
        $foo->set('unique_create', 'unique_create');
        try {
            R::store($foo);
        }
        catch (\Exception $e) {
            $this->assertEmpty($foo->getErrors('unique'));
            $this->assertEmpty($foo->getErrors('unique_create'));
            $this->assertNotEmpty($foo->getErrors('unique_update'));
        }

        $foo->set('unique_update', 'unique_update1');
        R::store($foo);
        $this->assertEmpty($foo->getErrors('unique'));
        $this->assertEmpty($foo->getErrors('unique_create'));
        $this->assertEmpty($foo->getErrors('unique_update'));
        R::freeze($this->frozen);
    }

    public function testCreateSuccess()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        R::freeze(false);
        $testmodel = $this->app->createModel('testmodel', array('name' => 'test'));
        R::store($testmodel);
        $bean = R::findOne('testmodel');
        $this->assertEquals($bean->name, $testmodel->get('name'));
        R::freeze($this->frozen);
    }

    public function testMeta()
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
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
    {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->migrate();
        $news = R::dispense('bar');
        $news->import(array('title' => 'test news', 'newscategory_id' => 1));
        R::store($news);
        $newsFound = R::findLast('bar');
        $this->assertEquals('test news', $newsFound->title);
    }
}\Patchwork\Interceptor\applyScheduledPatches();
 