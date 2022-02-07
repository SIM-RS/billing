<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
//	$idKunj=$_REQUEST['idKunj'];
	$txt_tind=$_REQUEST['txt_tind'];
	$txt_resiko=$_REQUEST['txt_resiko'];


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_fom_tolak_tind_medis (
  pelayanan_id,
  tindakan,
  resiko,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$txt_tind',
  '$txt_resiko',
  CURDATE(),
  '$idUsr'
  ) ;";
  //echo $sql;
  $ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil disimpan !";
		}
		else
		{
			echo "Data gagal disimpan !";
		}

	break;
	case 'edit':
		$sql="UPDATE b_fom_tolak_tind_medis SET pelayanan_id='$idPel', 
		  tindakan='$txt_tind',
		  resiko='$txt_resiko',
		  tgl_act= CURDATE(),
		  user_act='$idUsr'
		  WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex)
		{
			echo "Data berhasil diupdate !";
		}
		else
		{
			echo "Data gagal diupdate !";
		}
	break;
	case 'hapus':
		$sql="DELETE FROM b_fom_tolak_tind_medis WHERE id='$id'";
		$ex=mysql_query($sql);
		if($ex)
		{
			echo "Data berhasil dihapus !";
		}
		else
		{
			echo "Data gagal dihapus !";
		}
	break;
		
}
?>