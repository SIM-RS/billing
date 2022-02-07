<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUser=$_REQUEST['idUser'];
	$penerima_kuasa=$_REQUEST['penerima_kuasa'];
	//$tgl_lahir=tglSQL($_REQUEST['tgl_lahir']);
	$alamat=$_REQUEST['alamat'];
	$no_ktp=addslashes($_REQUEST['no_ktp']);
	$tgl_r=tglSQL($_REQUEST['tgl_r']);
	$tgl_l=tglSQL($_REQUEST['tgl_l']);
	$tgl_ra=tglSQL($_REQUEST['tgl_ra']);
	$hasil_lain=addslashes($_REQUEST['hasil_lain']);
	$hubungan=addslashes($_REQUEST['hubungan']);
	//$saksi1=addslashes($_REQUEST['saksi1']);
//	$saksi2=addslashes($_REQUEST['saksi2']);
//	$saksirs=addslashes($_REQUEST['saksirs']);
	//$infus=addslashes($_REQUEST['infus']);
	//$mt=addslashes($_REQUEST['mt']);
	//$bab=addslashes($_REQUEST['bab']);
	//$bak=addslashes($_REQUEST['bak']);
	//$keterangan=addslashes($_REQUEST['keterangan']);

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_surat_kuasa_medis (id,pelayanan_id,user_act,tgl_act,penerima_kuasa,alamat,no_ktp,tgl_r,tgl_l,tgl_ra,hasil_lain,hubungan) VALUES ('$id','$idPel','$idUser', CURDATE(),'$penerima_kuasa','$alamat','$no_ktp','$tgl_r','$tgl_l','$tgl_ra','$hasil_lain','$hubungan')";
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
		$sql="UPDATE b_surat_kuasa_medis SET pelayanan_id='$idPel', penerima_kuasa='$penerima_kuasa', alamat='$alamat',no_ktp='$no_ktp',tgl_r='$tgl_r',tgl_l='$tgl_l',tgl_ra='$tgl_ra',hasil_lain='$hasil_lain',hubungan='$hubungan' WHERE id='$id' ";
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