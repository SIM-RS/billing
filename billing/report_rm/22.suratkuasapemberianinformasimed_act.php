<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUser=$_REQUEST['idUser'];
	$no_permintaan=$_REQUEST['no_permintaan'];
	//$tgl_lahir=tglSQL($_REQUEST['tgl_lahir']);
	$mengenai=$_REQUEST['mengenai'];
	$kepada=addslashes($_REQUEST['kepada']);
	$tgl_r=tglSQL($_REQUEST['tgl_r']);
	$tgl_l=tglSQL($_REQUEST['tgl_l']);
	$tgl_ra=tglSQL($_REQUEST['tgl_ra']);
	$hasil_lain=addslashes($_REQUEST['hasil_lain']);

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_surat_kuasa_medis (id,pelayanan_id,user_act,tgl_act,no_permintaan,mengenai,kepada,tgl_r,tgl_l,tgl_ra,hasil_lain) VALUES ('$id','$idPel','$idUser', CURDATE(),'$no_permintaan','$mengenai','$kepada','$tgl_r','$tgl_l','$tgl_ra','$hasil_lain')";
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
		$sql="UPDATE b_surat_kuasa_medis SET pelayanan_id='$idPel', no_permintaan='$no_permintaan', mengenai='$mengenai',kepada='$kepada',tgl_r='$tgl_r',tgl_l='$tgl_l',tgl_ra='$tgl_ra',hasil_lain='$hasil_lain' WHERE id='$id' ";
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
		$sql="DELETE FROM b_surat_kuasa_medis WHERE id='$id'";
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