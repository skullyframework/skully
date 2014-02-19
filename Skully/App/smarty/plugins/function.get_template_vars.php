<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 4/24/13
 * Time: 3:09 PM
 * Description: Get all assigned variables from template, to help designer coding a template.
 */
function smarty_function_get_template_vars($params = array(), &$smarty) {
	return '<pre>'.print_r(app()->currentController->smarty()->tpl_vars, true).'</pre>';
}