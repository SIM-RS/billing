<?php
$username="siakdba";
$password="siakdba";
$database="localhost/orcl"; 
$koneksi=oci_connect($username,$password,$database);


if(!$koneksi){
	//echo "tidak bisa konek";	
}
?>