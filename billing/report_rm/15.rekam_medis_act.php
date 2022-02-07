<?php
include("../koneksi/konek.php");
//====================================================================
//====================================================================
//Paging,Sorting dan Filter======
	$tgl=tglSQL($_REQUEST['tgl']);
	$hd_ke=$_REQUEST['hd_ke'];
	$mesin=addslashes($_REQUEST['mesin']);
	$type=$_REQUEST['type'];
	$td_tidur=$_REQUEST['td_tidur'];
	$duduk=$_REQUEST['duduk'];
	$dosis_awal1=$_REQUEST['dosis_awal1'];
	$dosis_lanjut=$_REQUEST['dosis_lanjut'];
	$dosis_awal2=$_REQUEST['dosis_awal2'];
	$nadi=$_REQUEST['nadi'];
	$respirasi=$_REQUEST['respirasi'];
	$suhu=$_REQUEST['suhu'];
	$lama_hd=$_REQUEST['lama_hd'];
	$jam_mulai=$_REQUEST['jam_mulai'];
	$jam_selesai=$_REQUEST['jam_selesai'];
	$p_volume=$_REQUEST['p_volume'];
	$p_keluar=$_REQUEST['p_keluar'];
	$keluhan=$_REQUEST['keluhan'];
	$bbs=$_REQUEST['bbs'];
	$bbpre=$_REQUEST['bbpre'];
	$bbpo=$_REQUEST['bbpo'];
	$lain=$_REQUEST['lain'];
	$perawat1=$_REQUEST['perawat1'];
	$perawat2=$_REQUEST['perawat2'];
	$td_tidur2=$_REQUEST['td_tidur2'];
	$duduk2=$_REQUEST['duduk2'];
	$nadi2=$_REQUEST['nadi2'];
	$respirasi2=$_REQUEST['respirasi2'];
	$suhu2=$_REQUEST['suhu2'];
	$keluhan2=$_REQUEST['keluhan2'];
	$sisa=$_REQUEST['sisa'];
	$infus=$_REQUEST['infus'];
	$tran=$_REQUEST['tran'];
	$bilas=$_REQUEST['bilas'];
	$minum=$_REQUEST['minum'];
	$urine=$_REQUEST['urine'];
	$muntah=$_REQUEST['muntah'];
	$uf=$_REQUEST['uf'];
	$jumlah=$_REQUEST['jumlah'];
	$jumlah2=$_REQUEST['jumlah2'];
	$total=$_REQUEST['total'];
	$bb_pulang=$_REQUEST['bb_pulang'];
	$penekanan=$_REQUEST['penekanan'];
	$perawat11=$_REQUEST['perawat11'];
	$perawat22=$_REQUEST['perawat22'];
	$ket_res=$_REQUEST['ket_res'];
	$td=$_REQUEST['td'];
	$n=$_REQUEST['n'];
	$p=$_REQUEST['p'];
	$s=$_REQUEST['s'];
	$ket_res2=$_REQUEST['ket_res2'];
	$ket_res3=$_REQUEST['ket_res3'];
	$ket_manmin=$_REQUEST['ket_manmin'];
	$ket_manmin2=$_REQUEST['ket_manmin2'];
	$ket_manmin3=$_REQUEST['ket_manmin3'];
	$ket_kulit=$_REQUEST['ket_kulit'];
	$ket_eli=$_REQUEST['ket_eli'];
	$ket_eli2=$_REQUEST['ket_eli2'];
	$ket_tdristrht=$_REQUEST['ket_tdristrht'];
	$therapy=$_REQUEST['therapy'];
	$therapy2=$_REQUEST['therapy2'];
	$therapy3=$_REQUEST['therapy3'];
	$therapy4=$_REQUEST['therapy4'];
	$therapy5=$_REQUEST['therapy5'];
	$therapy6=$_REQUEST['therapy6'];
	$therapy7=$_REQUEST['therapy7'];
	$therapy8=$_REQUEST['therapy8'];
	$therapy9=$_REQUEST['therapy9'];
	$therapy10=$_REQUEST['therapy10'];
	$therapy11=$_REQUEST['therapy11'];
	$therapy12=$_REQUEST['therapy12'];
	$therapy13=$_REQUEST['therapy13'];
	$therapy14=$_REQUEST['therapy14'];
	$stop_jam=$_REQUEST['stop_jam'];
	$td2=$_REQUEST['td2'];
	$p2=$_REQUEST['p2'];
	$n2=$_REQUEST['n2'];
	$s2=$_REQUEST['s2'];
		
	//tabel atas	
	$jam=$_REQUEST['jam'];
	$tdd=$_REQUEST['tdd'];
	$nadi_t1=$_REQUEST['nadi_t1'];
	$respirasi_t1=$_REQUEST['respirasi_t1'];
	$suhu_t1=$_REQUEST['suhu_t1'];
	$heparin=$_REQUEST['heparin'];
	$tmp=$_REQUEST['tmp'];
	$ap=$_REQUEST['ap'];
	$qb=$_REQUEST['qb'];
	$ufr=$_REQUEST['ufr'];
	$ufg=$_REQUEST['ufg'];
	$keterangan=$_REQUEST['keterangan'];
	//akhir tabel atas
	
	//tabel bawah
	$jam2=$_REQUEST['jam2'];
	$saran=$_REQUEST['saran'];
	//akhir tabel bawah

	//radio button
	//$jenis_hd=$_REQUEST['radio[0]'];
	//$sarana=$_REQUEST['radio[1]'];
	//akhir radio button

