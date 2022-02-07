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


  $query = "SELECT * FROM rm_permintaan_laboratorium WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'klinis' => $data['klinis'],
      'diagnosis' => $data['diagnosis'],
      'darah_rutin' => $data['darah_rutin'],
      'anemia_profile' => $data['anemia_profile'],
      'haemorrhagic_test' => $data['haemorrhagic_test'],
      'faal_hati' => $data['faal_hati'],
      'faal_ginjal' => $data['faal_ginjal'],
      'metabolisme_karbohidra' => $data['metabolisme_karbohidra'],
      'urine' => $data['urine'],
      'thyroid' => $data['thyroid'],
      'lipid_profile' => $data['lipid_profile'],
      'arthritis_profile' => $data['arthritis_profile'],
      'elektrolit' => $data['elektrolit'],
      'feces' => $data['feces'],
      'pancreas' => $data['pancreas'],
      'myocard_infarct' => $data['myocard_infarct'],
      'vd_profile' => $data['vd_profile'],
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

  $query = "SELECT * FROM  `rm_permintaan_laboratorium` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'klinis' => $data['klinis'],
      'diagnosis' => $data['diagnosis'],
      'darah_rutin' => $data['darah_rutin'],
      'anemia_profile' => $data['anemia_profile'],
      'haemorrhagic_test' => $data['haemorrhagic_test'],
      'faal_hati' => $data['faal_hati'],
      'faal_ginjal' => $data['faal_ginjal'],
      'metabolisme_karbohidra' => $data['metabolisme_karbohidra'],
      'urine' => $data['urine'],
      'thyroid' => $data['thyroid'],
      'lipid_profile' => $data['lipid_profile'],
      'arthritis_profile' => $data['arthritis_profile'],
      'elektrolit' => $data['elektrolit'],
      'feces' => $data['feces'],
      'pancreas' => $data['pancreas'],
      'myocard_infarct' => $data['myocard_infarct'],
      'vd_profile' => $data['vd_profile'],
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
  $klinis = mysql_real_escape_string($_POST['klinis']);
  $diagnosis = mysql_real_escape_string($_POST['diagnosis']);
  $darah_rutin = mysql_real_escape_string($_POST['darah_rutin']);
  $anemia_profile = mysql_real_escape_string($_POST['anemia_profile']);
  $haemorrhagic_test = mysql_real_escape_string($_POST['haemorrhagic_test']);
  $faal_hati = mysql_real_escape_string($_POST['faal_hati']);
  $faal_ginjal = mysql_real_escape_string($_POST['faal_ginjal']);
  $metabolisme_karbohidra = mysql_real_escape_string($_POST['metabolisme_karbohidra']);
  $urine = mysql_real_escape_string($_POST['urine']);
  $thyroid = mysql_real_escape_string($_POST['thyroid']);
  $lipid_profile = mysql_real_escape_string($_POST['lipid_profile']);
  $arthritis_profile = mysql_real_escape_string($_POST['arthritis_profile']);
  $elektrolit = mysql_real_escape_string($_POST['elektrolit']);
  $feces = mysql_real_escape_string($_POST['feces']);
  $pancreas = mysql_real_escape_string($_POST['pancreas']);
  $myocard_infarct = mysql_real_escape_string($_POST['myocard_infarct']);
  $vd_profile = mysql_real_escape_string($_POST['vd_profile']);
  $lain_lain = mysql_real_escape_string($_POST['lain_lain']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "INSERT INTO `rm_permintaan_laboratorium` (`id`,`klinis`,`diagnosis`,`darah_rutin`,`anemia_profile`,`haemorrhagic_test`,`faal_hati`,`faal_ginjal`,`metabolisme_karbohidra`,`urine`,`thyroid`,`lipid_profile`,`arthritis_profile`,`elektrolit`,`feces`,`pancreas`,`myocard_infarct`,`vd_profile`,`lain_lain`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$klinis','$diagnosis','$darah_rutin','$anemia_profile','$haemorrhagic_test','$faal_hati','$faal_ginjal','$metabolisme_karbohidra','$urine','$thyroid','$lipid_profile','$arthritis_profile','$elektrolit','$feces','$pancreas','$myocard_infarct','$vd_profile','$lain_lain','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

  $klinis = mysql_real_escape_string($_POST['klinis']);
  $diagnosis = mysql_real_escape_string($_POST['diagnosis']);
  $darah_rutin = mysql_real_escape_string($_POST['darah_rutin']);
  $anemia_profile = mysql_real_escape_string($_POST['anemia_profile']);
  $haemorrhagic_test = mysql_real_escape_string($_POST['haemorrhagic_test']);
  $faal_hati = mysql_real_escape_string($_POST['faal_hati']);
  $faal_ginjal = mysql_real_escape_string($_POST['faal_ginjal']);
  $metabolisme_karbohidra = mysql_real_escape_string($_POST['metabolisme_karbohidra']);
  $urine = mysql_real_escape_string($_POST['urine']);
  $thyroid = mysql_real_escape_string($_POST['thyroid']);
  $lipid_profile = mysql_real_escape_string($_POST['lipid_profile']);
  $arthritis_profile = mysql_real_escape_string($_POST['arthritis_profile']);
  $elektrolit = mysql_real_escape_string($_POST['elektrolit']);
  $feces = mysql_real_escape_string($_POST['feces']);
  $pancreas = mysql_real_escape_string($_POST['pancreas']);
  $myocard_infarct = mysql_real_escape_string($_POST['myocard_infarct']);
  $vd_profile = mysql_real_escape_string($_POST['vd_profile']);
  $lain_lain = mysql_real_escape_string($_POST['lain_lain']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_permintaan_laboratorium` SET `klinis`= '$klinis',`diagnosis` = '$diagnosis',`anemia_profile` = '$anemia_profile',`haemorrhagic_test` = '$haemorrhagic_test',`faal_hati` = '$faal_hati',`faal_ginjal` = '$faal_ginjal',`metabolisme_karbohidra` = '$metabolisme_karbohidra',`urine` = '$urine',`thyroid` = '$thyroid',`lipid_profile` = '$lipid_profile',`arthritis_profile`='$arthritis_profile',`elektrolit` = '$elektrolit',`feces` = '$feces',`pancreas` = '$pancreas',`myocard_infarct` = '$myocard_infarct',`vd_profile` = '$vd_profile',`lain_lain` = '$lain_lain',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_permintaan_laboratorium` WHERE `id` = '$id'";
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