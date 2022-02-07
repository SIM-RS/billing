<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_keluhan=addslashes($_POST['txt_keluhan']);
	$txtDarah=$_POST['txtDarah'];
	$txtNadi=$_POST['txtNadi'];
	$txtTumor=$_POST['txtTumor'];
	$txtJVP=addslashes($_POST['txtJVP']);
	$txtParu=addslashes($_POST['txtParu']);
	$txtJantung=addslashes($_POST['txtJantung']);
	$txtHati=addslashes($_POST['txtHati']);
	$txtLimpa=addslashes($_POST['txtLimpa']);
	$txtLain=addslashes($_POST['txtLain']);
	$txtEdema=addslashes($_POST['txtEdema']);
	$txtEKG=addslashes($_POST['txtEKG']);
	$txtTREDMIL=addslashes($_POST['txtTREDMIL']);
	$txtECHO=addslashes($_POST['txtECHO']);
	$txt_anjuran=addslashes($_POST['txt_anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	
$sqlx="SELECT * FROM anamnese WHERE PEL_ID = '$idPel'";
$dP2=mysql_fetch_array(mysql_query($sqlx));
$keluhan=$dP2['KU'];
$tensi=$dP2['TENSI'];
$nadi=$dP2['NADI'];
	
	
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_check_kardiologi(pelayanan_id,kunjungan_id,keluhan,tekanan_darah,nadi,tumor,jvp,paru_paru,jantung,hati,limpa,lain_lain,edema,ekg,treadmil,echokardiografi,anjuran,tgl_act,user_act) VALUES('$idPel','$idKunj','$keluhan','$tensi','$nadi','$txtTumor','$txtJVP','$txtParu','$txtJantung','$txtHati','$txtLimpa','$txtLain','$txtEdema','$txtEKG','$txtTREDMIL','$txtECHO','$txt_anjuran',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_check_kardiologi SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		keluhan='$txt_keluhan',
		tekanan_darah='$txtDarah',
		nadi='$txtNadi',
		tumor='$txtTumor',
		jvp='$txtJVP',
		paru_paru='$txtParu',
		jantung='$txtJantung',
		hati='$txtHati',
		limpa='$txtLimpa',
		lain_lain='$txtLain',
		edema='$txtEdema',
		ekg='$txtEKG',
		treadmil='$txtTREDMIL',
		echokardiografi='$txtECHO',
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
		$sql="DELETE FROM b_ms_check_kardiologi WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>