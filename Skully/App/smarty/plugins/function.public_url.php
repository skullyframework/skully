<?php


/**
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_public_url($params = array(), &$smarty) {
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


    if (!empty($arguments)) {
        $argumentsStr = http_build_query($arguments);
        return $app->getTheme()->getPublicBaseUrl().$path.'?'.$argumentsStr;
    }
    else {
        return $app->getTheme()->getPublicBaseUrl().$path;
    }
}