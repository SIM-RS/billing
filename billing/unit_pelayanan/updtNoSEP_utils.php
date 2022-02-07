<?php
include("../koneksi/konek.php");
//include("distribusiBiayaKsoPx.php");
//====================================================================
$idKunj=$_REQUEST['idKunj'];
$NoSEP=$_REQUEST['NoSEP'];
$TglSEP=$_REQUEST['TglSEP'];
$TglSEP=explode("-",$TglSEP);
$TglSEP=$TglSEP[2]."-".$TglSEP[1]."-".$TglSEP[0];
$getInap=$_REQUEST['inap'];
$user_act=$_REQUEST['user_act'];
//===============================
$dt="Proses Update Berhasil !"."|".$NoSEP;

switch(strtolower($_REQUEST['act'])) {
	case 'update':
		$stInap="";
		if ($getInap=="1"){
			$stInap=", tgl_sjp_inap = '$TglSEP', no_sjp_inap = '$NoSEP'";
		}
		$sqlUp = "UPDATE b_kunjungan SET tgl_sjp = '$TglSEP', no_sjp = '$NoSEP'".$stInap." WHERE id = $idKunj";
		//echo $sqlUp.";<br>";
		$rsUp = mysql_query($sqlUp);
		if (mysql_affected_rows()==0){
			$dt="Proses Update Gagal !"."|";
		}
		break;
}

mysql_close($konek);
echo $dt;
?>