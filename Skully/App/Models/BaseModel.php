<?php


namespace Skully\App\Models;

use RedBeanPHP\SimpleModel;
use Skully\App\Helpers\UtilitiesHelper;
use Skully\ApplicationInterface;
use RedBeanPHP\Facade as R;

/**
 * Class BaseModel
 * @package Skully\App\Models
 */
abstract class BaseModel extends \RedBeanPHP\SimpleModel {

    /**
     * @var \RedBeanPHP\OODBBean Duplicated object right before saving.
     */
    public $oldMe;
    /**
     * @var \App\Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @param ApplicationInterface $app
     * @return void
     */
    public function setApp(ApplicationInterface $app) {
        $this->app = $app;
    }

    /**
     * Magic Getter to make the bean properties available from
     * the $this-scope.
     *
     * Before getting from bean, try seeing if getProp method exists first.
     *
     * @note this method returns a value, not a reference!
     *       To obtain a reference unbox the bean first!
     *
     * @param string $prop property
     *
     * @return mixed
     */
    public function __get( $prop )
    {
        $method = 'get'.UtilitiesHelper::toCamelCase($prop, true);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        else {
            return $this->bean->$prop;
        }
    }

    /**
     * Magic Setter.
     * Sets the value directly as a bean property.
     * Before setting bean value, try seeing if setProp method exists first.
     *
     * @param string $prop  property
     * @param mixed  $value value
     *
     * @return void
     */
    public function __set( $prop, $value )
    {
        $method = 'set'.UtilitiesHelper::toCamelCase($prop,true);
        if (method_exists($this, $method)) {
            $this->$method($value);
        }
        else {
            $this->bean->$prop = $value;
        }
    }

    public function get($prop)
    {
        return $this->$prop;
    }

    public function set($prop, $value)
    {
        return $this->$prop = $value;
    }

    public function has($prop)
    {
        return !empty($this->$prop);
    }

    public function getID()
    {
        return $this->unbox()->getID();
    }

    public function getTableName() {
        return strtolower(get_called_class());
    }

    /**
     * Instead of overriding this method, override methods
     * called by this (beforeUpdate,Save,Create and validatesOnCreate,Save,Update)
     * @throws \Exception
     */
    final public function update()
    {
        if (!$this->validates()) {
            throw new \Exception($this->errorMessage());
        }
        else {
            $this->actionsBefore();
        }
        $this->oldMe = R::dup($this->unbox(), array(), true);
    }

    /**
     * Instead of overriding this method, override methods
     * called by this (afterCreate,Save,Update)
     */
    final public function after_update()
    {
        $this->actionsAfter();
    }

    final public function after_delete()
    {
        $this->afterDestroy($this->oldMe);
    }

    /**
     * Actions right before saving the model in any way
     * (save, update, create)
     * These actions are run after validations.
     */
    public function actionsBefore()
    {
        if (!$this->getID()) {
            $this->beforeCreate();
        }
        else {
            $this->beforeUpdate();
        }
        $this->beforeSave();
    }

    /**
     * Actions right after saving the model in any way
     * (save, update, create)
     */
    private function actionsAfter()
    {
        if (!$this->oldMe->getID()) {
            $this->afterCreate($this->oldMe);
        }
        else {
            $this->afterUpdate($this->oldMe);
        }
        $this->afterSave($this->oldMe);
    }

