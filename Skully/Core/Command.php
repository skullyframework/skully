<?php

namespace Skully\Core;

use Symfony\Component\Console\Application;

class Command extends Application {
    /** @var $app \Skully\Application */
    protected $app;

    public function __construct($app = null, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->app = $app;
        parent::__construct($name, $version);
    }
}