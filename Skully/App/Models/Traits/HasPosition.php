<?php
namespace Skully\App\Models\Traits;

use RedBeanPHP\Facade as R;

trait HasPosition {
    public function beforeCreate()
    {
        if (is_null($this->get('position'))) {
            $this->set('position', (int)R::getCell("SELECT MAX(position) FROM " . $this->getTableName())+1);
        }
    }

} 