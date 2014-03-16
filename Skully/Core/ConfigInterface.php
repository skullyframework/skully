<?php


namespace Skully\Core;


/**
 * Interface ConfigInterface
 * @package Skully\Shared
 * This is the minimal requirements of a Config class.
 * Basically, a config object is an object containing all the configurations within a project.
 * Configurations are divided into two visibilities:
 * - protected configurations: These are configurations that are only available at Models and Controllers.
 * - public configurations: These are configurations that are also available at Views (i.e. they are
 *   appended into Smarty templates).
 * You can have different configurations for different apps by creating another class inherited from
 * Config class.
 * Depending on your app, you may want to attach a configuration into it, for example like this:
 * $app->attachConfig(new Config());
 *
 * Variation of this ConfigInterface could be, for example, getting configurations from Database.
 */
interface ConfigInterface {
    /**
     * @param $key
     * @param $value
     * Set a single protected variable.
     */
    public function setProtected($key, $value);

    /**
     * @param null $key
     * @return mixed
     * Get a single protected variable.
     * If $key is null, return all protected variables.
     */
    public function getProtected($key = null);

    /**
     * @param null $key
     * @return mixed
     * Get a single protected variable. When not found, get public variable instead.
     * If $key is null, return merged public and protected variables (in that order).
     */
    public function get($key = null);

    /**
     * @param $key
     * @param $value
     * @return mixed
     * Set a single public variable.
     */
    public function setPublic($key, $value);

    /**
     * @param null $key
     * @return mixed
     * Get a single public variable.
     * If $key is null, return all public variables.
     */
    public function getPublic($key = null);

    /**
     * @param $key
     * @return mixed
     * In this function, disallow protected variables to be accessed directly.
     */
    public function __get($key);
}