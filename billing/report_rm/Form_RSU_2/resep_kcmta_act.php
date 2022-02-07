<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$spher=$_REQUEST['j_spher'].','.$_REQUEST['d_spher'];
	$cyl=$_REQUEST['j_cyl'].','.$_REQUEST['d_cyl'];
	$axis=$_REQUEST['j_axis'].','.$_REQUEST['d_axis'];
	$prism=$_REQUEST['j_prism'].','.$_REQUEST['d_prism'];
	$base=$_REQUEST['j_base'].','.$_REQUEST['d_base'];
	$spher2=$_REQUEST['j_spher2'].','.$_REQUEST['d_spher2'];
	$cyl2=$_REQUEST['j_cyl2'].','.$_REQUEST['d_cyl2'];
	$axis2=$_REQUEST['j_axis2'].','.$_REQUEST['d_axis2'];
	$prism2=$_REQUEST['j_prism2'].','.$_REQUEST['d_prism2'];
	$base2=$_REQUEST['j_base2'].','.$_REQUEST['d_base2'];
	$jpupil=$_REQUEST['j_pupil'].','.$_REQUEST['d_pupil'];
	$idUsr=$_REQUEST['idUsr'];
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$sql="INSERT INTO b_fom_resep_kcmata(pelayanan_id,kunjungan_id,spher,cyl,axis,prism,base,spher_2,cyl_2,axis_2,prism_2,base_2,jarak_pupil,tgl_act,user_act) VALUES('$idPel','$idKunj','$spher','$cyl','$axis','$prism','$base','$spher2','$cyl2','$axis2','$prism2','$base2','$jpupil',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_resep_kcmata SET pelayanan_id='$idPel',kunjungan_id='$idKunj',spher='$spher',cyl='$cyl',axis='$axis',prism='$prism',base='$base',spher_2='$spher2',cyl_2='$cyl2',axis_2='$axis2',prism_2='$prism2',base_2='$base2',jarak_pupil='$jpupil',tgl_act=CURDATE(),user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sql="DELETE FROM b_fom_resep_kcmata WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>