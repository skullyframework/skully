<?php


/**
 * @param array $params
 * SSL default behaviour:
 * Decided by current page.
 * Set parameter __ssl to true or false to override default ssl behaviour.
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_public_url($params = array(), &$smarty) {
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
        $ssl = \Skully\App\Helpers\UrlHelper::isSecure();
    }

    $arguments = array();
    foreach($params as $key => $val)
    {
        $arguments[$key] = $val;
    }

    /** @var \Skully\ApplicationInterface $app */
    $app = $smarty->getRegisteredObject('app');

    if(strpos($path, "http://") !== 0 && strpos($path, "https://") !== 0){
        $path = $app->getTheme()->getPublicBaseUrl($ssl).$path;
    }

    if (!empty($arguments)) {
        $argumentsStr = http_build_query($arguments);
        return $path.'?'.$argumentsStr;
    }
    else {
        return $path;
    }
}