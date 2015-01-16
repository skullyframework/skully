<?php


namespace Skully\Core; \Patchwork\Interceptor\applyScheduledPatches();

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
    public static function setApp(ApplicationInterface $app) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        self::$app = $app;
    }
}\Patchwork\Interceptor\applyScheduledPatches();