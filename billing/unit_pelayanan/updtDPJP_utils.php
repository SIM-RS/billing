<?php
include("../koneksi/konek.php");
//include("distribusiBiayaKsoPx.php");
//====================================================================
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$dpjp=$_REQUEST['dpjp'];
//===============================
$dt="ERROR"."|".$dpjp;
$act = $_REQUEST['act'];
switch(strtolower($act)) {
	case 'view':
		$sqlUp = "SELECT mp.id,mp.nama FROM b_pelayanan p INNER JOIN b_ms_pegawai mp ON p.dpjp=mp.id WHERE p.id='$idPel'";
		//echo $sqlUp.";<br>";
		$rsUp = mysql_query($sqlUp);
		if (mysql_num_rows($rsUp)>0){
			$rwUp = mysql_fetch_array($rsUp);
			$ndpjp = $rwUp["nama"];
			$dt="OK"."|".$ndpjp;
		}
		break;
	case 'update':
/*		$stInap="";
		if ($getInap=="1"){
			$stInap=", tgl_sjp_inap = '$TglSEP', no_sjp_inap = '$NoSEP'";
		}*/
		$sqlUp = "SELECT id,nama FROM b_ms_pegawai WHERE id='$dpjp'";
		//echo $sqlUp.";<br>";
		$rsUp = mysql_query($sqlUp);
		if (mysql_num_rows($rsUp)>0){
			$rwUp = mysql_fetch_array($rsUp);
			$ndpjp = $rwUp["nama"];
			$sqlUp = "UPDATE b_kunjungan SET dpjp = '$dpjp' WHERE id = $idKunj";
			//echo $sqlUp.";<br>";
			$rsUp = mysql_query($sqlUp);
			if (mysql_affected_rows()>0){
				$sqlUp = "UPDATE b_pelayanan SET dpjp = '$dpjp' WHERE id = $idPel";
				//echo $sqlUp.";<br>";
				$rsUp = mysql_query($sqlUp);
				if (mysql_affected_rows()>0){
					$dt="OK"."|".$ndpjp;
				}
			}
		}
		break;
}

mysql_close($konek);
echo $dt;
?>