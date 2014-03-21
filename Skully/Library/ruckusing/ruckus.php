#!/usr/bin/php
<?php
include(realpath(dirname(__FILE__)) . '/configure.php');
// Find and initialize Composer
$composer_found = false;
$php53 = version_compare(PHP_VERSION, '5.3.2', '>=');

if (!defined('RUCKUSING_WORKING_BASE')) {
    define('RUCKUSING_WORKING_BASE', realpath(dirname(__FILE__)));
}
// $db_config = require RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'ruckusing.conf.php';
$db_config = require RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.inc.php';

if (!defined('RUCKUSING_BASE')) {
    if (isset($db_config['ruckusing_base'])) {
        define('RUCKUSING_BASE', $db_config['ruckusing_base']);
    } else {
        define('RUCKUSING_BASE', dirname(__FILE__));
    }
}
//echo "require file " . RUCKUSING_BASE . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.inc.php';

require_once RUCKUSING_BASE . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.inc.php';

if (!function_exists('loader') && !$composer_found) {

    set_include_path(
            implode(
                    PATH_SEPARATOR,
                    array(
                            RUCKUSING_BASE . DIRECTORY_SEPARATOR . 'lib',
                            get_include_path(),
                    )
            )
    );

    function loader($classname)
    {
	    $file = RUCKUSING_BASE . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        if (file_exists($file)) {
		    include $file;
	    }
    }

    if ($php53) {
       spl_autoload_register('loader', true, true);
    } else {
       spl_autoload_register('loader', true);
    }
}

$main = new Ruckusing_FrameworkRunner($db_config, $argv);
echo $main->execute();
