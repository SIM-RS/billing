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


  $query = "SELECT * FROM rm_checklist_rencana_pulang WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'aktifitas' => $data['aktifitas'],
      'catatan_aktifitas' => $data['catatan_aktifitas'],
      'pemberian_obat_dirumah' => $data['pemberian_obat_dirumah'],
      'catatan_pemberian_obat_dirumah' => $data['catatan_pemberian_obat_dirumah'],
      'fasilitas_kesehatan' => $data['fasilitas_kesehatan'],
      'catatan_fasilitas_kesehatan' => $data['catatan_fasilitas_kesehatan'],
      'hasil_pemeriksaan_penunjang' => $data['hasil_pemeriksaan_penunjang'],
      'catatan_hasil_pemeriksaan_penunjang' => $data['catatan_hasil_pemeriksaan_penunjang'],
      'kontrol_selanjutnya' => $data['kontrol_selanjutnya'],
      'catatan_kontrol_selanjutnya' => $data['catatan_kontrol_selanjutnya'],
      'diet' => $data['diet'],
      'catatan_diet' => $data['catatan_diet'],
      'edukasi_dan_latihan' => $data['edukasi_dan_latihan'],
      'catatan_edukasi_dan_latihan' => $data['catatan_edukasi_dan_latihan'],
      'rincian_pemulangan' => $data['rincian_pemulangan'],
      'id_kunjungan' => $data['id_kunjungan'],
      'id_pelayanan' => $data['id_pelayanan'],
      'id_pasien' => $data['id_pasien'],

    );
  }
  return $datas;
}