//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];	
	//echo count();
	$radio=$_REQUEST['radio'];
	$jenis_hd=$radio[0];
	$sarana=$radio[1];
	
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=3;$i++){
		$diag_a.=$c_chk[$i].',';
		}
	
	//checkbox
	$checkbox=$_REQUEST['checkbox'];
	$isi='';
	for($i=0;$i<=95;$i++){
		$isi.=$checkbox[$i].',';
		}
	//akhir sheckbox
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_rekam_medis_hd (
  pelayanan_id,
  tgl,
  hd_ke,
  mesin,
  type,
  td_tidur,
  duduk,
  dosis_awal1,
  dosis_lanjut,
  dosis_awal2,
  nadi,
  respirasi,
  suhu,
  lama_hd,
  jam_mulai,
  jam_selesai,
  p_volume,
  p_keluar,
  keluhan,
  bbs,
  bbpre,
  bbpo,
  lain,
  perawat1,
  perawat2,
  td_tidur2,
  duduk2,
  nadi2,
  respirasi2,
  suhu2,
  keluhan2,
  sisa,
  infus,
  tran,
  bilas,
  minum,
  urine,
  muntah,
  uf,
  jumlah,
  jumlah2,
  total,
  bb_pulang,
  penekanan,
  perawat11,
  perawat22,
  ket_res,
  td,
  n,
  p,
  s,
  ket_res2,
  ket_res3, 
  ket_manmin, 
  ket_manmin2, 
  ket_manmin3, 
  ket_kulit, 
  ket_eli, 
  ket_eli2, 
  ket_tdristrht, 
  therapy, 
  therapy2, 
  therapy3, 
  therapy4, 
  therapy5, 
  therapy6, 
  therapy7, 
  therapy8, 
  therapy9, 
  therapy10, 
  therapy11, 
  therapy12, 
  therapy13, 
  therapy14, 
  stop_jam, 
  td2,
  p2, 
  n2, 
  s2,
  diag_a,
  tgl_act,
  user_act,
  jenis_hd,
  sarana,
  isi
) 
VALUES
  (
  '$idPel',
  '$tgl',
  '$hd_ke',
  '$mesin',
  '$type',
  '$td_tidur',
  '$duduk',
  '$dosis_awal1',
  '$dosis_lanjut',
  '$dosis_awal2',
  '$nadi',
  '$respirasi',
  '$suhu',
  '$lama_hd',
  '$jam_mulai',
  '$jam_selesai',
  '$p_volume',
  '$p_keluar',
  '$keluhan',
  '$bbs',
  '$bbpre',
  '$bbpo',
  '$lain',
  '$perawat1',
  '$perawat2',
  '$td_tidur2',
  '$duduk2',
  '$nadi2',
  '$respirasi2',
  '$suhu2',
  '$keluhan2',
  '$sisa',
  '$infus',
  '$tran',
  '$bilas',
  '$minum',
  '$urine',
  '$muntah',
  '$uf',
  '$jumlah',
  '$jumlah2',
  '$total',
  '$bb_pulang',
  '$penekanan',
  '$perawat11',
  '$perawat22',
  '$ket_res',
  '$td',
  '$n',
  '$p',
  '$s',
  '$ket_res2',
  '$ket_res3',
  '$ket_manmin',
  '$ket_manmin2',
  '$ket_manmin3',
  '$ket_kulit',
  '$ket_eli',
  '$ket_eli2',
  '$ket_tdristrht',
  '$therapy', 
  '$therapy2', 
  '$therapy3', 
  '$therapy4', 
  '$therapy5', 
  '$therapy6', 
  '$therapy7', 
  '$therapy8', 
  '$therapy9', 
  '$therapy10', 
  '$therapy11', 
  '$therapy12', 
  '$therapy13', 
  '$therapy14', 
  '$stop_jam', 
  '$td2', 
  '$p2', 
  '$n2', 
  '$s2',
  '".substr($diag_a,0,-1)."',
  CURDATE(),
  '$idUsr', 
  '$jenis_hd', 
  '$sarana',
  '".substr($isi,0,-1)."') ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			
			foreach($jam as $key){
				 $sqlD="INSERT INTO b_fom_rekam_medis_hd_t1(rekam_medis_id,jam,tdd,nadi_t1,respirasi_t1,suhu_t1,heparin,tmp,ap,qb,ufr,ufg,keterangan) VALUES ('$idx','$jam[$i]','$tdd[$i]','$nadi_t1[$i]','$respirasi_t1[$i]','$suhu_t1[$i]','$heparin[$i]','$tmp[$i]','$ap[$i]','$qb[$i]','$ufr[$i]','$ufg[$i]','$keterangan[$i]')";
				mysql_query($sqlD);
				$i++;
			}
