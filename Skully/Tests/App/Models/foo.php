<?php

namespace App\Models;
use \Skully\App\Models\BaseModel;

class Foo extends BaseModel {
    public function validatesExistenceOf()
    {
        return array('name');
    }
}