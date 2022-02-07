<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUsr=$_REQUEST['idUsr'];
	
	$antibiotik=$_REQUEST['antibiotik'];
	$alasan=$_REQUEST['alasan'];
	$jenis1=$_REQUEST['jenis1'];
	$jenis2=$_REQUEST['jenis2'];
	$jenis3=$_REQUEST['jenis3'];
	$tgl_mulai1=$_REQUEST['tgl_mulai1'];
	$tgl_mulai1b=$_REQUEST['tgl_mulai1b'];
	$tgl_mulai2=$_REQUEST['tgl_mulai2'];
	$tgl_mulai2b=$_REQUEST['tgl_mulai2b'];
	$tgl_mulai3=$_REQUEST['tgl_mulai3'];
	$tgl_mulai3b=$_REQUEST['tgl_mulai3b'];
	$ruang1=$_REQUEST['ruang1'];
	$ruang2=$_REQUEST['ruang2'];
	$ruang3=$_REQUEST['ruang3'];
	$tgl_ruang1=$_REQUEST['tgl_ruang1'];
	$tgl_ruang1b=$_REQUEST['tgl_ruang1b'];
	$tgl_ruang2=$_REQUEST['tgl_ruang2'];
	$tgl_ruang2b=$_REQUEST['tgl_ruang2b'];
	$tgl_ruang3=$_REQUEST['tgl_ruang3'];
	$tgl_ruang3b=$_REQUEST['tgl_ruang3b'];
	
	$antib_alasan=$antibiotik.'*|-'.$alasan;
	$jenis1=$jenis1.'*|-'.$tgl_mulai1.'*|-'.$tgl_mulai1b;
	$jenis2=$jenis2.'*|-'.$tgl_mulai2.'*|-'.$tgl_mulai2b;
	$jenis3=$jenis3.'*|-'.$tgl_mulai3.'*|-'.$tgl_mulai3b;
	$ruang1=$ruang1.'*|-'.$tgl_ruang1.'*|-'.$tgl_ruang1b;
	$ruang2=$ruang2.'*|-'.$tgl_ruang2.'*|-'.$tgl_ruang2b;
	$ruang3=$ruang3.'*|-'.$tgl_ruang3.'*|-'.$tgl_ruang3b;
	
	for($i=1;$i<=8;$i++){
		$catheter.=$_REQUEST['catheter'.$i].'*|-';
		$urine_catheter.=$_REQUEST['urine_catheter'.$i].'*|-';
		$ngt.=$_REQUEST['ngt'.$i].'*|-';
		$cvc.=$_REQUEST['cvc'.$i].'*|-';
		$ett.=$_REQUEST['ett'.$i].'*|-';
		$lain.=$_REQUEST['lain'.$i].'*|-';
		}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	$sql="INSERT INTO lap_surveilan_infeksi_noso (
  pelayanan_id,
  kunjungan_id,
  user_act,
  user_id,
  antib_alasan,
  jenis1,
  jenis2,
  jenis3,
  ruang1,
  ruang2,
  ruang3,
  catheter,
  urine_catheter,
  ngt,
  cvc,
  ett,
  lain
) 
VALUES
  (
    '$idPel',
    '$idKunj',
    NOW(),
    '$idUsr',
	'$antib_alasan',
	'$jenis1',
	'$jenis2',
	'$jenis3',
	'$ruang1',
	'$ruang2',
	'$ruang3',
	'$catheter',
	'$urine_catheter',
	'$ngt',
	'$cvc',
	'$ett',
	'$lain'
  ) ;
";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				echo mysql_error();
				}
	break;
	case 'edit':
		$sql="UPDATE lap_surveilan_infeksi_noso SET
	pelayanan_id='$idPel',
  kunjungan_id='$idKunj',
  user_act=NOW(),
  user_id='$idUsr',
  antib_alasan='$antib_alasan',
  jenis1='$jenis1',
  jenis2='$jenis2',
  jenis3='$jenis3',
  ruang1='$ruang1',
  ruang2='$ruang2',
  ruang3='$ruang3',
  catheter='$catheter',
  urine_catheter='$urine_catheter',
  ngt='$ngt',
  cvc='$cvc',
  ett='$ett',
  lain='$lain'
  
WHERE id='".$_REQUEST['txtId']."'";
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
		$sql="DELETE FROM lap_surveilan_infeksi_noso WHERE id='".$_REQUEST['txtId']."'";
		$ex=mysql_query($sql);
		if($ex){
			echo "Data berhasil dihapus !";
			}else{
				echo "Data gagal dihapus !";
				}
	break;
		
}
?>