<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_manifes=addslashes($_REQUEST['txt_manifes']);
	$txt_mulai=addslashes($_REQUEST['txt_mulai']);
	$txt_riwayat=addslashes($_REQUEST['txt_riwayat']);
	$txt_ket=addslashes($_REQUEST['txt_ket']);
	$txt_lab=addslashes($_REQUEST['txt_lab']);
	$radJikPerem=$_REQUEST['radJikPerem'];
	$radSudah=$_REQUEST['radSudah'];
	$chPenyakit=$_REQUEST['chPenyakit'];
	$penyakit='';
	$rdSudahEso=$_REQUEST['rdSudahEso'];
	$txt_obat=$_REQUEST['txt_obat'];
	$txt_jam1=$_REQUEST['txt_jam1'];
	$txt_jam2=$_REQUEST['txt_jam2'];
	$txt_jam3=$_REQUEST['txt_jam3'];
	$txt_jam4=$_REQUEST['txt_jam4'];
	$txt_sedia=$_REQUEST['txt_sedia'];
	$txt_curiga=$_REQUEST['txt_curiga'];
	$txt_indikasi=$_REQUEST['txt_indikasi'];
	
	$idUsr=$_REQUEST['idUsr'];	
	//echo count();
	
	for($i=0;$i<=5;$i++){
		$penyakit.=$chPenyakit[$i].',';
		}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	
				$sql="INSERT INTO b_fom_monitoring_eso (
  pelayanan_id,
  kunjungan_id,
  status_perempuan,
  kesudahan,
  penyakit,
  manifestasi,
  saat,
  riwayat_eso,
  kesudahan_eso,
  ket_tambahan,
  data_lab,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$idKunj',
  '$radJikPerem',
  '$radSudah',
  '".substr($penyakit,0,-1)."',
  '$txt_manifes',
  '$txt_mulai',
  '$txt_riwayat',
  '$rdSudahEso',
  '$txt_ket',
  '$txt_lab',  
  CURDATE(),
  '$idUsr') ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			foreach($txt_obat as $key){
				 $sqlD="INSERT INTO b_fom_monitoring_eso_detail(monitoring_eso_id,nama_obat,bentuk,obat_curigai,pemberian,indikasi) VALUES ('$idx','$txt_obat[$i]','$txt_sedia[$i]','$txt_curiga[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]','$txt_indikasi[$i]')";
				mysql_query($sqlD);
				$i++;
				}
			//echo mysql_error();
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_monitoring_eso SET pelayanan_id='$idPel',
  kunjungan_id= '$idKunj',
  status_perempuan='$radJikPerem',
  kesudahan='$radSudah',
  penyakit='".substr($penyakit,0,-1)."',
  manifestasi='$txt_manifes',
  saat='$txt_mulai',
  riwayat_eso='$txt_riwayat',
  kesudahan_eso='$rdSudahEso',
  ket_tambahan='$txt_ket',
  data_lab='$txt_lab',
  tgl_act= CURDATE(),
  user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_fom_monitoring_eso_detail where monitoring_eso_id='".$_REQUEST['txtId']."'");
		$i=0;
			foreach($txt_obat as $key){
				$sqlD="INSERT INTO b_fom_monitoring_eso_detail(monitoring_eso_id,nama_obat,bentuk,obat_curigai,pemberian,indikasi) VALUES ('".$_REQUEST['txtId']."','$txt_obat[$i]','$txt_sedia[$i]','$txt_curiga[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]','$txt_indikasi[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$exx=mysql_query("delete from b_fom_monitoring_eso_detail where monitoring_eso_id='".$_REQUEST['txtId']."'");
		
		if($exx){
			$sql="DELETE FROM b_fom_monitoring_eso WHERE id='".$_REQUEST['txtId']."'";
			$ex=mysql_query($sql);
			if($ex){
				echo "Data berhasil dihapus !";
				
				}else{
				echo "Data gagal dihapus !";
				}
			
			}else{
				
				}
	break;
		
}
?>