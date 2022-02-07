<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
	$idPel=$_REQUEST['idPel'];
	$idKunj=$_REQUEST['idKunj'];
	$idUsr=$_REQUEST['idUsr'];
	
	$tglstat=$_REQUEST['tglstat'];
	$blnstat=$_REQUEST['blnstat'];
	$thnstat=$_REQUEST['thnstat'];
	$tgl_stat_jnzh=$thnstat."-".$blnstat."-".$tglstat;
	
	$namapemeriksa=$_REQUEST['namapemeriksa'];
	
	$tglperiksa=$_REQUEST['tglperiksa'];
	$blnperiksa=$_REQUEST['blnperiksa'];
	$thnperiksa=$_REQUEST['thnperiksa'];
	$tgl_priksa_jnzh=$thnperiksa."-".$blnperiksa."-".$tglperiksa;
	
	$lainnya=$_REQUEST['lainnya'];
	$kematianA=$_REQUEST['kematianA'];
	$kematianB=$_REQUEST['kematianB'];
	$kematianC=$_REQUEST['kematianC'];
	$kematianD=$_REQUEST['kematianD'];
	$kematian2A=$_REQUEST['kematian2A'];
	$kematian2B=$_REQUEST['kematian2B'];
	$kematian2C=$_REQUEST['kematian2C'];
	$kematian2D=$_REQUEST['kematian2D'];
	$kondisi=$_REQUEST['kondisi'];
	
	$thnICD=$_REQUEST['thnICD'];
	$blnICD=$_REQUEST['blnICD'];
	$hariICD=$_REQUEST['hariICD'];
	$jamICD=$_REQUEST['jamICD'];
	$ICD=$_REQUEST['ICD'];

//STATUS PENDUDUK
	$statuspenduduk=$_REQUEST['statuspenduduk'];
	$statpend='';
	for($i=0;$i<=1;$i++){
		$statpend.=$statuspenduduk[$i].',';
		}
//hubungan
	$hubungan=$_REQUEST['hubungan'];
	$hub='';
	for($i=0;$i<=2;$i++){
		$hub.=$hubungan[$i].',';
		}
//kepala
	$kepala=$_REQUEST['kepala'];
	$kep='';
	for($i=0;$i<=5;$i++){
		$kep.=$kepala[$i].',';
		}
//tempat
	$tempat=$_REQUEST['tempat'];
	$tmpt='';
	for($i=0;$i<=4;$i++){
		$tmpt.=$tempat[$i].',';
		}
//jenazah
	$jenazah=$_REQUEST['jenazah'];
	$jnzh='';
	for($i=0;$i<=1;$i++){
		$jnzh.=$jenazah[$i].',';
		}
//kualifikasi
	$kualifikasi=$_REQUEST['kualifikasi'];
	$kual='';
	for($i=0;$i<=1;$i++){
		$kual.=$kualifikasi[$i].',';
		}
//diagnosis
	$diagnosis=$_REQUEST['diagnosis'];
	$diag='';
	for($i=0;$i<=5;$i++){
		$diag.=$diagnosis[$i].',';
		}
//penyakit
	$penyakit=$_REQUEST['penyakit'];
	$peny='';
	for($i=0;$i<=2;$i++){
		$peny.=$penyakit[$i].',';
		}
//gangguan
	$gangguan=$_REQUEST['gangguan'];
	$gang='';
	for($i=0;$i<=2;$i++){
		$gang.=$gangguan[$i].',';
		}
//cedera
	$cedera=$_REQUEST['cedera'];
	$cdra='';
	for($i=0;$i<=2;$i++){
		$cdra.=$cedera[$i].',';
		}
//lain
	$lain=$_REQUEST['lain'];
	$lan='';
	for($i=0;$i<=1;$i++){
		$lan.=$lain[$i].',';
		}

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
	
				$sql="INSERT INTO sertifikat_kematian 
