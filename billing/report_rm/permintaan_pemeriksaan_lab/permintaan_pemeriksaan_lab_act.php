<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	
	//$textgl_lahir=tglSQL($_REQUEST['textgl_lahir']);
	
	$txt_noForm=addslashes($_REQUEST['txt_noForm']);
	$tgl_terima=tglSQL($_REQUEST['tgl_terima']);
	$checkbox=$_REQUEST['checkbox'];
	$jam_terima=$_REQUEST['jam_terima'];
	$isi='';
	for($i=0;$i<=185;$i++){
		$isi.=$checkbox[$i].',';
		}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	$sql="INSERT INTO b_form_pemeriksaan_lab (
  pelayanan_id,
  kunjungan_id,
  no_formulir,
  tgl_terima,
  jam_terima,
  isi,
  tgl_act,
  user_act
) 
VALUES
  (
    '$idPel',
    '$idKunj',
	'$txt_noForm',
	'$tgl_terima',
	'$jam_terima',	
	'".substr($isi,0,-1)."',
    CURDATE(),
    '$idUsr'
  
  ) ;";
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
	$sql="UPDATE b_form_pemeriksaan_lab SET
  pelayanan_id='$idPel',
  kunjungan_id='$idKunj', 
  no_formulir='$txt_noForm',
  tgl_terima='$tgl_terima',
  jam_terima='$jam_terima',
  isi='".substr($isi,0,-1)."',
  tgl_act=CURDATE(),
  user_act='$idUsr' 
  WHERE id='".$_REQUEST['id']."'";
 // WHERE id='".$_REQUEST['txtId']."'";

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
		$sql="DELETE FROM b_form_pemeriksaan_lab WHERE id='$id'";
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