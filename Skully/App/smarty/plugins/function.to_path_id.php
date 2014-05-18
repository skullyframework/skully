<?php

function smarty_function_to_path_id($params = array(), &$smarty) {
    $pathId = \App\Helpers\UrlHelper::toPathId($params['name'], $params['id']);
    return $pathId;
}