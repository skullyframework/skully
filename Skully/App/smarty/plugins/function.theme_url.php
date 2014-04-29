<?php


/**
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
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