<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$txt_anjuran=addslashes($_REQUEST['txt_anjuran']);
	$txt_obat=$_REQUEST['txt_obat'];
	$txt_jumlah=$_REQUEST['txt_jumlah'];
	$txt_dosis=$_REQUEST['txt_dosis'];
	$txt_frek=$_REQUEST['txt_frek'];
	$txt_beri=$_REQUEST['txt_beri'];
	$txt_jam1=$_REQUEST['txt_jam1'];
	$txt_jam2=$_REQUEST['txt_jam2'];
	$txt_jam3=$_REQUEST['txt_jam3'];
	$txt_jam4=$_REQUEST['txt_jam4'];
	$txt_jam5=$_REQUEST['txt_jam5'];
	$txt_jam6=$_REQUEST['txt_jam6'];
	$txt_petunjuk=$_REQUEST['txt_petunjuk'];
	$pJawabPem=$_REQUEST['pJawabPem'];
	$DWaktuMasuk=$_REQUEST['DWaktuMasuk'];
	$txt_riwayat_pen=$_REQUEST['txt_riwayat_pen'];
	$txt_pemeriksaan_fisik=$_REQUEST['txt_pemeriksaan_fisik'];
	$txt_pemeriksaan=$_REQUEST['txt_pemeriksaan'];
	$txt_terapi=$_REQUEST['txt_terapi'];
	$txt_hasil_konsul=$_REQUEST['txt_hasil_konsul'];
	$txt_alergi=$_REQUEST['txt_alergi'];
	$txt_hasil_lab=$_REQUEST['txt_hasil_lab'];
	$txt_diet=$_REQUEST['txt_diet'];
	$lanjut1=$_REQUEST['lanjut1'];
	$tglPoli=tglSQL($_REQUEST['tglPoli']);
	$txt_hasil_lab=$_REQUEST['txt_hasil_lab'];
	$idUsr=$_REQUEST['idUsr'];
	$jns=$_REQUEST['jns'];	
	//echo count();
	
	$query = "SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id = '$idUsr'";
	$dquery = mysql_fetch_array(mysql_query($query));
	
	if(($dquery['ms_group_id'] == 92) || ($dquery['ms_group_id'] == 95))
	{
		$isRekam = 1;
	}else{
		$isRekam = 0;
	}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_resum_medis_new (
  pelayanan_id,
  kunjungan_id,
  ppembayaran,
  dmasuk,
  rpenyakit,
  pemeriksaanf,
  ppenunjang,
  terapip,
  hkonsultasi,
  alergi,
  hasillab,
  diet,
  dilanjutkan,
  tgl_lanjut,
  anjuran,
  tgl_act,
  user_act,
  isRekam
) 
VALUES
  (
  '$idPel',
  '$idKunj',
  '$pJawabPem',
  '$DWaktuMasuk',
  '$txt_riwayat_pen',
  '$txt_pemeriksaan_fisik',
  '$txt_pemeriksaan',
  '$txt_terapi',
  '$txt_hasil_konsul',
  '$txt_alergi',
  '$txt_hasil_lab',
  '$txt_diet',
  '$lanjut1',
  '$tglPoli',
  '$txt_anjuran',
  CURDATE(),
  '$idUsr',
  $isRekam) ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			foreach($txt_obat as $key){
				 $sqlD="INSERT INTO b_fom_resum_medis_detail_new(resum_medis_id,nama_obat,jml,dosis,frekuensi,cara_beri,jam_pemberian,petunjuk) VALUES ('$idx','$txt_obat[$i]','$txt_jumlah[$i]','$txt_dosis[$i]','$txt_frek[$i]','$txt_beri[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]|$txt_jam5[$i]|$txt_jam6[$i]','$txt_petunjuk[$i]')";
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
		$sql="UPDATE b_fom_resum_medis_new SET pelayanan_id='$idPel',
  kunjungan_id= '$idKunj',
  anjuran='$txt_anjuran',
  ppembayaran='$pJawabPem',
  dmasuk='$DWaktuMasuk',
  rpenyakit='$txt_riwayat_pen',
  pemeriksaanf='$txt_pemeriksaan_fisik',
  ppenunjang='$txt_pemeriksaan',
  terapip='$txt_terapi',
  hkonsultasi='$txt_hasil_konsul',
  alergi='$txt_alergi',
  hasillab='$txt_hasil_lab',
  diet='$txt_diet',
  dilanjutkan='$lanjut1',
  tgl_lanjut='$tglPoli',
  tgl_act= CURDATE(),
  user_act='$idUsr',
  isRekam=$isRekam
   WHERE id='".$_REQUEST['txtId']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_fom_resum_medis_detail_new where resum_medis_id='".$_REQUEST['txtId']."'");
		$i=0;
			foreach($txt_obat as $key){
				$sqlD="INSERT INTO b_fom_resum_medis_detail_new(resum_medis_id,nama_obat,jml,dosis,frekuensi,cara_beri,jam_pemberian,petunjuk) VALUES ('".$_REQUEST['txtId']."','$txt_obat[$i]','$txt_jumlah[$i]','$txt_dosis[$i]','$txt_frek[$i]','$txt_beri[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]|$txt_jam5[$i]|$txt_jam6[$i]','$txt_petunjuk[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
	
		$queryUUS="UPDATE b_fom_resum_medis_new SET user_act='$idUsr' where id='".$_REQUEST['txtId']."'";
		$exec_query=mysql_query($queryUUS);
		
		$exx=mysql_query("delete from b_fom_resum_medis_new where id='".$_REQUEST['txtId']."'");
		//echo "delete from b_fom_resum_medis_new where resum_medis_id='".$_REQUEST['txtId']."'";
		if($exx){
			$sql="DELETE FROM b_fom_resum_medis_detail_new WHERE resum_medis_id='".$_REQUEST['txtId']."'";
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