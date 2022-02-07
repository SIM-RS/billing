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


	$query = "SELECT * FROM rm_laporan_operasi WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'ruang_operasi' => $data['ruang_operasi'],
			'kamar' => $data['kamar'],
			'akut_terencana' => $data['akut_terencana'],
			'tanggal' => $data['tanggal'],
			'pukul' => $data['pukul'],
			'pembedah' => $data['pembedah'],
			'ahli_anestesi' => $data['ahli_anestesi'],
			'asisten_1' => $data['asisten_1'],
			'asisten_2' => $data['asisten_2'],
			'perawat_instrument' => $data['perawat_instrument'],
			'jenis_anestesi' => $data['jenis_anestesi'],
			'diagnosa_pra_bedah' => $data['diagnosa_pra_bedah'],
			'indikasi_operasi' => $data['indikasi_operasi'],
			'diagnosa_pasca_bedah' => $data['diagnosa_pasca_bedah'],
			'nama_operasi' => $data['nama_operasi'],
			'desinfeksi_kulit_dengan' => $data['desinfeksi_kulit_dengan'],
			'jaringan_dieksisi' => $data['jaringan_dieksisi'],
			'dikirim_patologi_anatomi' => $data['dikirim_patologi_anatomi'],
			'jam_operasi_dimulai' => $data['jam_operasi_dimulai'],
			'jam_operasi_selesai' => $data['jam_operasi_selesai'],
			'lama_operasi_langsung' => $data['lama_operasi_langsung'],
			'jenis_bahan' => $data['jenis_bahan'],
			'pemeriksaan_laboratorium' => $data['pemeriksaan_laboratorium'],
			'macam_sayatan' => $data['macam_sayatan'],
			'posisi_penderita' => $data['posisi_penderita'],
			'teknik_operasi' => $data['teknik_operasi'],
			'temuan_intra_operasi' => $data['temuan_intra_operasi'],
			'penggunaan_amhp_khusus' => $data['penggunaan_amhp_khusus'],
			'jenis_amhp_khusus' => $data['jenis_amhp_khusus'],
			'jumlah_amhp_khusus' => $data['jumlah_amhp_khusus'],
			'komplikasi_intra_operasi' => $data['komplikasi_intra_operasi'],
			'perdarahan' => $data['perdarahan'],
			'penjabaran_komplikasi_intra_operasi' => $data['penjabaran_komplikasi_intra_operasi'],
			'kontrol_nadi' => $data['kontrol_nadi'],
			'kontrol_tensi' => $data['kontrol_tensi'],
			'kontrol_pernafasan' => $data['kontrol_pernafasan'],
			'kontrol_suhu' => $data['kontrol_suhu'],
			'puasa' => $data['puasa'],
			'drain' => $data['drain'],
			'infus' => $data['infus'],
			'obat_obatan' => $data['obat_obatan'],
			'ganti_balut' => $data['ganti_balut'],
			'lain_lain' => $data['lain_lain'],
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

	$query = "SELECT * FROM  `rm_laporan_operasi` WHERE  `id` =  '$id'";
	$exe = mysql_query($query);
	while ($data = mysql_fetch_array($exe)) {
		$datas[] = array(
			'id' => $data['id'],
			'ruang_operasi' => $data['ruang_operasi'],
			'kamar' => $data['kamar'],
			'akut_terencana' => $data['akut_terencana'],
			'tanggal' => $data['tanggal'],
			'pukul' => $data['pukul'],
			'pembedah' => $data['pembedah'],
			'ahli_anestesi' => $data['ahli_anestesi'],
			'asisten_1' => $data['asisten_1'],
			'asisten_2' => $data['asisten_2'],
			'perawat_instrument' => $data['perawat_instrument'],
			'jenis_anestesi' => $data['jenis_anestesi'],
			'diagnosa_pra_bedah' => $data['diagnosa_pra_bedah'],
			'indikasi_operasi' => $data['indikasi_operasi'],
			'diagnosa_pasca_bedah' => $data['diagnosa_pasca_bedah'],
			'nama_operasi' => $data['nama_operasi'],
			'desinfeksi_kulit_dengan' => $data['desinfeksi_kulit_dengan'],
			'jaringan_dieksisi' => $data['jaringan_dieksisi'],
			'dikirim_patologi_anatomi' => $data['dikirim_patologi_anatomi'],
			'jam_operasi_dimulai' => $data['jam_operasi_dimulai'],
			'jam_operasi_selesai' => $data['jam_operasi_selesai'],
			'lama_operasi_langsung' => $data['lama_operasi_langsung'],
			'jenis_bahan' => $data['jenis_bahan'],
			'pemeriksaan_laboratorium' => $data['pemeriksaan_laboratorium'],
			'macam_sayatan' => $data['macam_sayatan'],
			'posisi_penderita' => $data['posisi_penderita'],
			'teknik_operasi' => $data['teknik_operasi'],
			'temuan_intra_operasi' => $data['temuan_intra_operasi'],
			'penggunaan_amhp_khusus' => $data['penggunaan_amhp_khusus'],
			'jenis_amhp_khusus' => $data['jenis_amhp_khusus'],
			'jumlah_amhp_khusus' => $data['jumlah_amhp_khusus'],
			'komplikasi_intra_operasi' => $data['komplikasi_intra_operasi'],
			'perdarahan' => $data['perdarahan'],
			'penjabaran_komplikasi_intra_operasi' => $data['penjabaran_komplikasi_intra_operasi'],
			'kontrol_nadi' => $data['kontrol_nadi'],
			'kontrol_tensi' => $data['kontrol_tensi'],
			'kontrol_pernafasan' => $data['kontrol_pernafasan'],
			'kontrol_suhu' => $data['kontrol_suhu'],
			'puasa' => $data['puasa'],
			'drain' => $data['drain'],
			'infus' => $data['infus'],
			'obat_obatan' => $data['obat_obatan'],
			'ganti_balut' => $data['ganti_balut'],
			'lain_lain' => $data['lain_lain'],
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
	$ruang_operasi = mysql_real_escape_string($_POST['ruang_operasi']);
	$kamar = mysql_real_escape_string($_POST['kamar']);
	$akut_terencana = mysql_real_escape_string($_POST['akut_terencana']);
	$tanggal = mysql_real_escape_string($_POST['tanggal']);
	$pukul = mysql_real_escape_string($_POST['pukul']);
	$pembedah = mysql_real_escape_string($_POST['pembedah']);
	$ahli_anestesi = mysql_real_escape_string($_POST['ahli_anestesi']);
	$asisten_1 = mysql_real_escape_string($_POST['asisten_1']);
	$asisten_2 = mysql_real_escape_string($_POST['asisten_2']);
	$perawat_instrument = mysql_real_escape_string($_POST['perawat_instrument']);
	$jenis_anestesi = mysql_real_escape_string($_POST['jenis_anestesi']);
	$diagnosa_pra_bedah = mysql_real_escape_string($_POST['diagnosa_pra_bedah']);
	$indikasi_operasi = mysql_real_escape_string($_POST['indikasi_operasi']);
	$diagnosa_pasca_bedah = mysql_real_escape_string($_POST['diagnosa_pasca_bedah']);
	$nama_operasi = mysql_real_escape_string($_POST['nama_operasi']);
	$desinfeksi_kulit_dengan = mysql_real_escape_string($_POST['desinfeksi_kulit_dengan']);
	$jaringan_dieksisi = mysql_real_escape_string($_POST['jaringan_dieksisi']);
	$dikirim_patologi_anatomi = mysql_real_escape_string($_POST['dikirim_patologi_anatomi']);
	$jam_operasi_dimulai = mysql_real_escape_string($_POST['jam_operasi_dimulai']);
	$jam_operasi_selesai = mysql_real_escape_string($_POST['jam_operasi_selesai']);
	$lama_operasi_langsung = mysql_real_escape_string($_POST['lama_operasi_langsung']);
	$jenis_bahan = mysql_real_escape_string($_POST['jenis_bahan']);
	$pemeriksaan_laboratorium = mysql_real_escape_string($_POST['pemeriksaan_laboratorium']);
	$macam_sayatan = mysql_real_escape_string($_POST['macam_sayatan']);
	$posisi_penderita = mysql_real_escape_string($_POST['posisi_penderita']);
	$teknik_operasi = mysql_real_escape_string($_POST['teknik_operasi']);
	$temuan_intra_operasi = mysql_real_escape_string($_POST['temuan_intra_operasi']);
	$penggunaan_amhp_khusus = mysql_real_escape_string($_POST['penggunaan_amhp_khusus']);
	$jenis_amhp_khusus = mysql_real_escape_string($_POST['jenis_amhp_khusus']);
	$jumlah_amhp_khusus = mysql_real_escape_string($_POST['jumlah_amhp_khusus']);
	$komplikasi_intra_operasi = mysql_real_escape_string($_POST['komplikasi_intra_operasi']);
	$perdarahan = mysql_real_escape_string($_POST['perdarahan']);
	$penjabaran_komplikasi_intra_operasi = mysql_real_escape_string($_POST['penjabaran_komplikasi_intra_operasi']);
	$kontrol_nadi = mysql_real_escape_string($_POST['kontrol_nadi']);
	$kontrol_tensi = mysql_real_escape_string($_POST['kontrol_tensi']);
	$kontrol_pernafasan = mysql_real_escape_string($_POST['kontrol_pernafasan']);
	$kontrol_suhu = mysql_real_escape_string($_POST['kontrol_suhu']);
	$puasa = mysql_real_escape_string($_POST['puasa']);
	$drain = mysql_real_escape_string($_POST['drain']);
	$infus = mysql_real_escape_string($_POST['infus']);
	$obat_obatan = mysql_real_escape_string($_POST['obat_obatan']);
	$ganti_balut = mysql_real_escape_string($_POST['ganti_balut']);
	$lain_lain = mysql_real_escape_string($_POST['lain_lain']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);
	$id_user = mysql_real_escape_string($_POST['id_user']);

	$query = "INSERT INTO `rm_laporan_operasi` (`id`,`ruang_operasi`,`kamar`,`akut_terencana`,`tanggal`,`pukul`,`pembedah`,`ahli_anestesi`,`asisten_1`,`asisten_2`,`perawat_instrument`,`jenis_anestesi`,`diagnosa_pra_bedah`,`indikasi_operasi`,`diagnosa_pasca_bedah`,`nama_operasi`,`desinfeksi_kulit_dengan`,`jaringan_dieksisi`,`dikirim_patologi_anatomi`,`jam_operasi_dimulai`,`jam_operasi_selesai`,`lama_operasi_langsung`,`jenis_bahan`,`pemeriksaan_laboratorium`,`macam_sayatan`,`posisi_penderita`,`teknik_operasi`,`temuan_intra_operasi`,`penggunaan_amhp_khusus`,`jenis_amhp_khusus`,`jumlah_amhp_khusus`,`komplikasi_intra_operasi`,`perdarahan`,`penjabaran_komplikasi_intra_operasi`,`kontrol_nadi`,`kontrol_tensi`,`kontrol_pernafasan`,`kontrol_suhu`,`puasa`,`drain`,`infus`,`obat_obatan`,`ganti_balut`,`lain_lain`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$ruang_operasi','$kamar','$akut_terencana','$tanggal','$pukul','$pembedah','$ahli_anestesi','$asisten_1','$asisten_2','$perawat_instrument','$jenis_anestesi','$diagnosa_pra_bedah','$indikasi_operasi','$diagnosa_pasca_bedah','$nama_operasi','$desinfeksi_kulit_dengan','$jaringan_dieksisi','$dikirim_patologi_anatomi','$jam_operasi_dimulai','$jam_operasi_selesai','$lama_operasi_langsung','$jenis_bahan','$pemeriksaan_laboratorium','$macam_sayatan','$posisi_penderita','$teknik_operasi','$temuan_intra_operasi','$penggunaan_amhp_khusus','$jenis_amhp_khusus','$jumlah_amhp_khusus','$komplikasi_intra_operasi','$perdarahan','$penjabaran_komplikasi_intra_operasi','$kontrol_nadi','$kontrol_tensi','$kontrol_pernafasan','$kontrol_suhu','$puasa','$drain','$infus','$obat_obatan','$ganti_balut','$lain_lain','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

	$ruang_operasi = mysql_real_escape_string($_POST['ruang_operasi']);
	$kamar = mysql_real_escape_string($_POST['kamar']);
	$akut_terencana = mysql_real_escape_string($_POST['akut_terencana']);
	$tanggal = mysql_real_escape_string($_POST['tanggal']);
	$pukul = mysql_real_escape_string($_POST['pukul']);
	$pembedah = mysql_real_escape_string($_POST['pembedah']);
	$ahli_anestesi = mysql_real_escape_string($_POST['ahli_anestesi']);
	$asisten_1 = mysql_real_escape_string($_POST['asisten_1']);
	$asisten_2 = mysql_real_escape_string($_POST['asisten_2']);
	$perawat_instrument = mysql_real_escape_string($_POST['perawat_instrument']);
	$jenis_anestesi = mysql_real_escape_string($_POST['jenis_anestesi']);
	$diagnosa_pra_bedah = mysql_real_escape_string($_POST['diagnosa_pra_bedah']);
	$indikasi_operasi = mysql_real_escape_string($_POST['indikasi_operasi']);
	$diagnosa_pasca_bedah = mysql_real_escape_string($_POST['diagnosa_pasca_bedah']);
	$nama_operasi = mysql_real_escape_string($_POST['nama_operasi']);
	$desinfeksi_kulit_dengan = mysql_real_escape_string($_POST['desinfeksi_kulit_dengan']);
	$jaringan_dieksisi = mysql_real_escape_string($_POST['jaringan_dieksisi']);
	$dikirim_patologi_anatomi = mysql_real_escape_string($_POST['dikirim_patologi_anatomi']);
	$jam_operasi_dimulai = mysql_real_escape_string($_POST['jam_operasi_dimulai']);
	$jam_operasi_selesai = mysql_real_escape_string($_POST['jam_operasi_selesai']);
	$lama_operasi_langsung = mysql_real_escape_string($_POST['lama_operasi_langsung']);
	$jenis_bahan = mysql_real_escape_string($_POST['jenis_bahan']);
	$pemeriksaan_laboratorium = mysql_real_escape_string($_POST['pemeriksaan_laboratorium']);
	$macam_sayatan = mysql_real_escape_string($_POST['macam_sayatan']);
	$posisi_penderita = mysql_real_escape_string($_POST['posisi_penderita']);
	$teknik_operasi = mysql_real_escape_string($_POST['teknik_operasi']);
	$temuan_intra_operasi = mysql_real_escape_string($_POST['temuan_intra_operasi']);
	$penggunaan_amhp_khusus = mysql_real_escape_string($_POST['penggunaan_amhp_khusus']);
	$jenis_amhp_khusus = mysql_real_escape_string($_POST['jenis_amhp_khusus']);
	$jumlah_amhp_khusus = mysql_real_escape_string($_POST['jumlah_amhp_khusus']);
	$komplikasi_intra_operasi = mysql_real_escape_string($_POST['komplikasi_intra_operasi']);
	$perdarahan = mysql_real_escape_string($_POST['perdarahan']);
	$penjabaran_komplikasi_intra_operasi = mysql_real_escape_string($_POST['penjabaran_komplikasi_intra_operasi']);
	$kontrol_nadi = mysql_real_escape_string($_POST['kontrol_nadi']);
	$kontrol_tensi = mysql_real_escape_string($_POST['kontrol_tensi']);
	$kontrol_pernafasan = mysql_real_escape_string($_POST['kontrol_pernafasan']);
	$kontrol_suhu = mysql_real_escape_string($_POST['kontrol_suhu']);
	$puasa = mysql_real_escape_string($_POST['puasa']);
	$drain = mysql_real_escape_string($_POST['drain']);
	$infus = mysql_real_escape_string($_POST['infus']);
	$obat_obatan = mysql_real_escape_string($_POST['obat_obatan']);
	$ganti_balut = mysql_real_escape_string($_POST['ganti_balut']);
	$lain_lain = mysql_real_escape_string($_POST['lain_lain']);
	$id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
	$id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
	$id_pasien = mysql_real_escape_string($_POST['id_pasien']);
	$id_user = mysql_real_escape_string($_POST['id_user']);

	$query = "UPDATE `rm_laporan_operasi` SET `ruang_operasi` = '$ruang_operasi',`kamar` = '$kamar',`akut_terencana` = '$akut_terencana',`tanggal` = '$tanggal',`pukul` = '$pukul',`pembedah` = '$pembedah',`ahli_anestesi` = '$ahli_anestesi',`asisten_1` = '$asisten_1',`asisten_2` = '$asisten_2',`perawat_instrument` = '$perawat_instrument',`jenis_anestesi` = '$jenis_anestesi',`diagnosa_pra_bedah` = '$diagnosa_pra_bedah',`indikasi_operasi` = '$indikasi_operasi',`diagnosa_pasca_bedah` = '$diagnosa_pasca_bedah',`nama_operasi` = '$nama_operasi',`desinfeksi_kulit_dengan` = '$desinfeksi_kulit_dengan',`jaringan_dieksisi` = '$jaringan_dieksisi',`dikirim_patologi_anatomi` = '$dikirim_patologi_anatomi',`jam_operasi_dimulai` = '$jam_operasi_dimulai',`jam_operasi_selesai` = '$jam_operasi_selesai',`lama_operasi_langsung` = '$lama_operasi_langsung',`jenis_bahan` = '$jenis_bahan',`pemeriksaan_laboratorium` = '$pemeriksaan_laboratorium',`macam_sayatan` = '$macam_sayatan',`posisi_penderita` = '$posisi_penderita',`teknik_operasi` = '$teknik_operasi',`temuan_intra_operasi` = '$temuan_intra_operasi',`penggunaan_amhp_khusus` = '$penggunaan_amhp_khusus',`jenis_amhp_khusus` = '$jenis_amhp_khusus',`jumlah_amhp_khusus` = '$jumlah_amhp_khusus',`komplikasi_intra_operasi` = '$komplikasi_intra_operasi',`perdarahan` = '$perdarahan',`penjabaran_komplikasi_intra_operasi` = '$penjabaran_komplikasi_intra_operasi',`kontrol_nadi` = '$kontrol_nadi',`kontrol_tensi` = '$kontrol_tensi',`kontrol_pernafasan` = '$kontrol_pernafasan',`kontrol_suhu` = '$kontrol_suhu',`puasa` = '$puasa',`drain` = '$drain',`infus` = '$infus',`obat_obatan` = '$obat_obatan',`ganti_balut` = '$ganti_balut',`lain_lain` = '$lain_lain',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

	$query = "DELETE FROM `rm_laporan_operasi` WHERE `id` = '$id'";
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