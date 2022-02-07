<?php
require_once '../../koneksi/konek.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$idKunj = mysql_real_escape_string($_REQUEST['idKunj']);
$idPel = mysql_real_escape_string($_REQUEST['idPel']);


$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));

$idPasien = $sql['pasien_id'];
$idUser = mysql_real_escape_string($_REQUEST['idUser']);

function GetAll($idKunj, $idPasien)
{


	$query = "SELECT * FROM rm_dokumen_pelayanan_kamar WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'buku_status_ruang_pemulihan' => $data['buku_status_ruang_pemulihan'],
			'buku_status_ruangan' => $data['buku_status_ruangan'],
			'buku_status_keterangan' => $data['buku_status_keterangan'],
			'laporan_operasi_ruang_pemulihan' => $data['laporan_operasi_ruang_pemulihan'],
			'laporan_operasi_ruangan' => $data['laporan_operasi_ruangan'],
			'laporan_operasi_keterangan' => $data['laporan_operasi_keterangan'],
			'laporan_anestesi_ruang_pemulihan' => $data['laporan_anestesi_ruang_pemulihan'],
			'laporan_anestesi_ruangan' => $data['laporan_anestesi_ruangan'],
			'laporan_anestesi_keterangan' => $data['laporan_anestesi_keterangan'],
			'kim_ruang_pemulihan' => $data['kim_ruang_pemulihan'],
			'kim_ruangan' => $data['kim_ruangan'],
			'kim_keterangan' => $data['kim_keterangan'],
			'instruksi_obat_ruang_pemulihan' => $data['instruksi_obat_ruang_pemulihan'],
			'instruksi_obat_ruangan' => $data['instruksi_obat_ruangan'],
			'instruksi_obat_keterangan' => $data['instruksi_obat_keterangan'],
			'instruksi_khusus_ruang_pemulihan' => $data['instruksi_khusus_ruang_pemulihan'],
			'instruksi_khusus_ruangan' => $data['instruksi_khusus_ruangan'],
			'instruksi_khusus_keterangan' => $data['instruksi_khusus_keterangan'],
			'instruksi_transfusi_ruang_pemulihan' => $data['instruksi_transfusi_ruang_pemulihan'],
			'instruksi_transfusi_ruangan' => $data['instruksi_transfusi_ruangan'],
			'instruksi_transfusi_keterangan' => $data['instruksi_transfusi_keterangan'],
			'x_ray_photo_ruang_pemulihan' => $data['x_ray_photo_ruang_pemulihan'],
			'x_ray_photo_ruangan' => $data['x_ray_photo_ruangan'],
			'x_ray_photo_ruang_jumlah' => $data['x_ray_photo_ruang_jumlah'],
			'eeg_ruang_pemulihan' => $data['eeg_ruang_pemulihan'],
			'eeg_ruangan' => $data['eeg_ruangan'],
			'eeg_jumlah' => $data['eeg_jumlah'],
			'ecg_ruang_pemulihan' => $data['ecg_ruang_pemulihan'],
			'ecg_ruangan' => $data['ecg_ruangan'],
			'ecg_jumlah' => $data['ecg_jumlah'],
			'usg_ruang_pemulihan' => $data['usg_ruang_pemulihan'],
			'usg_ruangan' => $data['usg_ruangan'],
			'usg_jumlah' => $data['usg_jumlah'],
			'ct_scan_ruang_pemulihan' => $data['ct_scan_ruang_pemulihan'],
			'ct_scan_ruangan' => $data['ct_scan_ruangan'],
			'ct_scan_jumlah' => $data['ct_scan_jumlah'],
			'ngt_ruang_pemulihan' => $data['ngt_ruang_pemulihan'],
			'ngt_ruangan' => $data['ngt_ruangan'],
			'ngt_keterangan' => $data['ngt_keterangan'],
			'kateter_urin_ruang_pemulihan' => $data['kateter_urin_ruang_pemulihan'],
			'kateter_urin_ruangan' => $data['kateter_urin_ruangan'],
			'kateter_urin_keterangan' => $data['kateter_urin_keterangan'],
			'infus_ruang_pemulihan' => $data['infus_ruang_pemulihan'],
			'infus_ruangan' => $data['infus_ruangan'],
			'infus_area' => $data['infus_area'],
			'drain_ruang_pemulihan' => $data['drain_ruang_pemulihan'],
			'drain_ruangan' => $data['drain_ruangan'],
			'drain_area' => $data['drain_area'],
			'traksi_ruang_pemulihan' => $data['traksi_ruang_pemulihan'],
			'traksi_ruangan' => $data['traksi_ruangan'],
			'traksi_area' => $data['traksi_area'],
			'protesa_lain' => $data['protesa_lain'],
			'protesa_area' => $data['protesa_area'],
			'petugas_yang_menyerahkan' => $data['petugas_yang_menyerahkan'],
			'petugas_yang_menerima' => $data['petugas_yang_menerima'],
			'id_kunjungan' => $data['id_kunjungan'],
			'id_pelayanan' => $data['id_pelayanan'],
			'id_pasien' => $data['id_pasien'],
			'id_user' => $data['id_user'],

		);
	}
	return $datas;
}

