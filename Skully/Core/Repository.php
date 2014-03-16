<?php


namespace Skully\Core;

/**
 * Class Repository
 * @package Skully\Core
 * Database finder methods should be kept in Repository objects.
 */
class Repository extends ApplicationAware implements RepositoryInterface {

    /**
     * @param \Skully\ApplicationInterface|null $app
     */
    public function __construct($app = null)
    {
        if (!empty($app)) {
            $this->setApp($app);
        }
    }

} 