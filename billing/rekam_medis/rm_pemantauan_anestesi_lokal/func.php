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


	$query = "SELECT * FROM rm_pemantauan_anestesi_lokal WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'tanggal_tindakan' => $data['tanggal_tindakan'],
			'diagnosa' => $data['diagnosa'],
			'nama_tindakan' => $data['nama_tindakan'],
			'pembedah' => $data['pembedah'],
			'ruang_poli' => $data['ruang_poli'],
			'riwayat_penyakit' => $data['riwayat_penyakit'],
			'riwayat_alergi' => $data['riwayat_alergi'],
			'tanggal' => $data['tanggal'],
			'jam' => $data['jam'],
			'kesadaran' => $data['kesadaran'],
			'td' => $data['td'],
			'nadi' => $data['nadi'],
			'respirasi' => $data['respirasi'],
			'suhu' => $data['suhu'],
			'obat_obatan' => $data['obat_obatan'],
			'cairan' => $data['cairan'],
			'keterangan' => $data['keterangan'],
			'paska_bedah_kesadaran' => $data['paska_bedah_kesadaran'],
			'paska_bedah_tekanan_darah' => $data['paska_bedah_tekanan_darah'],
			'paska_bedah_nadi' => $data['paska_bedah_nadi'],
			'paska_bedah_respirasi' => $data['paska_bedah_respirasi'],
			'paska_bedah_suhu' => $data['paska_bedah_suhu'],
			'paska_bedah_reaksi_alergi' => $data['paska_bedah_reaksi_alergi'],
			'komplikasi_lain' => $data['komplikasi_lain'],
			'pembuat_laporan' => $data['pembuat_laporan'],
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

	$query = "SELECT * FROM  `rm_pemantauan_anestesi_lokal` WHERE  `id` =  '$id'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'tanggal_tindakan' => $data['tanggal_tindakan'],
			'diagnosa' => $data['diagnosa'],
			'nama_tindakan' => $data['nama_tindakan'],
			'pembedah' => $data['pembedah'],
			'ruang_poli' => $data['ruang_poli'],
			'riwayat_penyakit' => $data['riwayat_penyakit'],
			'riwayat_alergi' => $data['riwayat_alergi'],
			'tanggal' => $data['tanggal'],
			'jam' => $data['jam'],
			'kesadaran' => $data['kesadaran'],
			'td' => $data['td'],
			'nadi' => $data['nadi'],
			'respirasi' => $data['respirasi'],
			'suhu' => $data['suhu'],
			'obat_obatan' => $data['obat_obatan'],
			'cairan' => $data['cairan'],
			'keterangan' => $data['keterangan'],
			'paska_bedah_kesadaran' => $data['paska_bedah_kesadaran'],
			'paska_bedah_tekanan_darah' => $data['paska_bedah_tekanan_darah'],
			'paska_bedah_nadi' => $data['paska_bedah_nadi'],
			'paska_bedah_respirasi' => $data['paska_bedah_respirasi'],
			'paska_bedah_suhu' => $data['paska_bedah_suhu'],
			'paska_bedah_reaksi_alergi' => $data['paska_bedah_reaksi_alergi'],
			'komplikasi_lain' => $data['komplikasi_lain'],
			'pembuat_laporan' => $data['pembuat_laporan'],
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
	$tanggal_tindakan = mysql_real_escape_string($_POST['tanggal_tindakan']);
	$diagnosa = mysql_real_escape_string($_POST['diagnosa']);
	$nama_tindakan = mysql_real_escape_string($_POST['nama_tindakan']);
	$pembedah = mysql_real_escape_string($_POST['pembedah']);
	$ruang_poli = mysql_real_escape_string($_POST['ruang_poli']);
	$riwayat_penyakit = mysql_real_escape_string($_POST['riwayat_penyakit']);
	$riwayat_alergi = mysql_real_escape_string($_POST['riwayat_alergi']);
	$tanggal = mysql_real_escape_string($_POST['tanggal']);
	$jam = mysql_real_escape_string($_POST['jam']);
	$kesadaran = mysql_real_escape_string($_POST['kesadaran']);
	$td = mysql_real_escape_string($_POST['td']);
	$nadi = mysql_real_escape_string($_POST['nadi']);
	$respirasi = mysql_real_escape_string($_POST['respirasi']);
	$suhu = mysql_real_escape_string($_POST['suhu']);
	$obat_obatan = mysql_real_escape_string($_POST['obat_obatan']);
	$cairan = mysql_real_escape_string($_POST['cairan']);
	$keterangan = mysql_real_escape_string($_POST['keterangan']);
	$paska_bedah_kesadaran = mysql_real_escape_string($_POST['paska_bedah_kesadaran']);
	$paska_bedah_tekanan_darah = mysql_real_escape_string($_POST['paska_bedah_tekanan_darah']);
	$paska_bedah_nadi = mysql_real_escape_string($_POST['paska_bedah_nadi']);
	$paska_bedah_respirasi = mysql_real_escape_string($_POST['paska_bedah_respirasi']);
	$paska_bedah_suhu = mysql_real_escape_string($_POST['paska_bedah_suhu']);
	$paska_bedah_reaksi_alergi = mysql_real_escape_string($_POST['paska_bedah_reaksi_alergi']);
	$komplikasi_lain = mysql_real_escape_string($_POST['komplikasi_lain']);
	$pembuat_laporan = mysql_real_escape_string($_POST['pembuat_laporan']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);
	$id_user = mysql_real_escape_string($_POST['id_user']);

	$query = "INSERT INTO `rm_pemantauan_anestesi_lokal` (`id`,`tanggal_tindakan`,`diagnosa`,`nama_tindakan`,`pembedah`,`ruang_poli`,`riwayat_penyakit`,`riwayat_alergi`,`tanggal`,`jam`,`kesadaran`,`td`,`nadi`,`respirasi`,`suhu`,`obat_obatan`,`cairan`,`keterangan`,`paska_bedah_kesadaran`,`paska_bedah_tekanan_darah`,`paska_bedah_nadi`,`paska_bedah_respirasi`,`paska_bedah_suhu`,`paska_bedah_reaksi_alergi`,`komplikasi_lain`,`pembuat_laporan`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$tanggal_tindakan','$diagnosa','$nama_tindakan','$pembedah','$ruang_poli','$riwayat_penyakit','$riwayat_alergi','$tanggal','$jam','$kesadaran','$td','$nadi','$respirasi','$suhu','$obat_obatan','$cairan','$keterangan','$paska_bedah_kesadaran','$paska_bedah_tekanan_darah','$paska_bedah_nadi','$paska_bedah_respirasi','$paska_bedah_suhu','$paska_bedah_reaksi_alergi','$komplikasi_lain','$pembuat_laporan','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

	$tanggal_tindakan = mysql_real_escape_string($_POST['tanggal_tindakan']);
	$diagnosa = mysql_real_escape_string($_POST['diagnosa']);
	$nama_tindakan = mysql_real_escape_string($_POST['nama_tindakan']);
	$pembedah = mysql_real_escape_string($_POST['pembedah']);
	$ruang_poli = mysql_real_escape_string($_POST['ruang_poli']);
	$riwayat_penyakit = mysql_real_escape_string($_POST['riwayat_penyakit']);
	$riwayat_alergi = mysql_real_escape_string($_POST['riwayat_alergi']);
	$tanggal = mysql_real_escape_string($_POST['tanggal']);
	$jam = mysql_real_escape_string($_POST['jam']);
	$kesadaran = mysql_real_escape_string($_POST['kesadaran']);
	$td = mysql_real_escape_string($_POST['td']);
	$nadi = mysql_real_escape_string($_POST['nadi']);
	$respirasi = mysql_real_escape_string($_POST['respirasi']);
	$suhu = mysql_real_escape_string($_POST['suhu']);
	$obat_obatan = mysql_real_escape_string($_POST['obat_obatan']);
	$cairan = mysql_real_escape_string($_POST['cairan']);
	$keterangan = mysql_real_escape_string($_POST['keterangan']);
	$paska_bedah_kesadaran = mysql_real_escape_string($_POST['paska_bedah_kesadaran']);
	$paska_bedah_tekanan_darah = mysql_real_escape_string($_POST['paska_bedah_tekanan_darah']);
	$paska_bedah_nadi = mysql_real_escape_string($_POST['paska_bedah_nadi']);
	$paska_bedah_respirasi = mysql_real_escape_string($_POST['paska_bedah_respirasi']);
	$paska_bedah_suhu = mysql_real_escape_string($_POST['paska_bedah_suhu']);
	$paska_bedah_reaksi_alergi = mysql_real_escape_string($_POST['paska_bedah_reaksi_alergi']);
	$komplikasi_lain = mysql_real_escape_string($_POST['komplikasi_lain']);
	$pembuat_laporan = mysql_real_escape_string($_POST['pembuat_laporan']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);
	$id_user = mysql_real_escape_string($_POST['id_user']);

	$query = "UPDATE `rm_pemantauan_anestesi_lokal` SET `tanggal_tindakan` = '$tanggal_tindakan',`diagnosa` = '$diagnosa',`nama_tindakan` = '$nama_tindakan',`pembedah` = '$pembedah',`ruang_poli` = '$ruang_poli',`riwayat_penyakit` = '$riwayat_penyakit',`riwayat_alergi` = '$riwayat_alergi',`tanggal` = '$tanggal',`jam` = '$jam',`kesadaran` = '$kesadaran',`td` = '$td',`nadi` = '$nadi',`respirasi` = '$respirasi',`suhu` = '$suhu',`obat_obatan` = '$obat_obatan',`cairan` = '$cairan',`keterangan` = '$keterangan',`paska_bedah_kesadaran` = '$paska_bedah_kesadaran',`paska_bedah_tekanan_darah` = '$paska_bedah_tekanan_darah',`paska_bedah_nadi` = '$paska_bedah_nadi',`paska_bedah_respirasi` = '$paska_bedah_respirasi',`paska_bedah_suhu` = '$paska_bedah_suhu',`paska_bedah_reaksi_alergi` = '$paska_bedah_reaksi_alergi',`komplikasi_lain` = '$komplikasi_lain',`pembuat_laporan` = '$pembuat_laporan',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

	$query = "DELETE FROM `rm_pemantauan_anestesi_lokal` WHERE `id` = '$id'";
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