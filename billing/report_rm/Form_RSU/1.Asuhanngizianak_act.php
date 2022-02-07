<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$asupan_makanan=addslashes($_REQUEST['asupan_makanan']);
	$kesan=addslashes($_REQUEST['kesan']);
	$gizi_lanjut=addslashes($_REQUEST['gizi_lanjut']);
	$diagnosa_gizi_anak=addslashes($_REQUEST['diagnosa_gizi_anak']);
	$diit_dokter=addslashes($_REQUEST['diit_dokter']);
	$bbtb=addslashes($_REQUEST['bbtb']);
	$lla=addslashes($_REQUEST['lla']);
	$idUser=$_REQUEST['idUsr'];
	$nTB=$_REQUEST['nTB'];
	$nBB=$_REQUEST['nBB'];
	
	if($nTB == "")
	{
		$nTB = 0;
		$nBB = 0;
	}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_asuhan_gizi_anak (pelayanan_id,
				kunjungan_id,
				tgl,
				asupan_makanan,
				kesan,
				gizi_lanjut,
				diagnosa_gizi_anak,
				diit_dokter,
				bbtb,
				lla,
				tgl_act,
				user_act,
				BB,
				TB) 
				VALUES(
				'$idPel',
				'$idKunj',
				'$tgl',
				'$asupan_makanan',
				'$kesan',
				'$gizi_lanjut',
				'$diagnosa_gizi_anak',
				'$diit_dokter',
				'$bbtb',
				'$lla',
				CURDATE(),
  				'$idUser',
				$nBB,
				$nTB) ;";
		$ex=mysql_query($sql);
		//echo $sql;
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_asuhan_gizi_anak SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		tgl='$tgl',
		asupan_makanan='$asupan_makanan',
		kesan='$kesan',
		gizi_lanjut='$gizi_lanjut',
		diagnosa_gizi_anak='$diagnosa_gizi_anak',
		diit_dokter='$diit_dokter',
		bbtb='$bbtb',
		lla='$lla',
		tgl_act=CURDATE(),
		user_act='$idUser',
		BB=$nBB,
		TB=$nTB WHERE id='".$_REQUEST['id']."'";
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
		$sql="DELETE FROM b_fom_asuhan_gizi_anak WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>