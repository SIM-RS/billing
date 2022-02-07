<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_keluhan=addslashes($_POST['txt_keluhan']);
	$txtDaun=addslashes($_POST['txtDaun1']).'|'.addslashes($_POST['txtDaun2']);
	$txtLiang=addslashes($_POST['txtLiang1']).'|'.addslashes($_POST['txtLiang2']);
	$txtMembran=addslashes($_POST['txtMembran1']).'|'.addslashes($_POST['txtMembran2']);
	$txtAudiogram=addslashes($_POST['txtAudiogram1']).'|'.addslashes($_POST['txtAudiogram2']);
	$txtHidung=addslashes($_POST['txtHidung']);
	$txtRhino=addslashes($_POST['txtRhino']);
	$txtLaryn=addslashes($_POST['txtLaryn']);
	$txt_anjuran=addslashes($_POST['txt_anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_check_tht(pelayanan_id,kunjungan_id,keluhan,daun,liang,membran,audiogram,hidung,rhinopharynx,larynx,anjuran,tgl_act,user_act) VALUES('$idPel','$idKunj','$txt_keluhan','$txtDaun','$txtLiang','$txtMembran','$txtAudiogram','$txtHidung','$txtRhino','$txtLaryn','$txt_anjuran',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_check_tht SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		keluhan='$txt_keluhan',
		daun='$txtDaun',
		liang='$txtLiang',
		membran='$txtMembran',
		audiogram='$txtAudiogram',
		hidung='$txtHidung',
		rhinopharynx='$txtRhino',
		larynx='$txtLaryn',
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
		$sql="DELETE FROM b_ms_check_tht WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>