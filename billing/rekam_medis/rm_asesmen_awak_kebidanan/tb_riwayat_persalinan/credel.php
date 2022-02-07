<?php 

include '../../../koneksi/konek.php';
include '../../function/form.php';
date_default_timezone_set("Asia/Jakarta");

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = {$_REQUEST['id_kunjungan']}"));

$data = [
	'id_pasien' => $sql['pasien_id'],
	'tgl_persalinan' => mysql_real_escape_string($_REQUEST['tgl_persalinan']),
	'tempat' => mysql_real_escape_string($_REQUEST['tempat']),
	'usia_kehamilan' => mysql_real_escape_string($_REQUEST['usia_kehamilan']),
	'jenis_persalinan' => mysql_real_escape_string($_REQUEST['jenis_persalinan']),
	'penolong' => mysql_real_escape_string($_REQUEST['penolong']),
	'penyulit' => mysql_real_escape_string($_REQUEST['penyulit']),
	'jk' => mysql_real_escape_string($_REQUEST['jk']),
	'bb' => mysql_real_escape_string($_REQUEST['bb']),
	'keadaan' => mysql_real_escape_string($_REQUEST['keadaan']),
	'tgl_act'=> date('Y-m-d H:i:s'),
];

if (isset($_REQUEST['id'])) {
	update('tb_riwayat_persalinan', $_REQUEST['id'], $data);
	alertMessage("Berhasil mengedit tabel!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} elseif (isset($_REQUEST['delete'])) { 
	mysql_query("DELETE FROM tb_riwayat_persalinan WHERE id = {$_REQUEST['delete']}");
	alertMessage("Berhasil menghapus data!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} else {
	$hasil = save($data,'tb_riwayat_persalinan');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}