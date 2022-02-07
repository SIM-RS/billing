<?php
include("../../koneksi/konek.php");
//====================================================================
//====================================================================
//Paging,Sorting dan Filter======
	//$idPel=$_REQUEST['idPel'];
	//$idKunj=$_REQUEST['idKunj'];
	$jenis=$_REQUEST['jenis'];
	$keterangan1=$_REQUEST['keterangan1'];
	$jenis2=$_REQUEST['jenis2'];
	$keterangan2=$_REQUEST['keterangan2'];
	
	//$idUsr=$_REQUEST['idUsr'];	
	//echo count();
	$jenis_pemeriksaan=$_REQUEST['jenis_pemeriksaan'];
	$bagian=$_REQUEST['bagian'];
	$lembar=$_REQUEST['lembar'];
	$keterangan=$_REQUEST['keterangan'];



//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$tgl=tglSQL($_REQUEST['tgl']);
	$diperoleh=$_REQUEST['diperoleh'];
	$jam=addslashes($_REQUEST['jam']);
	$dikirim=$_REQUEST['dikirim'];
	$nama_ibu=$_REQUEST['nama_ibu'];
	$umur_ibu=$_REQUEST['umur_ibu'];
	$nama_ayah=$_REQUEST['nama_ayah'];
	$umur_ayah=$_REQUEST['umur_ayah'];
	$agama=$_REQUEST['agama'];
	//$status=$_REQUEST['status'];
	$pekerjaan=$_REQUEST['pekerjaan'];
	$pendidikan=$_REQUEST['pendidikan'];
	$alamat=$_REQUEST['alamat'];
	//$penyakit=$_REQUEST['penyakit'];
	$isi=$_REQUEST['isi'];
	$suhu=$_REQUEST['suhu'];
	$tensi=$_REQUEST['tensi'];
	$nadi=$_REQUEST['nadi'];
	$teratur=$_REQUEST['teratur'];
	$pulsasi=$_REQUEST['pulsasi'];
	$rr=$_REQUEST['rr'];
	$teratur2=$_REQUEST['teratur2'];
	$pernafasan=$_REQUEST['pernafasan'];
	$akral=$_REQUEST['akral'];
	$bb=$_REQUEST['bb'];
	$tb=$_REQUEST['tb'];
	$ld=$_REQUEST['ld'];
	$kesadaran=$_REQUEST['kesadaran'];
	$lk=$_REQUEST['lk'];
	$lp=$_REQUEST['lp'];
	$nilai=$_REQUEST['nilai'];
	$warna=$_REQUEST['warna'];
	$trugor=$_REQUEST['trugor'];
	$alasan=$_REQUEST['alasan'];
	//$alergi=$_REQUEST['alergi'];
	$sebut_alergi=$_REQUEST['sebut_alergi'];
	//$operasi=$_REQUEST['operasi'];
	$sebut_operasi=$_REQUEST['sebut_operasi'];
	$status1=$_REQUEST['status1'];
	$tgl1=tglSQL($_REQUEST['tgl1']);
	$status2=$_REQUEST['status2'];
	$tgl2=tglSQL($_REQUEST['tgl2']);
	$status3=$_REQUEST['status3'];
	$tgl3=tglSQL($_REQUEST['tgl3']);
	$status4=$_REQUEST['status4'];
	$tgl4=tglSQL($_REQUEST['tgl4']);
	$status5=$_REQUEST['status5'];
	$tgl5=tglSQL($_REQUEST['tgl5']);
	$status6=$_REQUEST['status6'];
	$tgl6=tglSQL($_REQUEST['tgl6']);
	$status7=$_REQUEST['status7'];
	$tgl7=tglSQL($_REQUEST['tgl7']);
	$status8=$_REQUEST['status8'];
	$tgl8=tglSQL($_REQUEST['tgl8']);
	$status9=$_REQUEST['status9'];
	$tgl9=tglSQL($_REQUEST['tgl9']);
	$status10=$_REQUEST['status10'];
	$tgl10=tglSQL($_REQUEST['tgl10']);
	$status11=$_REQUEST['status11'];
	$tgl11=tglSQL($_REQUEST['tgl11']);
	$status12=$_REQUEST['status12'];
	$tgl12=tglSQL($_REQUEST['tgl12']);
	$lama=$_REQUEST['lama'];
	$partus=$_REQUEST['partus'];
	//$komplikasi=$_REQUEST['komplikasi'];
	$sebut_kom=$_REQUEST['sebut_kom'];
	//$neonatus=$_REQUEST['neonatus'];
	$sebut_neo=$_REQUEST['sebut_neo'];
	//$maternal=$_REQUEST['maternal'];
	$sebut_mate=$_REQUEST['sebut_mate'];
	$berat=$_REQUEST['berat'];
	$panjang=$_REQUEST['panjang'];
	$asi=$_REQUEST['asi'];
	$formula=$_REQUEST['formula'];
	$susu=$_REQUEST['susu'];
	$cincang=$_REQUEST['cincang'];
	$tim=$_REQUEST['tim'];
	$nasi=$_REQUEST['nasi'];
	$bicara=$_REQUEST['bicara'];
	$makanan=$_REQUEST['makanan'];
	$porsi=$_REQUEST['porsi'];
	$frekuensi=$_REQUEST['frekuensi'];
	$tengurap=$_REQUEST['tengurap'];
	$duduk=$_REQUEST['duduk'];
	$merangkak=$_REQUEST['merangkak'];
	$berdiri=$_REQUEST['berdiri'];
	$jalan=$_REQUEST['jalan'];
	$penglihatan=$_REQUEST['penglihatan'];
	$alat_bantu=$_REQUEST['alat_bantu'];
	$pendengaran=$_REQUEST['pendengaran'];
	$idUsr=$_REQUEST['idUsr'];	
	//echo count();
	$radio=$_REQUEST['radio'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=5;$i++){
		$penyakit.=$c_chk[$i].',';
		}
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
  $sql="INSERT INTO b_ms_pengkajian_pasien_anak (
  pelayanan_id,
  tgl,
  diperoleh,
  jam,
  dikirim,
  nama_ibu,
  umur_ibu,
  nama_ayah,
  umur_ayah,
  agama,
  status,
  pekerjaan,
  pendidikan,
  alamat,
  isi,
  suhu,
  tensi,
  nadi,
  teratur,
  pulsasi,
  rr,
  teratur2,
  pernafasan,
  akral,
  bb,
  tb,
  ld,
  kesadaran,
  lk,
  lp,
  nilai,
  warna,
  trugor,
  alasan,
  alergi,
  sebut_alergi,
  operasi,
  sebut_operasi,
  status1,
  tgl1,
  status2,
  tgl2,
  status3,
  tgl3,
  status4,
  tgl4,
  status5,
  tgl5,
  status6,
  tgl6,
  status7,
  tgl7,
  status8,
  tgl8,
  status9,
  tgl9,
  status10,
  tgl10,
  status11,
  tgl11,
  status12,
  tgl12,
  lama,
  partus,
  komplikasi,
  sebut_kom,
  neonatus,
  sebut_neo,
  maternal,
  sebut_mate,
  berat,
  panjang,
  asi,
  formula,
  susu,
  cincang,
  tim,
  nasi,
  bicara,
  makanan,
  porsi,
  frekuensi,
  tengurap,
  duduk,
  merangkak,
  berdiri,
  jalan,
  penglihatan,
  alat_bantu,
  pendengaran,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$tgl',
  '$diperoleh',
  '$jam',
  '$dikirim',
  '$nama_ibu',
  '$umur_ibu',
  '$nama_ayah',
  '$umur_ayah',
  '$agama',
  '$radio[0]',
  '$pekerjaan',
  '$pendidikan',
  '$alamat',
  '".substr($penyakit,0,-1)."',
  '$isi',
  '$suhu',
  '$tensi',
  '$nadi',
  '$teratur',
  '$pulsasi',
  '$rr',
  '$teratur2',
  '$pernafasan',
  '$akral',
  '$bb',
  '$tb',
  '$ld',
  '$kesadaran',
  '$lk',
  '$nilai',
  '$warna',
  '$trugor',
  '$alasan',
  '$radio[1]',
  '$sebut_alergi',
  '$radio[2]',
  '$sebut_operasi',
  '$status1',
  '$tgl1',
  '$status2',
  '$tgl2',
  '$status3',
  '$tgl3',
  '$status4',
  '$tgl4',
  '$status5',
  '$tgl5',
  '$status6',
  '$tgl6',
  '$status7',
  '$tgl7',
  '$status8',
  '$tgl8',
  '$status9',
  '$tgl9',
  '$status10',
  '$tgl10',
  '$status11',
  '$tgl11',
  '$status12',
  '$tgl12',
  '$lama',
  '$partus',
  '$radio[3]',
  '$sebut_kom',
  '$radio[4]',
  '$sebut_neo',
  '$radio[5]',
  '$sebut_mate',
  '$berat',
  '$panjang',
  '$asi',
  '$formula',
  '$susu',
  '$cincang',
  '$tim',
  '$nasi',
  '$bicara',
  '$makanan',
  '$porsi',
  '$frekuensi',
  '$tengurap',
  '$duduk',
  '$merangkak',
  '$berdiri',
  '$jalan',
  '$penglihatan',
  '$alat_bantu',
  '$pendengaran',
  CURDATE(),
  '$idUsr') ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			
			foreach($jenis as $key){
				 $sqlD="INSERT INTO b_ms_pengkajian_pasien_anak1(pengkajian_id,jenis,keterangan1,jenis2,keterangan2) 
VALUES ('$idx','$jenis[$i]','$keterangan1[$i]','$jenis2[$i]','$keterangan2[$i]')";
				mysql_query($sqlD);
				$i++;
			}
