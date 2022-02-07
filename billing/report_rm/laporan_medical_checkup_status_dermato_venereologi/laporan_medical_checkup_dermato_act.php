<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$keluhan=addslashes($_REQUEST['keluhan']);
	$alergi=addslashes($_REQUEST['alergi']);
	$p_kulit=addslashes($_REQUEST['p_kulit']);
	$k_rambut=addslashes($_REQUEST['k_rambut']);
	$disuri=addslashes($_REQUEST['disuri']);
	$discharge=addslashes($_REQUEST['discharge']);
	$lain=addslashes($_REQUEST['lain']);
	$anak_h=addslashes($_REQUEST['anak_h']);
	$anak_m=addslashes($_REQUEST['anak_m']);
	$hamil=addslashes($_REQUEST['hamil']);
	$hamil_ke=addslashes($_REQUEST['hamil_ke']);
	$pms=addslashes($_REQUEST['pms']);
	$cs=addslashes($_REQUEST['cs']);
	$kulit=addslashes($_REQUEST['kulit']);
	$getah=addslashes($_REQUEST['getah']);
	$saraf=addslashes($_REQUEST['saraf']);
	$rambut=addslashes($_REQUEST['rambut']);
	$kuku=addslashes($_REQUEST['kuku']);
	$gene=addslashes($_REQUEST['gene']);
	$anjuran=addslashes($_REQUEST['anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	//$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=0;$i++){
		$cerai.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_laporan_dermato (pelayanan_id,
				keluhan,
				alergi,
				p_kulit,
				k_rambut,
				disuri,
				discharge,
				lain,
				anak_h,
				anak_m,
				hamil,
				hamil_ke,
				pms,
				cs,
				kulit,
				getah,
				saraf,
				rambut,
				kuku,
				gene,
				anjuran,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$keluhan',
				'$alergi',
				'$p_kulit',
				'$k_rambut',
				'$disuri',
				'$discharge',
				'$lain',
				'$anak_h',
				'$anak_m',
				'$hamil',
				'$hamil_ke',
				'$pms',
				'$cs',
				'$kulit',
				'$getah',
				'$saraf',
				'$rambut',
				'$kuku',
				'$gene',
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
		$sql="UPDATE b_laporan_dermato SET pelayanan_id='$idPel',
		keluhan='$keluhan',
		alergi='$alergi',
		p_kulit='$p_kulit',
		k_rambut='$k_rambut',
		disuri='$disuri',
		discharge='$discharge',
		lain='$lain',
		anak_h='$anak_h',
		anak_m='$anak_m',
		hamil='$hamil',
		hamil_ke='$hamil_ke',
		pms='$pms',
		cs='$cs',
		kulit='$kulit',
		getah='$getah',
		saraf='$saraf',
		rambut='$rambut',
		kuku='$kuku',
		gene='$gene',
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
		$sql="DELETE FROM b_laporan_dermato WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>