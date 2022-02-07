<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$keterangan=addslashes($_REQUEST['keterangan']);
	$means1=addslashes($_REQUEST['means1']);
	$means2=addslashes($_REQUEST['means2']);
	$means3=addslashes($_REQUEST['means3']);
	$means4=addslashes($_REQUEST['means4']);
	$means5=addslashes($_REQUEST['means5']);
	$means6=addslashes($_REQUEST['means6']);
	$means7=addslashes($_REQUEST['means7']);
	$means8=addslashes($_REQUEST['means8']);
	$pr1=addslashes($_REQUEST['pr1']);
	$pr2=addslashes($_REQUEST['pr2']);
	$pr3=addslashes($_REQUEST['pr3']);
	$pr4=addslashes($_REQUEST['pr4']);
	$pr5=addslashes($_REQUEST['pr5']);
	$pr6=addslashes($_REQUEST['pr6']);
	$pr7=addslashes($_REQUEST['pr7']);
	$pr8=addslashes($_REQUEST['pr8']);
	$p1=addslashes($_REQUEST['p1']);
	$p2=addslashes($_REQUEST['p2']);
	$p3=addslashes($_REQUEST['p3']);
	$p4=addslashes($_REQUEST['p4']);
	$p5=addslashes($_REQUEST['p5']);
	$p6=addslashes($_REQUEST['p6']);
	$p7=addslashes($_REQUEST['p7']);
	$p8=addslashes($_REQUEST['p8']);
	$kesan=addslashes($_REQUEST['kesan']);
	$anjuran=addslashes($_REQUEST['anjuran']);
	$idUsr=$_REQUEST['idUsr'];
	$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_laporan_faal_paru (pelayanan_id,
				keterangan,
				means1,
				means2,
				means3,
				means4,
				means5,
				means6,
				means7,
				means8,
				pr1,
				pr2,
				pr3,
				pr4,
				pr5,
				pr6,
				pr7,
				pr8,
				p1,
				p2,
				p3,
				p4,
				p5,
				p6,
				p7,
				p8,
				kesan,
				anjuran,
				obstruksi,
				restriksi,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$keterangan',
				'$means1',
				'$means2',
				'$means3',
				'$means4',
				'$means5',
				'$means6',
				'$means7',
				'$means8',
				'$pr1',
				'$pr2',
				'$pr3',
				'$pr4',
				'$pr5',
				'$pr6',
				'$pr7',
				'$pr8',
				'$p1',
				'$p2',
				'$p3',
				'$p4',
				'$p5',
				'$p6',
				'$p7',
				'$p8',
				'$kesan',
				'$anjuran',
				'$radio[0]',
				'$radio[1]',
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
		$sql="UPDATE b_laporan_faal_paru SET pelayanan_id='$idPel',
		keterangan='$keterangan',
		means1='$means1',
		means2='$means2',
		means3='$means3',
		means4='$means4',
		means5='$means5',
		means6='$means6',
		means7='$means7',
		means8='$means8',
		pr1='$pr1',
		pr2='$pr2',
		pr3='$pr3',
		pr4='$pr4',
		pr5='$pr5',
		pr6='$pr6',
		pr7='$pr7',
		pr8='$pr8',
		p1='$p1',
		p2='$p2',
		p3='$p3',
		p4='$p4',
		p5='$p5',
		p6='$p6',
		p7='$p7',
		p8='$p8',
		kesan='$kesan',
		anjuran='$anjuran',
		obstruksi='$radio[0]',
		restriksi='$radio[1]',
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
		$sql="DELETE FROM b_laporan_faal_paru WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>