<?php
session_start();
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];

include("../../koneksi/konek.php");
$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
$idPasien = $sql['pasien_id'];
$idUser = $_REQUEST['idUser'];

function GetAll($idKunj, $idPasien)
{


	$query = "SELECT * FROM rm_dugaan_reaksi_transfusi WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'diagnosa' => $data['diagnosa'],
			'bagian' => $data['bagian'],
			'ruangan' => $data['ruangan'],
			'kelas' => $data['kelas'],
			'hari_tanggal_jam_transfusi' => $data['hari_tanggal_jam_transfusi'],
			'jam_reaksi' => $data['jam_reaksi'],
			'jenis_komponen_darah' => $data['jenis_komponen_darah'],
			'golongan_darah' => $data['golongan_darah'],
			'perkiraan_vol_transfusi' => $data['perkiraan_vol_transfusi'],
			'pratransfusi_kesadaran' => $data['pratransfusi_kesadaran'],
			'pratransfusi_tekanan_darah' => $data['pratransfusi_tekanan_darah'],
			'pratransfusi_frekunensi_nadi' => $data['pratransfusi_frekunensi_nadi'],
			'pratransfusi_suhu' => $data['pratransfusi_suhu'],
			'pascatransfusi_kesadaran' => $data['pascatransfusi_kesadaran'],
			'pascatransfusi_tekanan_darah' => $data['pascatransfusi_tekanan_darah'],
			'pascaatransfusi_frekunensi_nadi' => $data['pascaatransfusi_frekunensi_nadi'],
			'pascatransfusi_suhu' => $data['pascatransfusi_suhu'],
			'gejala_tanda_klinis' => $data['gejala_tanda_klinis'],
			'nama_dokter' => $data['nama_dokter'],
			'id_kunjungan' => $data['id_kunjungan'],
			'id_pelayanan' => $data['id_pelayanan'],
			'id_pasien' => $data['id_pasien'],

		);
	}
	return $datas;
}

function GetOne($id)
{

	$query = "SELECT * FROM  `rm_dugaan_reaksi_transfusi` WHERE  `id` =  '$id'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'diagnosa' => $data['diagnosa'],
			'bagian' => $data['bagian'],
			'ruangan' => $data['ruangan'],
			'kelas' => $data['kelas'],
			'hari_tanggal_jam_transfusi' => $data['hari_tanggal_jam_transfusi'],
			'jam_reaksi' => $data['jam_reaksi'],
			'jenis_komponen_darah' => $data['jenis_komponen_darah'],
			'golongan_darah' => $data['golongan_darah'],
			'perkiraan_vol_transfusi' => $data['perkiraan_vol_transfusi'],
			'pratransfusi_kesadaran' => $data['pratransfusi_kesadaran'],
			'pratransfusi_tekanan_darah' => $data['pratransfusi_tekanan_darah'],
			'pratransfusi_frekunensi_nadi' => $data['pratransfusi_frekunensi_nadi'],
			'pratransfusi_suhu' => $data['pratransfusi_suhu'],
			'pascatransfusi_kesadaran' => $data['pascatransfusi_kesadaran'],
			'pascatransfusi_tekanan_darah' => $data['pascatransfusi_tekanan_darah'],
			'pascaatransfusi_frekunensi_nadi' => $data['pascaatransfusi_frekunensi_nadi'],
			'pascatransfusi_suhu' => $data['pascatransfusi_suhu'],
			'gejala_tanda_klinis' => $data['gejala_tanda_klinis'],
			'nama_dokter' => $data['nama_dokter'],
			'id_kunjungan' => $data['id_kunjungan'],
			'id_pelayanan' => $data['id_pelayanan'],
			'id_pasien' => $data['id_pasien'],

		);
	}
	return $datas;
}

function Insert()
{


	$idKunj = $_REQUEST['idKunj'];
	$idPel = $_REQUEST['idPel'];
	$idPasien = $_REQUEST['idPasien'];
	$idUser = $_REQUEST['idUser'];
	$diagnosa = mysql_real_escape_string($_POST['diagnosa']);
	$bagian = mysql_real_escape_string($_POST['bagian']);
	$ruangan = mysql_real_escape_string($_POST['ruangan']);
	$kelas = mysql_real_escape_string($_POST['kelas']);
	$hari_tanggal_jam_transfusi = mysql_real_escape_string($_POST['hari_tanggal_jam_transfusi']);
	$jam_reaksi = mysql_real_escape_string($_POST['jam_reaksi']);
	$jenis_komponen_darah = mysql_real_escape_string($_POST['jenis_komponen_darah']);
	$golongan_darah = mysql_real_escape_string($_POST['golongan_darah']);
	$perkiraan_vol_transfusi = mysql_real_escape_string($_POST['perkiraan_vol_transfusi']);
	$pratransfusi_kesadaran = mysql_real_escape_string($_POST['pratransfusi_kesadaran']);
	$pratransfusi_tekanan_darah = mysql_real_escape_string($_POST['pratransfusi_tekanan_darah']);
	$pratransfusi_frekunensi_nadi = mysql_real_escape_string($_POST['pratransfusi_frekunensi_nadi']);
	$pratransfusi_suhu = mysql_real_escape_string($_POST['pratransfusi_suhu']);
	$pascatransfusi_kesadaran = mysql_real_escape_string($_POST['pascatransfusi_kesadaran']);
	$pascatransfusi_tekanan_darah = mysql_real_escape_string($_POST['pascatransfusi_tekanan_darah']);
	$pascaatransfusi_frekunensi_nadi = mysql_real_escape_string($_POST['pascaatransfusi_frekunensi_nadi']);
	$pascatransfusi_suhu = mysql_real_escape_string($_POST['pascatransfusi_suhu']);
	$gejala_tanda_klinis = mysql_real_escape_string($_POST['gejala_tanda_klinis']);
	$nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);

	$query = "INSERT INTO `rm_dugaan_reaksi_transfusi` (`id`,`diagnosa`,`bagian`,`ruangan`,`kelas`,`hari_tanggal_jam_transfusi`,`jam_reaksi`,`jenis_komponen_darah`,`golongan_darah`,`perkiraan_vol_transfusi`,`pratransfusi_kesadaran`,`pratransfusi_tekanan_darah`,`pratransfusi_frekunensi_nadi`,`pratransfusi_suhu`,`pascatransfusi_kesadaran`,`pascatransfusi_tekanan_darah`,`pascaatransfusi_frekunensi_nadi`,`pascatransfusi_suhu`,`gejala_tanda_klinis`,`nama_dokter`,`id_kunjungan`,`id_pelayanan`,`id_pasien`z)
