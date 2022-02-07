<?php
include("../../koneksi/konek.php");

$act = $_REQUEST['act'];

$kunjungan_id = $_REQUEST['kunjungan_id'];
$pelayanan_id = $_REQUEST['pelayanan_id'];

	$x='';
	for($x=0;$x<=2;$x++)
	{
		if($x==2){$z="";}else{$z=",";}
	$set_perawatan.=$_REQUEST["perawatan$x"].$z;
		
	}
	//echo $set_perawatan;
//$set_perawatan = $_REQUEST['set_perawatan'];
$w='';
	for($w=0;$w<=1;$w++)
	{
		if($w==1){$z1="";}else{$z1=",";}
	$set_infeksi.=$_REQUEST["infeksi$w"].$z1;
		
	}
//$set_infeksi = $_REQUEST['set_infeksi'];

$y='';
	for($y=0;$y<=1;$y++)
	{
		if($y==1){$z2="";}else{$z2=",";}
	$set_cito.=$_REQUEST["cito$y"].$z2;
		
	}
	echo $set_cito;
//$set_cito = $_REQUEST['set_cito'];
$diet = $_REQUEST['diet'];

$infus = $_REQUEST['infus'];

$obat = $_REQUEST['obat'];
$sedia_drh = $_REQUEST['sedia_drh'];
$konsul = $_REQUEST['konsul'];

$lain_lain = $_REQUEST['lain_lain'];
$pemeriksaan = $_REQUEST['pemeriksaan'];

$q='';
	for($q=0;$q<=7;$q++)
	{
		if($q==7){$z3="";}else{$z3=", ";}
	$set_ruangan.=$_REQUEST["ruangan$q"].$z3;
		
	}
//$set_ruangan = $_REQUEST['set_ruangan'];
$lain_lain_ket = $_REQUEST['lain_lain_ket'];
$id = $_REQUEST['id'];


if($act=='tambah')
{
	$q = "insert into lap_srt_pengantar(kunjungan_id,pelayanan_id,set_perawatan,set_infeksi,set_cito,diet,infus,obat,sedia_drh,konsul,lain_lain,pemeriksaan,set_ruangan,lain_lain_ket) values('$kunjungan_id','$pelayanan_id','$set_perawatan','$set_infeksi','$set_cito','$diet','$infus','$obat','$sedia_drh','$konsul','$lain_lain','$pemeriksaan','$set_ruangan','$lain_lain_ket')";
	$s = mysql_query($q);
	echo $q;
}	
else if($act=='edit')
{
	$id = $_REQUEST['id'];
	$q = "update lap_srt_pengantar set set_perawatan='$set_perawatan',set_infeksi='$set_infeksi',set_cito='$set_cito',diet='$diet',infus='$infus',obat='$obat',sedia_drh='$sedia_drh',konsul='$konsul',lain_lain='$lain_lain',pemeriksaan='$pemeriksaan',set_ruangan='$set_ruangan',lain_lain_ket='$lain_lain_ket' where id='$id'";
	$s = mysql_query($q);
	
}
else if($act=='hapus')
{
	$id = $_REQUEST['id'];
	$q = "delete from lap_srt_pengantar where id='$id'";
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