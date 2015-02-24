<?php
use Skully\App\Helpers\Csrf as C;

/**
 * @param array $params
 * @param $content string
 * @param &$smarty Smarty
 * @param &$repeat boolean
 * @return string
 *
 */
function smarty_block_form($params, $content, &$smarty, &$repeat) {
    if (!$repeat) {
        $paramsStr = '';
        $defaultParams = array(
            'method' => 'POST'
        );
        if (!empty($params)) {
            $params = array_merge($defaultParams, $params);
        }
        else {
            $params = $defaultParams;
        }
        foreach ($params as $key => $param) {
            $paramsStr .= $key.'="'.$param.'" ';
        }

        /** @var \Skully\ApplicationInterface $app */
        $app = $smarty->getRegisteredObject('app');
        if($app->config("csrf")) {
            $token_id = C::get_token_id();
            $token_value = C::get_token($token_id);
            $form = "<form " . $paramsStr . ">\n";
            $form .= "<input type='hidden' name='" . $token_id . "' value='" . $token_value . "' />\n";
            $form .= $content . "\n</form>";
        }
        else {
            $form = "<form " . $paramsStr . ">\n" . $content . "\n</form>";
        }

        return $form;
    }
}