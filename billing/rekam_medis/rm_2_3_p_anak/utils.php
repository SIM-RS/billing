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
	'riwayat_penyakit_dahulu'=>mysql_real_escape_string($_REQUEST['riwayat_penyakit_dahulu']),
	'tanggal_anamnesa'=>$tanggal_anamnesa,
	'riwayat_pengobatan'=>mysql_real_escape_string($_REQUEST['riwayat_pengobatan']),
	'riwayat_penyakit_keluarga'=>$penyakitKeluarga .'|'. (mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluarga_ll']) != '' ? mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluarga_ll']) : ''),
	'tinggi_badan'=>mysql_real_escape_string($_REQUEST['tinggi_badan']),
	'lingkar_kepala'=>mysql_real_escape_string($_REQUEST['lk']),
	'tensi'=>mysql_real_escape_string($_REQUEST['tensi']),
	'temperatur'=>mysql_real_escape_string($_REQUEST['temperatur']),
	'nadi'=>mysql_real_escape_string($_REQUEST['nadi']),
	'pernapasan'=>mysql_real_escape_string($_REQUEST['pernapasan']),
	'riwayat_imunisasi'=>mysql_real_escape_string($_REQUEST['riwayat_imunisasi']),
	'riwayat_persalinan'=>mysql_real_escape_string($_REQUEST['riwayat_persalinan']) . "|" . mysql_real_escape_string($_REQUEST['ditolong_oleh'] . "|" . mysql_real_escape_string($_REQUEST['bb']) . "|" . mysql_real_escape_string($_REQUEST['pb']) . "|" . mysql_real_escape_string($_REQUEST['lk_rp']) . "|" . mysql_real_escape_string($_REQUEST['keadaan_saat_lahir'])),
	'riwayat_nutrisi'=>mysql_real_escape_string($_REQUEST['asi'] . "|" . mysql_real_escape_string($_REQUEST['susu_formula']) . "|" . mysql_real_escape_string($_REQUEST['bubur_susu']) . "|" . mysql_real_escape_string($_REQUEST['nasi_tim']) . "|" . mysql_real_escape_string($_REQUEST['makanan_dewasa'])),
	'riwayat_tumbuh_kembang'=>mysql_real_escape_string($_REQUEST['riwayat_tumbuh_kembang']),
	'kepala'=>mysql_real_escape_string($_REQUEST['kepala']),
	'mata'=>mysql_real_escape_string($_REQUEST['konjugtiva_pucat']) . "|" . mysql_real_escape_string($_REQUEST['hiperemi']) . "|" . mysql_real_escape_string($_REQUEST['sekret']) . "|" . mysql_real_escape_string($_REQUEST['sklera_ikterik']) . "|" . mysql_real_escape_string($_REQUEST['pupil_isokor']) . "|" . mysql_real_escape_string($_REQUEST['reflek_cahaya_oedema']),
	'tht'=>mysql_real_escape_string($_REQUEST['telinga']) . "|" . mysql_real_escape_string($_REQUEST['tenggorokan']) . "|" . mysql_real_escape_string($_REQUEST['lidah']) . "|" . mysql_real_escape_string($_REQUEST['bibir']) . "|" . mysql_real_escape_string($_REQUEST['faring']) . "|" . mysql_real_escape_string($_REQUEST['tonsil']) . "|" . mysql_real_escape_string($_REQUEST['hidung']),
	'leher'=>mysql_real_escape_string($_REQUEST['jvp']) . "|" . mysql_real_escape_string($_REQUEST['pembesaran_kelenjar']) . "|" . mysql_real_escape_string($_REQUEST['ukuran_kelenjar']),
	'thoraks'=>mysql_real_escape_string($_REQUEST['thoraks']),
	'cor'=>mysql_real_escape_string($_REQUEST['cor']),
	'abdomen'=>mysql_real_escape_string($_REQUEST['abdomen']),
	'pulmo'=>mysql_real_escape_string($_REQUEST['pulmo']),
	'hepar'=>mysql_real_escape_string($_REQUEST['hepar']),
	'lien'=>mysql_real_escape_string($_REQUEST['lien']),
	'massa'=>mysql_real_escape_string($_REQUEST['massa']),
	'ekstremitas'=>mysql_real_escape_string($_REQUEST['extermitas']),
	'kulit'=>mysql_real_escape_string($_REQUEST['kulit']),
	'genitalia_eksterna'=>mysql_real_escape_string($_REQUEST['genetalie_eksterna']),
	'diagnosa_kerja'=>mysql_real_escape_string($_REQUEST['diagnosa_kerja']),
	'anamnesa'=>mysql_real_escape_string($anamnesa),
	'diagnosa_differential'=>mysql_real_escape_string($_REQUEST['diagnosa_banding']),
	'jam_anamnesa'=>mysql_real_escape_string($_REQUEST['jam_anamnesa']),
	'rencana_kerja'=>mysql_real_escape_string($_REQUEST['rencana_kerja']),
	'jam_keluar'=>mysql_real_escape_string($_REQUEST['jam_keluar']),
	'kontrol_poliklinik'=>mysql_real_escape_string($_REQUEST['kontrol_poliklinik']),
	'dirawat_ruang'=>mysql_real_escape_string($_REQUEST['ruangan']) . "|" . mysql_real_escape_string($_REQUEST['konsul']) . "|" . mysql_real_escape_string($_REQUEST['devisi']),
	'petugas_anamnesa'=>$_REQUEST['cmbDokSemua'],
	'terapi_tindakan'=> mysql_real_escape_string($_REQUEST['terapi_tindakan']),
	'tanggal_act'=>date('Y-m-d H:i:s'),
];

if (isset($_REQUEST['id'])) {
	update('rm_2_3_p_anak', $_REQUEST['id'], $data);
	alertMessage("Berhasil mengedit rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
} else {
	$hasil = save($data,'rm_2_3_p_anak');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}

?>