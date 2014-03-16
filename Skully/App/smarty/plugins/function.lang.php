<?php


/**
 * @param array $params
 * @param Smarty $smarty
 * @return mixed
 */
function smarty_function_lang($params = array(), &$smarty) {
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