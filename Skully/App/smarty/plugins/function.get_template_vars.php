<?php

function smarty_function_get_template_vars($params = array(), &$smarty) {
	return '<pre>'.print_r(app()->currentController->smarty()->tpl_vars, true).'</pre>';
}