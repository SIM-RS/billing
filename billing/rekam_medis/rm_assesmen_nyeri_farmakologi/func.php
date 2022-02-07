<?php
session_start();

include("../../koneksi/konek.php");
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
$idPasien = $sql['pasien_id'];
$idUser = $_REQUEST['idUser'];

date_default_timezone_set('Asia/Jakarta');

function GetAll($idKunj, $idPasien)
{


  $query = "SELECT * FROM rm_assesmen_nyeri_farmakologi WHERE id_kunjungan = '$idKunj' AND id_pasien = '$idPasien' ";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'ruangan' => $data['ruangan'],
      'hari_tanggal' => $data['hari_tanggal'],
      'skala_nyeri_pertama' => $data['skala_nyeri_pertama'],
      'waktu_jam_pertama' => $data['waktu_jam_pertama'],
      'intervensi_yang_diberikan' => $data['intervensi_yang_diberikan'],
      'waktu_jam_kedua' => $data['waktu_jam_kedua'],
      'skala_nyeri_kedua' => $data['skala_nyeri_kedua'],
      'paraf' => $data['paraf'],
      'id_kunjungan' => $data['id_kunjungan'],
      'id_pelayanan' => $data['id_pelayanan'],
      'id_pasien' => $data['id_pasien'],

    );
  }
  return $datas;
}

function GetOne($id)
{

  $query = "SELECT * FROM  `rm_assesmen_nyeri_farmakologi` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'ruangan' => $data['ruangan'],
      'hari_tanggal' => $data['hari_tanggal'],
      'skala_nyeri_pertama' => $data['skala_nyeri_pertama'],
      'waktu_jam_pertama' => $data['waktu_jam_pertama'],
      'intervensi_yang_diberikan' => $data['intervensi_yang_diberikan'],
      'waktu_jam_kedua' => $data['waktu_jam_kedua'],
      'skala_nyeri_kedua' => $data['skala_nyeri_kedua'],
      'paraf' => $data['paraf'],
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
  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $hari_tanggal = hari_ini() . "," . date('d-m-yy');
  $skala_nyeri_pertama = mysql_real_escape_string($_POST['skala_nyeri_pertama']);
  $waktu_jam_pertama = date('h:i:s');
  $intervensi_yang_diberikan = mysql_real_escape_string($_POST['intervensi_yang_diberikan']);
  $waktu_jam_kedua = date('h:i:s');
  $skala_nyeri_kedua = mysql_real_escape_string($_POST['skala_nyeri_kedua']);
  $paraf = '';
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "INSERT INTO `rm_assesmen_nyeri_farmakologi` (`id`,`ruangan`,`hari_tanggal`,`skala_nyeri_pertama`,`waktu_jam_pertama`,`intervensi_yang_diberikan`,`waktu_jam_kedua`,`skala_nyeri_kedua`,`paraf`,`id_kunjungan`,`id_pelayanan`,`id_pasien`)
VALUES (NULL,'$ruangan','$hari_tanggal','$skala_nyeri_pertama','$waktu_jam_pertama','$intervensi_yang_diberikan','$waktu_jam_kedua','$skala_nyeri_kedua','$paraf','$id_kunjungan','$id_pelayanan','$id_pasien')";
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

  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $hari_tanggal = hari_ini() . "," . date('d-m-yy');
  $skala_nyeri_pertama = mysql_real_escape_string($_POST['skala_nyeri_pertama']);
  $waktu_jam_pertama = date('h:i:s');
  $intervensi_yang_diberikan = mysql_real_escape_string($_POST['intervensi_yang_diberikan']);
  $waktu_jam_kedua = date('h:i:s');
  $skala_nyeri_kedua = mysql_real_escape_string($_POST['skala_nyeri_kedua']);
  $paraf = '';
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "UPDATE `rm_assesmen_nyeri_farmakologi` SET `ruangan`= '$ruangan',`hari_tanggal` = '$hari_tanggal',`skala_nyeri_pertama` = '$skala_nyeri_pertama',`waktu_jam_pertama` = '$waktu_jam_pertama',`intervensi_yang_diberikan` = '$intervensi_yang_diberikan',`waktu_jam_kedua` = '$waktu_jam_kedua',`skala_nyeri_kedua` = '$skala_nyeri_kedua',`paraf` = '$paraf',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_assesmen_nyeri_farmakologi` WHERE `id` = '$id'";
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
  Update($_POST['id']);
} else if (isset($_POST['delete'])) {
  Delete($_POST['id']);
}