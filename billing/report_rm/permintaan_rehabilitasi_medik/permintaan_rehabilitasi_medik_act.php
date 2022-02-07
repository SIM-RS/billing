<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$formulir=addslashes($_REQUEST['formulir']);
	$isi=addslashes($_REQUEST['isi']);
	//$hasil=addslashes($_REQUEST['hasil']);
	$idUsr=$_REQUEST['idUsr'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=22;$i++){
		$cek.=$c_chk[$i].',';
		}
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_permintaan_rehabilitasi_medik (pelayanan_id,
				formulir,
				isi,
				cek,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$formulir',
				'$isi',
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
		$sql="UPDATE b_ms_permintaan_rehabilitasi_medik SET pelayanan_id='$idPel',
		formulir='$formulir',
		isi='$isi',
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
		$sql="DELETE FROM b_ms_permintaan_rehabilitasi_medik WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
}
?>