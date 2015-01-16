<?php


namespace Skully\Core; \Patchwork\Interceptor\applyScheduledPatches();

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
    public function setApp(ApplicationInterface $app) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
        $this->app = $app;
    }

}\Patchwork\Interceptor\applyScheduledPatches(); 