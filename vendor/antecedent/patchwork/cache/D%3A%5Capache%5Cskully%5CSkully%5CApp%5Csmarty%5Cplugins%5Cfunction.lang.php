<?php
 \Patchwork\Interceptor\applyScheduledPatches();

/**
 * @param array $params
 * @param Smarty $smarty
 * @return mixed
 */
function smarty_function_lang($params = array(), &$smarty) {$__pwClosureName=__NAMESPACE__?__NAMESPACE__."\{closure}":"{closure}";$__pwClass=(__CLASS__&&__FUNCTION__!==$__pwClosureName)?__CLASS__:null;$__pwCalledClass=$__pwClass?\get_called_class():null;if(!empty(\Patchwork\Interceptor\State::$patches[$__pwClass][__FUNCTION__])){$__pwFrame=\count(\debug_backtrace(false));if(\Patchwork\Interceptor\intercept($__pwClass,$__pwCalledClass,__FUNCTION__,$__pwFrame,$__pwResult)){return$__pwResult;}}unset($__pwClass,$__pwCalledClass,$__pwResult,$__pwClosureName,$__pwFrame);
	$value = $params['value'];
	unset($params['value']);

	$arguments = array();
	foreach($params as $key => $val)
	{
        $arguments[$key] = $val;
	}

    /** @var \Skully\ApplicationInterface $app */
    $app = $smarty->getRegisteredObject('app');

	return $app->getTranslator()->translate($value, $arguments);
}