function GetOne($id)
{

	$query = "SELECT * FROM  `rm_dokumen_pelayanan_kamar` WHERE  `id` =  '$id'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'buku_status_ruang_pemulihan' => $data['buku_status_ruang_pemulihan'],
			'buku_status_ruangan' => $data['buku_status_ruangan'],
			'buku_status_keterangan' => $data['buku_status_keterangan'],
			'laporan_operasi_ruang_pemulihan' => $data['laporan_operasi_ruang_pemulihan'],
			'laporan_operasi_ruangan' => $data['laporan_operasi_ruangan'],
			'laporan_operasi_keterangan' => $data['laporan_operasi_keterangan'],
			'laporan_anestesi_ruang_pemulihan' => $data['laporan_anestesi_ruang_pemulihan'],
			'laporan_anestesi_ruangan' => $data['laporan_anestesi_ruangan'],
			'laporan_anestesi_keterangan' => $data['laporan_anestesi_keterangan'],
			'kim_ruang_pemulihan' => $data['kim_ruang_pemulihan'],
			'kim_ruangan' => $data['kim_ruangan'],
			'kim_keterangan' => $data['kim_keterangan'],
			'instruksi_obat_ruang_pemulihan' => $data['instruksi_obat_ruang_pemulihan'],
			'instruksi_obat_ruangan' => $data['instruksi_obat_ruangan'],
			'instruksi_obat_keterangan' => $data['instruksi_obat_keterangan'],
			'instruksi_khusus_ruang_pemulihan' => $data['instruksi_khusus_ruang_pemulihan'],
			'instruksi_khusus_ruangan' => $data['instruksi_khusus_ruangan'],
			'instruksi_khusus_keterangan' => $data['instruksi_khusus_keterangan'],
			'instruksi_transfusi_ruang_pemulihan' => $data['instruksi_transfusi_ruang_pemulihan'],
			'instruksi_transfusi_ruangan' => $data['instruksi_transfusi_ruangan'],
			'instruksi_transfusi_keterangan' => $data['instruksi_transfusi_keterangan'],
			'x_ray_photo_ruang_pemulihan' => $data['x_ray_photo_ruang_pemulihan'],
			'x_ray_photo_ruangan' => $data['x_ray_photo_ruangan'],
			'x_ray_photo_ruang_jumlah' => $data['x_ray_photo_ruang_jumlah'],
			'eeg_ruang_pemulihan' => $data['eeg_ruang_pemulihan'],
			'eeg_ruangan' => $data['eeg_ruangan'],
			'eeg_jumlah' => $data['eeg_jumlah'],
			'ecg_ruang_pemulihan' => $data['ecg_ruang_pemulihan'],
			'ecg_ruangan' => $data['ecg_ruangan'],
			'ecg_jumlah' => $data['ecg_jumlah'],
			'usg_ruang_pemulihan' => $data['usg_ruang_pemulihan'],
			'usg_ruangan' => $data['usg_ruangan'],
			'usg_jumlah' => $data['usg_jumlah'],
			'ct_scan_ruang_pemulihan' => $data['ct_scan_ruang_pemulihan'],
			'ct_scan_ruangan' => $data['ct_scan_ruangan'],
			'ct_scan_jumlah' => $data['ct_scan_jumlah'],
			'ngt_ruang_pemulihan' => $data['ngt_ruang_pemulihan'],
			'ngt_ruangan' => $data['ngt_ruangan'],
			'ngt_keterangan' => $data['ngt_keterangan'],
			'kateter_urin_ruang_pemulihan' => $data['kateter_urin_ruang_pemulihan'],
			'kateter_urin_ruangan' => $data['kateter_urin_ruangan'],
			'kateter_urin_keterangan' => $data['kateter_urin_keterangan'],
			'infus_ruang_pemulihan' => $data['infus_ruang_pemulihan'],
			'infus_ruangan' => $data['infus_ruangan'],
			'infus_area' => $data['infus_area'],
			'drain_ruang_pemulihan' => $data['drain_ruang_pemulihan'],
			'drain_ruangan' => $data['drain_ruangan'],
			'drain_area' => $data['drain_area'],
			'traksi_ruang_pemulihan' => $data['traksi_ruang_pemulihan'],
			'traksi_ruangan' => $data['traksi_ruangan'],
			'traksi_area' => $data['traksi_area'],
			'protesa_lain' => $data['protesa_lain'],
			'protesa_area' => $data['protesa_area'],
			'petugas_yang_menyerahkan' => $data['petugas_yang_menyerahkan'],
			'petugas_yang_menerima' => $data['petugas_yang_menerima'],
			'id_kunjungan' => $data['id_kunjungan'],
			'id_pelayanan' => $data['id_pelayanan'],
			'id_pasien' => $data['id_pasien'],
			'id_user' => $data['id_user'],

		);
	}
	return $datas;
}

