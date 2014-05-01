<?php

use \Skully\Core\Config;
if (!defined('RUCKUSING_BASE')) {
    define('RUCKUSING_BASE', realpath(dirname(__FILE__).'/../../..') . DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'ruckusing'.DIRECTORY_SEPARATOR.'ruckusing-migrations');
}

if (!defined('RUCKUSING_SCHEMA_TBL_NAME')) {
    define('RUCKUSING_SCHEMA_TBL_NAME', 'schema_info');
}

if (!defined('RUCKUSING_TS_SCHEMA_TBL_NAME')) {
    define('RUCKUSING_TS_SCHEMA_TBL_NAME', 'schema_migrations');
}

function setCommonConfig(Config &$config, $serverName = null) {
// Config that can be carried over to any server
    if(empty($serverName)) $serverName = $_SERVER["SERVER_NAME"];

// clientAndServer configs are readable via javascript.
    if ($serverName == 'localhost' || $serverName == 'test') {
        $serverConfigAdd = array(
            'imagecachesPath' => BASE_PATH . 'images/cache/',
            'isDevMode' => false,

            /**
             * 'echo' to echo sql, 'log' to log sql at logs/errors.log, or false
             */
            'logSql' => false
        );

        $clientAndServerConfigAdd = array(
            'baseUrl' => 'http://localhost/localsite/',
            /**
             * Public directory. baseUrl + publicDir is the path to public directory accessible by public.
             * Set to '' for virtual host.
             */
            'publicDir' => 'public/'
        );
    }
    else {
        $serverConfigAdd = array(
            'imagecachesPath' => BASE_PATH . 'images/cache/',
            'isDevMode' => false,
            'logSql' => false
        );

        $clientAndServerConfigAdd = array(
            'baseUrl' => 'http://onlinesite.com/',
            /**
             * Public directory. baseUrl + publicDir is the path to public directory accessible by public.
             * Set to '' for virtual host.
             */
            'publicDir' => 'public/'
        );
    }

    $config_r = array_merge(array(
        'namespace' => 'App',

        // 0: no caching, 1: cache all with same lifetime, 2: cache with different lifetime per template.
        // http://www.smarty.net/docsv2/en/caching
        'caching' => 0,

        // Set these to show the site under maintenance page
        'maintenance' => false,
        'maintenanceIp' => '139.195.146.93',

        // Date formats used on the site
        "dateFormatDb" => "Y-m-d H:i:s",
        'dateFormat' => 'd M Y',
        'longDateTimeFormat' => 'M j, Y h:i A',
        'shortDateTimeFormat' => 'd/m H:i',
        'longDateFormat' => 'M j, Y',
        'shortDateFormat' => 'd/m',

        'adminLongDateTimeFormat' => 'd/m/Y H:i', // Used in tables
        'adminLongDateFormat' => 'd/m/Y', // Used in tables

        // The most important config. This states the mapping of site's urls.
        // If you want to add a parameter, do so by adding another action to
        // the controller. For example instead of adding 'home' parameter here,
        // route to pages/home then from there calls pages/view action.
        'urlRules' => array(
            '' => 'home/index',
            //admin
            'admin' => 'admin/home/index',
            'admin/index' => 'admin/home/index',
            'admin/loginProcess' => 'admin/admins/loginProcess',
            'admin/login' => 'admin/admins/login',
        ),
        // default selected language
        'language' => 'en',

        // the key here is used on url i.e. http://sitename.com/en/index
        'languages' => array(
            'en' => array('value' => 'english', 'code' => 'en')
        ),

        /**
         * Default email setting. Note that the password here is encrypted.
         * To encrypt the password, go to terminal, then run:
         * ./console skully:encrypt your_password
         * Then copy-paste the result here.
         * You can create additional emails in database to if you wish.
         */
        'smtpPort' => '465',
        'smtpHost' => 'smtp.google.com',
        'smtpPassword' => 'password',
        'smtpUsername' => 'email@name.com',
        'senderEmail' => 'email@name.com',
        'senderName' => 'SenderName',
        'replyToEmail' => 'contact@yoursite.com',
        'replyToName' => 'yoursite.com Contact',
        'smtpSecurity' => 'ssl',

        'basePath' => BASE_PATH,

        /**
         * Set skullyBasePath when Skully framework is located at funny places e.g. for Tests.
         */
        'skullyBasePath' => null,

        'globalSalt' => 'hakunamatata',

        'ruckusingConfig' => array(
            'migrations_dir' => array('default' => BASE_PATH . 'migrations'),
            'db_dir' => BASE_PATH . 'db',
            'log_dir' => BASE_PATH . 'logs' . DIRECTORY_SEPARATOR . 'migrations',
            'ruckusing_base' => RUCKUSING_BASE
        )
    ), $serverConfigAdd);

    $clientAndServerConfig = array_merge(array(
        // Theme used on the site, this relates to 'themes' directory.
        // This is also used by CKEditor, so needs to be in client.
        'theme' => 'default',

        // used in date forms
        'formDateFormat' => 'M d, yy',
        'serverFormDateFormat' => "%b %e, %Y",

        // used in time forms
        'formTimeFormat' => 'hh:mm TT',
        'serverFormDateTimeFormat' => "%b %e, %Y %I:%M %p"
    ), $clientAndServerConfigAdd);

    $config_r = array_merge($config_r, $clientAndServerConfig);

    $config->setProtectedFromArray($config_r);

    $clientConfig = array(
    );

    $clientConfig = array_merge($clientConfig, $clientAndServerConfig);
    $config->setPublicFromArray($clientConfig);
}