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
        $this->created_at = date(\DateTime::ISO8601);
        $this->updated_at = date(\DateTime::ISO8601);
    }

    public function beforeSave()
    {
        /** @var \Skully\App\Models\BaseModel $this */
        $this->updated_at = date(\DateTime::ISO8601);
    }
} 