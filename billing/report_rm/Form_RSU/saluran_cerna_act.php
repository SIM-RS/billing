<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$txtIdentitas=$_REQUEST['txtIdentitas'];
	$txtGastroskkopi=$_REQUEST['txtGastroskkopi'];
	$txtKolonoskopi=$_REQUEST['txtKolonoskopi'];
	$txtLigasi=$_REQUEST['txtLigasi'];
	$txtPolipectomi=$_REQUEST['txtPolipectomi'];
	$txtKauterisasi=$_REQUEST['txtKauterisasi'];
	$txtSthemoroid=$_REQUEST['txtSthemoroid'];
	$txtSafari=$_REQUEST['txtSafari'];
	$txtKolonoskopisth=$_REQUEST['txtKolonoskopisth'];
	$txtPolipectomihautensasi=$_REQUEST['txtPolipectomihautensasi'];
	$txtHeadprobe=$_REQUEST['txtHeadprobe'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ceklist_salurancerna (
pelayanan_id,
  tgl,
  identitas,
  gastroskopi,
  klonoskopi,
  ligasi,
  polipectomy_gastroskopi,
  kauterisasi_gastroskopi,
  st_hemoroid,
  safary_bouginage,
  kolonoskopi_sth,
  polipectomi_hautensasi_kolon,
  heat_probe_vikusgaster,
  tgl_act,
  user_act
) 
VALUES
  (
'$idPel',
 	'$tgl',
  '$txtIdentitas',
  '$txtGastroskkopi',
  '$txtKolonoskopi',
  '$txtLigasi',
  '$txtPolipectomi',
  '$txtKauterisasi',
  '$txtSthemoroid',
  '$txtSafari',
  '$txtKolonoskopisth',
  '$txtPolipectomihautensasi',
  '$txtHeadprobe',
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
		$sql="UPDATE b_ceklist_salurancerna SET pelayanan_id='$idPel', 
		  tgl='$tgl',
		  identitas='$txtIdentitas',
		  gastroskopi='$txtGastroskkopi',
		  klonoskopi='$txtKolonoskopi',
		  ligasi='$txtLigasi',
		  polipectomy_gastroskopi='$txtPolipectomi',
		  kauterisasi_gastroskopi='$txtKauterisasi',
		  st_hemoroid='$txtSthemoroid',
		  safary_bouginage='$txtSafari',
		  kolonoskopi_sth='$txtKolonoskopisth',
		  polipectomi_hautensasi_kolon='$txtPolipectomihautensasi',
		  heat_probe_vikusgaster='$txtHeadprobe',
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
		$sql="DELETE FROM b_ceklist_salurancerna WHERE id='$id'";
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