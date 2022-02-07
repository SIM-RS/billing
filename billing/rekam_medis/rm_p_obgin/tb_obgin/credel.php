<?php 

include '../../../koneksi/konek.php';
include '../../function/form.php';
date_default_timezone_set("Asia/Jakarta");

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = {$_REQUEST['id_kunjungan']}"));

$data = [
	'id_pasien' => $sql['pasien_id'],
	'tgl_partus' => mysql_real_escape_string($_REQUEST['tgl_partus']),
	'abortus' => mysql_real_escape_string($_REQUEST['abortus']),
	'prematur' => mysql_real_escape_string($_REQUEST['prematur']),
	'aterm' => mysql_real_escape_string($_REQUEST['aterm']),
	'jenis_partus' => mysql_real_escape_string($_REQUEST['jenis_partus']),
	'nakes' => mysql_real_escape_string($_REQUEST['nakes']),
	'non' => mysql_real_escape_string($_REQUEST['non']),
	'jk' => mysql_real_escape_string($_REQUEST['jk']),
	'bbl' => mysql_real_escape_string($_REQUEST['bbl']),
	'normal' => mysql_real_escape_string($_REQUEST['normal']),
	'cacat' => mysql_real_escape_string($_REQUEST['cacat']),
	'meninggal' => mysql_real_escape_string($_REQUEST['meninggal']),
	'ket' => mysql_real_escape_string($_REQUEST['keterangan']),
	'tgl_act'=> date('Y-m-d H:i:s'),
];

if (isset($_REQUEST['id'])) {
	update('tb_riwayat_kehamilan', $_REQUEST['id'], $data);
	alertMessage("Berhasil mengedit tabel!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} elseif (isset($_REQUEST['delete'])) { 
	mysql_query("DELETE FROM tb_riwayat_kehamilan WHERE id = {$_REQUEST['delete']}");
	alertMessage("Berhasil menghapus data!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);

} else {
	$hasil = save($data,'tb_riwayat_kehamilan');
	if($hasil[0]){
		alertMessage("Berhasil memasukan data!","index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}else{
		alertMessage("Gagal memasukan data! " . $hasil[1],"index.php?idKunj=".$_REQUEST['id_kunjungan']."&idPel=".$_REQUEST['id_pelayanan']. "&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['id_user']."&tmpLay=".$_REQUEST['tmpLay']);
	}
}