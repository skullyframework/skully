<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/19/14
 * Time: 12:35 AM
 */

namespace Skully\Core;


interface RepositoryInterface {

    /**
     * @param \Skully\ApplicationInterface|null $app
     */
    public function __construct($app = null);

} 