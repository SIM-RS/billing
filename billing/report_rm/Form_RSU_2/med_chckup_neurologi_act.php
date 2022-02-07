<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_keluhan=addslashes($_POST['txt_keluhan']);
	$txtSadar=addslashes($_POST['txtSadar']);
	$txtSelaput=addslashes($_POST['txtSelaput']);
	$txtIntra=addslashes($_POST['txtIntra']);
	$txtSyaraf=addslashes($_POST['txtSyaraf']);
	$txtMotorik=addslashes($_POST['txtMotorik']);
	$txtPatologis=addslashes($_POST['txtPatologis']);
	$txtSensorik=addslashes($_POST['txtSensorik']);
	$txtOtonom=addslashes($_POST['txtOtonom']);
	$txtLuhur=addslashes($_POST['txtLuhur']);
	$txtLain=addslashes($_POST['txtLain']);
	$txtEEG=addslashes($_POST['txtEEG']);
	$txt_anjuran=addslashes($_POST['txt_anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_check_neurologi(pelayanan_id,kunjungan_id,keluhan,kesadaran,selaput_otak,intrakranial,syaraf_otak,motorik,patologis,sensorik,otonom,luhur,lain_lain,eeg,anjuran,tgl_act,user_act) VALUES('$idPel','$idKunj','$txt_keluhan','$txtSadar','$txtSelaput','$txtIntra','$txtSyaraf','$txtMotorik','$txtPatologis','$txtSensorik','$txtOtonom','$txtLuhur','$txtLain','$txtEEG','$txt_anjuran',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_check_neurologi SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		keluhan='$txt_keluhan',
		kesadaran='$txtSadar',
		selaput_otak='$txtSelaput',
		intrakranial='$txtIntra',
		syaraf_otak='$txtSyaraf',
		motorik='$txtMotorik',
		patologis='$txtPatologis',
		sensorik='$txtSensorik',
		otonom='$txtOtonom',
		luhur='$txtLuhur',
		lain_lain='$txtLain',
		eeg='$txtEEG',
		anjuran='$txt_anjuran',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_ms_check_neurologi WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>