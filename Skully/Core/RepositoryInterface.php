<?php


namespace Skully\Core;


interface RepositoryInterface {

    /**
     * @param \Skully\ApplicationInterface|null $app
     */
    public function __construct($app = null);

} 