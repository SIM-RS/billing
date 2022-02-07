<?php
session_start();
include("../../koneksi/konek.php");
$idKunj = $_REQUEST['idKunj'];
$idPel = $_REQUEST['idPel'];

$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));
$idPasien = $sql['pasien_id'];
$idUser = $_REQUEST['idUser'];

function GetAll($idPasien)
{


  $query = "SELECT * FROM rm_assesmen_nyeri_non_farmakologi WHERE id_pasien = '$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],

      'ruangan' => $data['ruangan'],
      'tgl_jam' => $data['tgl_jam'],
      'provokatif' => $data['provokatif'],
      'quality' => $data['quality'],
      'regio' => $data['regio'],
      'severity' => $data['severity'],
      'tempo' => $data['tempo'],
      'tindakan_lanjut' => $data['tindakan_lanjut'],
      'paraf_nama' => $data['paraf_nama'],
      'id_kunjungan' => $data['id_kunjungan'],
      'id_pelayanan' => $data['id_pelayanan'],
      'id_pasien' => $data['id_pasien'],

    );
  }
  return $datas;
}

function GetOne($id)
{

  $query = "SELECT * FROM  `rm_assesmen_nyeri_non_farmakologi` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],

      'ruangan' => $data['ruangan'],
      'tgl_jam' => $data['tgl_jam'],
      'provokatif' => $data['provokatif'],
      'quality' => $data['quality'],
      'regio' => $data['regio'],
      'severity' => $data['severity'],
      'tempo' => $data['tempo'],
      'tindakan_lanjut' => $data['tindakan_lanjut'],
      'paraf_nama' => $data['paraf_nama'],
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
  $tgl_jam = date('d-m-yy h:i:s');
  $provokatif = mysql_real_escape_string($_POST['provokatif']);
  $quality = mysql_real_escape_string($_POST['quality']);
  $regio = mysql_real_escape_string($_POST['regio']);
  $severity = mysql_real_escape_string($_POST['severity']);
  $tempo = mysql_real_escape_string($_POST['tempo']);
  $tindakan_lanjut = mysql_real_escape_string($_POST['tindakan_lanjut']);
  $paraf_nama = '';
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "INSERT INTO `rm_assesmen_nyeri_non_farmakologi` (`id`,`ruangan`,`tgl_jam`,`provokatif`,`quality`,`regio`,`severity`,`tempo`,`tindakan_lanjut`,`paraf_nama`,`id_kunjungan`,`id_pelayanan`,`id_pasien`)
VALUES (NULL,'$ruangan','$tgl_jam','$provokatif','$quality','$regio','$severity','$tempo','$tindakan_lanjut','$paraf_nama','$id_kunjungan','$id_pelayanan','$id_pasien')";
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
  $tgl_jam = date('d-m-yy h:i:s');
  $provokatif = mysql_real_escape_string($_POST['provokatif']);
  $quality = mysql_real_escape_string($_POST['quality']);
  $regio = mysql_real_escape_string($_POST['regio']);
  $severity = mysql_real_escape_string($_POST['severity']);
  $tempo = mysql_real_escape_string($_POST['tempo']);
  $tindakan_lanjut = mysql_real_escape_string($_POST['tindakan_lanjut']);
  $paraf_nama = '';
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "UPDATE `rm_assesmen_nyeri_non_farmakologi` SET `ruangan` = '$ruangan',`tgl_jam` = '$tgl_jam',`provokatif` = '$provokatif',`quality` = '$quality',`regio` = '$regio',`severity` = '$severity',`tempo` = '$tempo',`tindakan_lanjut` = '$tindakan_lanjut',`paraf_nama` = '$paraf_nama',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_assesmen_nyeri_non_farmakologi` WHERE `id` = '$id'";
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