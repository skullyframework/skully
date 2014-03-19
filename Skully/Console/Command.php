<?php

namespace Skully\Console;

class Command extends \Symfony\Component\Console\Command\Command {
    /** @var $app \Skully\Application */
    protected $app;

    public function __construct($app = null, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->setApp($app);
        parent::__construct($name, $version);
    }

    /**
     * Attach skully application to this command.
     * @param $app \Skully\Application
     */
    public function setApp($app) {
        $this->app = $app;
    }
}