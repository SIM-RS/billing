<?php
	include('../koneksi/konek.php');
	//act=dijaminUbah&idUser=499&userJual=499&no_penjualan=000117&no_pasien=0116249&no_kunjungan=114&unit_id=100&tgl_act=2014-12-17
	$act = $_REQUEST['act'];
	$idUser = $_REQUEST['idUser'];
	$userJual = $_REQUEST['userJual'];
	$no_penjualan = $_REQUEST['no_penjualan'];
	$no_pasien = $_REQUEST['no_pasien'];
	$no_kunjungan = $_REQUEST['no_kunjungan'];
	$unit_id = $_REQUEST['unit_id'];
	$tgl_act = $_REQUEST['tgl_act'];
	$dijamin = $_REQUEST['dijamin'];
	
	$keter = 'tidak dijamin';
	if($dijamin == '1'){
		$keter = 'dijamin';
	}
	
	switch($act){
		case 'dijaminUbah':
			$sql = "UPDATE a_penjualan ap
						SET ap.DIJAMIN = '{$dijamin}',
							ap.USER_EDIT = '{$idUser}',
							ap.TGL_EDIT = NOW(),
							ap.TIPE_EDIT = 1
					WHERE ap.NO_KUNJUNGAN = '{$no_kunjungan}'
					  AND ap.NO_PASIEN = '{$no_pasien}'
					  AND ap.NO_PENJUALAN = '{$no_penjualan}'
					  AND ap.UNIT_ID = '{$unit_id}'
					  AND ap.USER_ID = '{$userJual}'
					  AND ap.TGL = '{$tgl_act}'";
			$query = mysqli_query($konek,$sql) or die ("gagal|Gagal, Data Tidak Dapat Dirubah!|".mysqli_error($konek));
			$warning = "sukses|Berhasil, Penjualan dengan NO {$no_penjualan} Status Dijaminnya telah berganti menjadi {$keter}!";
			break;
	}
	
	echo $warning;
?>