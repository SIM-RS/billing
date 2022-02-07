<?php
include("../../koneksi/konek.php");
//====================================================================
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$texos=$_REQUEST['texos'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sql="INSERT INTO b_ms_ksr (
pelayanan_id,
os,
  tgl_act,
  user_act
) 
VALUES
  (
	'$idPel',
	'$texos',
  CURDATE(),
  '$idUsr'
  
  ) ;";
		$ex=mysql_query($sql);
		echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_ksr SET pelayanan_id='$idPel', 
		  os='$texos',
		  tgl_act= CURDATE(),
		  user_act='$idUsr'
		  WHERE id='".$_REQUEST['id']."'";
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
		$sql="DELETE FROM b_ms_ksr WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>