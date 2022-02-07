<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$ket_klinis=$_REQUEST['ket_klinis'];
	$hasil=$_REQUEST['hasil'];
	$audio=$_REQUEST['audio'];
	$speech=$_REQUEST['speech'];
	$periksa_k=$_REQUEST['periksa_k'];
	$saran=$_REQUEST['saran'];
	$kk=$_REQUEST['kk'];
	$dr_act=$_REQUEST['dr_act'];
	$idUser=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_hasil_audiometri (pelayanan_id,
				kunjungan_id,
				ket_klinis,
				hasil,
				audio,
				speech,
				periksa_k,
				saran,
				kk,
				dr_act,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$idKunj',
				'$ket_klinis',
				'$hasil',
				'$audio',
				'$speech',
				'$periksa_k',
				'$saran',
				'$kk',
				'$dr_act',
				CURDATE(),
  				'$idUser') ;";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_hasil_audiometri SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		ket_klinis='$ket_klinis',
		hasil='$hasil',
		audio='$audio',
		speech='$speech',
		periksa_k='$periksa_k',
		saran='$saran',
		kk='$kk',
		dr_act='$dr_act',
		tgl_act=CURDATE(),
		user_act='$idUser' WHERE id='".$_REQUEST['txtId']."'";
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
		$sql="DELETE FROM b_fom_hasil_audiometri WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>