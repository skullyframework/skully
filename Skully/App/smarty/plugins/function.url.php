<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 4/24/13
 * Time: 3:09 PM
 */

/**
 * @param array $params
 * @param Smarty $smarty
 * @return mixed
 * Url function
 * $params:
 * - path: url string
 * - pass other items as array items.
 */
function smarty_function_url($params = array(), &$smarty) {
	$path = '';
	if (!empty($params['path'])) {
		$path = $params['path'];
		unset($params['path']);
	}
    /** @var \Skully\ApplicationInterface $app */
    $app = $smarty->getRegisteredObject('app');
	return $app->getRouter()->getUrl($path, $params);
}