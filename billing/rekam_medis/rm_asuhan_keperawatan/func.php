<?php
require_once '../../koneksi/konek.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);


$sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$idKunj'"));

$idPasien= $sql['pasien_id'];
$idUser=mysql_real_escape_string($_REQUEST['idUser']);

function GetAll($idKunj,$idPasien){
  

  $query = "SELECT * FROM rm_asuhan_keperawatan WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'],
		'diagnosa_kerja' => $data['diagnosa_kerja'],
		'kebutuhan' => $data['kebutuhan'],
		'kewaspadaan' => $data['kewaspadaan'],
		'dpjp' => $data['dpjp'],
		'tim' => $data['tim'],
		'pemeriksaan' => $data['pemeriksaan'],
		'tindakan' => $data['tindakan'],
		'diet' => $data['diet'],
		'batasan_cairan' => $data['batasan_cairan'],
		'aktivitas' => $data['aktivitas'],
		'pengobatan' => $data['pengobatan'],
		'keperawatan' => $data['keperawatan'],
		'tindakan_rehabilitas_medik' => $data['tindakan_rehabilitas_medik'],
		'konsultasi' => $data['konsultasi'],
		'sasaran' => $data['sasaran'],
		'nama_dokter' => $data['nama_dokter'],
		'id_kunjungan' => $data['id_kunjungan'],
		'id_pelayanan' => $data['id_pelayanan'],
		'id_pasien' => $data['id_pasien'],
		'id_user' => $data['id_user'],
		
    );
  }
  return $datas;
}

function GetOne($id){
 
  $query = "SELECT * FROM  `rm_asuhan_keperawatan` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'], 
		'diagnosa_kerja' => $data['diagnosa_kerja'], 
		'kebutuhan' => $data['kebutuhan'], 
		'kewaspadaan' => $data['kewaspadaan'], 
		'dpjp' => $data['dpjp'], 
		'tim' => $data['tim'], 
		'pemeriksaan' => $data['pemeriksaan'], 
		'tindakan' => $data['tindakan'], 
		'diet' => $data['diet'], 
		'batasan_cairan' => $data['batasan_cairan'], 
		'aktivitas' => $data['aktivitas'], 
		'pengobatan' => $data['pengobatan'], 
		'keperawatan' => $data['keperawatan'], 
		'tindakan_rehabilitas_medik' => $data['tindakan_rehabilitas_medik'], 
		'konsultasi' => $data['konsultasi'], 
		'sasaran' => $data['sasaran'], 
		'nama_dokter' => $data['nama_dokter'], 
		'id_kunjungan' => $data['id_kunjungan'], 
		'id_pelayanan' => $data['id_pelayanan'], 
		'id_pasien' => $data['id_pasien'], 
		'id_user' => $data['id_user'], 
		
    );
  }
return $datas;
}

function Insert(){
   

$idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);
$idPasien=mysql_real_escape_string($_REQUEST['idPasien']);
$idUser=mysql_real_escape_string($_REQUEST['idUser']);
  $diagnosa_kerja= mysql_real_escape_string($_POST['diagnosa_kerja']); 
		$kebutuhan= mysql_real_escape_string($_POST['kebutuhan']); 
		$kewaspadaan= mysql_real_escape_string($_POST['kewaspadaan']); 
		$dpjp= mysql_real_escape_string($_POST['dpjp']); 
		$tim= mysql_real_escape_string($_POST['tim']); 
		$pemeriksaan= mysql_real_escape_string($_POST['pemeriksaan']); 
		$tindakan= mysql_real_escape_string($_POST['tindakan']); 
		$diet= mysql_real_escape_string($_POST['diet']); 
		$batasan_cairan= mysql_real_escape_string($_POST['batasan_cairan']); 
		$aktivitas= mysql_real_escape_string($_POST['aktivitas']); 
		$pengobatan= mysql_real_escape_string($_POST['pengobatan']); 
		$keperawatan= mysql_real_escape_string($_POST['keperawatan']); 
		$tindakan_rehabilitas_medik= mysql_real_escape_string($_POST['tindakan_rehabilitas_medik']); 
		$konsultasi= mysql_real_escape_string($_POST['konsultasi']); 
		$sasaran= mysql_real_escape_string($_POST['sasaran']); 
		$nama_dokter= mysql_real_escape_string($_POST['nama_dokter']); 
		$id_kunjungan= mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan= mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien= mysql_real_escape_string($_POST['id_pasien']); 
		$id_user= mysql_real_escape_string($_POST['id_user']); 
		
  $query = "INSERT INTO `rm_asuhan_keperawatan` (`id`,`diagnosa_kerja`,`kebutuhan`,`kewaspadaan`,`dpjp`,`tim`,`pemeriksaan`,`tindakan`,`diet`,`batasan_cairan`,`aktivitas`,`pengobatan`,`keperawatan`,`tindakan_rehabilitas_medik`,`konsultasi`,`sasaran`,`nama_dokter`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$diagnosa_kerja','$kebutuhan','$kewaspadaan','$dpjp','$tim','$pemeriksaan','$tindakan','$diet','$batasan_cairan','$aktivitas','$pengobatan','$keperawatan','$tindakan_rehabilitas_medik','$konsultasi','$sasaran','$nama_dokter','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
