<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$id=$_REQUEST['id'];
	$idKunj=$_REQUEST['idKunj'];
	$id_dokter_pengganti=$_REQUEST['id_dokter_pengganti'];
	$alasan=$_REQUEST['alasan'];
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_alih_rawat (pelayanan_id,
				id_dokter_pengganti,
				alasan,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$id_dokter_pengganti',
				'$alasan',
				CURDATE(),
  				'$idUsr') ;";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_alih_rawat SET pelayanan_id='$idPel',
		
		id_dokter_pengganti='$id_dokter_pengganti',
		alasan='$alasan',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				//echo mysql_error();
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_fom_alih_rawat WHERE id='$id'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>