<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 1/9/14
 * Time: 3:07 PM
 */

/**
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
error_log("loading smarty function theme_url");
function smarty_function_theme_url($params = array(), &$smarty) {
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

    return $app->getTheme()->getUrl($path, $arguments);
}