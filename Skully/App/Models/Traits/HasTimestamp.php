<?php
namespace Skully\App\Models\Traits;

/**
 * Class HasTimestamp
 * @package Skully\App\Models\Traits
 */
trait HasTimestamp {
    public function beforeCreate()
    {
        /** @var \Skully\App\Models\BaseModel $this */
        $this->created_at = date("Y-m-d H:i:s");
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public function beforeSave()
    {
        /** @var \Skully\App\Models\BaseModel $this */
        $this->updated_at = date("Y-m-d H:i:s");
    }
} 