VALUES (NULL,'$diagnosa','$bagian','$ruangan','$kelas','$hari_tanggal_jam_transfusi','$jam_reaksi','$jenis_komponen_darah','$golongan_darah','$perkiraan_vol_transfusi','$pratransfusi_kesadaran','$pratransfusi_tekanan_darah','$pratransfusi_frekunensi_nadi','$pratransfusi_suhu','$pascatransfusi_kesadaran','$pascatransfusi_tekanan_darah','$pascaatransfusi_frekunensi_nadi','$pascatransfusi_suhu','$gejala_tanda_klinis','$nama_dokter','$id_kunjungan','$id_pelayanan','$id_pasien')";
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


	$idKunj = $_REQUEST['idKunj'];
	$idPel = $_REQUEST['idPel'];
	$idPasien = $_REQUEST['idPasien'];
	$idUser = $_REQUEST['idUser'];

	$diagnosa = mysql_real_escape_string($_POST['diagnosa']);
	$bagian = mysql_real_escape_string($_POST['bagian']);
	$ruangan = mysql_real_escape_string($_POST['ruangan']);
	$kelas = mysql_real_escape_string($_POST['kelas']);
	$hari_tanggal_jam_transfusi = mysql_real_escape_string($_POST['hari_tanggal_jam_transfusi']);
	$jam_reaksi = mysql_real_escape_string($_POST['jam_reaksi']);
	$jenis_komponen_darah = mysql_real_escape_string($_POST['jenis_komponen_darah']);
	$golongan_darah = mysql_real_escape_string($_POST['golongan_darah']);
	$perkiraan_vol_transfusi = mysql_real_escape_string($_POST['perkiraan_vol_transfusi']);
	$pratransfusi_kesadaran = mysql_real_escape_string($_POST['pratransfusi_kesadaran']);
	$pratransfusi_tekanan_darah = mysql_real_escape_string($_POST['pratransfusi_tekanan_darah']);
	$pratransfusi_frekunensi_nadi = mysql_real_escape_string($_POST['pratransfusi_frekunensi_nadi']);
	$pratransfusi_suhu = mysql_real_escape_string($_POST['pratransfusi_suhu']);
	$pascatransfusi_kesadaran = mysql_real_escape_string($_POST['pascatransfusi_kesadaran']);
	$pascatransfusi_tekanan_darah = mysql_real_escape_string($_POST['pascatransfusi_tekanan_darah']);
	$pascaatransfusi_frekunensi_nadi = mysql_real_escape_string($_POST['pascaatransfusi_frekunensi_nadi']);
	$pascatransfusi_suhu = mysql_real_escape_string($_POST['pascatransfusi_suhu']);
	$gejala_tanda_klinis = mysql_real_escape_string($_POST['gejala_tanda_klinis']);
	$nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);

	$query = "UPDATE `rm_dugaan_reaksi_transfusi` SET `diagnosa` = '$diagnosa',`bagian` = '$bagian',`ruangan` = '$ruangan',`kelas` = '$kelas',`hari_tanggal_jam_transfusi` = '$hari_tanggal_jam_transfusi',`jam_reaksi` = '$jam_reaksi',`jenis_komponen_darah` = '$jenis_komponen_darah',`golongan_darah` = '$golongan_darah',`perkiraan_vol_transfusi` = '$perkiraan_vol_transfusi',`pratransfusi_kesadaran` = '$pratransfusi_kesadaran',`pratransfusi_tekanan_darah` = '$pratransfusi_tekanan_darah',`pratransfusi_frekunensi_nadi` = '$pratransfusi_frekunensi_nadi',`pratransfusi_suhu` = '$pratransfusi_suhu',`pascatransfusi_kesadaran` = '$pascatransfusi_kesadaran',`pascatransfusi_tekanan_darah` = '$pascatransfusi_tekanan_darah',`pascaatransfusi_frekunensi_nadi` = '$pascaatransfusi_frekunensi_nadi',`pascatransfusi_suhu` = '$pascatransfusi_suhu',`gejala_tanda_klinis` = '$gejala_tanda_klinis',`nama_dokter` = '$nama_dokter',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien' WHERE  `id` =  '$id'";
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

	$idKunj = $_REQUEST['idKunj'];
	$idPel = $_REQUEST['idPel'];
	$idPasien = $_REQUEST['idPasien'];
	$idUser = $_REQUEST['idUser'];

	$query = "DELETE FROM `rm_dugaan_reaksi_transfusi` WHERE `id` = '$id'";
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


if (isset($_POST['insert'])) {
	Insert();
} else if (isset($_POST['update'])) {
	Update($_POST['id']);
} else if (isset($_POST['delete'])) {
	Delete($_POST['id']);
}