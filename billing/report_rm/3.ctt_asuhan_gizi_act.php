<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_antropometri=addslashes($_REQUEST['txt_antropometri']);
	$txt_antropometri_eval=addslashes($_REQUEST['txt_antropometri_eval']);
	$txt_biokimia=addslashes($_REQUEST['txt_biokimia']);
	$txt_biokimia_eval=addslashes($_REQUEST['txt_biokimia_eval']);
	$txt_fisik=addslashes($_REQUEST['txt_fisik']);
	$txt_fisik_eval=addslashes($_REQUEST['txt_fisik_eval']);
	$txt_gizi=addslashes($_REQUEST['txt_gizi']);
	$txt_gizi_eval=addslashes($_REQUEST['txt_gizi_eval']);
	$txt_RwytPersonal=addslashes($_REQUEST['txt_RwytPersonal']);
	$txt_RwytPersonal_eval=addslashes($_REQUEST['txt_RwytPersonal_eval']);
	$txt_diagnosa=addslashes($_REQUEST['txt_diagnosa']);
	$txt_intervensi=addslashes($_REQUEST['txt_intervensi']);
	$txt_monev=addslashes($_REQUEST['txt_monev']);
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_asuhan_gizi(pelayanan_id,kunjungan_id,antropometri,antropometri_eval,biokimia,biokimia_eval,fisik,fisik_eval,riwayat_gizi,riwayat_gizi_eval,riwayat_personal,riwayat_personal_eval,diagnosa_gizi,intervensi,rencana_monev,tgl_act,user_act) VALUES('$idPel','$idKunj','$txt_antropometri','$txt_antropometri_eval','$txt_biokimia','$txt_biokimia_eval','$txt_fisik','$txt_fisik_eval','$txt_gizi','$txt_gizi_eval','$txt_RwytPersonal','$txt_RwytPersonal_eval','$txt_diagnosa','$txt_intervensi','$txt_monev',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_asuhan_gizi SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		antropometri='$txt_antropometri',
		antropometri_eval='$txt_antropometri_eval',
		biokimia='$txt_biokimia',
		biokimia_eval='$txt_biokimia_eval',
		fisik='$txt_fisik',
		fisik_eval='$txt_fisik_eval',
		riwayat_gizi='$txt_gizi',
		riwayat_gizi_eval='$txt_gizi_eval',
		riwayat_personal='$txt_RwytPersonal',
		riwayat_personal_eval='$txt_RwytPersonal_eval',
		diagnosa_gizi='$txt_diagnosa',
		intervensi='$txt_intervensi',
		rencana_monev='$txt_monev',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
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
		$sql="DELETE FROM b_fom_asuhan_gizi WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>