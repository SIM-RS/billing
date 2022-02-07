<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$keluhan=addslashes($_REQUEST['keluhan']);
	$od=addslashes($_REQUEST['od']);
	$os=addslashes($_REQUEST['os']);
	$presbyopia=addslashes($_REQUEST['presbyopia']);
	$visus1=addslashes($_REQUEST['visus1']);
	$visus2=addslashes($_REQUEST['visus2']);
	$koreksi1=addslashes($_REQUEST['koreksi1']);
	$koreksi2=addslashes($_REQUEST['koreksi2']);
	$adisi1=addslashes($_REQUEST['adisi1']);
	$adisi2=addslashes($_REQUEST['adisi2']);
	$kedudukan1=addslashes($_REQUEST['kedudukan1']);
	$kedudukan2=addslashes($_REQUEST['kedudukan2']);
	$palpebra1=addslashes($_REQUEST['palpebra1']);
	$palpebra2=addslashes($_REQUEST['palpebra2']);
	$conjunctiva1=addslashes($_REQUEST['conjunctiva1']);
	$conjunctiva2=addslashes($_REQUEST['conjunctiva2']);
	$cornea1=addslashes($_REQUEST['cornea1']);
	$cornea2=addslashes($_REQUEST['cornea2']);
	$coa1=addslashes($_REQUEST['coa1']);
	$coa2=addslashes($_REQUEST['coa2']);
	$pupil1=addslashes($_REQUEST['pupil1']);
	$pupil2=addslashes($_REQUEST['pupil2']);
	$iris1=addslashes($_REQUEST['iris1']);
	$iris2=addslashes($_REQUEST['iris2']);
	$lensa1=addslashes($_REQUEST['lensa1']);
	$lensa2=addslashes($_REQUEST['lensa2']);
	$vitreous1=addslashes($_REQUEST['vitreous1']);
	$vitreous2=addslashes($_REQUEST['vitreous2']);
	$fundus1=addslashes($_REQUEST['fundus1']);
	$fundus2=addslashes($_REQUEST['fundus2']);
	$tio1=addslashes($_REQUEST['tio1']);
	$tio2=addslashes($_REQUEST['tio2']);
	$campus1=addslashes($_REQUEST['campus1']);
	$campus2=addslashes($_REQUEST['campus2']);
	$anjuran=addslashes($_REQUEST['anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_laporan_mata (pelayanan_id,
				keluhan,
				od,
				os,
				presbyopia,
				visus1,
				visus2,
				koreksi1,
				koreksi2,
				adisi1,
				adisi2,
				kedudukan1,
				kedudukan2,
				palpebra1,
				palpebra2,
				conjunctiva1,
				conjunctiva2,
				cornea1,
				cornea2,
				coa1,
				coa2,
				pupil1,
				pupil2,
				iris1,
				iris2,
				lensa1,
				lensa2,
				vitreous1,
				vitreous2,
				fundus1,
				fundus2,
				tio1,
				tio2,
				campus1,
				campus2,
				test,
				anjuran,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$keluhan',
				'$od',
				'$os',
				'$presbyopia',
				'$visus1',
				'$visus2',
				'$koreksi1',
				'$koreksi2',
				'$adisi1',
				'$adisi2',
				'$kedudukan1',
				'$kedudukan2',
				'$palpebra1',
				'$palpebra2',
				'$conjunctiva1',
				'$conjunctiva2',
				'$cornea1',
				'$cornea2',
				'$coa1',
				'$coa2',
				'$pupil1',
				'$pupil2',
				'$iris1',
				'$iris2',
				'$lensa1',
				'$lensa2',
				'$vitreous1',
				'$vitreous2',
				'$fundus1',
				'$fundus2',
				'$tio1',
				'$tio2',
				'$campus1',
				'$campus2',
				'$radio[0]',
				'$anjuran',
				CURDATE(),
  				'$idUsr') ;";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_laporan_mata SET pelayanan_id='$idPel',
		keluhan='$keluhan',
		od='$od',
		os='$os',
		presbyopia='$presbyopia',
		visus1='$visus1',
		visus2='$visus2',
		koreksi1='$koreksi1',
		koreksi2='$koreksi2',
		adisi1='$adisi1',
		adisi2='$adisi2',
		kedudukan1='$kedudukan1',
		kedudukan2='$kedudukan2',
		palpebra1='$palpebra1',
		palpebra2='$palpebra2',
		conjunctiva1='$conjunctiva1',
		conjunctiva2='$conjunctiva2',
		cornea1='$cornea1',
		cornea2='$cornea2',
		coa1='$coa1',
		coa2='$coa2',
		pupil1='$pupil1',
		pupil2='$pupil2',
		iris1='$iris1',
		iris2='$iris2',
		lensa1='$lensa1',
		lensa2='$lensa2',
		vitreous1='$vitreous1',
		vitreous2='$vitreous2',
		fundus1='$fundus1',
		fundus2='$fundus2',
		tio1='$tio1',
		tio2='$tio2',
		campus1='$campus1',
		campus2='$campus2',
		test='$radio[0]',
		anjuran='$anjuran',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo mysql_error();
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_laporan_mata WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>