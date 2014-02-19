<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/20/13
 * Time: 1:17 AM
 */

namespace Skully\Core;


/**
 * Class Config
 * @package Skully\Shared
 * A simple Basic implementation of ConfigInterface.
 * Allow config setting by passing an array.
 * See ConfigInterface for more documentation.
 */
class Config implements ConfigInterface{
    /**
     * @var array
     * Protected configurations, not passed to Views.
     */
    private $protected = array();
    /**
     * @var array
     * Public configurations, passed to Views.
     */
    private $public = array();

    /**
     * @param $array
     * Set protected configurations from array.
     */
    public function setProtectedFromArray($array)
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $this->setProtected($key, $value);
            }
        }
    }

    /**
     * @param $array
     * Set public configurations from array.
     */
    public function setPublicFromArray($array)
    {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $this->setPublic($key, $value);
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * Refer to ConfigInterface for documentation.
     */
    public function setProtected($key, $value)
    {
        $this->protected[$key] = $value;
    }

    /**
     * @param null $key
     * @return array|bool
     * Refer to ConfigInterface for documentation.
     */
    public function getProtected($key = null)
    {
        if (is_null($key)) {
            return $this->protected;
        }
        else {
            return isset($this->protected[$key]) ? $this->protected[$key] : null;
        }
    }

    public function get($key = null) {
        if (is_null($key)) {
            return array_merge($this->public, $this->protected);
        }
        else {
            return isset($this->protected[$key]) ? $this->protected[$key] : $this->getPublic($key);
        }
    }

    /**
     * @param $key
     * @param $value
     * @return void
     * Refer to ConfigInterface for documentation.
     */
    public function setPublic($key, $value)
    {
        $this->public[$key] = $value;
    }

    /**
     * @param null $key
     * @return array|bool
     * Refer to ConfigInterface for documentation.
     */
    public function getPublic($key = null)
    {
        if (is_null($key)) {
            return $this->public;
        }
        else {
            return isset($this->public[$key]) ? $this->public[$key] : null;
        }
    }

    /**
     * @param $key
     * @return bool
     * Refer to ConfigInterface for documentation.
     */
    public function __get($key)
    {
        return isset($this->public[$key]) ? $this->public[$key] : null;
    }
}