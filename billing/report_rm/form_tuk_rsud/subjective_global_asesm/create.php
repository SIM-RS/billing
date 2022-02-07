<?php

$data = isset($_POST['surat']) ? $_POST['surat'] : array();
if(!empty($data)) {
	extract($data);
	$alamat = $alamat1.'\r\n'.$alamat2;
	$penerima_alamat = $penerima_alamat1.'\r\n'.$penerima_alamat2;
	$sql = "INSERT INTO lap_subjective_global_asesm(
						 pelayanan_id,
						 kunjungan_id,
						 user_id,
						 tgl_act,
						 skor_antropomerti_6,
						 skor_antropomerti_12,
						 skor_perubahan_intake_makan,
						 skor_perubahan_gastrointestinal,
						 skor_perubahan_kapasitas_fungsi,
						 skor_penyakit_gizi,
						 skor_penilaian_fisik,
						 skor_total,
						 bb,
						 tb,
						 imt
			) VALUES (
					{$idPel},
					{$idKunj},
					{$idUsr},
					NOW(),
					'{$skor_antropomerti_6}',
					'{$skor_antropomerti_12}',
					'{$skor_perubahan_intake_makan}',
					'{$skor_perubahan_gastrointestinal}',
					'{$skor_perubahan_kapasitas_fungsi}',
					'{$skor_penyakit_gizi}',
					'{$skor_penilaian_fisik}',
					'{$skor_total}',
					'{$bb}',
					'{$tb}',
					'{$imt}'
			)";
	$ret = mysql_query($sql);echo mysql_error();
	if($ret) {
		header('Location: '.$BASE_URL);
	}
}

$serahTerima = array();

require_once '_form.php';

?>

