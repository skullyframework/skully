<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 12/28/13
 * Time: 3:32 PM
 */

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