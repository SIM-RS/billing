<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$tanggal=tglSQL($_REQUEST['tanggal']);
	$jam=$_REQUEST['jam'];
	$anamnesis=$_REQUEST['anamnesis'];
	$hubungan=$_REQUEST['hubungan'];
	$keluhan_utama=$_REQUEST['keluhan_utama'];
	$riwayat_ps=$_REQUEST['riwayat_ps'];
	$alergi=$_REQUEST['alergi'];
	$riwayat_pd=$_REQUEST['riwayat_pd'];
	$tahun=$_REQUEST['tahun'];
	$riwayat_pengobatan=$_REQUEST['hubungan'];
	$riwayat_pdk=$_REQUEST['riwayat_pdk'];
	$riwayat_pekerjaan=$_REQUEST['riwayat_pekerjaan'];
	$hubungan=$_REQUEST['hubungan'];
	//$tgl=tglSQL($_REQUEST['tgl']);


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ms_pengkajian_awal_medis (
  pelayanan_id,
  tanggal,
  jam,
	anamnesis,
	hubungan,
	keluhan_utama,
	riwayat_ps,
	alergi,
	tahun,
	riwayat_pd,
	riwayat_pengobatan,
	riwayat_pdk,
	riwayat_pekerjaan,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$tanggal',
  '$jam',
  '$anamnesis',
  '$hubungan',
  '$keluhan_utama',
  '$riwayat_ps',
  '$alergi',
  '$tahun',
  '$riwayat_pd',
  '$riwayat_pengobatan',
  '$riwayat_pdk',
  '$riwayat_pekerjaan',
  CURDATE(),
  '$idUsr'
  
  ) ;";
  echo $sql;
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
		$sql="UPDATE b_ms_pengkajian_awal_medis SET pelayanan_id='$idPel', 
		 tanggal='$tanggal',
		jam='$jam',
		anamnesis='$anamnesis',
		hubungan='$hubungan',
		keluhan_utama='$keluhan_utama',
		riwayat_ps='$riwayat_ps',
		alergi='$alergi',
		tahun='$tahun',
		riwayat_pd='$riwayat_pd',
		riwayat_pengobatan='$riwayat_pengobatan',
		riwayat_pdk='$riwayat_pdk',
		riwayat_pekerjaan='$riwayat_pekerjaan',
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
		$sql="DELETE FROM b_ms_pengkajian_awal_medis WHERE id='$id'";
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