(
  pelayanan_id,
  kunjungan_id,
  tgl_act,
  user_act,
  statuspenduduk,
  hubungan,
  kepala,
  tempat,
  jenazah,
  kualifikasi,
  diagnosis,
  penyakit,
  gangguan,
  cedera,
  lain,
  tgl_stat_jnzh,
  namapemeriksa,
  tgl_priksa_jnzh,
  lainnya,
  kematianA,
  kematianB,
  kematianC,
  kematianD,
  kematian2A,
  kematian2B,
  kematian2C,
  kematian2D,
  kondisi
) 
VALUES
(
  '$idPel',
  '$idKunj',
  NOW(),
  '$idUsr',
  '".substr($statpend,0,-1)."',
  '".substr($hub,0,-1)."',
  '".substr($kep,0,-1)."',
  '".substr($tmpt,0,-1)."',
  '".substr($jnzh,0,-1)."',
  '".substr($kual,0,-1)."',
  '".substr($diag,0,-1)."',
  '".substr($peny,0,-1)."',
  '".substr($gang,0,-1)."',
  '".substr($cdra,0,-1)."',
  '".substr($lan,0,-1)."',
  '$tgl_stat_jnzh',
  '$namapemeriksa',
  '$tgl_priksa_jnzh',
  '$lainnya',
  '$kematianA',
  '$kematianB',
  '$kematianC',
  '$kematianD',
  '$kematian2A',
  '$kematian2B',
  '$kematian2C',
  '$kematian2D',
  '$kondisi'
) ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			foreach($thnICD as $key){
				 $sqlD="INSERT INTO sertifikat_kematian_detail
				 (s_mati_id, tahun, bulan, hari, jam, icd) VALUES 
				 ('$idx','$thnICD[$i]','$blnICD[$i]','$hariICD[$i]','$jamICD[$i]','$ICD[$i]')";
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
		$sql="UPDATE sertifikat_kematian SET 
  pelayanan_id='$idPel',
  kunjungan_id= '$idKunj',
  tgl_act= NOW(),
  user_act='$idUsr', 
  statuspenduduk='".substr($statpend,0,-1)."',
  hubungan='".substr($hub,0,-1)."',
  kepala='".substr($kep,0,-1)."',
  tempat='".substr($tmpt,0,-1)."',
  jenazah='".substr($jnzh,0,-1)."',
  kualifikasi='".substr($kual,0,-1)."',
  diagnosis='".substr($diag,0,-1)."',
  penyakit='".substr($peny,0,-1)."',
  gangguan='".substr($gang,0,-1)."',
  cedera='".substr($cdra,0,-1)."',
  lain='".substr($lan,0,-1)."',
  tgl_stat_jnzh='$tgl_stat_jnzh',
  namapemeriksa='$namapemeriksa',
  tgl_priksa_jnzh='$tgl_priksa_jnzh',
  lainnya='$lainnya',
  kematianA='$kematianA',
  kematianB='$kematianB',
  kematianC='$kematianC',
  kematianD='$kematianD',
  kematian2A='$kematian2A',
  kematian2B='$kematian2B',
  kematian2C='$kematian2C',
  kematian2D='$kematian2D',
  kondisi='$kondisi'
  WHERE s_mati_id='".$_REQUEST['txtId']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from sertifikat_kematian_detail where s_mati_id='".$_REQUEST['txtId']."'");
		$i=0;
			foreach($thnICD as $key){
				$sqlD="INSERT INTO sertifikat_kematian_detail
				 (s_mati_id, tahun, bulan, hari, jam, icd) VALUES 
				 ('".$_REQUEST['txtId']."','$thnICD[$i]','$blnICD[$i]','$hariICD[$i]','$jamICD[$i]','$ICD[$i]')";
				mysql_query($sqlD);
				$i++;
				}
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'hapus':
		$exx=mysql_query("delete from sertifikat_kematian_detail where s_mati_id='".$_REQUEST['txtId']."'");
		
		if($exx){
			$sql="DELETE FROM sertifikat_kematian WHERE s_mati_id='".$_REQUEST['txtId']."'";
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