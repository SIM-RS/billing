<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUser=$_REQUEST['idUser'];
	
	$gastroskope=$_REQUEST['gastroskope'];
	$colonoskope=$_REQUEST['colonoskope'];
	$duadenoskope=$_REQUEST['duadenoskope'];
	$bronkoskope=$_REQUEST['bronkoskope'];
	$s_tgl=$_REQUEST['s_tgl'];

	//S_TES KEBOCORAN
	$s_teskebocoran=$_REQUEST['s_teskebocoran'];
	$statsteskebocoran='';
	for($i=0;$i<=1;$i++){
		$statsteskebocoran.=$s_teskebocoran[$i].',';
		}
	
	$s_tanda=$_REQUEST['s_tanda'];
	$s_skope=$_REQUEST['s_skope'];
	$s_nobath=$_REQUEST['s_nobath'];
	$s_nomulai=$_REQUEST['s_nomulai'];
	$s_selesai=$_REQUEST['s_selesai'];
	$s_pj1=$_REQUEST['s_pj1'];
	// CEK AIR
	$s_cekair=$_REQUEST['s_cekair'];
	$statair='';
	for($i=0;$i<=1;$i++){
		$statair.=$s_cekair[$i].',';
		}
	// CEK ALKOHOL
	$s_cekalkohol=$_REQUEST['s_cekalkohol'];
	$statalkohol='';
	for($i=0;$i<=1;$i++){
		$statalkohol.=$s_cekalkohol[$i].',';
		}
	$s_pj2=$_REQUEST['s_pj2'];
	
	$a_tgl=$_REQUEST['a_tgl'];

	//A_TES KEBOCORAN
	$a_teskebocoran=$_REQUEST['a_teskebocoran'];
	$astatsteskebocoran='';
	for($i=0;$i<=1;$i++){
		$astatsteskebocoran.=$a_teskebocoran[$i].',';
		}
	
	$a_tanda=$_REQUEST['a_tanda'];
	$a_skope=$_REQUEST['a_skope'];
	$a_nobath=$_REQUEST['a_nobath'];
	$a_nomulai=$_REQUEST['a_nomulai'];
	$a_selesai=$_REQUEST['a_selesai'];
	$a_pj1=$_REQUEST['a_pj1'];
	
	// CEK AIR
	$a_cekair=$_REQUEST['a_cekair'];
	$astatair='';
	for($i=0;$i<=1;$i++){
		$astatair.=$$a_cekair[$i].',';
		}
	// CEK ALKOHOL	
	$a_cekalkohol=$_REQUEST['a_cekalkohol'];

	$atatalkohol='';
	for($i=0;$i<=1;$i++){
		$astatalkohol.=$a_cekalkohol[$i].',';
		}
	$a_pj2=$_REQUEST['a_pj2'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ceklist_salurancerna (
pelayanan_id,
  tgl_act,
  gastroskope,
  colonoscope,
  duadenoscope,
  brochoscope,
  s_date,
  s_teskebocoran,
  s_tandakebocoran,
  s_skope,
  s_nobath,
  s_mulaiperendaman,
  s_selesaiperendaman,
  s_penanggungjawab,
  s_spoel_airbersih,
  s_spoel_alkohol,
  s_penanggungjawab2,
  a_date,
  a_teskebocoran,
  a_tandakebocoran,
  a_skope,
  a_nobath,
  a_mulaiperendaman,
  a_selesaiperendaman,
  a_penanggungjawab,
  a_spoel_airbersih,
  a_spoel_alkohol,
  a_penanggungjawab2,
  user_act
) 
VALUES
  (
'$idPel',
 CURDATE(),
 
  '$gastroskope',
  '$colonoskope',
  '$duadenoskope',
  '$bronkoskope',
  
	
	'$s_tgl',
	'$s_teskebocoran',
	's_tanda',
	'$s_skope',
	'$s_nobat',
	'$s_nomulai',
	'$s_selesai',
	'$s_pj1',
	'$s_cekair',
	'$s_cekalkohol',
	'$s_pj2',
	
	'$a_tgl',
	'$a_teskebocoran',
	'a_tanda',
	'$a_skope',
	'$a_nobath',
	'$a_nomulai',
	'$a_selesai',
	'$a_pj1',
	'$a_cekair',
	'$a_cekalkohol',
	'$a_pj2',
	'$idUser'
  
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
		$sql="UPDATE b_ceklist_endoskop_and_bronchoskopi SET pelayanan_id='$idPel', 
		tgl_act= CURDATE(),  

			gastroskope='$gastroskope',
		  colonoscope='$colonoskope',
		  duadenoscope='$duadenoskope',
		  brochoscope='$bronkoskope',


	
	
		  
		  s_date='$s_tgl',
		  s_teskebocoran='$s_teskebocoran',
		  s_tandakebocoran='s_tanda',
		  s_skope='$s_skope',
		  s_nobath='$s_nobat',
		  s_mulaiperendaman='$s_nomulai',
		  s-selesaiperendaman='$s_selesai',
		  s_penanggungjawab='$s_pj1',
		  s_spoel_airbersih='$s_cekair',
		  s_spoel_alkohol='$s_cekalkohol',
		  s_penanggungjawab2='$s_pj2=',

		  a_date='$a_tgl',
		  a_teskebocoran='$a_teskebocoran',
		  a_tandakebocoran='a_tanda',
		  a_skope='$a_skope',
		  a_nobath='$a_nobath',
		  a_mulaiperendaman='$a_nomulai',
		  a-selesaiperendaman='$a_selesai',
		  a_penanggungjawab='$a_pj1',
		  a_spoel_airbersih='$a_cekair',
		  a_spoel_alkohol='$a_cekalkohol',
		  a_penanggungjawab2='$a_pj2',
		  user_act='$idUser'
		  WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		echo $sql;
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
		$sql="DELETE FROM b_ceklist_endoskop_and_bronchoskopi WHERE id='$id'";
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