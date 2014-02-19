<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/28/13
 * Time: 3:35 PM
 */

namespace Skully\Core;

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