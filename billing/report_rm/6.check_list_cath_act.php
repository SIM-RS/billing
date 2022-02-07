<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tgl_list=tglSQL($_REQUEST['tgl_list']);
	$txt_dokter=addslashes($_REQUEST['txt_dokter']);
	$txt_tindakan=addslashes($_REQUEST['txt_tindakan']);
	$txt_penyakit=addslashes($_REQUEST['txt_penyakit']);
	$txt_tb=$_REQUEST['txt_tb'];
	$txt_bb=$_REQUEST['txt_bb'];
	$txt_obat=addslashes($_REQUEST['txt_obat']);
	$list=$_REQUEST['list_1'].','.$_REQUEST['list_2'].','.$_REQUEST['list_3'].','.$_REQUEST['list_4'].','.$_REQUEST['list_5'].','.$_REQUEST['list_6'].','.$_REQUEST['list_7'].','.$_REQUEST['list_8'].','.$_REQUEST['list_9'].','.$_REQUEST['list_10'].','.$_REQUEST['list_11'].','.$_REQUEST['list_12'].','.$_REQUEST['list_13'].','.$_REQUEST['list_14'].','.$_REQUEST['list_15'].','.$_REQUEST['list_16'].','.$_REQUEST['list_17'];
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_cath_form(pelayanan_id,kunjungan_id,tgl_list,dokter,tindakan,penyakit,TB,BB,list,obat,tgl_act,user_act) VALUES('$idPel','$idKunj','$tgl_list','$txt_dokter','$txt_tindakan','$txt_penyakit','$txt_tb','$txt_bb','$list','$txt_obat',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_cath_form SET pelayanan_id='$idPel',
		kunjungan_id='$idKunj',
		tgl_list='$tgl_list',
		dokter='$txt_dokter',
		tindakan='$txt_tindakan',
		penyakit='$txt_penyakit',
		TB='$txt_tb',
		BB='$txt_bb',
		list='$list',
		obat='$txt_obat',
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
		$sql="DELETE FROM b_fom_cath_form WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>