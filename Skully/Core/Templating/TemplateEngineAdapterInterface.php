<?php


namespace Skully\Core\Templating;

interface TemplateEngineAdapterInterface {

    /**
     * @param string $basePath Application's base path ending with DIRECTORY_SEPARATOR
     * @param string $theme
     * @param string $app
     * @param array $additionalPluginsDir
     * @param int $caching
     */
    public function __construct($basePath, $theme = 'default', $app = 'App', $additionalPluginsDir = array(), $caching = 1);

    /**
     * Set template directory
     *
     * @param  string|array $template_dir directory(s) of template sources
     */
    public function setTemplateDir($template_dir);

    /**
     * Add template directory(s)
     *
     * @param  string|array    $template_dir directory(s) of template sources
     * @param  string          $key          of the array element to assign the template dir to
     */
    public function addTemplateDir($template_dir, $key=null);

    /**
     * @param null $index
     * @return array|string
     */
    public function getTemplateDir($index = null);

    /**
     * @param $plugins_dir String Plugins directory to add
     */
    public function addPluginsDir($plugins_dir);

    /**
     * @param $plugins_dir String Plugins directory to set
     */
    public function setPluginsDir($plugins_dir);
    /**
     * @return array
     */
    public function getPluginsDir();

    /**
     * @param null $template
     * @param null $cache_id
     * @param null $compile_id
     * @param null $parent
     * See Smarty documentation
     */
    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null);

    /**
     * @param null $template
     * @param null $cache_id
     * @param null $compile_id
     * @param null $parent
     * @param bool $display
     * @param bool $merge_tpl_vars
     * @param bool $no_output_filter
     * @return string
     * See Smarty documentation
     */
    public function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false);

    /**
     * @param $tpl_var
     * @param null $value
     * @param bool $nocache
     * @return \Smarty_Internal_Data
     * See smarty documentation
     */
    public function assign($tpl_var, $value = null, $nocache = false);

    /**
     * @param null $template
     * @param null $cache_id
     * @param null $compile_id
     * @param null $parent
     * @return bool
     */
    public function isCached($template = null, $cache_id = null, $compile_id = null, $parent = null);

    /**
     * @param $object_name
     * @param $object_impl
     * @param array $allowed
     * @param bool $smarty_args
     * @param array $block_methods
     * @return \Smarty_Internal_TemplateBase
     */
    public function registerObject($object_name, $object_impl, $allowed = array(), $smarty_args = true, $block_methods = array());

    /**
     * @param $name
     * @return object
     */
    public function getRegisteredObject($name);

    /**
     * Takes unknown classes and loads plugin files for them
     * class name format: Smarty_PluginType_PluginName
     * plugin filename format: plugintype.pluginname.php
     *
     * @param  string $plugin_name class plugin name to load
     * @param  bool   $check       check if already loaded
     * @return string |boolean filepath of loaded file or false
     */
    public function loadPlugin($plugin_name, $check = true);

    /**
     * @param null $value
     * @return string
     */
    public function getTemplateVars($value=null);

    /**
     * @param int $value
     */
    public function setCacheLifetime($value=3600);
}