/*--------------------------------------------------------------------------------------------------------------------*/				
				
			$ii=0;
			foreach($jenis_pemeriksaan as $key)
				{
					$jenis_pemeriksaanx=$jenis_pemeriksaan[$ii];
					//echo $tglx;
					$jenis_pemeriksaan2=$jenis_pemeriksaanx;
				$sqlD2="INSERT INTO b_ms_pengkajian_pasien_anak2(pengkajian_id,jenis_pemeriksaan,bagian,lembar,keterangan) VALUES ('$idx','$jenis_pemeriksaan2','$bagian[$ii]','$lembar[$ii]','$keterangan[$ii]')";
				//echo $sqlD2;
				mysql_query($sqlD2);
				
				$ii++;
				}
/*---------------------------------------------------------------------------------------------------------------------------*/				
				
			//echo mysql_error();
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_ms_pengkajian_pasien_anak SET pelayanan_id='$idPel',
  tgl='$tgl',
  diperoleh='$diperoleh',
  jam='$jam',
  dikirim='$dikirim',
  nama_ibu='$nama_ibu',
  umur_ibu='$umur_ibu',
  nama_ayah='$nama_ayah',
  umur_ayah='$umur_ayah',
  agama='$agama',
  status='$radio[0]',
  pekerjaan='$pekerjaan',
  pendidikan='$pendidikan',
  alamat='$alamat',
  penyakit='".substr($penyakit,0,-1)."',
  isi='$isi',
  suhu='$suhu',
  tensi='$tensi',
  nadi='$nadi',
  teratur='$teratur',
  pulsasi='$pulsasi',
  rr='$rr',
  teratur2='$teratur',
  pernafasan='$pernafasan',
  akral='$akral',
  bb='$bb',
  tb='$tb',
  ld='$ld',
  kesadaran='$kesadaran',
  lk='$lk',
  lp='$lp',
  nilai='$nilai',
  warna='$warna',
  trugor='$trugor',
  alasan='$alasan',
  alergi='$radio[1]',
  sebut_alergi='$sebut_alergi',
  operasi='$radio[2]',
  sebut_operasi='$sebut_operasi',
  status1='$status1',
  tgl1='$tgl1',
  status2='$status2',
  tgl2='$tgl2',
  status3='$status3',
  tgl3='$tgl3',
  status4='$status4',
  tgl4='$tgl4',
  status5='$status5',
  tgl5='$tgl5',
  status6='$status6',
  tgl6='$tgl6',
  status7='$status7',
  tgl7='$tgl7',
  status8='$status8',
  tgl8='$tgl8',
  status9='$status9',
  tgl9='$tgl9',
  status10='$status10',
  tgl10='$tgl10',
  status11='$status11',
  tgl11='$tgl11',
  status12='$status12',
  tgl12='$tgl12',
  lama='$lama',
  partus='$partus',
  komplikasi='$radio[3]',
  sebut_kom='$sebut_kom',
  neonatus='$radio[4]',
  sebut_neo='$sebut_neo',
  maternal='$radio[5]',
  sebut_mate='$sebut_mate',
  berat='$berat',
  panjang='$panjang',
  asi='$asi',
  formula='$formula',
  susu='$susu',
  cincang='$cincang',
  tim='$tim',
  nasi='$nasi',
  bicara='$bicara',
  makanan='$makanan',
  porsi='$porsi',
  frekuensi='$frekuensi',
  tengurap='$tengurap',
  duduk='$duduk',
  merangkak='$merangkak',
  berdiri='$berdiri',
  jalan='$jalan',
  penglihatan='$penglihatan',
  alat_bantu='$alat_bantu',
  pendengaran='$pendengaran',
  tgl_act= CURDATE(),
  user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_ms_pengkajian_pasien_anak1 where pengkajian_id='".$_REQUEST['id']."'");
		$i=0;
			foreach($jenis as $key){
				$sqlD="INSERT INTO b_ms_pengkajian_pasien_anak1(pengkajian_id,jenis,keterangan1,jenis2,keterangan2) VALUES ('".$_REQUEST['id']."','$jenis[$i]','$keterangan1[$i]','$jenis2[$i]','$keterangan2[$i]')";
				mysql_query($sqlD);
				$i++;
				}
