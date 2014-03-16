<?php


namespace Skully\Core;

use Skully\ApplicationInterface;

/**
 * Class ApplicationAware
 * @package Skully\Core
 */
class ApplicationAware implements ApplicationAwareInterface {
    /**
     * @var ApplicationInterface
     */
    protected $app;

    /**
     * @param ApplicationInterface $app
     * @return void
     */
    public function setApp(ApplicationInterface $app) {
        $this->app = $app;
    }

} 