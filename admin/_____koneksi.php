<?php

$baseDir = dirname(__FILE__);

require $baseDir.'/../inc/koneksi.php';

 //    $server = "localhost";
	// $username = "root";
	// $password = "dbj3s1k4";
	// $database_name = "rspelindo_hcr";

	$conn = mysql_connect($server,$username,$password) or die ("Username or Password require to open databases is not valid");
	mysql_select_db($database_name,$conn) or die ("Databases ".$database_name." was not found");
?>