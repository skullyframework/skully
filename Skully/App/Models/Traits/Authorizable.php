<?php

namespace Skully\App\Models\Traits;

use Skully\App\Helpers\UtilitiesHelper;

/**
 * Class Authorizable
 * @package Skully\App\Models\Traits
 * Use this on models that are authorizable, like User or Admin.
 * Model must have salt and password_hash fields.
 */
trait Authorizable {
    protected $password;

    protected $password_confirmation;

    public function validatesOnCreate()
    {
        if (empty($this->password)) {
            $this->addError($this->app->getTranslator()->translate('passwordEmpty'), 'password');
        }
    }
    public function validatesOnSave()
    {
        if ($this->password != $this->password_confirmation) {
            $this->addError($this->app->getTranslator()->translate('passwordConfirmationWrong'), 'passwordConfirmation');
        }
    }

    public function beforeSave()
    {
        if (!empty($this->password)) {
            $this->set('salt', time());
            $this->set('password_hash', UtilitiesHelper::toHash($this->password, $this->get('salt'), $this->app->config('globalSalt')));
        }
        $this->removeProperty('password');
        $this->removeProperty('password_confirmation');
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password_confirmation
     */
    public function setPasswordConfirmation($password_confirmation)
    {
        $this->password_confirmation = $password_confirmation;
    }

    /**
     * @return mixed
     */
    public function getPasswordConfirmation()
    {
        return $this->password_confirmation;
    }
} 