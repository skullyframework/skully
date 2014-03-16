<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 10/12/13
 * Time: 12:19 PM
 * Description: Use this to decide if ruckus application is running on online or local version.
 */

/** When running ruckus.php, pass -p option for production database. */
$server = 'development';
if (isset($argv)) {
    foreach($argv as $arg) {
        if ($arg == '-p' || $arg == '--production') {
            $server = 'production';
        }
        elseif ($arg == '-t' || $arg == '--test') {
            $server = 'test';
        }
    }
}
if ($server == 'production') {
	$_SERVER['SERVER_NAME'] = '';
}
elseif ($server == 'test') {
    $_SERVER['SERVER_NAME'] = 'test';
}
else {
    $_SERVER['SERVER_NAME'] = 'localhost';
}

// We are going to drop our dispatch file in here
require_once(dirname(__FILE__).'/../../bootstrap.php');
$app = __setupApp();