<style>
.betul{
	font-size:14px;
	color:#00FF00;
	font-family:Tahoma, Geneva, sans-serif;
}
.salah{
	font-size:14px;
	color:#FF0000;
	font-family:Tahoma, Geneva, sans-serif;
}
</style>

<?php
include("../inc/koneksi.php");

$id=$_REQUEST['txtId'];
$kode=$_REQUEST['txtKode'];
$nama=$_REQUEST['txtNama'];
$url=$_REQUEST['txtUrl'];

$level=$_REQUEST['txtLevel'];
$parentid=$_REQUEST['txtParentId'];
$parentkode=$_REQUEST['txtParentKode'];
$modul=$_REQUEST['txtModul'];

switch(strtolower($_REQUEST['op'])){
	
	case 'update':
    	$q = "UPDATE ms_menu SET kode='$kode', nama='$nama', url='$url' WHERE id='$id'";
		$qq = mysql_query($q);
		
		if($qq){
			echo "<span class='betul'>Berhasil diubah...</span>";
		}else{
			echo "<span class='salah'>Gagal !.</span>";
		}
	break; 
	case 'tambah':
		if($kode=='' || $nama=='' || $id=''){
			echo "<span class='salah'>Mohon Isi Data Dengan Lengkap !</span>";
		}else{
			  $q2 = "INSERT INTO ms_menu (kode,nama,url,level,parent_id,parent_kode,islast,aktif,modul_id) VALUES ('$kode','$nama','$url','$level','$parentid','$parentkode','1','1','$modul')";
			  //echo $q2;
			  $qq2 = mysql_query($q2); //echo $q2;
			  
			  if($qq2){
				  echo "<span class='betul'>Berhasil ditambah...</span>";
			  }else{
				  echo "<span class='salah'>Gagal !.</span>";
			  }
			  
		}
	break;
	case 'hapus':
		$cek = "SELECT * from ms_menu where parent_id='$id'";
		$c=mysql_query($cek);
		if(mysql_num_rows($c)>0){
			echo "<span class='salah'>Tidak bisa di hapus, masih punya child.</span>";
		}
		else{
			$q = "DELETE FROM ms_menu WHERE id='$id'";
			$qq = mysql_query($q);
			
			if($qq){
				echo "<span class='betul'>Berhasil dihapus...</span>";
			}else{
				echo "<span class='salah'>Gagal !.</span>";
			}
		}
}
?>