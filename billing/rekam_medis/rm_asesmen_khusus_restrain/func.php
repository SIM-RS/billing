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
  

  $query = "SELECT * FROM rm_asesmen_khusus_restrain WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'],
		'gcs_e' => $data['gcs_e'],
		'gcs_v' => $data['gcs_v'],
		'gcs_m' => $data['gcs_m'],
		'reflek_cahaya_ka' => $data['reflek_cahaya_ka'],
		'reflek_cahaya_ki' => $data['reflek_cahaya_ki'],
		'ukuran_pupil_ka' => $data['ukuran_pupil_ka'],
		'ukuran_pupil_ki' => $data['ukuran_pupil_ki'],
		'ttv_td' => $data['ttv_td'],
		'ttv_pernafasan' => $data['ttv_pernafasan'],
		'ttv_suhu' => $data['ttv_suhu'],
		'ttv_nadi' => $data['ttv_nadi'],
		'hasil_observasi' => $data['hasil_observasi'],
		'pertimbangan_klinis' => $data['pertimbangan_klinis'],
		'restrain_non_farmakologi' => $data['restrain_non_farmakologi'],
		'restrain_farmakologi' => $data['restrain_farmakologi'],
		'lanjutan_restrain_non_farmakologi' => $data['lanjutan_restrain_non_farmakologi'],
		'lanjutan_restrain_farmakologi' => $data['lanjutan_restrain_farmakologi'],
		'pendidikan_restrain_keluarga' => $data['pendidikan_restrain_keluarga'],
		'tanggal' => $data['tanggal'],
		'pukul' => $data['pukul'],
		'id_kunjungan' => $data['id_kunjungan'],
		'id_pelayanan' => $data['id_pelayanan'],
		'id_pasien' => $data['id_pasien'],
		'id_user' => $data['id_user'],
		
    );
  }
  return $datas;
}

