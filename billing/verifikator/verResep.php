<?php
	session_start();
	include('../koneksi/konek.php');
	$act = $_REQUEST['ver'];
	$noPenj = $_REQUEST['noPenj'];
	$idPelay = $_REQUEST['idPelay'];
	$tglPenj = $_REQUEST['tglPenj'];
	$cbayar = $_REQUEST['cbayar'];
	$val = $_REQUEST['val'];
	
	$set = "";
	switch ($act){
		case "true":
			$set = "ap.TGL = '".tglSQL($tglPenj)."',
				ap.TGL_ACT = CONCAT('".tglSQL($tglPenj)." ', DATE_FORMAT(ap.TGL_ACT,'%H:%m:%s')),
				ap.CARA_BAYAR = '{$cbayar}'";
		break;
		case "false":
			$set = "ap.VERIFIKASI = {$val},
				ap.VERIFIKASI_ACT = ".$_SESSION['userId'];
		break;
	}
	
	$sql = "UPDATE $dbapotek.a_penjualan ap
			SET 
				{$set}
			WHERE
				ap.NO_PENJUALAN = '".$noPenj."'
				AND ap.NO_KUNJUNGAN = '".$idPelay."'";
	$query = mysql_query($sql);
	
	if(mysql_affected_rows()>0){
		switch($act){
			case "true":
				echo "Data Penjualan Obat No. ".$_REQUEST['noPenj']," Berhasil Dirubah!";
			break;
			case "false":
				if($val == 1){
					echo "VERIFIKASI BERHASIL!";
				} else{
					echo "VERIFIKASI BATAL!";
				}
			break;
		}
	}
	
	//echo mysql_affected_rows();
?>