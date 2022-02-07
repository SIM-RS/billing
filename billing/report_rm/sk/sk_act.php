<?php
include("../../koneksi/konek.php");

$act = $_REQUEST['act_mati'];
$id_pelayanan = $_REQUEST['id_plynn_mati'];
$id_kunjungan = $_REQUEST['id_knjngn_mati'];
$tgl_mati = tglSQL($_REQUEST['sk_tgl_mati']);
$jam_mati = $_REQUEST['sk_jam_mati'];
$tgl_periksa = tglSQL($_REQUEST['sk_tgl_periksa']);
$user_act = $_REQUEST['idUsr_mati'];

if($act=='tambah')
{
	$q = "insert into b_ms_sk(id_pelayanan,id_kunjungan,tgl_mati,jam_mati,tgl_periksa,user_act) values('$id_pelayanan','$id_kunjungan','$tgl_mati','$jam_mati','$tgl_periksa','$user_act')";
	$s = mysql_query($q);
	//echo $q;
}	
else if($act=='edit')
{
	$id = $_REQUEST['id_mati'];
	$q = "update b_ms_sk set tgl_mati='$tgl_mati',jam_mati='$jam_mati',tgl_periksa='$tgl_periksa' where id='$id'";
	$s = mysql_query($q);
	
}
else if($act=='hapus')
{
	$id = $_REQUEST['id_mati'];
	$q = "delete from b_ms_sk where id='$id'";
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
