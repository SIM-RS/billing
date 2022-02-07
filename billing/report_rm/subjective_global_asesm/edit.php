<?php
require_once '_functions.php';

$data = isset($_POST['surat']) ? $_POST['surat'] : array();
if(!empty($data)) {
	extract($data);
	
	$sql = "UPDATE lap_subjective_global_asesm
			SET 
			  tgl_act = NOW(),
			  skor_antropomerti_6 = '{$skor_antropomerti_6}',
			  skor_antropomerti_12 = '{$skor_antropomerti_12}',
			  skor_perubahan_intake_makan = '{$skor_perubahan_intake_makan}',
			  skor_perubahan_gastrointestinal = '{$skor_perubahan_gastrointestinal}',
			  skor_perubahan_kapasitas_fungsi = '{$skor_perubahan_kapasitas_fungsi}',
			  skor_penyakit_gizi = '{$skor_penyakit_gizi}',
			  skor_penilaian_fisik = '{$skor_penilaian_fisik}',
			  skor_total = '{$skor_total}',
			  bb = '{$bb}',
			  tb = '{$tb}',
			  imt = '{$imt}'
			WHERE pelayanan_id = '{$idPel}'";
	$ret = mysql_query($sql);echo mysql_error();
	if($ret) {
		header('Location: '.$BASE_URL.'&act=read');
	}
}

$surat = getSurat($idPel);
if($surat=== FALSE) {
	header('Location: '.$BASE_URL.'&act=create');
}

require_once '_form.php';

?>
