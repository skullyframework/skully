<?php

//----------------------------
// DATABASE CONFIGURATION
//----------------------------

/*

Valid types (adapters) are Postgres & MySQL:

'type' must be one of: 'pgsql' or 'mysql'

*/

$dbConfig = $app->config('dbConfig');

return array(
        'db' => array(
                'development' => array(
                        'type'      => 'mysql',
                        'host'      => $dbConfig['host'],
                        'port'      => $dbConfig['port'],
                        'database'  => $dbConfig['dbname'],
                        'user'      => $dbConfig['user'],
                        'password'  => $dbConfig['password'],
                        //'directory' => 'custom_name',
                        //'socket' => '/var/run/mysqld/mysqld.sock'
                ),
        ),

        'migrations_dir' => RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'migrations',

        'db_dir' => RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'db',

        'log_dir' => RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'logs',

        'ruckusing_base' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..'

);
