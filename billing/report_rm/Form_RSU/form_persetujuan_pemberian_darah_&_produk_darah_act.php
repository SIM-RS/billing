<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$texnama=$_REQUEST['texnama'];
	//$textgl_lahir=tglSQL($_REQUEST['textgl_lahir']);
	$textgl_lahir=tglSQL($_REQUEST['textgl_lahir']);
	$texumur=$_REQUEST['texumur'];
	$texalamat=$_REQUEST['texalamat'];
	$texno_tlp=$_REQUEST['texno_tlp'];
	$radiobutton=$_REQUEST['radiobutton'];
	$texno_ktp=$_REQUEST['texno_ktp'];
	$texhubungan=$_REQUEST['texhubungan'];
	//pemahaman
	$checkbox=$_REQUEST['checkbox'];
	$pemahaman='';
	for($i=0;$i<=2;$i++){
		$pemahaman.=$checkbox[$i].',';
		}
//	$checkbox=$_REQUEST['checkbox'];
	$textgl=$_REQUEST['textgl'];
	$texjam=$_REQUEST['texjam'];
	$texsaksi1=$_REQUEST['texsaksi1'];
	$texsaksi2=$_REQUEST['texsaksi2'];


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_form_persetujuan_pemberian_darah (
	pelayanan_id,
	name,
	taggal_lahir,
	umur,
	jenis_kelamin,
	alamat,
	no_telp,
	no_ktp_sim,
	hubungan,
	pemahaman,
	tanggal,
	jam,
	saksi1,
	saksi2,
  	tgl_act,
  	user_act
) 
VALUES
  (
	'$idPel',
	'$texnama',
	'$textgl_lahir',
	'$texumur',
	'$radiobutton',
	'$texalamat',
	'$texno_tlp',
	'$texno_ktp',
	'$texhubungan',
	'".substr($pemahaman,0,-1)."',
	'$textgl',
	'$texjam',
	'$texsaksi1',
	'$texsaksi2',
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
		$sql="UPDATE b_form_persetujuan_pemberian_darah SET pelayanan_id='$idPel', 
		  name='$texnama',
		  taggal_lahir='$textgl_lahir',
		  umur='$texumur',
		  jenis_kelamin='$radiobutton',
		  alamat='$texalamat',
		  no_telp='$texno_tlp',
		  no_ktp_sim='$texno_ktp',
		  hubungan='$texhubungan',
		  pemahaman='".substr($pemahaman,0,-1)."',
		  tanggal='$textgl',
		  jam='$texjam',
		  saksi1='$texsaksi1',
		  saksi2='$texsaksi2',
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
		$sql="DELETE FROMb_form_persetujuan_pemberian_darah WHERE id='$id'";
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