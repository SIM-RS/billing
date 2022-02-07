<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$derita=addslashes($_REQUEST['derita']);
	$sebut=addslashes($_REQUEST['sebut']);
	$riwayat=addslashes($_REQUEST['riwayat']);
	$idUsr=$_REQUEST['idUsr'];
	$radio=$_REQUEST['radio'];
	/*$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$pilihan.=$c_chk[$i].',';
		}*/
	
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_vaccination (pelayanan_id,
				tgl,
				sakit,
				derita,
				terapi,
				sebut,
				obat,
				makanan,
				reaksi,
				wanita,
				vaksinasi,
				riwayat,
				tgl_act,
				user_act) 
				VALUES(
				'$idPel',
				'$tgl',
				'$radio[0]',
				'$derita',
				'$radio[1]',
				'$sebut',
				'$radio[2]',
				'$radio[3]',
				'$radio[4]',
				'$radio[5]',
				'$radio[6]',
				'$riwayat',
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
		$sql="UPDATE b_vaccination SET pelayanan_id='$idPel',
		tgl='$tgl',
		sakit='$radio[0]',
		derita='$derita',
		terapi='$radio[1]',
		sebut='$sebut',
		obat='$radio[2]',
		makanan='$radio[3]',
		reaksi='$radio[4]',
		wanita='$radio[5]',
		vaksinasi='$radio[6]',
		riwayat='$riwayat',
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
		$sql="DELETE FROM b_vaccination WHERE id='".$_REQUEST['id']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>