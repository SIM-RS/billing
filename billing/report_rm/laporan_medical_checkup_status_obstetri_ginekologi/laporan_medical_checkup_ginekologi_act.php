<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$nikah=addslashes($_REQUEST['nikah']);
	$lama=addslashes($_REQUEST['lama']);
	$cerai=addslashes($_REQUEST['cerai']);
	$keluhan=addslashes($_REQUEST['keluhan']);
	$menarche=addslashes($_REQUEST['menarche']);
	$lamahaid=addslashes($_REQUEST['lamahaid']);
	$dysmenorrhoe=addslashes($_REQUEST['dysmenorrhoe']);
	$dyspareuni=addslashes($_REQUEST['dyspareuni']);
	$kontrasepsi=addslashes($_REQUEST['kontrasepsi']);
	$flour=addslashes($_REQUEST['flour']);
	$fluxus=addslashes($_REQUEST['fluxus']);
	$gangguan_m=addslashes($_REQUEST['gangguan_m']);
	$gangguan_d=addslashes($_REQUEST['gangguan_d']);
	$lain=addslashes($_REQUEST['lain']);
	$riwayat_o=addslashes($_REQUEST['riwayat_o']);
	$riwayat_g=addslashes($_REQUEST['riwayat_g']);
	$abdomen=addslashes($_REQUEST['abdomen']);
	$vulva=addslashes($_REQUEST['vulva']);
	$uretra=addslashes($_REQUEST['uretra']);
	$vagina=addslashes($_REQUEST['vagina']);
	$cervix=addslashes($_REQUEST['cervix']);
	$adnexa=addslashes($_REQUEST['adnexa']);
	$cul=addslashes($_REQUEST['cul']);
	$pap=addslashes($_REQUEST['pap']);
	$anjuran=addslashes($_REQUEST['anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	//$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=0;$i++){
		$cerai.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_laporan_obstetri_ginekologi (pelayanan_id,
				nikah,
				lama,
				cerai,
				keluhan,
				menarche,
				lamahaid,
				dysmenorrhoe,
				dyspareuni,
				kontrasepsi,
				flour,
				fluxus,
				gangguan_m,
				gangguan_d,
				lain,
				riwayat_o,
				riwayat_g,
				abdomen,
				vulva,
				uretra,
				vagina,
				cervix,
				adnexa,
				cul,
				pap,
				anjuran,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$nikah',
				'$lama',
				'$cerai',
				'$keluhan',
				'$menarche',
				'$lamahaid',
				'$dysmenorrhoe',
				'$dyspareuni',
				'$kontrasepsi',
				'$flour',
				'$fluxus',
				'$gangguan_m',
				'$gangguan_d',
				'$lain',
				'$riwayat_o',
				'$riwayat_g',
				'$abdomen',
				'$vulva',
				'$uretra',
				'$vagina',
				'$cervix',
				'$adnexa',
				'$cul',
				'$pap',
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
		$sql="UPDATE b_laporan_obstetri_ginekologi SET pelayanan_id='$idPel',
		nikah='$nikah',
		lama='$lama',
		cerai='$cerai',
		keluhan='$keluhan',
		menarche='$menarche',
		lamahaid='$lamahaid',
		dysmenorrhoe='$dysmenorrhoe',
		dyspareuni='$dyspareuni',
		kontrasepsi='$kontrasepsi',
		flour='$flour',
		fluxus='$fluxus',
		gangguan_m='$gangguan_m',
		gangguan_d='$gangguan_d',
		lain='$lain',
		riwayat_o='$riwayat_o',
		riwayat_g='$riwayat_g',
		abdomen='$abdomen',
		vulva='$vulva',
		uretra='$uretra',
		vagina='$vagina',
		cervix='$cervix',
		adnexa='$adnexa',
		cul='$cul',
		pap='$pap',
		anjuran='$anjuran',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil diupdate !";
			}else{
				echo mysql_error();
				echo "Data gagal diupdate !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_laporan_obstetri_ginekologi WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>