/*--------------------------------------------------------------------------------------------------------------------*/				
				
			$ii=0;
			foreach($jam2 as $key)
				{
					$jamx=$jam2[$ii];
					//echo $tglx;
					//$jam22=tglSQL($jamx);
				$sqlD2="INSERT INTO b_fom_rekam_medis_hd_t2(rekam_medis_id,jam2,saran) VALUES ('$idx','$jam2[$ii]','$saran[$ii]')";
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
		$sql="UPDATE b_fom_rekam_medis_hd SET pelayanan_id='$idPel',
  tgl='$tgl',
  hd_ke='$hd_ke',
  mesin='$mesin',
  type='$type',
  td_tidur='$td_tidur',
  duduk='$duduk',
  dosis_awal1='$dosis_awal1',
  dosis_lanjut='$dosis_lanjut',
  dosis_awal2='$dosis_awal2',
  nadi='$nadi',
  respirasi='$respirasi',
  suhu='$suhu',
  lama_hd='$lama_hd',
  jam_mulai='$jam_mulai',
  jam_selesai='$jam_selesai',
  p_volume='$p_volume',
  p_keluar='$p_keluar',
  keluhan='$keluhan',
  bbs='$bbs',
  bbpre='$bbpre',
  bbpo='$bbpo',
  lain='$lain',
  perawat1='$perawat1',
  perawat2='$perawat2',
  td_tidur2='$td_tidur2',
  duduk2='$duduk2',
  nadi2='$nadi2',
  respirasi2='$respirasi2',
  suhu2='$suhu2',
  keluhan2='$keluhan2',
  sisa='$sisa',
  infus='$infus',
  tran='$tran',
  bilas='$bilas',
  minum='$minum',
  urine='$urine',
  muntah='$muntah',
  uf='$uf',
  jumlah='$jumlah',
  jumlah2='$jumlah2',
  total='$total',
  bb_pulang='$bb_pulang',
  penekanan='$penekanan',
  perawat11='$perawat11',
  perawat22='$perawat22',
  ket_res='$ket_res',
  td='$td',
  n='$n',
  p='$p',
  s='$s',
  ket_res2='$ket_res2',
  ket_res3='$ket_res3',
  ket_manmin='$ket_manmin',
  ket_manmin2='$ket_manmin2',
  ket_manmin3='$ket_manmin3',
  ket_kulit='$ket_kulit',
  ket_eli='$ket_eli',
  ket_eli2='$ket_eli2',
  ket_tdristrht='$ket_tdristrht',
  therapy='$therapy', 
  therapy2='$therapy2', 
  therapy3='$therapy3', 
  therapy4='$therapy4', 
  therapy5='$therapy5', 
  therapy6='$therapy6', 
  therapy7='$therapy7', 
  therapy8='$therapy8', 
  therapy9='$therapy9', 
  therapy10='$therapy10', 
  therapy11='$therapy11', 
  therapy12='$therapy12', 
  therapy13='$therapy13', 
  therapy14='$therapy14', 
  stop_jam='$stop_jam', 
  td2='$td2', 
  p2='$p2', 
  n2='$n2', 
  s2='$s2',
  tgl_act= CURDATE(),
  user_act='$idUsr',
  jenis_hd='$jenis_hd', 
  sarana='$sarana',
  diag_a='".substr($diag_a,0,-1)."',
  isi='".substr($isi,0,-1)."'
  WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_fom_rekam_medis_hd_t1 where rekam_medis_id='".$_REQUEST['id']."'");
		$i=0;
			foreach($jam as $key){
				$sqlD="INSERT INTO b_fom_rekam_medis_hd_t1(rekam_medis_id,jam,tdd,nadi_t1,respirasi_t1,suhu_t1,heparin,tmp,ap,qb,ufr,ufg,keterangan) VALUES ('".$_REQUEST['id']."','$jam[$i]','$tdd[$i]','$nadi_t1[$i]','$respirasi_t1[$i]','$suhu_t1[$i]','$heparin[$i]','$tmp[$i]','$ap[$i]','$qb[$i]','$ufr[$i]','$ufg[$i]','$keterangan[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
		mysql_query("delete from b_fom_rekam_medis_hd_t2 where rekam_medis_id='".$_REQUEST['id']."'");
		$ii=0;
			foreach($jam2 as $key){
				$sqlD="INSERT INTO b_fom_rekam_medis_hd_t2(rekam_medis_id,jam2,saran) VALUES ('".$_REQUEST['id']."','$jam2[$ii]','$saran[$ii]')";
				mysql_query($sqlD);
				$ii++;
				}
/*--------------------------------------------------------*/
	/*if($ex){
		mysql_query("delete from b_fom_resume_kep_kontrol where resume_kep_id='".$_REQUEST['id']."'");
		$ii=0;
			foreach($tgl as $key)
				{
					$tglx=$tgl[$ii];
					//echo $tglx;
					$tgl2=tglSQL($tglx);
				$sqlD2="INSERT INTO b_fom_resume_kep_kontrol(resume_kep_id,tgl,hari,jam,dokter) VALUES ('$idx','$tgl2','$hari[$ii]','$jam[$ii]','$dokter[$ii]')";
				//echo $sqlD2;
				mysql_query($sqlD2);
				
				$ii++;
				}
	}*/
/*--------------------------------------------------------*/
				
				
			echo "Data berhasil diupdate !";
			}else{
				echo "Data gagal diupdate !";
				}
	break;
	case 'hapus':
		$exx=mysql_query("delete from b_fom_rekam_medis_hd where id='".$_REQUEST['id']."'");
		
		if($exx){
			$sql="DELETE FROM b_fom_rekam_medis_hd_t1 WHERE rekam_medis_id='".$_REQUEST['id']."'";
			$ex=mysql_query($sql);
			$sql2="DELETE FROM b_fom_rekam_medis_hd_t2 WHERE rekam_medis_id='".$_REQUEST['id']."'";
			$ex2=mysql_query($sql2);
			
			if($ex && $ex2){
				echo "Data berhasil dihapus !";
				
				}else{
				echo "Data gagal dihapus !";
				}
			
			}else{
				
				}
	break;
		
}
?>