/*--------------------------------------------------------*/
	if($ex){
		mysql_query("delete from b_ms_pengkajian_pasien_anak2 where pengkajian_id='".$_REQUEST['id']."'");
		$ii=0;
			foreach($jenis_pemeriksaan as $key)
				{
					$jenis_pemeriksaanx=$jenis_pemeriksaan[$ii];
					//echo $tglx;
					$jenis_pemeriksaan2=$jenis_pemeriksaanx;
				$sqlD2="INSERT INTO b_ms_pengkajian_pasien_anak2(pengkajian_id,jenis_pemeriksaan,bagian,lembar,keterangan) VALUES ('".$_REQUEST['id']."','$jenis_pemeriksaan2','$bagian[$ii]','$lembar[$ii]','$keterangan[$ii]')";
				//echo $sqlD2;
				mysql_query($sqlD2);
				
				$ii++;
				}
	}
/*--------------------------------------------------------*/
				
				
			echo "Data berhasil diupdate !";
			}else{
				echo "Data gagal diupdate !";
				}
	break;
	case 'hapus':
		$exx=mysql_query("delete from b_ms_pengkajian_pasien_anak1 where pengkajian_id='".$_REQUEST['id']."'");
		$exx=mysql_query("delete from b_ms_pengkajian_pasien_anak2 where pengkajian_id='".$_REQUEST['id']."'");
		
		if($exx){
			$sql="DELETE FROM b_ms_pengkajian_pasien_anak WHERE id='".$_REQUEST['id']."'";
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