function Insert()
{


	$idKunj = mysql_real_escape_string($_REQUEST['idKunj']);
	$idPel = mysql_real_escape_string($_REQUEST['idPel']);
	$idPasien = mysql_real_escape_string($_REQUEST['idPasien']);
	$idUser = mysql_real_escape_string($_REQUEST['idUser']);
	$buku_status_ruang_pemulihan = mysql_real_escape_string($_POST['buku_status_ruang_pemulihan']);
	$buku_status_ruangan = mysql_real_escape_string($_POST['buku_status_ruangan']);
	$buku_status_keterangan = mysql_real_escape_string($_POST['buku_status_keterangan']);
	$laporan_operasi_ruang_pemulihan = mysql_real_escape_string($_POST['laporan_operasi_ruang_pemulihan']);
	$laporan_operasi_ruangan = mysql_real_escape_string($_POST['laporan_operasi_ruangan']);
	$laporan_operasi_keterangan = mysql_real_escape_string($_POST['laporan_operasi_keterangan']);
	$laporan_anestesi_ruang_pemulihan = mysql_real_escape_string($_POST['laporan_anestesi_ruang_pemulihan']);
	$laporan_anestesi_ruangan = mysql_real_escape_string($_POST['laporan_anestesi_ruangan']);
	$laporan_anestesi_keterangan = mysql_real_escape_string($_POST['laporan_anestesi_keterangan']);
	$kim_ruang_pemulihan = mysql_real_escape_string($_POST['kim_ruang_pemulihan']);
	$kim_ruangan = mysql_real_escape_string($_POST['kim_ruangan']);
	$kim_keterangan = mysql_real_escape_string($_POST['kim_keterangan']);
	$instruksi_obat_ruang_pemulihan = mysql_real_escape_string($_POST['instruksi_obat_ruang_pemulihan']);
	$instruksi_obat_ruangan = mysql_real_escape_string($_POST['instruksi_obat_ruangan']);
	$instruksi_obat_keterangan = mysql_real_escape_string($_POST['instruksi_obat_keterangan']);
	$instruksi_khusus_ruang_pemulihan = mysql_real_escape_string($_POST['instruksi_khusus_ruang_pemulihan']);
	$instruksi_khusus_ruangan = mysql_real_escape_string($_POST['instruksi_khusus_ruangan']);
	$instruksi_khusus_keterangan = mysql_real_escape_string($_POST['instruksi_khusus_keterangan']);
	$instruksi_transfusi_ruang_pemulihan = mysql_real_escape_string($_POST['instruksi_transfusi_ruang_pemulihan']);
	$instruksi_transfusi_ruangan = mysql_real_escape_string($_POST['instruksi_transfusi_ruangan']);
	$instruksi_transfusi_keterangan = mysql_real_escape_string($_POST['instruksi_transfusi_keterangan']);
	$x_ray_photo_ruang_pemulihan = mysql_real_escape_string($_POST['x_ray_photo_ruang_pemulihan']);
	$x_ray_photo_ruangan = mysql_real_escape_string($_POST['x_ray_photo_ruangan']);
	$x_ray_photo_ruang_jumlah = mysql_real_escape_string($_POST['x_ray_photo_ruang_jumlah']);
	$eeg_ruang_pemulihan = mysql_real_escape_string($_POST['eeg_ruang_pemulihan']);
	$eeg_ruangan = mysql_real_escape_string($_POST['eeg_ruangan']);
	$eeg_jumlah = mysql_real_escape_string($_POST['eeg_jumlah']);
	$ecg_ruang_pemulihan = mysql_real_escape_string($_POST['ecg_ruang_pemulihan']);
	$ecg_ruangan = mysql_real_escape_string($_POST['ecg_ruangan']);
	$ecg_jumlah = mysql_real_escape_string($_POST['ecg_jumlah']);
	$usg_ruang_pemulihan = mysql_real_escape_string($_POST['usg_ruang_pemulihan']);
	$usg_ruangan = mysql_real_escape_string($_POST['usg_ruangan']);
	$usg_jumlah = mysql_real_escape_string($_POST['usg_jumlah']);
	$ct_scan_ruang_pemulihan = mysql_real_escape_string($_POST['ct_scan_ruang_pemulihan']);
	$ct_scan_ruangan = mysql_real_escape_string($_POST['ct_scan_ruangan']);
	$ct_scan_jumlah = mysql_real_escape_string($_POST['ct_scan_jumlah']);
	$ngt_ruang_pemulihan = mysql_real_escape_string($_POST['ngt_ruang_pemulihan']);
	$ngt_ruangan = mysql_real_escape_string($_POST['ngt_ruangan']);
	$ngt_keterangan = mysql_real_escape_string($_POST['ngt_keterangan']);
	$kateter_urin_ruang_pemulihan = mysql_real_escape_string($_POST['kateter_urin_ruang_pemulihan']);
	$kateter_urin_ruangan = mysql_real_escape_string($_POST['kateter_urin_ruangan']);
	$kateter_urin_keterangan = mysql_real_escape_string($_POST['kateter_urin_keterangan']);
	$infus_ruang_pemulihan = mysql_real_escape_string($_POST['infus_ruang_pemulihan']);
	$infus_ruangan = mysql_real_escape_string($_POST['infus_ruangan']);
	$infus_area = mysql_real_escape_string($_POST['infus_area']);
	$drain_ruang_pemulihan = mysql_real_escape_string($_POST['drain_ruang_pemulihan']);
	$drain_ruangan = mysql_real_escape_string($_POST['drain_ruangan']);
	$drain_area = mysql_real_escape_string($_POST['drain_area']);
	$traksi_ruang_pemulihan = mysql_real_escape_string($_POST['traksi_ruang_pemulihan']);
	$traksi_ruangan = mysql_real_escape_string($_POST['traksi_ruangan']);
	$traksi_area = mysql_real_escape_string($_POST['traksi_area']);
	$protesa_lain = mysql_real_escape_string($_POST['protesa_lain']);
	$protesa_area = mysql_real_escape_string($_POST['protesa_area']);
	$petugas_yang_menyerahkan = mysql_real_escape_string($_POST['petugas_yang_menyerahkan']);
	$petugas_yang_menerima = mysql_real_escape_string($_POST['petugas_yang_menerima']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);
	$id_user = mysql_real_escape_string($_POST['id_user']);

	$query = "INSERT INTO `rm_dokumen_pelayanan_kamar` (`id`,`buku_status_ruang_pemulihan`,`buku_status_ruangan`,`buku_status_keterangan`,`laporan_operasi_ruang_pemulihan`,`laporan_operasi_ruangan`,`laporan_operasi_keterangan`,`laporan_anestesi_ruang_pemulihan`,`laporan_anestesi_ruangan`,`laporan_anestesi_keterangan`,`kim_ruang_pemulihan`,`kim_ruangan`,`kim_keterangan`,`instruksi_obat_ruang_pemulihan`,`instruksi_obat_ruangan`,`instruksi_obat_keterangan`,`instruksi_khusus_ruang_pemulihan`,`instruksi_khusus_ruangan`,`instruksi_khusus_keterangan`,`instruksi_transfusi_ruang_pemulihan`,`instruksi_transfusi_ruangan`,`instruksi_transfusi_keterangan`,`x_ray_photo_ruang_pemulihan`,`x_ray_photo_ruangan`,`x_ray_photo_ruang_jumlah`,`eeg_ruang_pemulihan`,`eeg_ruangan`,`eeg_jumlah`,`ecg_ruang_pemulihan`,`ecg_ruangan`,`ecg_jumlah`,`usg_ruang_pemulihan`,`usg_ruangan`,`usg_jumlah`,`ct_scan_ruang_pemulihan`,`ct_scan_ruangan`,`ct_scan_jumlah`,`ngt_ruang_pemulihan`,`ngt_ruangan`,`ngt_keterangan`,`kateter_urin_ruang_pemulihan`,`kateter_urin_ruangan`,`kateter_urin_keterangan`,`infus_ruang_pemulihan`,`infus_ruangan`,`infus_area`,`drain_ruang_pemulihan`,`drain_ruangan`,`drain_area`,`traksi_ruang_pemulihan`,`traksi_ruangan`,`traksi_area`,`protesa_lain`,`protesa_area`,`petugas_yang_menyerahkan`,`petugas_yang_menerima`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$buku_status_ruang_pemulihan','$buku_status_ruangan','$buku_status_keterangan','$laporan_operasi_ruang_pemulihan','$laporan_operasi_ruangan','$laporan_operasi_keterangan','$laporan_anestesi_ruang_pemulihan','$laporan_anestesi_ruangan','$laporan_anestesi_keterangan','$kim_ruang_pemulihan','$kim_ruangan','$kim_keterangan','$instruksi_obat_ruang_pemulihan','$instruksi_obat_ruangan','$instruksi_obat_keterangan','$instruksi_khusus_ruang_pemulihan','$instruksi_khusus_ruangan','$instruksi_khusus_keterangan','$instruksi_transfusi_ruang_pemulihan','$instruksi_transfusi_ruangan','$instruksi_transfusi_keterangan','$x_ray_photo_ruang_pemulihan','$x_ray_photo_ruangan','$x_ray_photo_ruang_jumlah','$eeg_ruang_pemulihan','$eeg_ruangan','$eeg_jumlah','$ecg_ruang_pemulihan','$ecg_ruangan','$ecg_jumlah','$usg_ruang_pemulihan','$usg_ruangan','$usg_jumlah','$ct_scan_ruang_pemulihan','$ct_scan_ruangan','$ct_scan_jumlah','$ngt_ruang_pemulihan','$ngt_ruangan','$ngt_keterangan','$kateter_urin_ruang_pemulihan','$kateter_urin_ruangan','$kateter_urin_keterangan','$infus_ruang_pemulihan','$infus_ruangan','$infus_area','$drain_ruang_pemulihan','$drain_ruangan','$drain_area','$traksi_ruang_pemulihan','$traksi_ruangan','$traksi_area','$protesa_lain','$protesa_area','$petugas_yang_menyerahkan','$petugas_yang_menerima','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
	$exe = mysql_query($query);
	if ($exe) {
		// kalau berhasil
		$_SESSION['message'] = " Data Telah disimpan ";
		$_SESSION['mType'] = "success ";

		header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
	} else {
		$_SESSION['message'] = " Data Gagal disimpan ";
		$_SESSION['mType'] = "danger ";

		header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
	}
}
function Update($id)
{


	$idKunj = mysql_real_escape_string($_REQUEST['idKunj']);
	$idPel = mysql_real_escape_string($_REQUEST['idPel']);
	$idPasien = mysql_real_escape_string($_REQUEST['idPasien']);
	$idUser = mysql_real_escape_string($_REQUEST['idUser']);

	$buku_status_ruang_pemulihan = mysql_real_escape_string($_POST['buku_status_ruang_pemulihan']);
	$buku_status_ruangan = mysql_real_escape_string($_POST['buku_status_ruangan']);
	$buku_status_keterangan = mysql_real_escape_string($_POST['buku_status_keterangan']);
	$laporan_operasi_ruang_pemulihan = mysql_real_escape_string($_POST['laporan_operasi_ruang_pemulihan']);
	$laporan_operasi_ruangan = mysql_real_escape_string($_POST['laporan_operasi_ruangan']);
	$laporan_operasi_keterangan = mysql_real_escape_string($_POST['laporan_operasi_keterangan']);
	$laporan_anestesi_ruang_pemulihan = mysql_real_escape_string($_POST['laporan_anestesi_ruang_pemulihan']);
	$laporan_anestesi_ruangan = mysql_real_escape_string($_POST['laporan_anestesi_ruangan']);
	$laporan_anestesi_keterangan = mysql_real_escape_string($_POST['laporan_anestesi_keterangan']);
	$kim_ruang_pemulihan = mysql_real_escape_string($_POST['kim_ruang_pemulihan']);
	$kim_ruangan = mysql_real_escape_string($_POST['kim_ruangan']);
	$kim_keterangan = mysql_real_escape_string($_POST['kim_keterangan']);
	$instruksi_obat_ruang_pemulihan = mysql_real_escape_string($_POST['instruksi_obat_ruang_pemulihan']);
	$instruksi_obat_ruangan = mysql_real_escape_string($_POST['instruksi_obat_ruangan']);
	$instruksi_obat_keterangan = mysql_real_escape_string($_POST['instruksi_obat_keterangan']);
	$instruksi_khusus_ruang_pemulihan = mysql_real_escape_string($_POST['instruksi_khusus_ruang_pemulihan']);
	$instruksi_khusus_ruangan = mysql_real_escape_string($_POST['instruksi_khusus_ruangan']);
	$instruksi_khusus_keterangan = mysql_real_escape_string($_POST['instruksi_khusus_keterangan']);
	$instruksi_transfusi_ruang_pemulihan = mysql_real_escape_string($_POST['instruksi_transfusi_ruang_pemulihan']);
	$instruksi_transfusi_ruangan = mysql_real_escape_string($_POST['instruksi_transfusi_ruangan']);
	$instruksi_transfusi_keterangan = mysql_real_escape_string($_POST['instruksi_transfusi_keterangan']);
	$x_ray_photo_ruang_pemulihan = mysql_real_escape_string($_POST['x_ray_photo_ruang_pemulihan']);
	$x_ray_photo_ruangan = mysql_real_escape_string($_POST['x_ray_photo_ruangan']);
	$x_ray_photo_ruang_jumlah = mysql_real_escape_string($_POST['x_ray_photo_ruang_jumlah']);
	$eeg_ruang_pemulihan = mysql_real_escape_string($_POST['eeg_ruang_pemulihan']);
	$eeg_ruangan = mysql_real_escape_string($_POST['eeg_ruangan']);
	$eeg_jumlah = mysql_real_escape_string($_POST['eeg_jumlah']);
	$ecg_ruang_pemulihan = mysql_real_escape_string($_POST['ecg_ruang_pemulihan']);
	$ecg_ruangan = mysql_real_escape_string($_POST['ecg_ruangan']);
	$ecg_jumlah = mysql_real_escape_string($_POST['ecg_jumlah']);
	$usg_ruang_pemulihan = mysql_real_escape_string($_POST['usg_ruang_pemulihan']);
	$usg_ruangan = mysql_real_escape_string($_POST['usg_ruangan']);
	$usg_jumlah = mysql_real_escape_string($_POST['usg_jumlah']);
	$ct_scan_ruang_pemulihan = mysql_real_escape_string($_POST['ct_scan_ruang_pemulihan']);
	$ct_scan_ruangan = mysql_real_escape_string($_POST['ct_scan_ruangan']);
	$ct_scan_jumlah = mysql_real_escape_string($_POST['ct_scan_jumlah']);
	$ngt_ruang_pemulihan = mysql_real_escape_string($_POST['ngt_ruang_pemulihan']);
	$ngt_ruangan = mysql_real_escape_string($_POST['ngt_ruangan']);
	$ngt_keterangan = mysql_real_escape_string($_POST['ngt_keterangan']);
	$kateter_urin_ruang_pemulihan = mysql_real_escape_string($_POST['kateter_urin_ruang_pemulihan']);
	$kateter_urin_ruangan = mysql_real_escape_string($_POST['kateter_urin_ruangan']);
	$kateter_urin_keterangan = mysql_real_escape_string($_POST['kateter_urin_keterangan']);
	$infus_ruang_pemulihan = mysql_real_escape_string($_POST['infus_ruang_pemulihan']);
	$infus_ruangan = mysql_real_escape_string($_POST['infus_ruangan']);
	$infus_area = mysql_real_escape_string($_POST['infus_area']);
	$drain_ruang_pemulihan = mysql_real_escape_string($_POST['drain_ruang_pemulihan']);
	$drain_ruangan = mysql_real_escape_string($_POST['drain_ruangan']);
	$drain_area = mysql_real_escape_string($_POST['drain_area']);
	$traksi_ruang_pemulihan = mysql_real_escape_string($_POST['traksi_ruang_pemulihan']);
	$traksi_ruangan = mysql_real_escape_string($_POST['traksi_ruangan']);
	$traksi_area = mysql_real_escape_string($_POST['traksi_area']);
	$protesa_lain = mysql_real_escape_string($_POST['protesa_lain']);
	$protesa_area = mysql_real_escape_string($_POST['protesa_area']);
	$petugas_yang_menyerahkan = mysql_real_escape_string($_POST['petugas_yang_menyerahkan']);
	$petugas_yang_menerima = mysql_real_escape_string($_POST['petugas_yang_menerima']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);
	$id_user = mysql_real_escape_string($_POST['id_user']);

	$query = "UPDATE `rm_dokumen_pelayanan_kamar` SET `buku_status_ruang_pemulihan` = '$buku_status_ruang_pemulihan',`buku_status_ruangan` = '$buku_status_ruangan',`buku_status_keterangan` = '$buku_status_keterangan',`laporan_operasi_ruang_pemulihan` = '$laporan_operasi_ruang_pemulihan',`laporan_operasi_ruangan` = '$laporan_operasi_ruangan',`laporan_operasi_keterangan` = '$laporan_operasi_keterangan',`laporan_anestesi_ruang_pemulihan` = '$laporan_anestesi_ruang_pemulihan',`laporan_anestesi_ruangan` = '$laporan_anestesi_ruangan',`laporan_anestesi_keterangan` = '$laporan_anestesi_keterangan',`kim_ruang_pemulihan` = '$kim_ruang_pemulihan',`kim_ruangan` = '$kim_ruangan',`kim_keterangan` = '$kim_keterangan',`instruksi_obat_ruang_pemulihan` = '$instruksi_obat_ruang_pemulihan',`instruksi_obat_ruangan` = '$instruksi_obat_ruangan',`instruksi_obat_keterangan` = '$instruksi_obat_keterangan',`instruksi_khusus_ruang_pemulihan` = '$instruksi_khusus_ruang_pemulihan',`instruksi_khusus_ruangan` = '$instruksi_khusus_ruangan',`instruksi_khusus_keterangan` = '$instruksi_khusus_keterangan',`instruksi_transfusi_ruang_pemulihan` = '$instruksi_transfusi_ruang_pemulihan',`instruksi_transfusi_ruangan` = '$instruksi_transfusi_ruangan',`instruksi_transfusi_keterangan` = '$instruksi_transfusi_keterangan',`x_ray_photo_ruang_pemulihan` = '$x_ray_photo_ruang_pemulihan',`x_ray_photo_ruangan` = '$x_ray_photo_ruangan',`x_ray_photo_ruang_jumlah` = '$x_ray_photo_ruang_jumlah',`eeg_ruang_pemulihan` = '$eeg_ruang_pemulihan',`eeg_ruangan` = '$eeg_ruangan',`eeg_jumlah` = '$eeg_jumlah',`ecg_ruang_pemulihan` = '$ecg_ruang_pemulihan',`ecg_ruangan` = '$ecg_ruangan',`ecg_jumlah` = '$ecg_jumlah',`usg_ruang_pemulihan` = '$usg_ruang_pemulihan',`usg_ruangan` = '$usg_ruangan',`usg_jumlah` = '$usg_jumlah',`ct_scan_ruang_pemulihan` = '$ct_scan_ruang_pemulihan',`ct_scan_ruangan` = '$ct_scan_ruangan',`ct_scan_jumlah` = '$ct_scan_jumlah',`ngt_ruang_pemulihan` = '$ngt_ruang_pemulihan',`ngt_ruangan` = '$ngt_ruangan',`ngt_keterangan` = '$ngt_keterangan',`kateter_urin_ruang_pemulihan` = '$kateter_urin_ruang_pemulihan',`kateter_urin_ruangan` = '$kateter_urin_ruangan',`kateter_urin_keterangan` = '$kateter_urin_keterangan',`infus_ruang_pemulihan` = '$infus_ruang_pemulihan',`infus_ruangan` = '$infus_ruangan',`infus_area` = '$infus_area',`drain_ruang_pemulihan` = '$drain_ruang_pemulihan',`drain_ruangan` = '$drain_ruangan',`drain_area` = '$drain_area',`traksi_ruang_pemulihan` = '$traksi_ruang_pemulihan',`traksi_ruangan` = '$traksi_ruangan',`traksi_area` = '$traksi_area',`protesa_lain` = '$protesa_lain',`protesa_area` = '$protesa_area',`petugas_yang_menyerahkan` = '$petugas_yang_menyerahkan',`petugas_yang_menerima` = '$petugas_yang_menerima',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
	$exe = mysql_query($query);
	if ($exe) {
		// kalau berhasil
		$_SESSION['message'] = " Data Telah diubah ";
		$_SESSION['mType'] = "success ";

		header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
	} else {
		$_SESSION['message'] = " Data Gagal diubah ";
		$_SESSION['mType'] = "danger ";

		header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
	}
}
function Delete($id)
{

	$idKunj = mysql_real_escape_string($_REQUEST['idKunj']);
	$idPel = mysql_real_escape_string($_REQUEST['idPel']);
	$idPasien = mysql_real_escape_string($_REQUEST['idPasien']);
	$idUser = mysql_real_escape_string($_REQUEST['idUser']);

	$query = "DELETE FROM `rm_dokumen_pelayanan_kamar` WHERE `id` = '$id'";
	$exe = mysql_query($query);
	if ($exe) {
		// kalau berhasil
		$_SESSION['message'] = " Data Telah dihapus ";
		$_SESSION['mType'] = "success ";

		header("Location: index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser");
	} else {
		$_SESSION['message'] = " Data Gagal dihapus ";
		$_SESSION['mType'] = "danger ";

		header("Location: index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser");
	}
}




function hari_ini()
{
	$hari = date("D");

	switch ($hari) {
		case 'Sun':
			$hari_ini = "Minggu";
			break;

		case 'Mon':
			$hari_ini = "Senin";
			break;

		case 'Tue':
			$hari_ini = "Selasa";
			break;

		case 'Wed':
			$hari_ini = "Rabu";
			break;

		case 'Thu':
			$hari_ini = "Kamis";
			break;

		case 'Fri':
			$hari_ini = "Jumat";
			break;

		case 'Sat':
			$hari_ini = "Sabtu";
			break;

		default:
			$hari_ini = "Tidak di ketahui";
			break;
	}

	return "" . $hari_ini . "";
}



if (isset($_POST['insert'])) {
	Insert();
} else if (isset($_POST['update'])) {
	Update(mysql_real_escape_string($_POST['id']));
} else if (isset($_POST['delete'])) {
	Delete(mysql_real_escape_string($_POST['id']));
}