$exe = mysql_query($query);
  if($exe){
    // kalau berhasil
    $_SESSION['message'] = " Data Telah disimpan ";
    $_SESSION['mType'] = "success ";
      
    header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
  else{
    $_SESSION['message'] = " Data Gagal disimpan ";
    $_SESSION['mType'] = "danger ";
    
  header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
}
function Update($id){
   

  $idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);
$idPasien=mysql_real_escape_string($_REQUEST['idPasien']);
$idUser=mysql_real_escape_string($_REQUEST['idUser']);

  $diagnosa_kerja=mysql_real_escape_string($_POST['diagnosa_kerja']); 
		$kebutuhan=mysql_real_escape_string($_POST['kebutuhan']); 
		$kewaspadaan=mysql_real_escape_string($_POST['kewaspadaan']); 
		$dpjp=mysql_real_escape_string($_POST['dpjp']); 
		$tim=mysql_real_escape_string($_POST['tim']); 
		$pemeriksaan=mysql_real_escape_string($_POST['pemeriksaan']); 
		$tindakan=mysql_real_escape_string($_POST['tindakan']); 
		$diet=mysql_real_escape_string($_POST['diet']); 
		$batasan_cairan=mysql_real_escape_string($_POST['batasan_cairan']); 
		$aktivitas=mysql_real_escape_string($_POST['aktivitas']); 
		$pengobatan=mysql_real_escape_string($_POST['pengobatan']); 
		$keperawatan=mysql_real_escape_string($_POST['keperawatan']); 
		$tindakan_rehabilitas_medik=mysql_real_escape_string($_POST['tindakan_rehabilitas_medik']); 
		$konsultasi=mysql_real_escape_string($_POST['konsultasi']); 
		$sasaran=mysql_real_escape_string($_POST['sasaran']); 
		$nama_dokter=mysql_real_escape_string($_POST['nama_dokter']); 
		$id_kunjungan=mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan=mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien=mysql_real_escape_string($_POST['id_pasien']); 
		$id_user=mysql_real_escape_string($_POST['id_user']); 
		
  $query = "UPDATE `rm_asuhan_keperawatan` SET `diagnosa_kerja` = '$diagnosa_kerja',`kebutuhan` = '$kebutuhan',`kewaspadaan` = '$kewaspadaan',`dpjp` = '$dpjp',`tim` = '$tim',`pemeriksaan` = '$pemeriksaan',`tindakan` = '$tindakan',`diet` = '$diet',`batasan_cairan` = '$batasan_cairan',`aktivitas` = '$aktivitas',`pengobatan` = '$pengobatan',`keperawatan` = '$keperawatan',`tindakan_rehabilitas_medik` = '$tindakan_rehabilitas_medik',`konsultasi` = '$konsultasi',`sasaran` = '$sasaran',`nama_dokter` = '$nama_dokter',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
$exe = mysql_query($query);
  if($exe){
    // kalau berhasil
    $_SESSION['message'] = " Data Telah diubah ";
    $_SESSION['mType'] = "success ";
    
   header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
  else{
    $_SESSION['message'] = " Data Gagal diubah ";
    $_SESSION['mType'] = "danger ";
    
   header("Location: index.php?idKunj=$id_kunjungan&idPel=$id_pelayanan&idPasien=$id_pasien&idUser=$id_user");
  }
}
function Delete($id){
   
 $idKunj=mysql_real_escape_string($_REQUEST['idKunj']);
$idPel=mysql_real_escape_string($_REQUEST['idPel']);
$idPasien=mysql_real_escape_string($_REQUEST['idPasien']);
$idUser=mysql_real_escape_string($_REQUEST['idUser']);

  $query = "DELETE FROM `rm_asuhan_keperawatan` WHERE `id` = '$id'";
  $exe = mysql_query($query);
    if($exe){
      // kalau berhasil
      $_SESSION['message'] = " Data Telah dihapus ";
      $_SESSION['mType'] = "success ";
       
      header("Location: index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser");
    }
    else{
      $_SESSION['message'] = " Data Gagal dihapus ";
      $_SESSION['mType'] = "danger ";

      header("Location: index.php?idKunj=$idKunj&idPel=$idPel&idPasien=$idPasien&idUser=$idUser");
    }
}




function hari_ini(){
  $hari = date ("D");
 
  switch($hari){
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



if(isset($_POST['insert'])){
  Insert();
}
else if(isset($_POST['update'])){
  Update(mysql_real_escape_string($_POST['id']));
}
else if(isset($_POST['delete'])){
  Delete(mysql_real_escape_string($_POST['id']));
}
?>
