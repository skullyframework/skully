<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/19/14
 * Time: 12:28 AM
 */

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