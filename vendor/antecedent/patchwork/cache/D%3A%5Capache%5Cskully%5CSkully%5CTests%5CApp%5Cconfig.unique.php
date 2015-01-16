<?php
 \Patchwork\Interceptor\applyScheduledPatches();

date_default_timezone_set('Asia/Jakarta');

use Skully\Core\Config;

function setUniqueConfig(Config &$config, $serverName = null) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
    if(empty($serverName)) $serverName = $_SERVER["SERVER_NAME"];

    if ($serverName == 'localhost') {
        /**
         * LOCALHOST
         */
        $config_r=array(
            'serverName' => $serverName,
            "dbConfig" => array(
                'type' => 'mysql',
                "host"	    => "127.0.0.1",
                "user"	    => "root",
                "password"	=> "oisadj",
                "port"		=> "3306",
                "dbname"	=> "skully",
                'charset'   => 'utf8'
            ),
        );
    }
    elseif ($serverName == 'test') {
        /**
         * TEST
         */
        $config_r=array(
            'serverName' => $serverName,
            "dbConfig" => array(
                'type' => 'sqlite',
                "host"	    => "localhost",
                "user"	    => "",
                "password"	=> "",
                "port"		=> "",
                "dbname"	=> 'test.db',
                'charset'   => 'utf8'
            ),
        );
    }
    else {
        /**
         * ONLINE
         */
        $config_r=array(
            'serverName' => $serverName,
            "dbConfig" => array(
                'type' => 'mysql',
                "host"	    => "",
                "user"	    => "",
                "password"	=> "",
                "port"		=> "3306",
                "dbname"	=> "online_database",
                'charset'   => 'utf8',

                // Added on Skully v0.1.6
                // The following is added so when we migrate, get data from "skully"
                // directory, instead of "online_database" directory.
                'directory' => 'skully'
            )
        );
    }
    $config->setProtectedFromArray($config_r);

    if ($serverName == 'localhost') {
        $clientAndServerConfig = array(
        );
    }
    elseif ($serverName == 'test') {
        $clientAndServerConfig = array(
        );
    }
    else {
        $clientAndServerConfig = array(
        );
    }
    $config->setProtectedFromArray($clientAndServerConfig);
    $config->setPublicFromArray($clientAndServerConfig);
}