<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUser=$_REQUEST['idUser'];
	$dpjp=$_REQUEST['dpjp'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=11;$i++){
		$list.=$c_chk[$i].',';
		}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ceklist_transfusi (
  pelayanan_id,
  dpjp,
  list,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$dpjp',
  '".substr($list,0,-1)."',
  CURDATE(),
  '$idUser') ;";
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
		$sql="UPDATE b_ceklist_transfusi SET pelayanan_id='$idPel', dpjp='$dpjp', list='$list', tgl_act= CURDATE(),
  user_act='$idUser' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
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
		$sql="DELETE FROM b_ceklist_transfusi WHERE id='$id'";
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