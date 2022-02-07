<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$pokok_masalah=$_REQUEST['pokok_masalah'];
	$kronologis=addslashes($_REQUEST['kronologis']);
	$jenis_kejadian=addslashes($_REQUEST['jenis_kejadian']);
	$pelapor=addslashes($_REQUEST['pelapor']);
	$kejadian_mengenai=addslashes($_REQUEST['kejadian_mengenai']);
	$tgl=tglSQL($_REQUEST['tgl']);
	//$tgl_=$_REQUEST['tgl'];
	$jam=$_REQUEST['jam'];
	$unit_kerja=addslashes($_REQUEST['unit_kerja']);
	$lokasi_kejadian=addslashes($_REQUEST['lokasi_kejadian']);
	$akibat_kejadian=addslashes($_REQUEST['akibat_kejadian']);
	$kejadian_sama=addslashes($_REQUEST['kejadian_sama']);
	$jumlah_kejadian=addslashes($_REQUEST['jumlah_kejadian']);
	$tindakan=addslashes($_REQUEST['tindakan']);
	$grading_resiko=addslashes($_REQUEST['grading_resiko']);

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ms_laporan_kejadian (id,pelayanan_id,pokok_masalah,kronologis,jenis_kejadian,pelapor,kejadian_mengenai,tgl,jam,unit_kerja,lokasi_kejadian,akibat_kejadian,kejadian_sama,jumlah_kejadian,tindakan,grading_resiko) VALUES ('$id','$idPel','$pokok_masalah','$kronologis','$jenis_kejadian','$pelapor','$kejadian_mengenai','$tgl','$jam','$unit_kerja','$lokasi_kejadian','$akibat_kejadian','$kejadian_sama','$jumlah_kejadian','$tindakan','$grading_resiko')";
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
		$sql="UPDATE b_ms_laporan_kejadian SET pelayanan_id='$idPel', pokok_masalah='$pokok_masalah', kronologis='$kronologis',jenis_kejadian='$jenis_kejadian',pelapor='$pelapor',kejadian_mengenai='$kejadian_mengenai',tgl='$tgl',jam='$jam',unit_kerja='$unit_kerja',lokasi_kejadian='$lokasi_kejadian',akibat_kejadian='$akibat_kejadian',kejadian_sama='$kejadian_sama',jumlah_kejadian='$jumlah_kejadian',tindakan='$tindakan',grading_resiko='$grading_resiko' WHERE id='$id' ";
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
		$sql="DELETE FROM b_ms_laporan_kejadian WHERE id='$id'";
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