    public function validates()
    {
        if (!$this->getID()) {
            $this->validatesOnCreate();
        }
        else {
            $this->validatesOnUpdate();
        }
        $this->validatesOnSave();
        $mustExists = $this->validatesExistenceOf();
        if (!empty($mustExists)) {
            foreach($mustExists as $var) {
                $value = $this->$var;
                // PHP Gotcha: somehow empty($this->$var) does not work, maybe because $var is a (magic) function.
                if (empty($value)) {
                    $varStr = str_replace('_', ' ', $var);
                    $varStr = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $varStr);
                    $varStr = ucfirst(strtolower($varStr));
                    $this->addError($this->app->getTranslator()->translate('mustExists', array('varStr' => $varStr)), $var);
                }
            }
        }
        $mustUnique = $this->validatesUniquenessOf();
        if (!empty($mustUnique)) {
            foreach ($mustUnique as $var) {
                $count = R::count($this->getTableName(), "$var = ?", array($this->get($var)));
                $varStr = str_replace('_', ' ', $var);
                $varStr = preg_replace('/(?!^)[A-Z]{2,}(?=[A-Z][a-z])|[A-Z][a-z]/', ' $0', $varStr);
                $varStr = ucfirst(strtolower($varStr));
                if ($this->getID()) {
                    if ($count > 1) {
                        $this->addError($this->app->getTranslator()->translate('mustUnique', array('varStr' => $varStr)), $var);
                    }
                }
                else {
                    if ($count > 0) {
                        $this->addError($this->app->getTranslator()->translate('mustUnique', array('varStr' => $varStr)), $var);
                    }
                }
            }
        }
        return !$this->hasError();
    }

    public function addError($text, $attribute = null)
    {
        if (empty($attribute)) {
            $this->errors = array_merge($this->errors, array($text));
        }
        else {
            $this->errors = array_merge($this->errors, array($attribute => $text));
        }
    }

    public function getErrors($attribute = null, $arrayWrapper = null)
    {
        if (!empty($attribute)) {
            if (is_null($arrayWrapper)) {
                return $this->errors[$attribute];
            }
            else {
                return array($arrayWrapper.'['.$attribute.']' => $this->errors[$attribute]);
            }
        }
        else {
            if (is_null($arrayWrapper)) {
                return $this->errors;
            }
            else {
                $newErrors = array();
                if (!empty($this->errors)) {
                    foreach ($this->errors as $key => $error) {
                        $newErrors[$arrayWrapper.'['.$key.']'] = $error;
                    }
                }
                return $newErrors;
            }
        }
    }

    public function hasError()
    {
        return count($this->getErrors())>0;
    }

    public function errorMessage($combiner = "\n")
    {
        $message = '';
        if (!empty($this->errors)) {
            foreach($this->errors as $error) {
                $message .= $error . $combiner;
            }
        }
        return $message;
    }

    public function setMeta($path, $value)
    {
        $this->unbox()->setMeta($path, $value);
    }

    public function getMeta($path)
    {
        return $this->unbox()->getMeta($path);
    }

    public function import($array, $selection = FALSE, $notrim = FALSE)
    {
        $this->unbox()->import($array, $selection, $notrim);
    }

    public function removeProperty($property)
    {
        unset($this->$property);
    }

    /**
     * Export model's bean and its custom Meta (meta set via method setMeta)
     * Custom meta returned here are directly translated into model's attributes.
     * @param bool $customMeta
     * @return array
     */
    public function export($customMeta = true)
    {
        if ($customMeta) {
            $values = $this->unbox()->export(true);
            $metaTags = array();
            if (!empty($values['__info'])) {
                foreach ($values['__info'] as $key => $info) {
                    if (!in_array($key, array('type', 'sys.id', 'sys.orig', 'tainted', 'model'))) {
                        $metaTags[$key] = $info;
                    }
                }
            }
            unset($values['__info']);
        }
        else {
            $values = $this->unbox()->export();
            $metaTags = array();
        }
        return array_merge($values, $metaTags);
    }

    /**
     * ---------------------------------
     *        Methods to Override
     * ---------------------------------
    **/

    public function validatesExistenceOf()
    {
        return array();
    }

    public function validatesUniquenessOf()
    {
        return array();
    }

    public function afterSave($oldMe)
    {

    }

    public function afterUpdate($oldMe)
    {

    }

    public function afterCreate($oldMe)
    {

    }

    /**
     * @var \RedBeanPHP\OODBBean $oldMe
     */
    public function afterDestroy($oldMe)
    {

    }

    public function beforeSave()
    {

    }

    public function beforeUpdate()
    {

    }

    public function beforeCreate()
    {

    }

    protected function validatesOnCreate()
    {
        return true;
    }

    protected function validatesOnUpdate()
    {
        return true;
    }

    protected function validatesOnSave()
    {
        return true;
    }
}