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


  $query = "SELECT * FROM rm_surat_pernyataan_umum_bpjs WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'nama' => $data['nama'],
      'umur' => $data['umur'],
      'alamat' => $data['alamat'],
      'no_hp' => $data['no_hp'],
      'hubungan' => $data['hubungan'],
      'diagnosa_pasien' => $data['diagnosa_pasien'],
      'case_manager' => $data['case_manager'],
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

  $query = "SELECT * FROM  `rm_surat_pernyataan_umum_bpjs` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'nama' => $data['nama'],
      'umur' => $data['umur'],
      'alamat' => $data['alamat'],
      'no_hp' => $data['no_hp'],
      'hubungan' => $data['hubungan'],
      'diagnosa_pasien' => $data['diagnosa_pasien'],
      'case_manager' => $data['case_manager'],
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
  $nama = mysql_real_escape_string($_POST['nama']);
  $umur = mysql_real_escape_string($_POST['umur']);
  $alamat = mysql_real_escape_string($_POST['alamat']);
  $no_hp = mysql_real_escape_string($_POST['no_hp']);
  $hubungan = mysql_real_escape_string($_POST['hubungan']);
  $diagnosa_pasien = mysql_real_escape_string($_POST['diagnosa_pasien']);
  $case_manager = mysql_real_escape_string($_POST['case_manager']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "INSERT INTO `rm_surat_pernyataan_umum_bpjs` (`id`,`nama`,`umur`,`alamat`,`no_hp`,`hubungan`,`diagnosa_pasien`,`case_manager`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$nama','$umur','$alamat','$no_hp','$hubungan','$diagnosa_pasien','$case_manager','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

  $nama = mysql_real_escape_string($_POST['nama']);
  $umur = mysql_real_escape_string($_POST['umur']);
  $alamat = mysql_real_escape_string($_POST['alamat']);
  $no_hp = mysql_real_escape_string($_POST['no_hp']);
  $hubungan = mysql_real_escape_string($_POST['hubungan']);
  $diagnosa_pasien = mysql_real_escape_string($_POST['diagnosa_pasien']);
  $case_manager = mysql_real_escape_string($_POST['case_manager']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_surat_pernyataan_umum_bpjs` SET `nama` = '$nama',`umur` = '$umur',`alamat` = '$alamat',`no_hp` = '$no_hp',`hubungan` = '$hubungan',`diagnosa_pasien` = '$diagnosa_pasien',`case_manager` = '$case_manager',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_surat_pernyataan_umum_bpjs` WHERE `id` = '$id'";
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