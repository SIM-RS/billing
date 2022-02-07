<?php
include '../../koneksi/konek.php';
include '../function/form.php';
date_default_timezone_set("Asia/Jakarta");

$anamnesa = mysql_real_escape_string($_REQUEST['anamnesa']);
$tanggal_anamnesa = mysql_real_escape_string($_REQUEST['tanggal_anamnesa']);
$keluhan_utama = mysql_real_escape_string($_REQUEST['keluhan_utama']);

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = {$_REQUEST['id_kunjungan']}"));

$penyakitKeluarga = "";
for($i = 0; $i < sizeof($_REQUEST['riwayat_penyakit_keluarga']); $i++){
	$penyakitKeluarga .= $_REQUEST['riwayat_penyakit_keluarga'][$i] . '|';
}
$penyakitKeluarga = substr($penyakitKeluarga, 0,-1);
$data = [
	'id_pasien' => $sql['pasien_id'],
	'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
	'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
	'alergi_terhadap' => mysql_real_escape_string($_REQUEST['alergi_terhadap_keterangan']),
    'keluhan_utama' => $keluhan_utama,
	'riwayat_penyakit_dahulu' => mysql_real_escape_string($_REQUEST['riwayat_penyakit_dahulu']),
	'riwayat_pengobatan' => mysql_real_escape_string($_REQUEST['riwayat_pengobatan']),
	'riwayat_penyakit_keluarga' => $penyakitKeluarga .'|'. (mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluarga_ll']) != '' ? mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluarga_ll']) : ''),
	'tinggi_badan' => mysql_real_escape_string($_REQUEST['tinggi_badan']),
	'tensi' => mysql_real_escape_string($_REQUEST['tensi']),
	'suhu' => mysql_real_escape_string($_REQUEST['suhu']) . '|' . mysql_real_escape_string($_REQUEST['rectal']),
	'kepala_leher' => mysql_real_escape_string($_REQUEST['kepala_leher']),
	'thoraks'=>mysql_real_escape_string($_REQUEST['thoraks']),
	'abdomen'=>mysql_real_escape_string($_REQUEST['abdomen']),
	'ekstermitas'=>mysql_real_escape_string($_REQUEST['ekstermitas']),
	'diagnosa_kerja'=>mysql_real_escape_string($_REQUEST['diagnosa_kerja']),
	'diagnosa_differential'=>mysql_real_escape_string($_REQUEST['diagnosa_differential']),
	'terapi_tindakan'=>mysql_real_escape_string($_REQUEST['terapi_tindakan']),
	'rencana_kerja'=>mysql_real_escape_string($_REQUEST['rencana_kerja']),
    'anamnesa' => $anamnesa,
    'tanggal_anamnesa' => $tanggal_anamnesa,
    'jam_anamnesa' => mysql_real_escape_string($_REQUEST['jam_anamnesa']),
    'tanggal_act' => date('Y-m-d H:i:s'),
    'petugas_anamnesa'=>mysql_real_escape_string($_REQUEST['cmbDokSemua']),
];

if (isset($_REQUEST['id'])) {
	update('rm_2_2_p_dalam', $_REQUEST['id'], $data);
	
	alertMessage("Berhasil mengedit rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} else {
	$hasil = save($data,'rm_2_2_p_dalam');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}

?>