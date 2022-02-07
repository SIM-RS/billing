<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_keluhan=addslashes($_POST['txt_keluhan']);
	$txt_umbilical=$_POST['txt_umbilical'];
	$txt_inguinal=$_POST['txt_inguinal'];
	$txt_incisional=$_POST['txt_incisional'];
	$txt_ampula=addslashes($_POST['txt_ampula']);
	$txt_hemoroid=$_POST['txt_hemoroid'];
	$rd_grade=$_POST['rd_grade'];
	$txt_polip=$_POST['txt_polip'];
	$txt_sphinter=addslashes($_POST['txt_sphinter']);
	$txt_anjuran=addslashes($_POST['txt_anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_med_chk_bdh_wnt(pelayanan_id,kunjungan_id,keluhan,umbilical,inguinal,incisional,ampulla_recti,hemoroid,grade,polip,sphiner_ani,anjuran,tgl_act,user_act) VALUES('$idPel','$idKunj','$txt_keluhan','$txt_umbilical','$txt_inguinal','$txt_incisional','$txt_ampula','$txt_hemoroid','$rd_grade','$txt_polip','$txt_sphinter','$txt_anjuran',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_med_chk_bdh_wnt SET pelayanan_id='$idPel',kunjungan_id='$idKunj',keluhan='$txt_keluhan',umbilical='$txt_umbilical',inguinal='$txt_inguinal',incisional='$txt_incisional',ampulla_recti='$txt_ampula',hemoroid='$txt_hemoroid',grade='$rd_grade',polip='$txt_polip',sphiner_ani='$txt_sphinter',anjuran='$txt_anjuran',tgl_act=CURDATE(),user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_fom_med_chk_bdh_wnt WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>