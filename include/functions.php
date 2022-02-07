<?php

if(!function_exists('getUrl')) {
	function getUrl($path = '') {
		$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
		$baseurl = $protocol . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']).'/';

		return $baseurl.$path;
	}
}

?>