function GetOne($id)
{

  $query = "SELECT * FROM  `rm_checklist_rencana_pulang` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while ($data = mysql_fetch_array($exe)) {
    $datas[] = array(
      'id' => $data['id'],
      'aktifitas' => $data['aktifitas'],
      'catatan_aktifitas' => $data['catatan_aktifitas'],
      'pemberian_obat_dirumah' => $data['pemberian_obat_dirumah'],
      'catatan_pemberian_obat_dirumah' => $data['catatan_pemberian_obat_dirumah'],
      'fasilitas_kesehatan' => $data['fasilitas_kesehatan'],
      'catatan_fasilitas_kesehatan' => $data['catatan_fasilitas_kesehatan'],
      'hasil_pemeriksaan_penunjang' => $data['hasil_pemeriksaan_penunjang'],
      'catatan_hasil_pemeriksaan_penunjang' => $data['catatan_hasil_pemeriksaan_penunjang'],
      'kontrol_selanjutnya' => $data['kontrol_selanjutnya'],
      'catatan_kontrol_selanjutnya' => $data['catatan_kontrol_selanjutnya'],
      'diet' => $data['diet'],
      'catatan_diet' => $data['catatan_diet'],
      'edukasi_dan_latihan' => $data['edukasi_dan_latihan'],
      'catatan_edukasi_dan_latihan' => $data['catatan_edukasi_dan_latihan'],
      'rincian_pemulangan' => $data['rincian_pemulangan'],
      'catatan_rincian_pemulangan' => $data['catatan_rincian_pemulangan'],
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
  $aktifitas = mysql_real_escape_string($_POST['aktifitas']);
  $catatan_aktifitas = mysql_real_escape_string($_POST['catatan_aktifitas']);
  $pemberian_obat_dirumah = mysql_real_escape_string($_POST['pemberian_obat_dirumah']);
  $catatan_pemberian_obat_dirumah = mysql_real_escape_string($_POST['catatan_pemberian_obat_dirumah']);
  $fasilitas_kesehatan = mysql_real_escape_string($_POST['fasilitas_kesehatan']);
  $catatan_fasilitas_kesehatan = mysql_real_escape_string($_POST['catatan_fasilitas_kesehatan']);
  $hasil_pemeriksaan_penunjang = mysql_real_escape_string($_POST['hasil_pemeriksaan_penunjang']);
  $catatan_hasil_pemeriksaan_penunjang = mysql_real_escape_string($_POST['catatan_hasil_pemeriksaan_penunjang']);
  $kontrol_selanjutnya = mysql_real_escape_string($_POST['kontrol_selanjutnya']);
  $catatan_kontrol_selanjutnya = mysql_real_escape_string($_POST['catatan_kontrol_selanjutnya']);
  $diet = mysql_real_escape_string($_POST['diet']);
  $catatan_diet = mysql_real_escape_string($_POST['catatan_diet']);
  $edukasi_dan_latihan = mysql_real_escape_string($_POST['edukasi_dan_latihan']);
  $catatan_edukasi_dan_latihan = mysql_real_escape_string($_POST['catatan_edukasi_dan_latihan']);
  $rincian_pemulangan = mysql_real_escape_string($_POST['rincian_pemulangan']);
  $catatan_rincian_pemulangan = mysql_real_escape_string($_POST['catatan_rincian_pemulangan']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

//   $query = "INSERT INTO `rm_checklist_rencana_pulang` (`id`,`aktifitas`,`catatan_aktifitas`,`pemberian_obat_dirumah`,`catatan_pemberian_obat_dirumah`,`fasilitas_kesehatan`,`catatan_fasilitas_kesehatan`,`hasil_pemeriksaan_penunjang`,`catatan_hasil_pemeriksaan_penunjang`,`kontrol_selanjutnya`,`catatan_kontrol_selanjutnya`,`diet`,`catatan_diet`,`edukasi_dan_latihan`,`catatan_edukasi_dan_latihan`,`rincian_pemulangan`,`catatan_rincian_pemulangan`,`id_kunjungan`,`id_pelayanan`,`id_pasien`, `tgl_act`)
// VALUES (NULL,'$aktifitas','$catatan_aktifitas','$pemberian_obat_dirumah','$catatan_pemberian_obat_dirumah','$fasilitas_kesehatan','$catatan_fasilitas_kesehatan','$hasil_pemeriksaan_penunjang','$catatan_hasil_pemeriksaan_penunjang','$kontrol_selanjutnya','$catatan_kontrol_selanjutnya','$diet','$catatan_diet','$edukasi_dan_latihan','$catatan_edukasi_dan_latihan','$rincian_pemulangan','$catatan_rincian_pemulangan','$id_kunjungan','$id_pelayanan','$id_pasien', NULL)";

  $query = "INSERT INTO `rm_checklist_rencana_pulang` (`id`,`aktifitas`,`pemberian_obat_dirumah`,`fasilitas_kesehatan`,`kontrol_selanjutnya`,`diet`,`edukasi_dan_latihan`,`rincian_pemulangan`,`id_kunjungan`,`id_pelayanan`,`id_pasien`, `tgl_act`)
VALUES (NULL,'$aktifitas','$pemberian_obat_dirumah','$fasilitas_kesehatan','$kontrol_selanjutnya','$diet','$edukasi_dan_latihan','$rincian_pemulangan','$id_kunjungan','$id_pelayanan','$id_pasien', NULL)";

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
    // header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
}
function Update($id)
{


  $idKunj = $_REQUEST['idKunj'];
  $idPel = $_REQUEST['idPel'];
  $idPasien = $_REQUEST['idPasien'];
  $idUser = $_REQUEST['idUser'];

  $aktifitas = mysql_real_escape_string($_POST['aktifitas']);
  $catatan_aktifitas = mysql_real_escape_string($_POST['catatan_aktifitas']);
  $pemberian_obat_dirumah = mysql_real_escape_string($_POST['pemberian_obat_dirumah']);
  $catatan_pemberian_obat_dirumah = mysql_real_escape_string($_POST['catatan_pemberian_obat_dirumah']);
  $fasilitas_kesehatan = mysql_real_escape_string($_POST['fasilitas_kesehatan']);
  $catatan_fasilitas_kesehatan = mysql_real_escape_string($_POST['catatan_fasilitas_kesehatan']);
  $hasil_pemeriksaan_penunjang = mysql_real_escape_string($_POST['hasil_pemeriksaan_penunjang']);
  $catatan_hasil_pemeriksaan_penunjang = mysql_real_escape_string($_POST['catatan_hasil_pemeriksaan_penunjang']);
  $kontrol_selanjutnya = mysql_real_escape_string($_POST['kontrol_selanjutnya']);
  $catatan_kontrol_selanjutnya = mysql_real_escape_string($_POST['catatan_kontrol_selanjutnya']);
  $diet = mysql_real_escape_string($_POST['diet']);
  $catatan_diet = mysql_real_escape_string($_POST['catatan_diet']);
  $edukasi_dan_latihan = mysql_real_escape_string($_POST['edukasi_dan_latihan']);
  $catatan_edukasi_dan_latihan = mysql_real_escape_string($_POST['catatan_edukasi_dan_latihan']);
  $rincian_pemulangan = mysql_real_escape_string($_POST['rincian_pemulangan']);
  $catatan_rincian_pemulangan = mysql_real_escape_string($_POST['catatan_rincian_pemulangan']);
  $id_kunjungan = mysql_real_escape_string($_POST['id_kunjungan']);
  $id_pelayanan = mysql_real_escape_string($_POST['id_pelayanan']);
  $id_pasien = mysql_real_escape_string($_POST['id_pasien']);

  $query = "UPDATE `rm_checklist_rencana_pulang` SET `aktifitas` = '$aktifitas',`catatan_aktifitas`= '$catatan_aktifitas',`pemberian_obat_dirumah` = '$pemberian_obat_dirumah',`catatan_pemberian_obat_dirumah` = '$catatan_pemberian_obat_dirumah',`fasilitas_kesehatan` = '$fasilitas_kesehatan',`catatan_fasilitas_kesehatan`='$catatan_fasilitas_kesehatan',`hasil_pemeriksaan_penunjang` = '$hasil_pemeriksaan_penunjang',`catatan_hasil_pemeriksaan_penunjang`= '$catatan_hasil_pemeriksaan_penunjang',`kontrol_selanjutnya` = '$kontrol_selanjutnya',`catatan_kontrol_selanjutnya`= '$catatan_kontrol_selanjutnya',`diet` = '$diet',`catatan_diet` = '$catatan_diet',`edukasi_dan_latihan` = '$edukasi_dan_latihan',`catatan_edukasi_dan_latihan` = '$catatan_edukasi_dan_latihan',`rincian_pemulangan` = '$rincian_pemulangan',`catatan_rincian_pemulangan` = '$catatan_rincian_pemulangan',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_checklist_rencana_pulang` WHERE `id` = '$id'";
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