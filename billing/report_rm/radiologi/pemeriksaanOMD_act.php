<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txtTgl=addslashes(tglSQL($_REQUEST['txtTgl']));
	$txtJam=addslashes($_REQUEST['txtJam']);
	$txtJam1=addslashes($_REQUEST['txtJam1']);
	$txtJam2=addslashes($_REQUEST['txtJam2']);
	
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_periksa_omd(pelayanan_id,kunjungan_id,tgl_datang,jam_datang,jam_siap1,jam_siap2,tgl_act,user_act) VALUES('$idPel','$idKunj','$txtTgl','$txtJam','$txtJam1','$txtJam2',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_periksa_omd SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		tgl_datang='$txtTgl',
		jam_datang='$txtJam',
		jam_siap1='$txtJam1',
		jam_siap2='$txtJam2',
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
		$sql="DELETE FROM b_ms_periksa_omd WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>