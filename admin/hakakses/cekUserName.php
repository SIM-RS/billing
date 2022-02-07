<?php
include '../inc/koneksi.php';

$username=$_REQUEST['username'];
$cek="select * from pegawai where USER_NAME='$username'";
$kueri=mysql_query($cek);
$ada='';
if(mysql_num_rows($kueri)>0){
	$ada='1';
}
else{
	$ada='0';
}

echo $ada;
?>