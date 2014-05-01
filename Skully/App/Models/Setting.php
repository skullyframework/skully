<?php
namespace Skully\App\Models;
use \RedBeanPHP\Facade as R;
use \Skully\App\Helpers\FileHelper;
use \Skully\Library\EncryptionClass\EncryptionClass;

class Setting extends BaseModel{
    protected function protectedFields() {
        return array('isClient', 'type');
    }

    public function beforeCreate() {
        $pos = R::getCell("SELECT MAX(position) FROM setting");
        $this->set('position', (int)$pos+1);
    }

    public function beforeSave() {
        $crypt = new EncryptionClass();
        if ($this->get('input_type') == 'password') {
            $this->set('value', $crypt->encrypt($this->app->config('globalSalt'), $this->get('value')));
        }
    }

    public function getDisplayValue()
    {
        if ($this->get('input_type') == 'password') {
            return "*************";
        }
        else {
            return trim($this->get('value'));
        }
    }

    public function imagePath()
    {
        return 'images/settings/' . $this->get("id") . '/';
    }

    /**
     * @param \Skully\App\Models\Setting $oldMe
     */
    public function afterDestroy($oldMe)
    {
        if($oldMe->get('input_type') == "image"){
            //delete images
            if(file_exists($oldMe->imagePath()))
                FileHelper::removeFolder($oldMe->imagePath());
        }
    }
} 