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
  

  $query = "SELECT * FROM rm_checklist_kesiapan_operasi WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'],
		'signin_opsi_pertama' => $data['signin_opsi_pertama'],
		'signin_opsi_kedua' => $data['signin_opsi_kedua'],
		'signin_opsi_ketiga' => $data['signin_opsi_ketiga'],
		'signin_opsi_keempat' => $data['signin_opsi_keempat'],
		'signin_opsi_kelima' => $data['signin_opsi_kelima'],
		'signin_opsi_keenam' => $data['signin_opsi_keenam'],
		'signin_opsi_ketujuh' => $data['signin_opsi_ketujuh'],
		'signin_anastesi' => $data['signin_anastesi'],
		'timeout_operator' => $data['timeout_operator'],
		'timeout_asisten' => $data['timeout_asisten'],
		'timeout_instrument' => $data['timeout_instrument'],
		'timeout_sirkuler' => $data['timeout_sirkuler'],
		'timeout_prosedur' => $data['timeout_prosedur'],
		'timeout_lokasi_inisiasi' => $data['timeout_lokasi_inisiasi'],
		'timeout_opsi_pertama' => $data['timeout_opsi_pertama'],
		'timeout_opsi_kedua' => $data['timeout_opsi_kedua'],
		'timeout_opsi_ketiga' => $data['timeout_opsi_ketiga'],
		'timeout_opsi_keempat' => $data['timeout_opsi_keempat'],
		'timeout_opsi_kelima' => $data['timeout_opsi_kelima'],
		'timeout_opsi_keenam' => $data['timeout_opsi_keenam'],
		'timeout_perawat_sirkuaer' => $data['timeout_perawat_sirkuaer'],
		'signout_opsi_pertama' => $data['signout_opsi_pertama'],
		'signout_opsi_kedua' => $data['signout_opsi_kedua'],
		'id_kunjungan' => $data['id_kunjungan'],
		'id_pelayanan' => $data['id_pelayanan'],
		'id_pasien' => $data['id_pasien'],
		'id_user' => $data['id_user'],
		
    );
  }
  return $datas;
}

