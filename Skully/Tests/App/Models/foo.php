<?php

namespace App\Models;
use \Skully\App\Models\BaseModel;

class Foo extends BaseModel {

    public function validatesExistenceOnUpdateOf()
    {
        return array('exists_update');
    }

    public function validatesExistenceOnCreateOf()
    {
        return array('exists_create');
    }

    public function validatesUniquenessOnUpdateOf()
    {
        return array('unique_update');
    }

    public function validatesUniquenessOnCreateOf()
    {
        return array('unique_create');
    }

    public function validatesUniquenessOf()
    {
        return array('unique');
    }

    public function validatesExistenceOf()
    {
        return array('name');
    }
}