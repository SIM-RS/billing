<?php
session_start();

require_once '../../koneksi/konek.php';

$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
$idPasien = $sql['pasien_id'];
$idUser = $_REQUEST['idUser'];

function GetAll()
{


  $query = "SELECT * FROM rm_resume_rawat_jalan";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'tgl_resume' => $data['tgl_resume'],
      'resume' => $data['resume'],
      'alergi_resume' => $data['alergi_resume'],
      'tgl_kunjungan' => $data['tgl_kunjungan'],
      'klinik_dokter' => $data['klinik_dokter'],
      'diagnosis_kunjungan' => $data['diagnosis_kunjungan'],
      'terapi_kunjungan' => $data['terapi_kunjungan'],
      'ttd_nama_perawat' => $data['ttd_nama_perawat'],
      'verifikasi_ttd_dpjp' => $data['verifikasi_ttd_dpjp'],
      'id_kunjungan' => $data['id_kunjungan'],
      'id_pelayanan' => $data['id_pelayanan'],
      'id_pasien' => $data['id_pasien'],
      'id_user' => $data['id_user'],

    );
  }
  return $datas;
}
function GetWhere($idKunj, $idPasien)
{



  $query = "SELECT * FROM rm_resume_rawat_jalan WHERE id_kunjungan = '$idKunj' AND id_pasien= '$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'tgl_resume' => $data['tgl_resume'],
      'resume' => $data['resume'],
      'alergi_resume' => $data['alergi_resume'],
      'tgl_kunjungan' => $data['tgl_kunjungan'],
      'klinik_dokter' => $data['klinik_dokter'],
      'diagnosis_kunjungan' => $data['diagnosis_kunjungan'],
      'terapi_kunjungan' => $data['terapi_kunjungan'],
      'ttd_nama_perawat' => $data['ttd_nama_perawat'],
      'verifikasi_ttd_dpjp' => $data['verifikasi_ttd_dpjp'],
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

  $query = "SELECT * FROM  `rm_resume_rawat_jalan` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'tgl_resume' => $data['tgl_resume'],
      'resume' => $data['resume'],
      'alergi_resume' => $data['alergi_resume'],
      'tgl_kunjungan' => $data['tgl_kunjungan'],
      'klinik_dokter' => $data['klinik_dokter'],
      'diagnosis_kunjungan' => $data['diagnosis_kunjungan'],
      'terapi_kunjungan' => $data['terapi_kunjungan'],
      'ttd_nama_perawat' => $data['ttd_nama_perawat'],
      'verifikasi_ttd_dpjp' => $data['verifikasi_ttd_dpjp'],
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

  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $idUser = $_REQUEST['idUser'];
  $tgl_resume = mysql_real_escape_string($_POST['tgl_resume']);
  $resume = mysql_real_escape_string($_POST['resume']);
  $alergi_resume = mysql_real_escape_string($_POST['alergi_resume']);
  $tgl_kunjungan = mysql_real_escape_string($_POST['tgl_kunjungan']);
  $klinik_dokter = mysql_real_escape_string($_POST['klinik_dokter']);
  $diagnosis_kunjungan = mysql_real_escape_string($_POST['diagnosis_kunjungan']);
  $terapi_kunjungan = mysql_real_escape_string($_POST['terapi_kunjungan']);
  $ttd_nama_perawat = mysql_real_escape_string($_POST['ttd_nama_perawat']);
  $verifikasi_ttd_dpjp = mysql_real_escape_string($_POST['verifikasi_ttd_dpjp']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "INSERT INTO `rm_resume_rawat_jalan` (`id`,`tgl_resume`,`resume`,`alergi_resume`,`tgl_kunjungan`,`klinik_dokter`,`diagnosis_kunjungan`,`terapi_kunjungan`,`ttd_nama_perawat`,`verifikasi_ttd_dpjp`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`)
VALUES (NULL,'$tgl_resume','$resume','$alergi_resume','$tgl_kunjungan','$klinik_dokter','$diagnosis_kunjungan','$terapi_kunjungan','$ttd_nama_perawat','$verifikasi_ttd_dpjp','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user')";
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

  $tgl_resume = mysql_real_escape_string($_POST['tgl_resume']);
  $resume = mysql_real_escape_string($_POST['resume']);
  $alergi_resume = mysql_real_escape_string($_POST['alergi_resume']);
  $tgl_kunjungan = mysql_real_escape_string($_POST['tgl_kunjungan']);
  $klinik_dokter = mysql_real_escape_string($_POST['klinik_dokter']);
  $diagnosis_kunjungan = mysql_real_escape_string($_POST['diagnosis_kunjungan']);
  $terapi_kunjungan = mysql_real_escape_string($_POST['terapi_kunjungan']);
  $ttd_nama_perawat = mysql_real_escape_string($_POST['ttd_nama_perawat']);
  $verifikasi_ttd_dpjp = mysql_real_escape_string($_POST['verifikasi_ttd_dpjp']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_resume_rawat_jalan` SET `tgl_resume` = '$tgl_resume',`resume` = '$resume',`alergi_resume` = '$alergi_resume',`tgl_kunjungan` = '$tgl_kunjungan',`klinik_dokter` = '$klinik_dokter',`diagnosis_kunjungan` = '$diagnosis_kunjungan',`terapi_kunjungan` = '$terapi_kunjungan',`ttd_nama_perawat` = '$ttd_nama_perawat',`verifikasi_ttd_dpjp` = '$verifikasi_ttd_dpjp',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_resume_rawat_jalan` WHERE `id` = '$id'";
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