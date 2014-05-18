<?php

function smarty_function_number_format($params = array(), &$smarty) {
	$number = $params["number"];
	$dec = isset($params["dec"]) ? $params["dec"] : 0;
	$point = isset($params["point"]) ? $params["point"] : ",";
	$sep = isset($params["sep"]) ? $params["sep"] : ".";
	return number_format($number * 1, $dec, $point, $sep);
}