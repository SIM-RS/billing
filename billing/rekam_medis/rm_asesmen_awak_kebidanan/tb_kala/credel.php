<?php 

include '../../../koneksi/konek.php';
include '../../function/form.php';
date_default_timezone_set("Asia/Jakarta");

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = {$_REQUEST['id_kunjungan']}"));

$data = [
	'id_pasien' => $sql['pasien_id'],
	'jam' => mysql_real_escape_string($_REQUEST['jam']),
	'tensi' => mysql_real_escape_string($_REQUEST['tensi']),
	'nadi' => mysql_real_escape_string($_REQUEST['nadi']),
	'suhu' => mysql_real_escape_string($_REQUEST['suhu']),
	'rr' => mysql_real_escape_string($_REQUEST['rr']),
	'tfu' => mysql_real_escape_string($_REQUEST['tfu']),
	'konstraksi' => mysql_real_escape_string($_REQUEST['konstraksi']),
	'pendarahan' => mysql_real_escape_string($_REQUEST['pendarahan']),
	'tipe' => mysql_real_escape_string($_REQUEST['tipe']),
	'tgl_act'=> date('Y-m-d H:i:s'),
];

if (isset($_REQUEST['id'])) {
	update('tb_kala', $_REQUEST['id'], $data);
	alertMessage("Berhasil mengedit tabel!",$_REQUEST['domain']."?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} elseif (isset($_REQUEST['delete'])) { 
	mysql_query("DELETE FROM tb_kala WHERE id = {$_REQUEST['delete']}");
	alertMessage("Berhasil menghapus data!",$_REQUEST['domain']."?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['idPel']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']);

} else {
	$hasil = save($data,'tb_kala');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data!",$_REQUEST['domain']."?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}