function GetOne($id){
 
  $query = "SELECT * FROM  `rm_checklist_kesiapan_operasi` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'], 
		'signin_opsi_pertama' => $data['signin_opsi_pertama'], 
		'signin_opsi_kedua' => $data['signin_opsi_kedua'], 
		'signin_opsi_ketiga' => $data['signin_opsi_ketiga'], 
		'signin_opsi_keempat' => $data['signin_opsi_keempat'], 
		'signin_opsi_kelima' => $data['signin_opsi_kelima'], 
		'signin_opsi_keenam' => $data['signin_opsi_keenam'], 
		'signin_opsi_ketujuh' => $data['signin_opsi_ketujuh'], 
		'signin_anastesi' => $data['signin_anastesi'], 
		'timeout_operator' => $data['timeout_operator'], 
		'timeout_asisten' => $data['timeout_asisten'], 
		'timeout_instrument' => $data['timeout_instrument'], 
		'timeout_sirkuler' => $data['timeout_sirkuler'], 
		'timeout_prosedur' => $data['timeout_prosedur'], 
		'timeout_lokasi_inisiasi' => $data['timeout_lokasi_inisiasi'], 
		'timeout_opsi_pertama' => $data['timeout_opsi_pertama'], 
		'timeout_opsi_kedua' => $data['timeout_opsi_kedua'], 
		'timeout_opsi_ketiga' => $data['timeout_opsi_ketiga'], 
		'timeout_opsi_keempat' => $data['timeout_opsi_keempat'], 
		'timeout_opsi_kelima' => $data['timeout_opsi_kelima'], 
		'timeout_opsi_keenam' => $data['timeout_opsi_keenam'], 
		'timeout_perawat_sirkuaer' => $data['timeout_perawat_sirkuaer'], 
		'signout_opsi_pertama' => $data['signout_opsi_pertama'], 
		'signout_opsi_kedua' => $data['signout_opsi_kedua'], 
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
  $signin_opsi_pertama= mysql_real_escape_string($_POST['signin_opsi_pertama']); 
		$signin_opsi_kedua= mysql_real_escape_string($_POST['signin_opsi_kedua']); 
		$signin_opsi_ketiga= mysql_real_escape_string($_POST['signin_opsi_ketiga']); 
		$signin_opsi_keempat= mysql_real_escape_string($_POST['signin_opsi_keempat']); 
		$signin_opsi_kelima= mysql_real_escape_string($_POST['signin_opsi_kelima']); 
		$signin_opsi_keenam= mysql_real_escape_string($_POST['signin_opsi_keenam']); 
		$signin_opsi_ketujuh= mysql_real_escape_string($_POST['signin_opsi_ketujuh']); 
		$signin_anastesi= mysql_real_escape_string($_POST['signin_anastesi']); 
		$timeout_operator= mysql_real_escape_string($_POST['timeout_operator']); 
		$timeout_asisten= mysql_real_escape_string($_POST['timeout_asisten']); 
		$timeout_instrument= mysql_real_escape_string($_POST['timeout_instrument']); 
		$timeout_sirkuler= mysql_real_escape_string($_POST['timeout_sirkuler']); 
		$timeout_prosedur= mysql_real_escape_string($_POST['timeout_prosedur']); 
		$timeout_lokasi_inisiasi= mysql_real_escape_string($_POST['timeout_lokasi_inisiasi']); 
		$timeout_opsi_pertama= mysql_real_escape_string($_POST['timeout_opsi_pertama']); 
		$timeout_opsi_kedua= mysql_real_escape_string($_POST['timeout_opsi_kedua']); 
		$timeout_opsi_ketiga= mysql_real_escape_string($_POST['timeout_opsi_ketiga']); 
		$timeout_opsi_keempat= mysql_real_escape_string($_POST['timeout_opsi_keempat']); 
		$timeout_opsi_kelima= mysql_real_escape_string($_POST['timeout_opsi_kelima']); 
		$timeout_opsi_keenam= mysql_real_escape_string($_POST['timeout_opsi_keenam']); 
		$timeout_perawat_sirkuaer= mysql_real_escape_string($_POST['timeout_perawat_sirkuaer']); 
		$signout_opsi_pertama= mysql_real_escape_string($_POST['signout_opsi_pertama']); 
		$signout_opsi_kedua= mysql_real_escape_string($_POST['signout_opsi_kedua']); 
		$id_kunjungan= mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan= mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien= mysql_real_escape_string($_POST['id_pasien']); 
		$id_user= mysql_real_escape_string($_POST['id_user']); 
		
  $query = "INSERT INTO `rm_checklist_kesiapan_operasi` (`id`,`signin_opsi_pertama`,`signin_opsi_kedua`,`signin_opsi_ketiga`,`signin_opsi_keempat`,`signin_opsi_kelima`,`signin_opsi_keenam`,`signin_opsi_ketujuh`,`signin_anastesi`,`timeout_operator`,`timeout_asisten`,`timeout_instrument`,`timeout_sirkuler`,`timeout_prosedur`,`timeout_lokasi_inisiasi`,`timeout_opsi_pertama`,`timeout_opsi_kedua`,`timeout_opsi_ketiga`,`timeout_opsi_keempat`,`timeout_opsi_kelima`,`timeout_opsi_keenam`,`timeout_perawat_sirkuaer`,`signout_opsi_pertama`,`signout_opsi_kedua`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`)
VALUES (NULL,'$signin_opsi_pertama','$signin_opsi_kedua','$signin_opsi_ketiga','$signin_opsi_keempat','$signin_opsi_kelima','$signin_opsi_keenam','$signin_opsi_ketujuh','$signin_anastesi','$timeout_operator','$timeout_asisten','$timeout_instrument','$timeout_sirkuler','$timeout_prosedur','$timeout_lokasi_inisiasi','$timeout_opsi_pertama','$timeout_opsi_kedua','$timeout_opsi_ketiga','$timeout_opsi_keempat','$timeout_opsi_kelima','$timeout_opsi_keenam','$timeout_perawat_sirkuaer','$signout_opsi_pertama','$signout_opsi_kedua','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user')";
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

  $signin_opsi_pertama=mysql_real_escape_string($_POST['signin_opsi_pertama']); 
		$signin_opsi_kedua=mysql_real_escape_string($_POST['signin_opsi_kedua']); 
		$signin_opsi_ketiga=mysql_real_escape_string($_POST['signin_opsi_ketiga']); 
		$signin_opsi_keempat=mysql_real_escape_string($_POST['signin_opsi_keempat']); 
		$signin_opsi_kelima=mysql_real_escape_string($_POST['signin_opsi_kelima']); 
		$signin_opsi_keenam=mysql_real_escape_string($_POST['signin_opsi_keenam']); 
		$signin_opsi_ketujuh=mysql_real_escape_string($_POST['signin_opsi_ketujuh']); 
		$signin_anastesi=mysql_real_escape_string($_POST['signin_anastesi']); 
		$timeout_operator=mysql_real_escape_string($_POST['timeout_operator']); 
		$timeout_asisten=mysql_real_escape_string($_POST['timeout_asisten']); 
		$timeout_instrument=mysql_real_escape_string($_POST['timeout_instrument']); 
		$timeout_sirkuler=mysql_real_escape_string($_POST['timeout_sirkuler']); 
		$timeout_prosedur=mysql_real_escape_string($_POST['timeout_prosedur']); 
		$timeout_lokasi_inisiasi=mysql_real_escape_string($_POST['timeout_lokasi_inisiasi']); 
		$timeout_opsi_pertama=mysql_real_escape_string($_POST['timeout_opsi_pertama']); 
		$timeout_opsi_kedua=mysql_real_escape_string($_POST['timeout_opsi_kedua']); 
		$timeout_opsi_ketiga=mysql_real_escape_string($_POST['timeout_opsi_ketiga']); 
		$timeout_opsi_keempat=mysql_real_escape_string($_POST['timeout_opsi_keempat']); 
		$timeout_opsi_kelima=mysql_real_escape_string($_POST['timeout_opsi_kelima']); 
		$timeout_opsi_keenam=mysql_real_escape_string($_POST['timeout_opsi_keenam']); 
		$timeout_perawat_sirkuaer=mysql_real_escape_string($_POST['timeout_perawat_sirkuaer']); 
		$signout_opsi_pertama=mysql_real_escape_string($_POST['signout_opsi_pertama']); 
		$signout_opsi_kedua=mysql_real_escape_string($_POST['signout_opsi_kedua']); 
		$id_kunjungan=mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan=mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien=mysql_real_escape_string($_POST['id_pasien']); 
		$id_user=mysql_real_escape_string($_POST['id_user']); 
		
  $query = "UPDATE `rm_checklist_kesiapan_operasi` SET `signin_opsi_pertama` = '$signin_opsi_pertama',`signin_opsi_kedua` = '$signin_opsi_kedua',`signin_opsi_ketiga` = '$signin_opsi_ketiga',`signin_opsi_keempat` = '$signin_opsi_keempat',`signin_opsi_kelima` = '$signin_opsi_kelima',`signin_opsi_keenam` = '$signin_opsi_keenam',`signin_opsi_ketujuh` = '$signin_opsi_ketujuh',`signin_anastesi` = '$signin_anastesi',`timeout_operator` = '$timeout_operator',`timeout_asisten` = '$timeout_asisten',`timeout_instrument` = '$timeout_instrument',`timeout_sirkuler` = '$timeout_sirkuler',`timeout_prosedur` = '$timeout_prosedur',`timeout_lokasi_inisiasi` = '$timeout_lokasi_inisiasi',`timeout_opsi_pertama` = '$timeout_opsi_pertama',`timeout_opsi_kedua` = '$timeout_opsi_kedua',`timeout_opsi_ketiga` = '$timeout_opsi_ketiga',`timeout_opsi_keempat` = '$timeout_opsi_keempat',`timeout_opsi_kelima` = '$timeout_opsi_kelima',`timeout_opsi_keenam` = '$timeout_opsi_keenam',`timeout_perawat_sirkuaer` = '$timeout_perawat_sirkuaer',`signout_opsi_pertama` = '$signout_opsi_pertama',`signout_opsi_kedua` = '$signout_opsi_kedua',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_checklist_kesiapan_operasi` WHERE `id` = '$id'";
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
