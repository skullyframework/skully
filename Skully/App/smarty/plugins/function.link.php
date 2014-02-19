<?php
/**
 * Created by Trio Design Team (jay@tgitriodesign.com).
 * Date: 7/20/13
 * Time: 5:56 PM
 * Description: link function in smarty
 */

function smarty_function_link($params = array(), &$smarty) {
	$href = '';
	if (!empty($params['href'])) {
		$href = $params['href'];
		unset($params['href']);
	}

	$text = '';
	if (!empty($params['text'])) {
		$href = $params['text'];
		unset($params['text']);
	}
	return '<a href="'.$href.'" target="_blank">'.$text.'</a>';
}