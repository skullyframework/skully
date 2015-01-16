<?php


namespace Skully\Core; \Patchwork\Interceptor\applyScheduledPatches();

use Skully\ApplicationInterface;

/**
 * Interface ApplicationAwareInterface
 * @package Skully\Core
 * Application is the container of Skully framework.
 * Any class extended from this would be able to "see" Application by doing $this->app.
 */
interface ApplicationAwareInterface {
    /**
     * @param ApplicationInterface $app
     * @return mixed
     */
    public function setApp(ApplicationInterface $app);
} 