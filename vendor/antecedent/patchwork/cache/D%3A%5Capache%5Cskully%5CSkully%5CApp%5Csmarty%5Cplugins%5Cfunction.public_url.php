<?php
 \Patchwork\Interceptor\applyScheduledPatches();

/**
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_public_url($params = array(), &$smarty) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
    $path = '';
    if (!empty($params['path'])) {
        $path = $params['path'];
        unset($params['path']);
    }

    $arguments = array();
    foreach($params as $key => $val)
    {
        $arguments[$key] = $val;
    }

    /** @var \Skully\ApplicationInterface $app */
    $app = $smarty->getRegisteredObject('app');

    if(strpos($path, "http://") !== 0 && strpos($path, "https://") !== 0){
        $path = $app->getTheme()->getPublicBaseUrl().$path;
    }

    if (!empty($arguments)) {
        $argumentsStr = http_build_query($arguments);
        return $path.'?'.$argumentsStr;
    }
    else {
        return $path;
    }
}