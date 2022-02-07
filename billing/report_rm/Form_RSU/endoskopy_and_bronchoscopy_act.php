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
	$s_tgl=tglSQL($_REQUEST['s_tgl']);


	//S_TES KEBOCORAN
	$s_teskebocoran=$_REQUEST['s_teskebocoran'];
	//$statsteskebocoran='';
	//for($i=0;$i<=1;$i++){
		//$statsteskebocoran.=$s_teskebocoran[$i].',';
		//}
	
	$s_tanda=$_REQUEST['s_tanda'];
	$s_skope=$_REQUEST['s_skope'];
	$s_nobath=$_REQUEST['s_nobath'];
	$s_nomulai=$_REQUEST['s_nomulai'];
	$s_selesai=$_REQUEST['s_selesai'];
	$s_pj1=$_REQUEST['s_pj1'];
	// CEK AIR
	$s_cekair=$_REQUEST['s_cekair'];
	//$statair='';
	//for($i=0;$i<=1;$i++){
		//$statair.=$s_cekair[$i].',';
		//}
	// CEK ALKOHOL
	$s_cekalkohol=$_REQUEST['s_cekalkohol'];
//	$statalkohol='';
	//for($i=0;$i<=1;$i++){
	//	$statalkohol.=$s_cekalkohol[$i].',';
	//	}
	$s_pj2=$_REQUEST['s_pj2'];
	
	$a_tgl=tglSQL($_REQUEST['a_tgl']);
	

	//A_TES KEBOCORAN
	$a_teskebocoran=$_REQUEST['a_teskebocoran'];
	//$astatsteskebocoran='';
	//for($i=0;$i<=1;$i++){
		//$astatsteskebocoran.=$a_teskebocoran[$i].',';
		//}
	
	$a_tanda=$_REQUEST['a_tanda'];
	$a_skope=$_REQUEST['a_skope'];
	$a_nobath=$_REQUEST['a_nobath'];
	$a_nomulai=$_REQUEST['a_nomulai'];
	$a_selesai=$_REQUEST['a_selesai'];
	$a_pj1=$_REQUEST['a_pj1'];
	
	// CEK AIR
	$a_cekair=$_REQUEST['a_cekair'];
	//$astatair='';
	//for($i=0;$i<=1;$i++){
		//$astatair.=$$a_cekair[$i].',';
		//}
	// CEK ALKOHOL	
	$a_cekalkohol=$_REQUEST['a_cekalkohol'];

	//$atatalkohol='';
	//for($i=0;$i<=1;$i++){
		//$astatalkohol.=$a_cekalkohol[$i].',';
		//}
	$a_pj2=$_REQUEST['a_pj2'];
//	$radiobutton[0]=$_REQUEST['radiobutton[0]'];
//	$radiobutton[1]=$_REQUEST['radiobutton[1]'];
	//$radiobutton[2]=$_REQUEST['radiobutton[2]'];
	//$radiobutton[3]=$_REQUEST['radiobutton[3]'];
	$anesfar=$_REQUEST['anesfar'];
	$pethidine=$_REQUEST['pethidine'];
	$andrenaline=$_REQUEST['andrenaline'];
	$recopol=$_REQUEST['recopol'];
	$sa=$_REQUEST['sa'];
	$buscopan=$_REQUEST['buscopan'];
	$aetoxysclerol=$_REQUEST['aetoxysclerol'];
	$factusup=$_REQUEST['factusup'];
	$xylocain=$_REQUEST['xylocain'];
	$td=$_REQUEST['td'];
	$spo2=$_REQUEST['spo2'];
	$r=$_REQUEST['r'];
	//$radiobutton[4]=$_REQUEST['radiobutton[4]'];
