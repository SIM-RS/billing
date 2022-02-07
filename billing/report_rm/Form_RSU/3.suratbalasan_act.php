<?php
include("../../koneksi/konek.php");

$act = $_REQUEST['act'];

$kunjungan_id = $_REQUEST['kunjungan_id'];
$pelayanan_id = $_REQUEST['pelayanan_id'];
$idUsr = $_REQUEST['idUsr'];

$pemeriksaan = $_REQUEST['pemeriksaan'];
$terapi = $_REQUEST['terapi'];

if($act=='tambah')
{
	$q = "insert into lap_srt_balasan(kunjungan_id,pelayanan_id,user_act,tgl_act,pemeriksaan,terapi) values
	('$kunjungan_id','$pelayanan_id','$idUsr',NOW(),'$pemeriksaan','$terapi')";
	$s = mysql_query($q);
	//echo $q;
}	
else if($act=='edit')
{
	$id = $_REQUEST['id'];
	$q = "update lap_srt_balasan set user_act='$idUsr',tgl_act=NOW(), pemeriksaan='$pemeriksaan', terapi='$terapi' where id='$id'";
	$s = mysql_query($q);
	
}
else if($act=='hapus')
{
	$id = $_REQUEST['id'];
	$q = "delete from lap_srt_balasan where id='$id'";
	$s = mysql_query($q);
}
//==========================================

if($s)
{
	echo "sukses";
}
else
{
	echo "gagal";
}
?>