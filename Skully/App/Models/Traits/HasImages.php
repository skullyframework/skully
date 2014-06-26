<?php
namespace Skully\App\Models\Traits;

use Skully\App\Helpers\UtilitiesHelper;

/**
 * Class HasImages
 * @package Skully\App\Models\Base
 * Trait used for models having a field "images" which is a json text containing list of images.
 * Field name must be named as exactly "images".
 * If you need to use different field name, override the methods you need.
 * This trait is required so images can be uploaded with Skully Admin.
 */
trait HasImages {

    // --- Functions that are required for Model with images --- //
    // START //
    protected function classname()
    {
        $classname = get_called_class();
        $classname_r = explode('\\', $classname);
        $classname = $classname_r[count($classname_r)-1];
        return $classname;
    }
    /**
     * @return string
     * Override this method to change path name
     */
    public function imageBaseUrl()
    {
        $classname = $this->classname();
        /** @var \Skully\App\Models\BaseModel $this */
        return 'images/'.$classname.'/' . $this->id . '/';
    }

    public function imageBasePath()
    {
        $classname = $this->classname();
        /** @var \Skully\App\Models\BaseModel $this */
        return $this->getApp()->getTheme()->getPublicBasePath() . 'images/'.$classname.'/' . $this->id . '/';
    }

    /**
     * @param $fieldName
     * @return array|mixed
     * It is imperative to use bean here
     */
    protected function _getImageField($fieldName)
    {
        try {
            /** @var \Skully\App\Models\BaseModel $this */
            return UtilitiesHelper::decodeJson($this->bean->$fieldName, true);
        }
        catch (\Exception $e) {
            return array();
        }
    }

    /**
     * @param $fieldName
     * @param array $values
     * It is imperative to use bean here
     */
    protected function _setImageField($fieldName, $values = array())
    {
        if (is_string($values)) {
            $this->bean->$fieldName = $values;
        }
        else {
            /** @var \Skully\App\Models\BaseModel $this */
            $this->bean->$fieldName = json_encode($values);
        }
    }

    // END //

    // --- Following functions are to be added as required. --- //
    // Function names are depending on field name, e.g. with field thumb_image, create functions:
    // - getThumbImage
    // - setThumbImage
    // START //
    public function getImages()
    {
        return $this->_getImageField('images');

    }


    public function setImages($values = array())
    {
        $this->_setImageField('images', $values);
    }

    // END //
}