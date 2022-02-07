<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$formulir=addslashes($_REQUEST['formulir']);
	$id_konsultan=addslashes($_REQUEST['id_konsultan']);
	//$hasil=addslashes($_REQUEST['hasil']);
	$idUsr=$_REQUEST['idUsr'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=65;$i++){
		$cek.=$c_chk[$i].',';
		}
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_pemeriksaan_diagnostik (pelayanan_id,
				formulir,
				id_konsultan,
				cek,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$formulir',
				'$id_konsultan',
				'".substr($cek,0,-1)."',
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
		$sql="UPDATE b_pemeriksaan_diagnostik SET pelayanan_id='$idPel',
		formulir='$formulir',
		id_konsultan='$id_konsultan',
		cek='$cek',
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
		$sql="DELETE FROM b_pemeriksaan_diagnostik WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>