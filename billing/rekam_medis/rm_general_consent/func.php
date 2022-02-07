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


  $query = "SELECT * FROM rm_general_consent WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'nama' => $data['nama'],
      'alamat' => $data['alamat'],
      'hubungan_pasien' => $data['hubungan_pasien'],
      'no_telp' => $data['no_telp'],
      'no_identitas' => $data['no_identitas'],
      'hasil_diagnosis' => $data['hasil_diagnosis'],
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

  $query = "SELECT * FROM  `rm_general_consent` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'nama' => $data['nama'],
      'alamat' => $data['alamat'],
      'hubungan_pasien' => $data['hubungan_pasien'],
      'no_telp' => $data['no_telp'],
      'no_identitas' => $data['no_identitas'],
      'hasil_diagnosis' => $data['hasil_diagnosis'],
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
  $alamat = mysql_real_escape_string($_POST['alamat']);
  $hubungan_pasien = mysql_real_escape_string($_POST['hubungan_pasien']);
  $no_telp = mysql_real_escape_string($_POST['no_telp']);
  $no_identitas = mysql_real_escape_string($_POST['no_identitas']);
  $hasil_diagnosis = mysql_real_escape_string($_POST['hasil_diagnosis']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "INSERT INTO `rm_general_consent` (`id`,`nama`,`alamat`,`hubungan_pasien`,`no_telp`,`no_identitas`,`hasil_diagnosis`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$nama','$alamat','$hubungan_pasien','$no_telp','$no_identitas','$hasil_diagnosis','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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
  $alamat = mysql_real_escape_string($_POST['alamat']);
  $hubungan_pasien = mysql_real_escape_string($_POST['hubungan_pasien']);
  $no_telp = mysql_real_escape_string($_POST['no_telp']);
  $no_identitas = mysql_real_escape_string($_POST['no_identitas']);
  $hasil_diagnosis = mysql_real_escape_string($_POST['hasil_diagnosis']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_general_consent` SET `nama` = '$nama',`alamat` = '$alamat',`hubungan_pasien` = '$hubungan_pasien',`no_telp` = '$no_telp',`no_identitas` = '$no_identitas',`hasil_diagnosis` = '$hasil_diagnosis',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_general_consent` WHERE `id` = '$id'";
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