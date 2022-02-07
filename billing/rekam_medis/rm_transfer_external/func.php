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
  

  $query = "SELECT * FROM rm_transfer_external WHERE id_kunjungan = '$idKunj' AND id_pasien ='$idPasien'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'],
		'ruang' => $data['ruang'],
		'kelas' => $data['kelas'],
		'dpjp' => $data['dpjp'],
		'ppjp' => $data['ppjp'],
		'rs_tujuan' => $data['rs_tujuan'],
		'nama_petugas_dihubungi' => $data['nama_petugas_dihubungi'],
		'tanggal_menghubungi' => $data['tanggal_menghubungi'],
		'jam_menghubungi' => $data['jam_menghubungi'],
		'alasan_transfer' => $data['alasan_transfer'],
		'tanggal_transfer' => $data['tanggal_transfer'],
		'jam_transfer' => $data['jam_transfer'],
		'kategori_pasien_transfer' => $data['kategori_pasien_transfer'],
		'jenis_ambulans' => $data['jenis_ambulans'],
		'diagnosis' => $data['diagnosis'],
		'temuan_penting_pasien' => $data['temuan_penting_pasien'],
		'prosedur' => $data['prosedur'],
		'alat_pemasangan' => $data['alat_pemasangan'],
		'tanggal_pemasangan' => $data['tanggal_pemasangan'],
		'obat_pasien_saat_ini' => $data['obat_pasien_saat_ini'], 
		'obat_saat_transfer' => $data['obat_saat_transfer'],
		'jumlah_obat_transfer' => $data['jumlah_obat_transfer'],
		'pasien_akan_transfer_kesadaran' => $data['pasien_akan_transfer_kesadaran'],
		'pasien_akan_transfer_td' => $data['pasien_akan_transfer_td'],
		'pasien_akan_transfer_hr' => $data['pasien_akan_transfer_hr'],
		'pasien_akan_transfer_rr' => $data['pasien_akan_transfer_rr'],
		'pasien_selama_transfer_kesadaran' => $data['pasien_selama_transfer_kesadaran'],
		'pasien_selama_transfer_td' => $data['pasien_selama_transfer_td'],
		'pasien_selama_transfer_hr' => $data['pasien_selama_transfer_hr'],
		'pasien_selama_transfer_rr' => $data['pasien_selama_transfer_rr'],
		'kejadian_selama_transfer' => $data['kejadian_selama_transfer'],
		'petugas_yang_menyerahkan' => $data['petugas_yang_menyerahkan'],
		'petugas_yang_menerima' => $data['petugas_yang_menerima'],
		'id_kunjungan' => $data['id_kunjungan'],
		'id_pelayanan' => $data['id_pelayanan'],
		'id_pasien' => $data['id_pasien'],
		'id_user' => $data['id_user'],
		
    );
  }
  return $datas;
}

