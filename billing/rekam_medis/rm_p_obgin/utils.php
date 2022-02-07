<?php
include '../../koneksi/konek.php';
include '../function/form.php';
date_default_timezone_set("Asia/Jakarta");

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = {$_REQUEST['id_kunjungan']}"));

$data = [
	'id_pasien' => $sql['pasien_id'],
	'id_kunjungan'=>mysql_real_escape_string($_REQUEST['id_kunjungan']),
	'id_pelayanan'=>mysql_real_escape_string($_REQUEST['id_pelayanan']),
	'alergi_terhadap'=>mysql_real_escape_string($_REQUEST['alergi_terhadap_keterangan']),
	'keluhan_utama'=>mysql_real_escape_string($_REQUEST['keluhan_utama']),
	'riwayat_penyakit_sekarang' => mysql_real_escape_string($_REQUEST['riwayat_penyakit_sekarang']),
	'riwayat_menstruasi' => mysql_real_escape_string($_REQUEST['umur_menstruasi']) ."|" . mysql_real_escape_string($_REQUEST['siklus']) . "|" . mysql_real_escape_string($_REQUEST['teratur_siklus']) . "|" . mysql_real_escape_string($_REQUEST['lama_menstruasi']) . "|" . mysql_real_escape_string($_REQUEST['volume_menstruasi']) . "|" . mysql_real_escape_string($_REQUEST['keluhan_haid']),
	'riwayat_perkawinan' => mysql_real_escape_string($_REQUEST['status_kawin']) ."|" . mysql_real_escape_string($_REQUEST['umur_kawin']),
	'riwayat_pemakaian_alat_kontrasepsi' => mysql_real_escape_string($_REQUEST['riwayat_pemakaian_kontrasepsi']) ."|" . mysql_real_escape_string($_REQUEST['jenis_kontrasepsi']) ."|" . mysql_real_escape_string($_REQUEST['lama_pemakaian']),
	'riwayat_hamil_ini' => mysql_real_escape_string($_REQUEST['hari_pertama_terakhir']) ."|" . mysql_real_escape_string($_REQUEST['tafsiran_partus']) ."|" . mysql_real_escape_string($_REQUEST['ante_natal_care']) ."|" . mysql_real_escape_string($_REQUEST['frekuensi']) ."|" . mysql_real_escape_string($_REQUEST['imunisasi_tt']) ."|" . mysql_real_escape_string($_REQUEST['keluhan_hamil']),
	'riwayat_penyakit_yang_lalu' => mysql_real_escape_string($_REQUEST['riwayat_penyakit_lalu']) ."|" . mysql_real_escape_string($_REQUEST['pernah_dirawat']) ."|" . mysql_real_escape_string($_REQUEST['alasan_dirawat']) ."|" . mysql_real_escape_string($_REQUEST['tanggal_dirawat']) ."|" . mysql_real_escape_string($_REQUEST['pernah_dioperasi']) ."|" . mysql_real_escape_string($_REQUEST['jenis_operasi']) ."|" . mysql_real_escape_string($_REQUEST['tanggal_operasi']) ."|" . mysql_real_escape_string($_REQUEST['di_operasi']),
	'riwayat_penyakit_keluarga' => mysql_real_escape_string($_REQUEST['riwayat_penyakit_keluaraga']),
	'riwayat_penyakit_gynekologi' => mysql_real_escape_string($_REQUEST['penyakit_gykenologi']),
	'kesadaran' => mysql_real_escape_string($_REQUEST['kesadaran']),
	'tinggi_badan' => mysql_real_escape_string($_REQUEST['tinggi_badan']),
	'berat_badan' => mysql_real_escape_string($_REQUEST['berat_badan']),
	'tensi' => "null",
	'suhu' => mysql_real_escape_string($_REQUEST['suhu']),
	'nadi' => mysql_real_escape_string($_REQUEST['nadi']),
	'td' => mysql_real_escape_string($_REQUEST['td']),
	'pernapasan' => mysql_real_escape_string($_REQUEST['pernapasan']),
	'mata' => mysql_real_escape_string($_REQUEST['mata_konjuctiva']) ."|" . mysql_real_escape_string($_REQUEST['mata_sclera']),
	'leher' => mysql_real_escape_string($_REQUEST['leher_tyroid']),
	'dada' => mysql_real_escape_string($_REQUEST['jantung']),
	'paru' => mysql_real_escape_string($_REQUEST['paru']),
	'mamae' => mysql_real_escape_string($_REQUEST['bentuk_mamae']) ."|" . mysql_real_escape_string($_REQUEST['mamae_2']) ."|" . mysql_real_escape_string($_REQUEST['mamae_pengeluaran']) ."|" . mysql_real_escape_string($_REQUEST['mamae_kebersihan']) ."|" . mysql_real_escape_string($_REQUEST['kelainan_mamae']),
	'extermitas' => mysql_real_escape_string($_REQUEST['exter_tungkai']) ."|" . mysql_real_escape_string($_REQUEST['refleks_exter']) ."|" . mysql_real_escape_string($_REQUEST['edema']),
	'inspeksi' => mysql_real_escape_string($_REQUEST['luka_operasi']) ."|" . mysql_real_escape_string($_REQUEST['area_pembesaran']) ."|" . mysql_real_escape_string($_REQUEST['kelainan_abdomen']),
	'palpasi' => mysql_real_escape_string($_REQUEST['tinggi_fundus']) ."|" . mysql_real_escape_string($_REQUEST['punggung_letak']) ."|" . mysql_real_escape_string($_REQUEST['persentasi']) ."|" . mysql_real_escape_string($_REQUEST['bagian_terendah']) ."|" . mysql_real_escape_string($_REQUEST['osborn_test']) ."|" . mysql_real_escape_string($_REQUEST['konstraksi_uterus']) ."|" . mysql_real_escape_string($_REQUEST['his']) ."|" . mysql_real_escape_string($_REQUEST['lama_palpasi']) ."|" . mysql_real_escape_string($_REQUEST['kelainan_palpasi']) ."|" . mysql_real_escape_string($_REQUEST['teraba_massa']) ."|" . mysql_real_escape_string($_REQUEST['ukuran_palpasi']) ."|" . mysql_real_escape_string($_REQUEST['taksiran_berat']),
	'auskultasi' => mysql_real_escape_string($_REQUEST['bising_usus']) ."|" . mysql_real_escape_string($_REQUEST['aukultasi_djj']) ."|" . mysql_real_escape_string($_REQUEST['aukultasi_teratur']),
	'inspeksi_anogenital' => mysql_real_escape_string($_REQUEST['pengeluaran_pervaginam']) ."|" . mysql_real_escape_string($_REQUEST['lochea']) ."|" . mysql_real_escape_string($_REQUEST['volume_anogenital']) ."|" . mysql_real_escape_string($_REQUEST['berbau_anogenital']) ."|" . mysql_real_escape_string($_REQUEST['perinium']) ."|" . mysql_real_escape_string($_REQUEST['derajat_anogenital']) ."|" . mysql_real_escape_string($_REQUEST['jahitan_anogenital']) ."|" . mysql_real_escape_string($_REQUEST['kelainan_inspekulo']) ."|" . mysql_real_escape_string($_REQUEST['hymen_inspekulo']) ."|" . mysql_real_escape_string($_REQUEST['portio']) ."|" . mysql_real_escape_string($_REQUEST['toucher_oleh']) ."|" . mysql_real_escape_string($_REQUEST['toucher_tgl']) ."|" . mysql_real_escape_string($_REQUEST['toucher_jam']) ."|" . mysql_real_escape_string($_REQUEST['pembukaan']) ."|" . mysql_real_escape_string($_REQUEST['effactment']) ."|" . mysql_real_escape_string($_REQUEST['terbawah']) ."|" . mysql_real_escape_string($_REQUEST['cervix']) ."|" . mysql_real_escape_string($_REQUEST['panggul_promont']) ."|" . mysql_real_escape_string($_REQUEST['linea_innom']) ."|" . mysql_real_escape_string($_REQUEST['sacrum']) ."|" . mysql_real_escape_string($_REQUEST['spin']) ."|" . mysql_real_escape_string($_REQUEST['kesan_panggul']),
	'usg' => mysql_real_escape_string($_REQUEST['usg']),
	'laboratorium' => mysql_real_escape_string($_REQUEST['labotarium']),
	'terapi_tindakan' => mysql_real_escape_string($_REQUEST['terapi']),
	'rencana_kerja' => mysql_real_escape_string($_REQUEST['rencana_kerja']),
	'jam_keluar' => 'null',
	'tanggal' => mysql_real_escape_string($_REQUEST['tanggal']),
	'kontrol_poliklinik' => mysql_real_escape_string($_REQUEST['kontrol']),
	'dirawat_ruang' => mysql_real_escape_string($_REQUEST['rawat_ruang']),
	'kelas' => mysql_real_escape_string($_REQUEST['kelas']),	
	'anamnesa'=>mysql_real_escape_string($_REQUEST['anamnesa']),
	'tanggal_anamnesa'=>mysql_real_escape_string($_REQUEST['tanggal_anamnesa']),
	'jam_anamnesa'=>mysql_real_escape_string($_REQUEST['jam_anamnesa']),
	'petugas_anamnesa'=>$_REQUEST['cmbDokSemua'],
	'tanggal_act'=>date('Y-m-d H:i:s'),
];

if (isset($_REQUEST['id'])) {
	update('rm_2_4_p_obgin', $_REQUEST['id'], $data);
	alertMessage("Berhasil mengedit rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
} else {
	$hasil = save($data,'rm_2_4_p_obgin');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data rekam medis!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data rekam medis! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}

?>