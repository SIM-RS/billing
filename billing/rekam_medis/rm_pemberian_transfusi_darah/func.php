<?php
session_start();
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];
include("../../koneksi/konek.php");
$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
$idPasien = $sql['pasien_id'];
$idUser = $_REQUEST['idUser'];
date_default_timezone_set('Asia/Jakarta');

function GetAll($idKunj, $idPasien)
{


  $query = "SELECT * FROM rm_pemberian_transfusi_darah WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'dokter_pelaksana_tindakan' => $data['dokter_pelaksana_tindakan'],
      'pemberi_informasi' => $data['pemberi_informasi'],
      'penerima_informasi' => $data['penerima_informasi'],
      'dasar_diagnosis' => $data['dasar_diagnosis'],
      'indikasi_tindakan' => $data['indikasi_tindakan'],
      'biaya_pengelolaan' => $data['biaya_pengelolaan'],
      'nama_dokter' => $data['nama_dokter'],
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

  $query = "SELECT * FROM  `rm_pemberian_transfusi_darah` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'dokter_pelaksana_tindakan' => $data['dokter_pelaksana_tindakan'],
      'pemberi_informasi' => $data['pemberi_informasi'],
      'penerima_informasi' => $data['penerima_informasi'],
      'dasar_diagnosis' => $data['dasar_diagnosis'],
      'indikasi_tindakan' => $data['indikasi_tindakan'],
      'biaya_pengelolaan' => $data['biaya_pengelolaan'],
      'nama_dokter' => $data['nama_dokter'],
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
  $dokter_pelaksana_tindakan = mysql_real_escape_string($_POST['dokter_pelaksana_tindakan']);
  $pemberi_informasi = mysql_real_escape_string($_POST['pemberi_informasi']);
  $penerima_informasi = mysql_real_escape_string($_POST['penerima_informasi']);
  $dasar_diagnosis = mysql_real_escape_string($_POST['dasar_diagnosis']);
  $indikasi_tindakan = mysql_real_escape_string($_POST['indikasi_tindakan']);
  $biaya_pengelolaan = mysql_real_escape_string($_POST['biaya_pengelolaan']);
  $nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

//   $query = "INSERT INTO `rm_pemberian_transfusi_darah` (`id`,`dokter_pelaksana_tindakan`,`pemberi_informasi`,`penerima_informasi`,`dasar_diagnosis`,`indikasi_tindakan`,`biaya_pengelolaan`,`nama_dokter`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
// VALUES (NULL,'$dokter_pelaksana_tindakan','$pemberi_informasi','$penerima_informasi','$dasar_diagnosis','$indikasi_tindakan','$biaya_pengelolaan','$nama_dokter','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";

$query = "INSERT INTO `rm_pemberian_transfusi_darah` (`id`,`dokter_pelaksana_tindakan`,`pemberi_informasi`,`penerima_informasi`, `id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$dokter_pelaksana_tindakan','$pemberi_informasi','$penerima_informasi','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";

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

  $dokter_pelaksana_tindakan = mysql_real_escape_string($_POST['dokter_pelaksana_tindakan']);
  $pemberi_informasi = mysql_real_escape_string($_POST['pemberi_informasi']);
  $penerima_informasi = mysql_real_escape_string($_POST['penerima_informasi']);
  $dasar_diagnosis = mysql_real_escape_string($_POST['dasar_diagnosis']);
  $indikasi_tindakan = mysql_real_escape_string($_POST['indikasi_tindakan']);
  $biaya_pengelolaan = mysql_real_escape_string($_POST['biaya_pengelolaan']);
  $nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_pemberian_transfusi_darah` SET `dokter_pelaksana_tindakan` = '$dokter_pelaksana_tindakan',`pemberi_informasi` = '$pemberi_informasi',`penerima_informasi` = '$penerima_informasi',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_pemberian_transfusi_darah` WHERE `id` = '$id'";
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