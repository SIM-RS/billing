<?php
	session_start();
	include_once('../koneksi/konek.php');
	//$idunit = $_REQUEST['idunit'];
	//$no_jual = $_REQUEST['no_jual'];
	// $av_registry_id = $_REQUEST['av_registry_id'];
	$no_pasien = $_REQUEST['no_pasien'];
	$no_pelayanan = $_REQUEST['no_pelayanan'];
	$act = $_REQUEST['act'];
	$carabayar = $_REQUEST['carabayar'];
	
	$tgl_s = explode('-',$_REQUEST['tgl_s']);
	$tgl_s1 = $tgl_s[2].'-'.$tgl_s[1].'-'.$tgl_s[0];
	
	$tgl_d = explode('-',$_REQUEST['tgl_d']);
	$tgl_d1 = $tgl_d[2].'-'.$tgl_d[1].'-'.$tgl_d[0];
	
	switch($act){
		case 'cek':
			$sql = "SELECT 
					  DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') tgl_byr, 
					  ku.UNIT_ID, ku.USER_ID, ku.FK_NO_PENJUALAN,
					  IFNULL(ku.bayar, SUM(ku.BAYAR_UTANG)) bayar, 
					  IFNULL(ku.kembali,0) kembali, ku.NO_BAYAR
					FROM a_kredit_utang ku 
					INNER JOIN a_penjualan ap
					   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
					  AND ap.UNIT_ID = ku.UNIT_ID
					WHERE 
					 /*ku.FK_NO_PENJUALAN = '{$no_jual}'*/
					 /* AND ku.UNIT_ID = '{$idunit}'*/
					 /* AND ap.KSO_ID <> '88' */
					   ap.TGL_ACT BETWEEN '{$tgl_s1} 00:00:00' AND '{$tgl_d1} 23:59:59'
					  /* AND (ap.DIJAMIN = 0 OR ap.DIJAMIN = 1) */
					  AND ap.NO_PASIEN='{$no_pasien}'
					  AND ku.STATUS = 0";
			// AND ap.AV_REGISTRY_ID='$av_registry_id'
			$query = mysqli_query($konek,$sql);
			$data = mysqli_fetch_array($query);
			if(mysqli_errno($konek)<=0){
				if($data['tgl_byr']!=''){
					$hasil = "ada";
				} else {
					$hasil = "kosong";
				}
			} else {
				$hasil = "gagal|".mysqli_error($konek);
			}
			break;
	}
	
	//echo $sql;
	echo $hasil;
?>