function GetOne($id){
 
  $query = "SELECT * FROM  `rm_transfer_external` WHERE  `id` =  '$id'";
  $exe = mysql_query($query);
  while($data = mysql_fetch_array($exe)){
    $datas[] = array('id' => $data['id'], 
		'ruang' => $data['ruang'], 
		'kelas' => $data['kelas'], 
		'dpjp' => $data['dpjp'], 
		'ppjp' => $data['ppjp'], 
		'rs_tujuan' => $data['rs_tujuan'], 
		'nama_petugas_dihubungi' => $data['nama_petugas_dihubungi'], 
		'tanggal_menghubungi' => $data['tanggal_menghubungi'], 
		'jam_menghubungi' => $data['jam_menghubungi'], 
		'alasan_transfer' => $data['alasan_transfer'], 
		'tanggal_transfer' => $data['tanggal_transfer'], 
		'jam_transfer' => $data['jam_transfer'], 
		'kategori_pasien_transfer' => $data['kategori_pasien_transfer'], 
		'jenis_ambulans' => $data['jenis_ambulans'], 
		'diagnosis' => $data['diagnosis'], 
		'temuan_penting_pasien' => $data['temuan_penting_pasien'], 
		'prosedur' => $data['prosedur'], 
		'alat_pemasangan' => $data['alat_pemasangan'], 
		'tanggal_pemasangan' => $data['tanggal_pemasangan'], 
		'obat_pasien_saat_ini' => $data['obat_pasien_saat_ini'], 
		'obat_saat_transfer' => $data['obat_saat_transfer'], 
		'jumlah_obat_transfer' => $data['jumlah_obat_transfer'], 
		'pasien_akan_transfer_kesadaran' => $data['pasien_akan_transfer_kesadaran'], 
		'pasien_akan_transfer_td' => $data['pasien_akan_transfer_td'], 
		'pasien_akan_transfer_hr' => $data['pasien_akan_transfer_hr'], 
		'pasien_akan_transfer_rr' => $data['pasien_akan_transfer_rr'], 
		'pasien_selama_transfer_kesadaran' => $data['pasien_selama_transfer_kesadaran'], 
		'pasien_selama_transfer_td' => $data['pasien_selama_transfer_td'], 
		'pasien_selama_transfer_hr' => $data['pasien_selama_transfer_hr'], 
		'pasien_selama_transfer_rr' => $data['pasien_selama_transfer_rr'], 
		'kejadian_selama_transfer' => $data['kejadian_selama_transfer'],
		'petugas_yang_menyerahkan' => $data['petugas_yang_menyerahkan'], 
		'petugas_yang_menerima' => $data['petugas_yang_menerima'], 
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
  $ruang= mysql_real_escape_string($_POST['ruang']); 
		$kelas= mysql_real_escape_string($_POST['kelas']); 
		$dpjp= mysql_real_escape_string($_POST['dpjp']); 
		$ppjp= mysql_real_escape_string($_POST['ppjp']); 
		$rs_tujuan= mysql_real_escape_string($_POST['rs_tujuan']); 
		$nama_petugas_dihubungi= mysql_real_escape_string($_POST['nama_petugas_dihubungi']); 
		$tanggal_menghubungi= mysql_real_escape_string($_POST['tanggal_menghubungi']); 
		$jam_menghubungi= mysql_real_escape_string($_POST['jam_menghubungi']); 
		$alasan_transfer= mysql_real_escape_string($_POST['alasan_transfer']); 
		$tanggal_transfer= mysql_real_escape_string($_POST['tanggal_transfer']); 
		$jam_transfer= mysql_real_escape_string($_POST['jam_transfer']); 
		$kategori_pasien_transfer= mysql_real_escape_string($_POST['kategori_pasien_transfer']); 
		$jenis_ambulans= mysql_real_escape_string($_POST['jenis_ambulans']); 
		$diagnosis= mysql_real_escape_string($_POST['diagnosis']); 
		$temuan_penting_pasien= mysql_real_escape_string($_POST['temuan_penting_pasien']); 
		$prosedur= mysql_real_escape_string($_POST['prosedur']); 
		$alat_pemasangan= mysql_real_escape_string($_POST['alat_pemasangan']); 
		$tanggal_pemasangan= mysql_real_escape_string($_POST['tanggal_pemasangan']); 
		$obat_pasien_saat_ini= mysql_real_escape_string($_POST['obat_pasien_saat_ini']); 
		$obat_saat_transfer= mysql_real_escape_string($_POST['obat_saat_transfer']); 
		$jumlah_obat_transfer= mysql_real_escape_string($_POST['jumlah_obat_transfer']); 
		$pasien_akan_transfer_kesadaran= mysql_real_escape_string($_POST['pasien_akan_transfer_kesadaran']); 
		$pasien_akan_transfer_td= mysql_real_escape_string($_POST['pasien_akan_transfer_td']); 
		$pasien_akan_transfer_hr= mysql_real_escape_string($_POST['pasien_akan_transfer_hr']); 
		$pasien_akan_transfer_rr= mysql_real_escape_string($_POST['pasien_akan_transfer_rr']); 
		$pasien_selama_transfer_kesadaran= mysql_real_escape_string($_POST['pasien_selama_transfer_kesadaran']); 
		$pasien_selama_transfer_td= mysql_real_escape_string($_POST['pasien_selama_transfer_td']); 
		$pasien_selama_transfer_hr= mysql_real_escape_string($_POST['pasien_selama_transfer_hr']); 
		$pasien_selama_transfer_rr= mysql_real_escape_string($_POST['pasien_selama_transfer_rr']); 
		$kejadian_selama_transfer= mysql_real_escape_string($_POST['kejadian_selama_transfer']); 
		$petugas_yang_menyerahkan= mysql_real_escape_string($_POST['petugas_yang_menyerahkan']); 
		$petugas_yang_menerima= mysql_real_escape_string($_POST['petugas_yang_menerima']); 
		$id_kunjungan= mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan= mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien= mysql_real_escape_string($_POST['id_pasien']); 
		$id_user= mysql_real_escape_string($_POST['id_user']); 
		
  $query = "INSERT INTO `rm_transfer_external` (`id`,`ruang`,`kelas`,`dpjp`,`ppjp`,`rs_tujuan`,`nama_petugas_dihubungi`,`tanggal_menghubungi`,`jam_menghubungi`,`alasan_transfer`,`tanggal_transfer`,`jam_transfer`,`kategori_pasien_transfer`,`jenis_ambulans`,`diagnosis`,`temuan_penting_pasien`,`prosedur`,`alat_pemasangan`,`tanggal_pemasangan`,`obat_pasien_saat_ini`,`obat_saat_transfer`,`jumlah_obat_transfer`,`pasien_akan_transfer_kesadaran`,`pasien_akan_transfer_td`,`pasien_akan_transfer_hr`,`pasien_akan_transfer_rr`,`pasien_selama_transfer_kesadaran`,`pasien_selama_transfer_td`,`pasien_selama_transfer_hr`,`pasien_selama_transfer_rr`,`kejadian_selama_transfer`,`petugas_yang_menyerahkan`,`petugas_yang_menerima`,`id_kunjungan`,`id_pelayanan`,`id_pasien`,`id_user`, `tgl_act`)
VALUES (NULL,'$ruang','$kelas','$dpjp','$ppjp','$rs_tujuan','$nama_petugas_dihubungi','$tanggal_menghubungi','$jam_menghubungi','$alasan_transfer','$tanggal_transfer','$jam_transfer','$kategori_pasien_transfer','$jenis_ambulans','$diagnosis','$temuan_penting_pasien','$prosedur','$alat_pemasangan','$tanggal_pemasangan','$obat_pasien_saat_ini','$obat_saat_transfer','$jumlah_obat_transfer','$pasien_akan_transfer_kesadaran','$pasien_akan_transfer_td','$pasien_akan_transfer_hr','$pasien_akan_transfer_rr','$pasien_selama_transfer_kesadaran','$pasien_selama_transfer_td','$pasien_selama_transfer_hr','$pasien_selama_transfer_rr','$kejadian_selama_transfer','$petugas_yang_menyerahkan','$petugas_yang_menerima','$id_kunjungan','$id_pelayanan','$id_pasien','$id_user', NULL)";
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

  $ruang=mysql_real_escape_string($_POST['ruang']); 
		$kelas=mysql_real_escape_string($_POST['kelas']); 
		$dpjp=mysql_real_escape_string($_POST['dpjp']); 
		$ppjp=mysql_real_escape_string($_POST['ppjp']); 
		$rs_tujuan=mysql_real_escape_string($_POST['rs_tujuan']); 
		$nama_petugas_dihubungi=mysql_real_escape_string($_POST['nama_petugas_dihubungi']); 
		$tanggal_menghubungi=mysql_real_escape_string($_POST['tanggal_menghubungi']); 
		$jam_menghubungi=mysql_real_escape_string($_POST['jam_menghubungi']); 
		$alasan_transfer=mysql_real_escape_string($_POST['alasan_transfer']); 
		$tanggal_transfer=mysql_real_escape_string($_POST['tanggal_transfer']); 
		$jam_transfer=mysql_real_escape_string($_POST['jam_transfer']); 
		$kategori_pasien_transfer=mysql_real_escape_string($_POST['kategori_pasien_transfer']); 
		$jenis_ambulans=mysql_real_escape_string($_POST['jenis_ambulans']); 
		$diagnosis=mysql_real_escape_string($_POST['diagnosis']); 
		$temuan_penting_pasien=mysql_real_escape_string($_POST['temuan_penting_pasien']); 
		$prosedur=mysql_real_escape_string($_POST['prosedur']); 
		$alat_pemasangan=mysql_real_escape_string($_POST['alat_pemasangan']); 
		$tanggal_pemasangan=mysql_real_escape_string($_POST['tanggal_pemasangan']); 
		$obat_pasien_saat_ini= mysql_real_escape_string($_POST['obat_pasien_saat_ini']); 
		$obat_saat_transfer=mysql_real_escape_string($_POST['obat_saat_transfer']); 
		$jumlah_obat_transfer=mysql_real_escape_string($_POST['jumlah_obat_transfer']); 
		$pasien_akan_transfer_kesadaran=mysql_real_escape_string($_POST['pasien_akan_transfer_kesadaran']); 
		$pasien_akan_transfer_td=mysql_real_escape_string($_POST['pasien_akan_transfer_td']); 
		$pasien_akan_transfer_hr=mysql_real_escape_string($_POST['pasien_akan_transfer_hr']); 
		$pasien_akan_transfer_rr=mysql_real_escape_string($_POST['pasien_akan_transfer_rr']); 
		$pasien_selama_transfer_kesadaran=mysql_real_escape_string($_POST['pasien_selama_transfer_kesadaran']); 
		$pasien_selama_transfer_td=mysql_real_escape_string($_POST['pasien_selama_transfer_td']); 
		$pasien_selama_transfer_hr=mysql_real_escape_string($_POST['pasien_selama_transfer_hr']); 
		$pasien_selama_transfer_rr=mysql_real_escape_string($_POST['pasien_selama_transfer_rr']); 
		$kejadian_selama_transfer= mysql_real_escape_string($_POST['kejadian_selama_transfer']); 
		$petugas_yang_menyerahkan=mysql_real_escape_string($_POST['petugas_yang_menyerahkan']); 
		$petugas_yang_menerima=mysql_real_escape_string($_POST['petugas_yang_menerima']); 
		$id_kunjungan=mysql_real_escape_string($_POST['id_kunjungan']); 
		$id_pelayanan=mysql_real_escape_string($_POST['id_pelayanan']); 
		$id_pasien=mysql_real_escape_string($_POST['id_pasien']); 
		$id_user=mysql_real_escape_string($_POST['id_user']); 
		
  $query = "UPDATE `rm_transfer_external` SET `ruang` = '$ruang',`kelas` = '$kelas',`dpjp` = '$dpjp',`ppjp` = '$ppjp',`rs_tujuan` = '$rs_tujuan',`nama_petugas_dihubungi` = '$nama_petugas_dihubungi',`tanggal_menghubungi` = '$tanggal_menghubungi',`jam_menghubungi` = '$jam_menghubungi',`alasan_transfer` = '$alasan_transfer',`tanggal_transfer` = '$tanggal_transfer',`jam_transfer` = '$jam_transfer',`kategori_pasien_transfer` = '$kategori_pasien_transfer',`jenis_ambulans` = '$jenis_ambulans',`diagnosis` = '$diagnosis',`temuan_penting_pasien` = '$temuan_penting_pasien',`prosedur` = '$prosedur',`alat_pemasangan` = '$alat_pemasangan',`tanggal_pemasangan` = '$tanggal_pemasangan',`obat_pasien_saat_ini` = '$obat_pasien_saat_ini',`obat_saat_transfer` = '$obat_saat_transfer',`jumlah_obat_transfer` = '$jumlah_obat_transfer',`pasien_akan_transfer_kesadaran` = '$pasien_akan_transfer_kesadaran',`pasien_akan_transfer_td` = '$pasien_akan_transfer_td',`pasien_akan_transfer_hr` = '$pasien_akan_transfer_hr',`pasien_akan_transfer_rr` = '$pasien_akan_transfer_rr',`pasien_selama_transfer_kesadaran` = '$pasien_selama_transfer_kesadaran',`pasien_selama_transfer_td` = '$pasien_selama_transfer_td',`pasien_selama_transfer_hr` = '$pasien_selama_transfer_hr',`pasien_selama_transfer_rr` = '$pasien_selama_transfer_rr',`kejadian_selama_transfer` = '$kejadian_selama_transfer',`petugas_yang_menyerahkan` = '$petugas_yang_menyerahkan',`petugas_yang_menerima` = '$petugas_yang_menerima',`id_kunjungan` = '$id_kunjungan',`id_pelayanan` = '$id_pelayanan',`id_pasien` = '$id_pasien',`id_user` = '$id_user' WHERE  `id` =  '$id'";
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

  $query = "DELETE FROM `rm_transfer_external` WHERE `id` = '$id'";
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
