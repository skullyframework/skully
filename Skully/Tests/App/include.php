<?php
define('BASE_PATH', __DIR__. DIRECTORY_SEPARATOR);

$_SERVER['SERVER_NAME'] = 'test';

require_once('Application.php');
require_once('Controllers/base.php');
require_once('Controllers/home.php');
require_once('Controllers/adminBase.php');
require_once('Controllers/adminHome.php');
require_once('Controllers/home2.php');
require_once('Controllers/plugins.php');
require_once('Controllers/themes.php');
require_once('Controllers/news.php');
require_once('Models/testmodel.php');
require_once('Models/foo.php');
require_once('Models/bar.php');