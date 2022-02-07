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


  $query = "SELECT * FROM rm_checklist_kesiapan_anestesi WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'ruangan' => $data['ruangan'],
      'diagnosis' => $data['diagnosis'],
      'jenis_operasi' => $data['jenis_operasi'],
      'teknik_anesthesi' => $data['teknik_anesthesi'],
      'tgl_tindakan' => $data['tgl_tindakan'],
      'listrik' => $data['listrik'],
      'gas_medis' => $data['gas_medis'],
      'mesin_anestesia' => $data['mesin_anestesia'],
      'manajemen_jalan_nafas' => $data['manajemen_jalan_nafas'],
      'pemantauan' => $data['pemantauan'],
      'lain_lain' => $data['lain_lain'],
      'obat_obat' => $data['obat_obat'],
      'penata_anesthesi' => $data['penata_anesthesi'],
      'dr_ahli_anesthesi' => $data['dr_ahli_anesthesi'],
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

  $query = "SELECT * FROM  `rm_checklist_kesiapan_anestesi` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'ruangan' => $data['ruangan'],
      'diagnosis' => $data['diagnosis'],
      'jenis_operasi' => $data['jenis_operasi'],
      'teknik_anesthesi' => $data['teknik_anesthesi'],
      'tgl_tindakan' => $data['tgl_tindakan'],
      'listrik' => $data['listrik'],
      'gas_medis' => $data['gas_medis'],
      'mesin_anestesia' => $data['mesin_anestesia'],
      'manajemen_jalan_nafas' => $data['manajemen_jalan_nafas'],
      'pemantauan' => $data['pemantauan'],
      'lain_lain' => $data['lain_lain'],
      'obat_obat' => $data['obat_obat'],
      'penata_anesthesi' => $data['penata_anesthesi'],
      'dr_ahli_anesthesi' => $data['dr_ahli_anesthesi'],
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
  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $diagnosis = mysql_real_escape_string($_POST['diagnosis']);
  $jenis_operasi = mysql_real_escape_string($_POST['jenis_operasi']);
  $teknik_anesthesi = mysql_real_escape_string($_POST['teknik_anesthesi']);
  $tgl_tindakan = mysql_real_escape_string($_POST['tgl_tindakan']);
  $listrik = mysql_real_escape_string($_POST['listrik']);
  $gas_medis = mysql_real_escape_string($_POST['gas_medis']);
  $mesin_anestesia = mysql_real_escape_string($_POST['mesin_anestesia']);
  $manajemen_jalan_nafas = mysql_real_escape_string($_POST['manajemen_jalan_nafas']);
  $pemantauan = mysql_real_escape_string($_POST['pemantauan']);
  $lain_lain = mysql_real_escape_string($_POST['lain_lain']);
  $obat_obat = mysql_real_escape_string($_POST['obat_obat']);
  $penata_anesthesi = mysql_real_escape_string($_POST['penata_anesthesi']);
  $dr_ahli_anesthesi = mysql_real_escape_string($_POST['dr_ahli_anesthesi']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "INSERT INTO `rm_checklist_kesiapan_anestesi` (`id`,`ruangan`,`diagnosis`,`jenis_operasi`,`teknik_anesthesi`,`tgl_tindakan`,`listrik`,`gas_medis`,`mesin_anestesia`,`manajemen_jalan_nafas`,`pemantauan`,`lain_lain`,`obat_obat`,`penata_anesthesi`,`dr_ahli_anesthesi`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$ruangan','$diagnosis','$jenis_operasi','$teknik_anesthesi','$tgl_tindakan','$listrik','$gas_medis','$mesin_anestesia','$manajemen_jalan_nafas','$pemantauan','$lain_lain','$obat_obat','$penata_anesthesi','$dr_ahli_anesthesi','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

  $ruangan = mysql_real_escape_string($_POST['ruangan']);
  $diagnosis = mysql_real_escape_string($_POST['diagnosis']);
  $jenis_operasi = mysql_real_escape_string($_POST['jenis_operasi']);
  $teknik_anesthesi = mysql_real_escape_string($_POST['teknik_anesthesi']);
  $tgl_tindakan = mysql_real_escape_string($_POST['tgl_tindakan']);
  $listrik = mysql_real_escape_string($_POST['listrik']);
  $gas_medis = mysql_real_escape_string($_POST['gas_medis']);
  $mesin_anestesia = mysql_real_escape_string($_POST['mesin_anestesia']);
  $manajemen_jalan_nafas = mysql_real_escape_string($_POST['manajemen_jalan_nafas']);
  $pemantauan = mysql_real_escape_string($_POST['pemantauan']);
  $lain_lain = mysql_real_escape_string($_POST['lain_lain']);
  $obat_obat = mysql_real_escape_string($_POST['obat_obat']);
  $penata_anesthesi = mysql_real_escape_string($_POST['penata_anesthesi']);
  $dr_ahli_anesthesi = mysql_real_escape_string($_POST['dr_ahli_anesthesi']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_checklist_kesiapan_anestesi` SET `ruangan` = '$ruangan',`diagnosis` = '$diagnosis',`jenis_operasi` = '$jenis_operasi',`teknik_anesthesi` = '$teknik_anesthesi',`tgl_tindakan` = '$tgl_tindakan',`listrik` = '$listrik',`gas_medis` = '$gas_medis',`mesin_anestesia` = '$mesin_anestesia',`manajemen_jalan_nafas` = '$manajemen_jalan_nafas',`pemantauan` = '$pemantauan',`lain_lain` = '$lain_lain',`obat_obat` = '$obat_obat',`penata_anesthesi` = '$penata_anesthesi',`dr_ahli_anesthesi` = '$dr_ahli_anesthesi',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_checklist_kesiapan_anestesi` WHERE `id` = '$id'";
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