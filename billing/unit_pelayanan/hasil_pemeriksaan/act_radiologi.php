<?php
include("../../koneksi/konek.php");

$act=$_REQUEST['act'];
$id=$_REQUEST['id'];

if ($act=='delete') {
	mysql_query("DELETE FROM b_hasil_rad WHERE tindakan_id='".$id."'");
}
?>