<?php
include '../../koneksi/konek.php';
include '../function/form.php';
date_default_timezone_set("Asia/Jakarta");

// var_dump($_REQUEST);

$kepala = 'Kepala|' . $_REQUEST['kepala'] . ' ' . $_REQUEST['kepala_ket'] . '||';
$mata = 'Mata|' . $_REQUEST['mata'] . ' ' . $_REQUEST['mata_ket'] . '||';
$tht = 'THT|' . $_REQUEST['tht'] . ' ' . $_REQUEST['tht_ket'] . '||';
$leher = 'Leher|' . $_REQUEST['leher'] . ' ' . $_REQUEST['leher_ket'] . '||';
$dada = 'Dada|' . $_REQUEST['dada'] . ' ' . $_REQUEST['dada_ket'] . '||';
$jantung = 'Jantung|' . $_REQUEST['jantung'] . ' ' . $_REQUEST['jantung_ket'] . '||';
$paru = 'Paru|' . $_REQUEST['paru'] . ' ' . $_REQUEST['paru_ket'] . '||';
$perut = 'Perut|' . $_REQUEST['perut'] . ' ' . $_REQUEST['perut_ket'] . '||';
$hepar = 'Hepar|' . $_REQUEST['hepar'] . ' ' . $_REQUEST['hepar_ket'] . '||';
$lien = 'Lien|' . $_REQUEST['lien'] . ' ' . $_REQUEST['lien_ket'] . '||';
$punggung = 'Punggung|' . $_REQUEST['punggung'] . ' ' . $_REQUEST['punggung_ket'] . '||';
$genital = 'Genital|' . $_REQUEST['genital'] . ' ' . $_REQUEST['genital_ket'] . '||';
$ekstremitas = 'Ekstremitas|' . $_REQUEST['ekstremitas'] . ' ' . $_REQUEST['ekstremitas_ket'] . '||';
$rectal_toucher = 'Rectal Toucher|' . $_REQUEST['rectal_toucher'] . ' ' . $_REQUEST['rectal_toucher_ket'];


$pemeriksaan_fisik = $kepala . $mata . $tht . $leher . $dada . $jantung . $paru . $perut . $hepar . $lien . $punggung . $genital . $ekstremitas . $rectal_toucher;

$anamnesa = mysql_real_escape_string($_REQUEST['anamnesa']);
$tanggal_anamnesa = mysql_real_escape_string($_REQUEST['tanggal_anamnesa']);
$keluhan_utama = mysql_real_escape_string($_REQUEST['keluhan_utama']);

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = {$_REQUEST['id_kunjungan']}"));

$penyakitKeluarga = "";
for($i = 0; $i < sizeof($_REQUEST['riwayat_penyakit_keluarga']); $i++){
	$penyakitKeluarga .= $_REQUEST['riwayat_penyakit_keluarga'][$i] . '|';
}
$penyakitKeluarga = substr($penyakitKeluarga, 0,-1);

$penyakit = selectedMultipleData($_REQUEST['riwayat_penyakit']);

