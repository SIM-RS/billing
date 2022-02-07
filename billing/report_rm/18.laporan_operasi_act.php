<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txtTglOpr=tglSQL($_POST['txtTglOpr']);
	$txtJamMulai=addslashes($_POST['txtJamMulai']);
	$txtJamSelesai=addslashes($_POST['txtJamSelesai']);
	$chkOpr=addslashes($_POST['chkOpr']);
	$txtPraBedah=addslashes($_POST['txtPraBedah']);
	$chkGolOpr=addslashes($_POST['chkGolOpr']);
	$chkJnsOpr=addslashes($_POST['chkJnsOpr']);
	$cmbDokter=addslashes($_POST['cmbDokter']);
	$chkAnas=addslashes($_POST['chkAnas']);
	$txtLain=addslashes($_POST['txtLain']);
	$txtPasca=addslashes($_POST['txtPasca']);
	$txtTindakan=$_POST['txtTindakan'];
	$txtUraian=addslashes($_POST['txtUraian']);
	$chkJaringan=addslashes($_POST['chkJaringan']);
	$txtJaringan=addslashes($_POST['txtJaringan']);
	$chkOpr=addslashes($_POST['chkOpr']);
	$idUsr=$_REQUEST['idUsr'];
	foreach($txtTindakan as $key){
			$txtTindakan_isi.=$key.'|';
		}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ms_lap_operasi(pelayanan_id,kunjungan_id,tgl_operasi,jam_mulai,jam_selesai,diagnosa_pra,gol_opr,jns_operasi,dokter,anestesi,anastesi_lain,diagnosa_pasca,tindakan,uraian,jaringan,macam_jaringan,tgl_act,user_act,kamar) VALUES('$idPel','$idKunj','$txtTglOpr','$txtJamMulai','$txtJamSelesai','$txtPraBedah','$chkGolOpr','$chkJnsOpr','$cmbDokter','$chkAnas','$txtLain','$txtPasca','$txtTindakan_isi','$txtUraian','$chkJaringan','$txtJaringan',CURDATE(),'$idUsr','$chkOpr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_lap_operasi SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		tgl_operasi='$txtTglOpr',
		jam_mulai='$txtJamMulai',
		jam_selesai='$txtJamSelesai',
		diagnosa_pra='$txtPraBedah',
		gol_opr='$chkGolOpr',
		jns_operasi='$chkJnsOpr',
		dokter='$cmbDokter',
		anestesi='$chkAnas',
		anastesi_lain='$txtLain',
		diagnosa_pasca='$txtPasca',
		tindakan='$txtTindakan_isi',
		uraian='$txtUraian',
		jaringan='$chkJaringan',
		macam_jaringan='$txtJaringan',
		kamar='$chkOpr',
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
		$sql="DELETE FROM b_ms_lap_operasi WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>