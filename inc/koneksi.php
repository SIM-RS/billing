<?php
	include_once 'global.inc';
    global $rspelindo_server;
	global $rspelindo_username;
	global $rspelindo_password;
	global $rspelindo_database_name;
	
	global $rspelindo_db_billing;
	global $rspelindo_db_apotek;
	global $rspelindo_db_bank_darah;
	global $rspelindo_db_askep;
	global $rspelindo_db_akuntansi;
	global $rspelindo_db_keuangan;
	global $rspelindo_db_gizi;
	global $rspelindo_db_aset;
	global $rspelindo_db_cssd;
	global $rspelindo_db_master;
	
	$conn = mysql_connect($rspelindo_server,$rspelindo_username,$rspelindo_password) or die ("Username or Password require to open databases is not valid");
	mysql_select_db($rspelindo_database_name,$conn) or die ("Databases ".$rspelindo_database_name." was not found");


if(!function_exists('baseUrl')){
	function baseUrl(){
	  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
	  //return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	  return $protocol . "://" . $_SERVER['HTTP_HOST'] . '/' . 'simrs-pelindo';
	}
}
?>