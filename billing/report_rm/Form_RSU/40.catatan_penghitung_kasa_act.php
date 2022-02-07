
<?php
include("../../koneksi/konek.php");
$idUsr=$_REQUEST['idUsr'];	
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idPsn=$_REQUEST['idPsn'];
$jenis=$_REQUEST['jenis'];
$jumlah_awal=$_REQUEST['j_awal'];
$tambahan1=$_REQUEST['tambahan1'];
$tambahan2=$_REQUEST['tambahan2'];
$tambahan3=$_REQUEST['tambahan3'];
$tambahan4=$_REQUEST['tambahan4'];
$tambahan5=$_REQUEST['tambahan5'];
$jumlah_sementara=$_REQUEST['j_sementara'];
$tambahan=$_REQUEST['tambahan'];
$jumlah_akhir=$_REQUEST['j_akhir'];
$keterangan=$_REQUEST['keterangan'];
$a_bedah=$_REQUEST['a_bedah'];
$p_instrumen=$_REQUEST['p_instrumen'];
$p_sirkuler=$_REQUEST['p_sirkuler'];
$r_operasi=$_REQUEST['r_operasi'];
$j_operasi=$_REQUEST['j_operasi'];
$tgl=tglSQL($_REQUEST['tgl']);
$jam=$_REQUEST['jam'];
$jam2=$_REQUEST['jam2'];	
$jumlah_kasa=$_REQUEST['jumlah_kasa'];
$jumlah_jarum=$_REQUEST['jumlah_jarum'];
$jumlah_instrumen=$_REQUEST['jumlah_instrumen'];
$jumlah_pisau=$_REQUEST['jumlah_pisau'];
$act=$_REQUEST['act'];


/*echo $idUsr.'|'.$idPel.'|'.$idKunj.'|'.$jenis[0].'|'.$jumlah_awal[0].'|'.$tambahan1[0].'|'.$tambahan2[0].'|'.$tambahan3[0].'|'.$tambahan4[0].'|'.$tambahan5[0].'|'.$jumlah_sementara[0].'|'.$tambahan[0].'|'.$jumlah_akhir[0].'|'.$keterangan[0].'|'.$a_bedah.'|'.$p_instrumen.'|'.$p_sirkuler.'|'.$r_operasi.'|'.$j_operasi.'|'.$tgl.'|'.$jam.'|'.$jam2.'|'.$jumlah_kasa.'|'.$jumlah_jarum.'|'.$jumlah_instrumen.'|'.$jumlah_pisau.'|'.$act;*/

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	$sql="INSERT INTO b_form_catatan_penghitung VALUES
	  ('',
	  '$idPel',
	  '$idKunj',
	  '$idPsn',
	  '$r_operasi',
	  '$a_bedah',
	  '$p_instrumen',
	  '$p_sirkuler',
	  '$j_operasi',
	  '$tgl',
	  '$jam',  
	  '$jam2', 
	  '$jumlah_kasa', 
	  '$jumlah_jarum', 
	  '$jumlah_instrumen', 
	  '$jumlah_pisau', 
	  CURDATE(),
	  '$idUsr')";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			foreach($jenis as $key){
				 $sqlD="INSERT INTO b_form_catatan_penghitung_detail VALUES ('','$idx','$jenis[$i]','$jumlah_awal[$i]','$tambahan1[$i]','$tambahan2[$i]','$tambahan3[$i]','$tambahan4[$i]','$tambahan5[$i]','$jumlah_sementara[$i]','$tambahan[$i]','$jumlah_akhir[$i]','$keterangan[$i]')";
				mysql_query($sqlD);
				$i++;
				}
			echo mysql_error();
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		/*$sql="UPDATE b_fom_monitoring_eso SET pelayanan_id='$idPel',
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
  user_act='$idUsr' WHERE id='".$_REQUEST['txtId']."'";*/
  
  $sql="UPDATE b_form_catatan_penghitung set ruang_operasi='$r_operasi', ahli_bedah='$a_bedah', perawat_instrumen='$p_instrumen',perawat_sirkuler='$p_sirkuler',jenis_operasi='$j_operasi',tanggal='$tgl',jam_mulai='$jam', jam_selesai='$jam2',jumlah_kasa='$jumlah_kasa',jumlah_jarum='$jumlah_jarum', jumlah_instrumen='$jumlah_instrumen', jumlah_pisau='$jumlah_pisau', tgl_act=CURDATE() where id='".$_REQUEST['txtId']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_form_catatan_penghitung_detail where id_form_catatan_penghitung='".$_REQUEST['txtId']."'");
		$i=0;
			foreach($jenis as $key){
				$sqlD="INSERT INTO b_form_catatan_penghitung_detail VALUES ('','".$_REQUEST['txtId']."','$jenis[$i]','$jumlah_awal[$i]','$tambahan1[$i]','$tambahan2[$i]','$tambahan3[$i]','$tambahan4[$i]','$tambahan5[$i]','$jumlah_sementara[$i]','$tambahan[$i]','$jumlah_akhir[$i]','$keterangan[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$sqlh="delete from b_form_catatan_penghitung_detail where id_form_catatan_penghitung='".$_REQUEST['txtId']."' ";
		$hapus=mysql_query($sqlh);
		//$exx=mysql_query("delete from b_fom_monitoring_eso_detail where monitoring_eso_id='".$_REQUEST['txtId']."'");
		//echo $sqlh;
		if($hapus){
			//$sql="DELETE FROM b_fom_monitoring_eso WHERE id='".$_REQUEST['txtId']."'";
			$sqlh2="delete from b_form_catatan_penghitung where id='".$_REQUEST['txtId']."'";
			$ex=mysql_query($sqlh2);
			//echo $sqlh2;
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