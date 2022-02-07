<?php
include("../../koneksi/konek.php");

$act = $_REQUEST['act'];

$kunjungan_id = $_REQUEST['kunjungan_id'];
$pelayanan_id = $_REQUEST['pelayanan_id'];
$idUsr = $_REQUEST['idUsr'];

$keluhan = $_REQUEST['keluhan'];
$perjalanan = $_REQUEST['perjalanan'];
$penyakit_lain = $_REQUEST['penyakit_lain'];
$penyakit_dahulu = $_REQUEST['penyakit_dahulu'];
$keadaan_umum = $_REQUEST['keadaan_umum'];
$kesadaran = $_REQUEST['kesadaran'];
$bb = $_REQUEST['bb'];
$pernafasan = $_REQUEST['pernafasan'];
$suhu = $_REQUEST['suhu'];
$kepala = $_REQUEST['kepala'];
$mata = $_REQUEST['mata'];
$tht = $_REQUEST['tht'];
$gigi_mulut = $_REQUEST['gigi_mulut'];
$leher = $_REQUEST['leher'];
$paru_paru = $_REQUEST['paru_paru'];
$jantung = $_REQUEST['jantung'];
$abdomen = $_REQUEST['abdomen'];
$extremitas = $_REQUEST['extremitas'];
$diagnosis_kerja = $_REQUEST['diagnosis_kerja'];
$diagnosis_diff = $_REQUEST['diagnosis_diff'];
$pengobatan = $_REQUEST['pengobatan'];
$diit = $_REQUEST['diit'];
$lab = $_REQUEST['lab'];
$radiologi = $_REQUEST['radiologi'];
$ekg = $_REQUEST['ekg'];
$dll = $_REQUEST['dll'];

if($act=='tambah')
{
	$q = "insert into lap_riw_penyakit(kunjungan_id,pelayanan_id,keluhan,perjalanan,penyakit_lain,penyakit_dahulu,keadaan_umum,kesadaran,bb,pernafasan,suhu,kepala,mata,tht,gigi_mulut,leher,paru_paru,jantung,abdomen,extremitas,diagnosis_kerja,diagnosis_diff,pengobatan,diit,lab,radiologi,ekg,dll,user_act,tgl_act) values('$kunjungan_id','$pelayanan_id','$keluhan','$perjalanan','$penyakit_lain','$penyakit_dahulu','$keadaan_umum','$kesadaran','$bb','$pernafasan','$suhu','$kepala','$mata','$tht','$gigi_mulut','$leher','$paru_paru','$jantung','$abdomen','$extremitas','$diagnosis_kerja','$diagnosis_diff','$pengobatan','$diit','$lab','$radiologi','$ekg','$dll','$idUsr',NOW())";
	$s = mysql_query($q);
	//echo $q;
}	
else if($act=='edit')
{
	$id = $_REQUEST['id'];
	$q = "update lap_riw_penyakit set keluhan='$keluhan',perjalanan='$perjalanan',penyakit_lain='$penyakit_lain',penyakit_dahulu='$penyakit_dahulu',keadaan_umum='$keadaan_umum',kesadaran='$kesadaran',bb='$bb',pernafasan='$pernafasan',suhu='$suhu',kepala='$kepala',mata='$mata',tht='$tht',gigi_mulut='$gigi_mulut',leher='$leher',paru_paru='$paru_paru',jantung='$jantung',abdomen='$abdomen',extremitas='$extremitas',diagnosis_kerja='$diagnosis_kerja',diagnosis_diff='$diagnosis_diff',pengobatan='$pengobatan',diit='$diit',lab='$lab',radiologi='$radiologi',ekg='$ekg',dll='$dll',user_act='$idUsr',tgl_act=NOW() where id='$id'";
	$s = mysql_query($q);
	
}
else if($act=='hapus')
{
	$id = $_REQUEST['id'];
	$q = "delete from lap_riw_penyakit where id='$id'";
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