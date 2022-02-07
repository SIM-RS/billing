<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$alasan=$_REQUEST['alasan'];
	$petugas=$_REQUEST['petugas'];


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ms_formulir_permintaan_darah (
pelayanan_id,
  tgl,
  alasan_transfusi,
  petugas,
  tgl_act,
  user_act
) 
VALUES
  (
	'$idPel',
 	'$tgl',
  '$alasan',
  '$petugas',
  CURDATE(),
  '$idUsr'
  
  ) ;";
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
		$sql="UPDATE b_ms_formulir_permintaan_darah SET pelayanan_id='$idPel', 
		  tgl='$tgl',
		  alasan_transfusi='$alasan',
		  petugas='$petugas',
		  tgl_act= CURDATE(),
		  user_act='$idUsr'
		  WHERE id='".$_REQUEST['id']."'";
		echo $sql;
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
		$sql="DELETE FROM b_ms_formulir_permintaan_darah WHERE id='$id'";
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