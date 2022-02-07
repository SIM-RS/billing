<?php
session_start();
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];
include("../../koneksi/konek.php");
$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
$idPasien = $sql['pasien_id'];
$idUser = $_REQUEST['idUser'];

function GetAll()
{


  $query = "SELECT * FROM rm_lokasi_penandaan_operasi";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'prosedur' => $data['prosedur'],
      'tanggal_prosedur' => $data['tanggal_prosedur'],
      'nama_pasien' => $data['nama_pasien'],
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

  $query = "SELECT * FROM  `rm_lokasi_penandaan_operasi` WHERE  `id` =  '$id'";

  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'prosedur' => $data['prosedur'],
      'tanggal_prosedur' => $data['tanggal_prosedur'],
      'nama_pasien' => $data['nama_pasien'],
      'nama_dokter' => $data['nama_dokter'],
      'id_kunjungan' => $data['id_kunjungan'],
      'id_pelayanan' => $data['id_pelayanan'],
      'id_pasien' => $data['id_pasien'],

    );
  }
  return $datas;
}
function GetWhere($idKunj, $idPasien)
{

  $query = "SELECT * FROM  `rm_lokasi_penandaan_operasi` WHERE  `id_kunjungan` =  '$idKunj' AND `id_pasien` =  '$idPasien'";

  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'prosedur' => $data['prosedur'],
      'tanggal_prosedur' => $data['tanggal_prosedur'],
      'nama_pasien' => $data['nama_pasien'],
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

  $prosedur = mysql_real_escape_string($_POST['prosedur']);
  $tanggal_prosedur = mysql_real_escape_string($_POST['tanggal_prosedur']);
  $nama_pasien = mysql_real_escape_string($_POST['nama_pasien']);
  $nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "INSERT INTO `rm_lokasi_penandaan_operasi` (`id`,`prosedur`,`tanggal_prosedur`,`nama_pasien`,`nama_dokter`,`id_kunjungan`,`id_pelayanan`,`id_pasien`)
VALUES (NULL,'$prosedur','$tanggal_prosedur','$nama_pasien','$nama_dokter','$id_kunjungan','$id_pelayanan','$id_pasien')";
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

  $prosedur = mysql_real_escape_string($_POST['prosedur']);
  $tanggal_prosedur = mysql_real_escape_string($_POST['tanggal_prosedur']);
  $nama_pasien = mysql_real_escape_string($_POST['nama_pasien']);
  $nama_dokter = mysql_real_escape_string($_POST['nama_dokter']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "UPDATE `rm_lokasi_penandaan_operasi` SET `prosedur` = '$prosedur',`tanggal_prosedur` = '$tanggal_prosedur',`nama_pasien` = '$nama_pasien',`nama_dokter` = '$nama_dokter',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_lokasi_penandaan_operasi` WHERE `id` = '$id'";
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