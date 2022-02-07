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


  $query = "SELECT * FROM rm_persetujuan_penolakan_tindakan_transfusi WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'dpjp' => $data['dpjp'],
      'pemberi_informasi' => $data['pemberi_informasi'],
      'penerima_informasi' => $data['penerima_informasi'],
      'diagnosis_wd_dan_dd' => $data['diagnosis_wd_dan_dd'],
      'dasar_diagnosis' => $data['dasar_diagnosis'],
      'tindakan_kedokteran' => $data['tindakan_kedokteran'],
      'indikasi_tindakan' => $data['indikasi_tindakan'],
      'tata_cara' => $data['tata_cara'],
      'tujuan' => $data['tujuan'],
      'risiko' => $data['risiko'],
      'komplikasi' => $data['komplikasi'],
      'prognosis' => $data['prognosis'],
      'alternatif_risiko' => $data['alternatif_risiko'],
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

  $query = "SELECT * FROM  `rm_persetujuan_penolakan_tindakan_transfusi` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'dpjp' => $data['dokter_pelaksana_tindakan'],
      'pemberi_informasi' => $data['pemberi_informasi'],
      'penerima_informasi' => $data['penerima_informasi'],
      'diagnosis_wd_dan_dd' => $data['diagnosis_wd_dan_dd'],
      'dasar_diagnosis' => $data['dasar_diagnosis'],
      'tindakan_kedokteran' => $data['tindakan_kedokteran'],
      'indikasi_tindakan' => $data['indikasi_tindakan'],
      'tata_cara' => $data['tata_cara'],
      'tujuan' => $data['tujuan'],
      'risiko' => $data['risiko'],
      'komplikasi' => $data['komplikasi'],
      'prognosis' => $data['prognosis'],
      'alternatif_risiko' => $data['alternatif_risiko'],
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


  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $idUser = $_REQUEST['idUser'];
  $dpjp = mysql_real_escape_string($_POST['dpjp']);
  $pemberi_informasi = mysql_real_escape_string($_POST['pemberi_informasi']);
  $penerima_informasi = mysql_real_escape_string($_POST['penerima_informasi']);
  $diagnosis_wd_dan_dd = mysql_real_escape_string($_POST['diagnosis_wd_dan_dd']);
  $dasar_diagnosis = mysql_real_escape_string($_POST['dasar_diagnosis']);
  $tindakan_kedokteran = mysql_real_escape_string($_POST['tindakan_kedokteran']);
  $indikasi_tindakan = mysql_real_escape_string($_POST['indikasi_tindakan']);
  $tata_cara = mysql_real_escape_string($_POST['tata_cara']);
  $tujuan = mysql_real_escape_string($_POST['tujuan']);
  $risiko = mysql_real_escape_string($_POST['risiko']);
  $komplikasi = mysql_real_escape_string($_POST['komplikasi']);
  $prognosis = mysql_real_escape_string($_POST['prognosis']);
  $alternatif_risiko = mysql_real_escape_string($_POST['alternatif_risiko']);
  $lain_lain = mysql_real_escape_string($_POST['lain_lain']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

//   $query = "INSERT INTO `rm_persetujuan_penolakan_tindakan_transfusi` (`id`,`dpjp`,`pemberi_informasi`,`penerima_informasi`,`diagnosis_wd_dan_dd`,`dasar_diagnosis`,`tindakan_kedokteran`,`indikasi_tindakan`,`tata_cara`,`tujuan`,`risiko`,`komplikasi`,`prognosis`,`alternatif_risiko`,`lain_lain`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`,  `tgl_act`)
// VALUES (NULL,'$dpjp','$pemberi_informasi','$penerima_informasi','$diagnosis_wd_dan_dd','$dasar_diagnosis','$tindakan_kedokteran','$indikasi_tindakan','$tata_cara','$tujuan','$risiko','$komplikasi','$prognosis','$alternatif_risiko','$lain_lain','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";

  $query = "INSERT INTO `rm_persetujuan_penolakan_tindakan_transfusi` (`id`,`dokter_pelaksana_tindakan`,`pemberi_informasi`,`penerima_informasi`,`diagnosis_wd_dan_dd`,`dasar_diagnosis`,`tindakan_kedokteran`,`indikasi_tindakan`,`tata_cara`,`tujuan`,`risiko`,`komplikasi`,`prognosis`,`alternatif_risiko`,`lain_lain`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`,  `tgl_act`)
VALUES (NULL,'$dpjp','$pemberi_informasi','$penerima_informasi','$diagnosis_wd_dan_dd','$dasar_diagnosis','$tindakan_kedokteran','$indikasi_tindakan','$tata_cara','$tujuan','$risiko','$komplikasi','$prognosis','$alternatif_risiko','$lain_lain','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";

  $exe = mysql_query($query);
  if ($exe) {
    // kalau berhasil
    $_SESSION['message'] = " Data Telah disimpan ";
    $_SESSION['mType'] = "success ";

    header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  } else {
    $_SESSION['message'] = " Data Gagal disimpan ";
    $_SESSION['mType'] = "danger ";
    var_dump($_POST);
    header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
}
function Update($id)
{


  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $idUser = $_REQUEST['idUser'];

  $dpjp = mysql_real_escape_string($_POST['dpjp']);
  $pemberi_informasi = mysql_real_escape_string($_POST['pemberi_informasi']);
  $penerima_informasi = mysql_real_escape_string($_POST['penerima_informasi']);
  $diagnosis_wd_dan_dd = mysql_real_escape_string($_POST['diagnosis_wd_dan_dd']);
  $dasar_diagnosis = mysql_real_escape_string($_POST['dasar_diagnosis']);
  $tindakan_kedokteran = mysql_real_escape_string($_POST['tindakan_kedokteran']);
  $indikasi_tindakan = mysql_real_escape_string($_POST['indikasi_tindakan']);
  $tata_cara = mysql_real_escape_string($_POST['tata_cara']);
  $tujuan = mysql_real_escape_string($_POST['tujuan']);
  $risiko = mysql_real_escape_string($_POST['risiko']);
  $komplikasi = mysql_real_escape_string($_POST['komplikasi']);
  $prognosis = mysql_real_escape_string($_POST['prognosis']);
  $alternatif_risiko = mysql_real_escape_string($_POST['alternatif_risiko']);
  $lain_lain = mysql_real_escape_string($_POST['lain_lain']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);
  $id_user = mysql_real_escape_string($_POST['id_user']);

  $query = "UPDATE `rm_persetujuan_penolakan_tindakan_transfusi` SET `dpjp` = '$dpjp',`pemberi_informasi` = '$pemberi_informasi',`penerima_informasi` = '$penerima_informasi',`diagnosis_wd_dan_dd` = '$diagnosis_wd_dan_dd',`dasar_diagnosis` = '$dasar_diagnosis',`tindakan_kedokteran` = '$tindakan_kedokteran',`indikasi_tindakan` = '$indikasi_tindakan',`tata_cara` = '$tata_cara',`tujuan` = '$tujuan',`risiko` = '$risiko',`komplikasi` = '$komplikasi',`prognosis` = '$prognosis',`alternatif_risiko` = '$alternatif_risiko',`lain_lain` = '$lain_lain',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_persetujuan_penolakan_tindakan_transfusi` WHERE `id` = '$id'";
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