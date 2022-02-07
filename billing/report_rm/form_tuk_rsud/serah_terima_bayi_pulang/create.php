<?php

$data = isset($_POST['serahTerima']) ? $_POST['serahTerima'] : array();
if(!empty($data)) {
	extract($data);
	$alamat = $alamat1.'\r\n'.$alamat2;
	$penerima_alamat = $penerima_alamat1.'\r\n'.$penerima_alamat2;
	echo $sql = "INSERT INTO lap_serah_terima_bayi_pulang (
			  kunjungan_id,
			  pelayanan_id,
			  user_id,
			  nama_ibu,
			  nama_ayah,
			  alamat,
			  berat_badan,
			  panjang,
			  penerima_nama,
			  penerima_alamat,
			  penerima_telepon,
			  penerima_kartu_identitas,
			  penerima_hubungan_keluarga,
			  saksi
			) 
			VALUES(
			  {$idKunj},
			  {$idPel},
			  {$idUsr},
			  '{$nama_ibu}',
			  '{$nama_ayah}',
			  '{$alamat}',
			  {$berat_badan},
			  {$panjang},
			  '{$penerima_nama}',
			  '{$penerima_alamat}',
			  '{$penerima_telepon}',
			  '{$penerima_kartu_identitas}',
			  '{$penerima_hubungan_keluarga}',
			  '{$saksi}'
			)";
	$ret = mysql_query($sql);echo mysql_error();
	if($ret) {
		header('Location: '.$BASE_URL.'&act=read');
	}
}

$serahTerima = array();

require_once '_form.php';

?>

