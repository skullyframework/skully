<?php


/**
 * @param array $params
 * @param Smarty $smarty
 * @return mixed
 * Url function
 * $params:
 * - path: url string
 * - pass other items as array items.
 * SSL default behaviour:
 * NULL (won't attempt to change http:// into https:// or vice versa).
 * Set parameter __ssl to true or false to override default ssl behaviour.
 */
function smarty_function_url($params = array(), &$smarty) {
	$path = '';
	if (!empty($params['path'])) {
		$path = $params['path'];
		unset($params['path']);
	}

    if (!empty($params['__ssl'])) {
        $ssl = $params['__ssl'];
        unset($params['__ssl']);
    }
    else {
        $ssl = null;
    }

    /** @var \Skully\ApplicationInterface $app */
    $app = $smarty->getRegisteredObject('app');
	return $app->getRouter()->getUrl($path, $params, $ssl);
}