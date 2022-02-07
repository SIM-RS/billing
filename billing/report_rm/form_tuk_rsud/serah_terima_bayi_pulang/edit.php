<?php
require_once '_functions.php';

$data = isset($_POST['serahTerima']) ? $_POST['serahTerima'] : array();
if(!empty($data)) {
	extract($data);
	$alamat = $alamat1.'\r\n'.$alamat2;
	$penerima_alamat = $penerima_alamat1.'\r\n'.$penerima_alamat2;
	$sql = "UPDATE lap_serah_terima_bayi_pulang
			SET
			  nama_ibu = '{$nama_ibu}',
			  nama_ayah = '{$nama_ayah}',
			  alamat = '{$alamat}',
			  berat_badan = '{$berat_badan}',
			  panjang = '{$panjang}',
			  penerima_nama = '{$penerima_nama}',
			  penerima_alamat = '{$penerima_alamat}',
			  penerima_telepon = '{$penerima_telepon}',
			  penerima_kartu_identitas = '{$penerima_kartu_identitas}',
			  penerima_hubungan_keluarga = '{$penerima_hubungan_keluarga}',
			  saksi = '{$saksi}',
			  jam_kelahiran = '{$jam_kelahiran}'
			WHERE pelayanan_id = '{$idPel}'";
	$ret = mysql_query($sql);echo mysql_error();
	if($ret) {
		header('Location: '.$BASE_URL.'&act=read');
	}
}

$serahTerima = getSerahTerima($idPel, $idPsn);
if($serahTerima === FALSE) {
	header('Location: '.$BASE_URL.'&act=create');
}

require_once '_form.php';

?>
