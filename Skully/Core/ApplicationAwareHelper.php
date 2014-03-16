<?php


namespace Skully\Core;

use Skully\ApplicationInterface;

/**
 * Class ApplicationAwareHelper
 * @package Skully\Core
 * Helpers in Skully MVC is a bit unique in which:
 * 1. They don't have to be extended from Skully\App\BaseHelper unless you need the helper you made
 *    to be aware of the application (i.e. can use self::app).
 * 2. Helpers implementation are entirely up to you. It is generally acceptable to
 *    have all the functions static.
 */
class ApplicationAwareHelper
{
    /**
     * @var ApplicationInterface
     */
    protected static $app;

    /**
     * @param ApplicationInterface $app
     * @return void
     */
    public static function setApp(ApplicationInterface $app) {
        self::$app = $app;
    }
}