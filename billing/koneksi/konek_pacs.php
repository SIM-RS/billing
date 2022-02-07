<?php
$username="muflih";
$password="muflih_test";
$database="192.10.10.114:1521/siakdb"; 
$koneksi=oci_connect($username,$password,$database);

/*define ('DB_USER','muflih');
define ('DB_PASS','muflih_test');
define ('DB_HOST', '192.10.10.114');
define ('DB_NAME', 'siakdb');
define ('CONST_DB_CHARSET_FOR_CONNECT','WE8ISO8859P15');
define ('DB_CONNECTION_STRING','\\192.10.10.114:1521/siakdb');//in localhost use ''
*/

//$koneksi = oci_connect(DB_USER, DB_PASS,DB_CONNECTION_STRING,CONST_DB_CHARSET_FOR_CONNECT);


if(!$koneksi){
	$e = oci_error();
	print htmlentities($e['message']);
    //trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	//echo "tidak bisa konek";	
}
?>