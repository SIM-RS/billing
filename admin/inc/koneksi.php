<?php

$baseDir = dirname(__FILE__);

require $baseDir.'/../../inc/koneksi.php';

	// include_once '../../inc/global.inc';
 //    global $server;
	// global $username;
	// global $password;
	// global $database_name;
	
	//$conn = mysql_connect($server,$username,$password) or die ("Username or Password require to open databases is not valid");
	mysql_select_db($rspelindo_database_name,$conn) or die ("Databases ".$rspelindo_database_name." was not found");
?>