<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$nama1=$_REQUEST['nama1'];
	$tgl_lahir=tglSQL($_REQUEST['TglLahir']);
	$umur=$_REQUEST['th'];
	$jenis_kelamin=$_REQUEST['jenis_kelamin'];
	$alamat=$_REQUEST['alamat'];
	$no_telp=$_REQUEST['no_telp'];
	$no_ktp=$_REQUEST['no_ktp'];
	$hubungan=$_REQUEST['hubungan'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$sehingga.=$c_chk[$i].',';
		}
	$alasan=$_REQUEST['alasan'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$jam=$_REQUEST['jam'];
	$saksi1=$_REQUEST['saksi1'];
	$saksi2=$_REQUEST['saksi2'];


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ms_penolakan_pemberian_darah (
  pelayanan_id,
  nama1,
  tgl_lahir,
  umur,
  jenis_kelamin,
  alamat,
  no_telp,
  no_ktp,
  hubungan,
  sehingga,
  alasan,
  tgl,
  jam,
  saksi1,
  saksi2,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$nama1',
  '$tgl_lahir',
  '$umur',
  '$jenis_kelamin',
  '$alamat',
  '$no_telp',
  '$no_ktp',
  '$hubungan',
  '".substr($sehingga,0,-1)."',
  '$alasan',
  '$tgl',
  '$jam',
  '$saksi1',
  '$saksi2',
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
		$sql="UPDATE b_ms_penolakan_pemberian_darah SET pelayanan_id='$idPel', 
		  nama1='$nama1',
		  tgl_lahir='$tgl_lahir',
		  umur='$umur',
		  jenis_kelamin='$jenis_kelamin',
		  alamat='$alamat',
		  no_telp='$no_telp',
		  no_ktp='$no_ktp',
		  hubungan='$hubungan',
		  sehingga='$sehingga',
		  alasan='$alasan',
		  tgl='$tgl',
		  jam='$jam',
		  saksi1='$saksi1',
		  saksi2='$saksi2',
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
		$sql="DELETE FROM b_ms_penolakan_pemberian_darah WHERE id='$id'";
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