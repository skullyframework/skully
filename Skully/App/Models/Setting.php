<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 2/10/14
 * Time: 1:43 AM
 */

namespace Skully\App\Models;
use \RedBean_Facade as R;
use \App\Helpers\FileHelper;

class Setting extends BaseModel{
    protected function protectedFields() {
        return array('isClient', 'type');
    }

    public function beforeCreate() {
        $pos = R::getCell("SELECT MAX(position) FROM setting");
        $this->set('position', (int)$pos+1);
    }

    public function beforeSave() {
        $crypt = new \EncryptionClass();
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