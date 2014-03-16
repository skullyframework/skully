<?php


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