//	$radiobutton[5]=$_REQUEST['radiobutton[5]'];
	//$radiobutton[6]=$_REQUEST['radiobutton[6]'];
	$potensial_perdarahan=$_REQUEST['potensial_perdarahan'];
	$rest_infeksi=$_REQUEST['rest_infeksi'];
	$restiaspirasi=$_REQUEST['restiaspirasi'];
	$resti_syok=$_REQUEST['resti_syok'];
	$selesai_tindakan=date($_REQUEST['selesai_tindakan']);
	//$radiobutton[7]=$_REQUEST['radiobutton[7]'];
	//$radiobutton[8]=$_REQUEST['radiobutton[8]'];
	//$radiobutton[9]=$_REQUEST['radiobutton[9]'];
	$spuit_5cc=$_REQUEST['spuit_5cc'];
	$spuit_3cc=$_REQUEST['spuit_3cc'];
	$spuit_10cc=$_REQUEST['spuit_10cc'];
	$spuit_20cc=$_REQUEST['spuit_20cc'];
	$infus_set=$_REQUEST['infus_set'];
	$cidex_opa=$_REQUEST['cidex_opa'];
	$vasofik=$_REQUEST['vasofik'];
	$neddle=$_REQUEST['neddle'];
	$tegaderm=$_REQUEST['tegaderm'];
	$aquabides=$_REQUEST['aquabides'];
	$xylocain2=$_REQUEST['xylocain2'];
	$selangO2=$_REQUEST['selangO2'];
	$alkohol_swab=$_REQUEST['alkohol_swab'];
	$radiobutton=$_REQUEST['radiobutton'];
	$nacl=$_REQUEST['nacl'];
	$_cc=$_REQUEST['_cc'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ceklist_endoskop_and_bronchoskopi (
pelayanan_id,
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
	g_rasaaman,
	g_rasanyaman,
	perubahan_pola,
	posisi_pasien_mkk,
	anesfar,
	pethidine,
	adrenaline,
	recopol,
	sa,
	buscopan,
	aetoxysclerol,
	fatu_supp,
	xylocain_Spray,
	td,
	spo2,
	r,
	monitoring_perdarahan,
	monitoring_perdarahan_bilaada,
	monitoring_alat,
	g_rasanyaman2,
	potensial_perdarahan,
	resti_infeksi,
	resti_aspirasi,
	resti_syok,
	selesai_tindakan,
	posisi_pasien,
	keadaan_umum_pas,
	lama_observasi,
	spuit_5cc,
	spuit_3cc,
	spuit_10cc,
	spuit_20cc,
	infus_set,
	cidex_opa,
	vasofik,
	neddle,
	tegaderm,
	aquabidest,
	xylocain,
	selang_O2,
	alkohol_swab,
	nacl,
  tgl_act,
  user_act
) 
VALUES
  (
'$idPel',

  '$gastroskope',
  '$colonoskope',
  '$duadenoskope',
  '$bronkoskope',
	'$s_tgl',
	'$s_teskebocoran',
	'$s_tanda',
	'$s_skope',
	'$s_nobath',
	'$s_nomulai',
	'$s_selesai',
	'$s_pj1',
  	'$s_cekair',
  	'$s_cekalkohol',
	'$s_pj2',
	'$a_tgl',
	 '$a_teskebocoran',
	'$a_tanda',
	'$a_skope',
	'$a_nobath',
	'$a_nomulai',
	'$a_selesai',
	'$a_pj1',
 	 '$a_cekair',
  	'$a_cekalkohol',
	'$a_pj2',
	'$radiobutton[0]',
	'$radiobutton[1]',
	'$radiobutton[2]',
	'$radiobutton[3]',
	'$anesfar',
	'$pethidine',
	'$andrenaline',
	'$recopol',
	'$sa',
	'$buscopan',
	'$aetoxysclerol',
	'$factusup',
	'$xylocain',
	'$td',
	'$spo2',
	'$r',
	'$radiobutton[4]',
	'$_cc',
	'$radiobutton[5]',
	'$radiobutton[6]',
	'$potensial_perdarahan',
	'$rest_infeksi',
	'$restiaspirasi',
	'$resti_syok',
	'$selesai_tindakan',
	'$radiobutton[7]',
	'$radiobutton[8]',
	'$radiobutton[9]',
	'$spuit_5cc',
	'$spuit_3cc',
	'$spuit_10cc',
	'$spuit_20cc',
	'$infus_set',
	'$cidex_opa',
	'$vasofik',
	'$neddle',
	'$tegaderm',
	'$aquabides',
	'$xylocain2',
	'$selangO2',
	'$alkohol_swab',
	'$nacl',
	 CURDATE(),
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
		  gastroskope='$gastroskope',
		  colonoscope='$colonoskope',
		  duadenoscope='$duadenoskope',
		  brochoscope='$bronkoskope',
		  s_date='$s_tgl',
		  s_teskebocoran='$s_teskebocoran',
		  s_tandakebocoran='$s_tanda',
		  s_skope='$s_skope',
		  s_nobath='$s_nobath',
		  s_mulaiperendaman='$s_nomulai',
		  s_selesaiperendaman='$s_selesai',
		  s_penanggungjawab='$s_pj1',
		  s_spoel_airbersih='$s_cekair',
		  s_spoel_alkohol='$s_cekalkohol',
		  s_penanggungjawab2='$s_pj2',
		  a_date='$a_tgl',
		  a_teskebocoran='$a_teskebocoran',
		  a_tandakebocoran='$a_tanda',
		  a_skope='$a_skope',
		  a_nobath='$a_nobath',
		  a_mulaiperendaman='$a_nomulai',
		  a_selesaiperendaman='$a_selesai',
		  a_penanggungjawab='$a_pj1',
		  a_spoel_airbersih='$a_cekair',
		  a_spoel_alkohol='$a_cekalkohol',
		  a_penanggungjawab2='$a_pj2',
		 	 g_rasaaman='$radiobutton[0]',
			g_rasanyaman='$radiobutton[1]',
			perubahan_pola='$radiobutton[2]',
			posisi_pasien_mkk='$radiobutton[3]',
			anesfar='$anesfar',
			pethidine='$pethidine',
			adrenaline='$andrenaline',
			recopol='$recopol',
			sa='$sa',
			buscopan='$buscopan',
			aetoxysclerol='$aetoxysclerol',
			fatu_supp='$factusup',
			xylocain_Spray='$xylocain',
			td='$td',
			spo2='$spo2',
			r='$r',
			monitoring_perdarahan='$radiobutton[4]',
			monitoring_perdarahan_bilaada='$_cc',
			monitoring_alat='$radiobutton[5]',
			g_rasanyaman2='$radiobutton[6]',
			potensial_perdarahan='$potensial_perdarahan',
			resti_infeksi='$rest_infeksi',
			resti_aspirasi='$restiaspirasi',
			resti_syok='$resti_syok',
			selesai_tindakan='$selesai_tindakan',
			posisi_pasien='$radiobutton[7]',
			keadaan_umum_pas='$radiobutton[8]',
			lama_observasi='$radiobutton[9]',
			spuit_5cc='$spuit_5cc',
			spuit_3cc='$spuit_3cc',
			spuit_10cc='$spuit_10cc',
			spuit_20cc='$spuit_20cc',
			infus_set='$infus_set',
			cidex_opa='$cidex_opa',
			vasofik='$vasofik',
			neddle='$neddle',
			tegaderm='$tegaderm',
			aquabidest='$aquabides',
			xylocain='$xylocain2',
			selang_O2='$selangO2',
			alkohol_swab='$alkohol_swab',
			nacl='$nacl',
		 	tgl_act= CURDATE(),  
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