$data = [
	'id_pasien' => $sql['pasien_id'],
	'id_kunjungan'=>mysql_real_escape_string($_REQUEST['id_kunjungan']),
	'id_pelayanan'=>mysql_real_escape_string($_REQUEST['id_pelayanan']),
	'alergi_terhadap'=>mysql_real_escape_string($_REQUEST['alergi_terhadap_keterangan']),
	'keluhan_utama'=>mysql_real_escape_string($_REQUEST['keluhan_utama']),
	'riwayat_penyakit_sekarang'=>mysql_real_escape_string($_REQUEST['riwayat_penyakit_sekarang']),
	'riwayat_penyakit_dahulu'=>mysql_real_escape_string($_REQUEST['riwayat_penyakit_dahulu']),
	'riwayat_pengobatan'=>mysql_real_escape_string($_REQUEST['riwayat_pengobatan']),
	'riwayat_penyakit_keluarga'=>$penyakitKeluarga .'|'. (mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluarga_ll']) != '' ? mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluarga_ll']) : ''),
	'riwayat_pekerjaan'=>mysql_real_escape_string($_REQUEST['riwayat_pekerjaan']),
	'keadaan_umum'=>mysql_real_escape_string($_REQUEST['keadaan_umum']),
	'gizi'=>mysql_real_escape_string($_REQUEST['gizi']),
	'gcs'=>mysql_real_escape_string($_REQUEST['gcs']),
	'tindakan_resusitasi'=>mysql_real_escape_string($_REQUEST['tindakan_resusitasi']),
	'berat_badan'=>mysql_real_escape_string($_REQUEST['berat_badan']),
	'tinggi_badan'=>mysql_real_escape_string($_REQUEST['tinggi_badan']),
	'tensi'=>mysql_real_escape_string($_REQUEST['tensi']),
	'suhu'=>mysql_real_escape_string($_REQUEST['suhu']) . '|' . mysql_real_escape_string($_REQUEST['rectal']),
	'nadi'=>mysql_real_escape_string($_REQUEST['nadi']),
	'respirasi'=>mysql_real_escape_string($_REQUEST['respirasi']),
	'saturasi'=>mysql_real_escape_string($_REQUEST['saturasi']),
	'saturasi_pada'=>mysql_real_escape_string($_REQUEST['saturasi_pada']),
	'riwayat_penyakit'=>mysql_real_escape_string($penyakit) . '|' .(mysql_real_escape_string($_REQUEST['riwayat_penyakit_ll']) != '' ? mysql_real_escape_string($_REQUEST['riwayat_penyakit_ll']) : ''),
	'riwayat_operasi'=>mysql_real_escape_string($_REQUEST['riwayat_operasi']) . '|' . mysql_real_escape_string($_REQUEST['riwayat_operasi_keterangan']),
	'riwayat_transfusi'=>mysql_real_escape_string($_REQUEST['riwayat_transfusi']),
	'reaksi_transfusi'=>mysql_real_escape_string($_REQUEST['reaksi_transfusi']),
	'pemeriksaan_fisik'=>mysql_real_escape_string($pemeriksaan_fisik),
	'status_lokasi'=>mysql_real_escape_string($_REQUEST['status_lokalis']),
	'skema'=>mysql_real_escape_string($_REQUEST['skema']),
	'pemeriksaan_penunjang'=>mysql_real_escape_string($_REQUEST['pemeriksaan_penunjang']),
	'diagnosa_kerja'=>mysql_real_escape_string($_REQUEST['diagnosa_kerja']),
	'diagnosa_differential'=>mysql_real_escape_string($_REQUEST['diagnosa_differential']),
	'terapi_tindakan'=>mysql_real_escape_string($_REQUEST['terapi_tindakan']),
	'rencana_kerja'=>mysql_real_escape_string($_REQUEST['rencana_kerja']),
	'saran'=>mysql_real_escape_string($_REQUEST['saran']),
	'catatan_penting'=>mysql_real_escape_string($_REQUEST['catatan_penting']),
	'anamnesa'=>mysql_real_escape_string($anamnesa),
	'tanggal_anamnesa'=>mysql_real_escape_string($_REQUEST['tanggal_anamnesa']),
	'jam_anamnesa'=>mysql_real_escape_string($_REQUEST['jam_anamnesa']),
	'petugas_anamnesa'=>$_REQUEST['cmbDokSemua'],
	'hasil_pembedahan'=> mysql_real_escape_string($_REQUEST['hasil_pembedahan']),
	'tanggal_act'=>date('Y-m-d H:i:s'),
];

if (isset($_REQUEST['id'])) {
	update('rm_2_7_p_bedah', $_REQUEST['id'], $data);
	alertMessage("Berhasil mengedit rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} else {
	$hasil = save($data,'rm_2_7_p_bedah');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}

?>