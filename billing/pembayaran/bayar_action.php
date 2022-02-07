<?php
include("../koneksi/konek.php");

$idbayar = ($_REQUEST['idbayar'] == '')?NULL:$_REQUEST['idbayar'];
$idKunj = $_REQUEST['idKunj'];
$idPel = ($_REQUEST['idPel'] == '')?NULL:$_REQUEST['idPel'];
$idUser = $_REQUEST['idUser'];
$idKasir = $_REQUEST['idKasir'];
$jnsKasir = $_REQUEST['jnsKasir'];
$total = $_REQUEST['total'];
$jaminan = $_REQUEST['jaminan'];
$action = $_REQUEST['action'];

switch($action):
	case 'getCount':
		if ($idbayar == '' && $idPel == '') { 
			/* KASIR RAWAT INAP PASIEN KSO */
			$sql = "SELECT MAX(count)+1 AS cetak_count FROM b_bayar_cetak WHERE kunjungan_id = '{$idKunj}' AND kasir_id = '{$idKasir}'";
		} else if ($idbayar == '' && $idPel != '') {
			/* KASIR RAWAT JALAN PASIEN KSO */
			$sql = "SELECT MAX(count)+1 AS cetak_count FROM b_bayar_cetak WHERE kunjungan_id = '{$idKunj}' AND pelayanan_id = '{$idPel}' AND kasir_id = '{$idKasir}'";
		} else {
			/* SEMUA KASIR PASIEN UMUM */
			$sql = "SELECT MAX(count)+1 AS cetak_count FROM b_bayar_cetak WHERE bayar_id = '{$idbayar}' AND kasir_id = '{$idKasir}'";
		}
		$query = mysql_query($sql);
		$rows = mysql_fetch_array($query);
		$sInsCount = "INSERT INTO b_bayar_cetak (bayar_id, kunjungan_id, pelayanan_id, kasir_id, jenis_kasir, total, jaminan_kso, tg_act, user_act, count)
						VALUES ('{$idbayar}', '{$idKunj}', '{$idPel}', '{$idKasir}', '{$jnsKasir}', '{$total}', '{$jaminan}', NOW(), '{$idUser}', '".$rows['cetak_count']."')";
		mysql_query($sInsCount) or die (mysql_error());
	break;
	
	case 'getLimit':
		$sql = "SELECT DATEDIFF(DATE(NOW()),DATE(tgl_act)) AS limitbayar FROM b_bayar WHERE id = '{$idbayar}'";
		$query = mysql_query($sql);
		$rows = mysql_fetch_array($query) or die (mysql_error());
		echo $rows['limitbayar'];
	break;
endswitch;

?>