function GetOne($id){
 
  $query = "SELECT * FROM  `rm_asesmen_khusus_restrain` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'], 
		'gcs_e' => $data['gcs_e'], 
		'gcs_v' => $data['gcs_v'], 
		'gcs_m' => $data['gcs_m'], 
		'reflek_cahaya_ka' => $data['reflek_cahaya_ka'], 
		'reflek_cahaya_ki' => $data['reflek_cahaya_ki'], 
		'ukuran_pupil_ka' => $data['ukuran_pupil_ka'], 
		'ukuran_pupil_ki' => $data['ukuran_pupil_ki'], 
		'ttv_td' => $data['ttv_td'], 
		'ttv_pernafasan' => $data['ttv_pernafasan'], 
		'ttv_suhu' => $data['ttv_suhu'], 
		'ttv_nadi' => $data['ttv_nadi'], 
		'hasil_observasi' => $data['hasil_observasi'], 
		'pertimbangan_klinis' => $data['pertimbangan_klinis'], 
		'restrain_non_farmakologi' => $data['restrain_non_farmakologi'], 
		'restrain_farmakologi' => $data['restrain_farmakologi'], 
		'lanjutan_restrain_non_farmakologi' => $data['lanjutan_restrain_non_farmakologi'],
		'lanjutan_restrain_farmakologi' => $data['lanjutan_restrain_farmakologi'], 
		'pendidikan_restrain_keluarga' => $data['pendidikan_restrain_keluarga'], 
		'tanggal' => $data['tanggal'], 
		'pukul' => $data['pukul'], 
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
  $gcs_e= mysql_real_escape_string($_POST['gcs_e']); 
		$gcs_v= mysql_real_escape_string($_POST['gcs_v']); 
		$gcs_m= mysql_real_escape_string($_POST['gcs_m']); 
		$reflek_cahaya_ka= mysql_real_escape_string($_POST['reflek_cahaya_ka']); 
		$reflek_cahaya_ki= mysql_real_escape_string($_POST['reflek_cahaya_ki']); 
		$ukuran_pupil_ka= mysql_real_escape_string($_POST['ukuran_pupil_ka']); 
		$ukuran_pupil_ki= mysql_real_escape_string($_POST['ukuran_pupil_ki']); 
		$ttv_td= mysql_real_escape_string($_POST['ttv_td']); 
		$ttv_pernafasan= mysql_real_escape_string($_POST['ttv_pernafasan']); 
		$ttv_suhu= mysql_real_escape_string($_POST['ttv_suhu']); 
		$ttv_nadi= mysql_real_escape_string($_POST['ttv_nadi']); 
		$hasil_observasi= mysql_real_escape_string($_POST['hasil_observasi']); 
		$pertimbangan_klinis= mysql_real_escape_string($_POST['pertimbangan_klinis']); 
		$restrain_non_farmakologi= mysql_real_escape_string($_POST['restrain_non_farmakologi']); 
		$restrain_farmakologi= mysql_real_escape_string($_POST['restrain_farmakologi']); 

		$lanjutan_restrain_non_farmakologi= mysql_real_escape_string($_POST['lanjutan_restrain_non_farmakologi']); 
		$lanjutan_restrain_farmakologi= mysql_real_escape_string($_POST['lanjutan_restrain_farmakologi']); 

		$pendidikan_restrain_keluarga= mysql_real_escape_string($_POST['pendidikan_restrain_keluarga']); 
		$tanggal= mysql_real_escape_string($_POST['tanggal']); 
		$pukul= mysql_real_escape_string($_POST['pukul']); 
		$id_kunjungan= mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan= mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien= mysql_real_escape_string($_POST['id_pasien']); 
		$id_user= mysql_real_escape_string($_POST['id_user']); 
		
  $query = "INSERT INTO `rm_asesmen_khusus_restrain` (`id`,`gcs_e`,`gcs_v`,`gcs_m`,`reflek_cahaya_ka`,`reflek_cahaya_ki`,`ukuran_pupil_ka`,`ukuran_pupil_ki`,`ttv_td`,`ttv_pernafasan`,`ttv_suhu`,`ttv_nadi`,`hasil_observasi`,`pertimbangan_klinis`,`restrain_non_farmakologi`,`restrain_farmakologi`,`lanjutan_restrain_non_farmakologi`,`lanjutan_restrain_farmakologi`,`pendidikan_restrain_keluarga`,`tanggal`,`pukul`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$gcs_e','$gcs_v','$gcs_m','$reflek_cahaya_ka','$reflek_cahaya_ki','$ukuran_pupil_ka','$ukuran_pupil_ki','$ttv_td','$ttv_pernafasan','$ttv_suhu','$ttv_nadi','$hasil_observasi','$pertimbangan_klinis','$restrain_non_farmakologi','$restrain_farmakologi','$lanjutan_restrain_non_farmakologi','$lanjutan_restrain_farmakologi','$pendidikan_restrain_keluarga','$tanggal','$pukul','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

  $gcs_e=mysql_real_escape_string($_POST['gcs_e']); 
		$gcs_v=mysql_real_escape_string($_POST['gcs_v']); 
		$gcs_m=mysql_real_escape_string($_POST['gcs_m']); 
		$reflek_cahaya_ka=mysql_real_escape_string($_POST['reflek_cahaya_ka']); 
		$reflek_cahaya_ki=mysql_real_escape_string($_POST['reflek_cahaya_ki']); 
		$ukuran_pupil_ka=mysql_real_escape_string($_POST['ukuran_pupil_ka']); 
		$ukuran_pupil_ki=mysql_real_escape_string($_POST['ukuran_pupil_ki']); 
		$ttv_td=mysql_real_escape_string($_POST['ttv_td']); 
		$ttv_pernafasan=mysql_real_escape_string($_POST['ttv_pernafasan']); 
		$ttv_suhu=mysql_real_escape_string($_POST['ttv_suhu']); 
		$ttv_nadi=mysql_real_escape_string($_POST['ttv_nadi']); 
		$hasil_observasi=mysql_real_escape_string($_POST['hasil_observasi']); 
		$pertimbangan_klinis=mysql_real_escape_string($_POST['pertimbangan_klinis']); 
		$restrain_non_farmakologi=mysql_real_escape_string($_POST['restrain_non_farmakologi']); 
		$restrain_farmakologi=mysql_real_escape_string($_POST['restrain_farmakologi']); 

		$lanjutan_restrain_non_farmakologi=mysql_real_escape_string($_POST['lanjutan_restrain_non_farmakologi']); 
		$lanjutan_restrain_farmakologi=mysql_real_escape_string($_POST['lanjutan_restrain_farmakologi']); 

		$pendidikan_restrain_keluarga=mysql_real_escape_string($_POST['pendidikan_restrain_keluarga']); 
		$tanggal=mysql_real_escape_string($_POST['tanggal']); 
		$pukul=mysql_real_escape_string($_POST['pukul']); 
		$id_kunjungan=mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan=mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien=mysql_real_escape_string($_POST['id_pasien']); 
		$id_user=mysql_real_escape_string($_POST['id_user']); 
		
  $query = "UPDATE `rm_asesmen_khusus_restrain` SET `gcs_e` = '$gcs_e',`gcs_v` = '$gcs_v',`gcs_m` = '$gcs_m',`reflek_cahaya_ka` = '$reflek_cahaya_ka',`reflek_cahaya_ki` = '$reflek_cahaya_ki',`ukuran_pupil_ka` = '$ukuran_pupil_ka',`ukuran_pupil_ki` = '$ukuran_pupil_ki',`ttv_td` = '$ttv_td',`ttv_pernafasan` = '$ttv_pernafasan',`ttv_suhu` = '$ttv_suhu',`ttv_nadi` = '$ttv_nadi',`hasil_observasi` = '$hasil_observasi',`pertimbangan_klinis` = '$pertimbangan_klinis',`restrain_non_farmakologi` = '$restrain_non_farmakologi',`restrain_farmakologi` = '$restrain_farmakologi',`lanjutan_restrain_non_farmakologi` = '$lanjutan_restrain_non_farmakologi',`lanjutan_restrain_farmakologi` = '$lanjutan_restrain_farmakologi',`pendidikan_restrain_keluarga` = '$pendidikan_restrain_keluarga',`tanggal` = '$tanggal',`pukul` = '$pukul',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_asesmen_khusus_restrain` WHERE `id` = '$id'";
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
