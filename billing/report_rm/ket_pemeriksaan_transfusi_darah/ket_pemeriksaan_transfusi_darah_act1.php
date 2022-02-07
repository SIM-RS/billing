<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$nominal=addslashes($_REQUEST['nominal']);
	$nominal2=addslashes($_REQUEST['nominal2']);
	$name=addslashes($_REQUEST['name']);
	$address=addslashes($_REQUEST['address']);
	$hubungan=addslashes($_REQUEST['hubungan']);
	$idUsr=$_REQUEST['idUsr'];
	$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_ket_pem_ulang_transfusi (pelayanan_id,
				nominal,
				nominal2,
				name,
				address,
				hubungan,
				menyatakan,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$nominal',
				'$nominal2',
				'$name',
				'$address',
				'$hubungan',
				'$radio[0]',
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
		$sql="UPDATE b_ket_pem_ulang_transfusi SET pelayanan_id='$idPel',
		nominal='$nominal',
		nominal2='$nominal2',
		name='$name',
		address='$address',
		hubungan='$hubungan',
		menyatakan='$radio[0]',
		tgl_act=CURDATE(),
		user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
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
		$sql="DELETE FROM b_ket_pem_ulang_transfusi WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>