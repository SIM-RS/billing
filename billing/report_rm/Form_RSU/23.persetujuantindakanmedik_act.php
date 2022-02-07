<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$id_tindakan1=$_REQUEST['id_tindakan1'];
	//$tgl_lahir=tglSQL($_REQUEST['tgl_lahir']);
	$id_tindakan2=$_REQUEST['id_tindakan2'];
	$resiko=addslashes($_REQUEST['resiko']);
	$alasan=addslashes($_REQUEST['alasan']);
	$saksi1=addslashes($_REQUEST['saksi1']);
	$saksi2=addslashes($_REQUEST['saksi2']);
	$saksirs=addslashes($_REQUEST['saksirs']);
	//$infus=addslashes($_REQUEST['infus']);
	//$mt=addslashes($_REQUEST['mt']);
	//$bab=addslashes($_REQUEST['bab']);
	//$bak=addslashes($_REQUEST['bak']);
	//$keterangan=addslashes($_REQUEST['keterangan']);

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_tindakan_medik (id,pelayanan_id,id_tindakan1,id_tindakan2,resiko,alasan,saksi1,saksi2,saksirs) VALUES ('$id','$idPel','$id_tindakan1','$id_tindakan2','$resiko','$alasan','$saksi1','$saksi2','$saksirs')";
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
		$sql="UPDATE b_tindakan_medik SET pelayanan_id='$idPel', id_tindakan1='$id_tindakan1', id_tindakan2='$id_tindakan2',resiko='$resiko',alasan='$alasan',saksi1='$saksi1',saksi2='$saksi2',saksirs='$saksirs' WHERE id='$id' ";
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
		$sql="DELETE FROM b_tindakan_medik WHERE id='$id'";
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