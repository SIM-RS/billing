<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$dokter=addslashes($_REQUEST['dokter']);
	$keluhan=addslashes($_REQUEST['keluhan']);
	$hasil=addslashes($_REQUEST['hasil']);
	$idUsr=$_REQUEST['idUsr'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_konsultasi (pelayanan_id,
				dokter,
				keluhan,
				hasil,
				pilihan,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$dokter',
				'$keluhan',
				'$hasil',
				'".substr($pilihan,0,-1)."',
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
		$sql="UPDATE b_konsultasi SET pelayanan_id='$idPel',
		dokter='$dokter',
		keluhan='$keluhan',
		hasil='$hasil',
		pilihan='$pilihan',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_konsultasi WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>