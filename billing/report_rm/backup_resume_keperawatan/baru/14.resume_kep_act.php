<?php
include("../koneksi/konek.php");
//====================================================================
//====================================================================
//Paging,Sorting dan Filter======
	//$idPel=$_REQUEST['idPel'];
	//$idKunj=$_REQUEST['idKunj'];
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
	//$idUsr=$_REQUEST['idUsr'];	
	//echo count();
	$tgl=$_REQUEST['tgl'];
	$hari=$_REQUEST['hari'];
	$jam=$_REQUEST['jam'];
	$dokter=$_REQUEST['dokter'];
	$resume_kep_id = $_REQUEST['resume_kep_id'];



//Paging,Sorting dan Filter======
	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	//$idKunj=$_REQUEST['idKunj'];
	//$txt_anjuran=addslashes($_REQUEST['txt_anjuran']);
	//$nutrisi=$_REQUEST['nutrisi'];
	/*$txt_jam2=$_REQUEST['txt_jam2'];
	$txt_jam3=$_REQUEST['txt_jam3'];
	$txt_jam4=$_REQUEST['txt_jam4'];
	$txt_jam5=$_REQUEST['txt_jam5'];
	$txt_jam6=$_REQUEST['txt_jam6'];
	$txt_petunjuk=$_REQUEST['txt_petunjuk'];*/
	$tekanan_darah=$_REQUEST['tekanan_darah'];
	$pernafasan=addslashes($_REQUEST['pernafasan']);
	$nadi=$_REQUEST['nadi'];
	$suhu=$_REQUEST['suhu'];
	$_diet=$_REQUEST['_diet'];
	$_batas=$_REQUEST['_batas'];
	$_tgl=tglSQL($_REQUEST['_tgl']);
	$_tinggi=$_REQUEST['_tinggi'];
	$_warna=$_REQUEST['_warna'];
	$_bau=$_REQUEST['_bau'];
	$_cairan=$_REQUEST['_cairan'];
	$_lain=$_REQUEST['_lain'];
	$diagnosa1=$_REQUEST['diagnosa1'];
	$diagnosa2=$_REQUEST['diagnosa2'];
	$anjuran1=$_REQUEST['anjuran1'];
	$anjuran2=$_REQUEST['anjuran2'];
	$anjuran3=$_REQUEST['anjuran3'];
	$anjuran4=$_REQUEST['anjuran4'];
	$lab=$_REQUEST['lab'];
	$foto=$_REQUEST['foto'];
	$scan=$_REQUEST['scan'];
	$mri=$_REQUEST['mri'];
	$usg=$_REQUEST['usg'];
	$surat=$_REQUEST['surat'];
	$surat_a=$_REQUEST['surat_a'];
	$summary=$_REQUEST['summary'];
	$buku=$_REQUEST['buku'];
	$kartu=$_REQUEST['kartu'];
	$skl=$_REQUEST['skl'];
	$serah=$_REQUEST['serah'];
	$lain=$_REQUEST['lain'];
	$hasil1=$_REQUEST['hasil1'];
	$hasil2=$_REQUEST['hasil2'];
	$hasil3=$_REQUEST['hasil3'];
	$hasil4=$_REQUEST['hasil4'];
	$hasil5=$_REQUEST['hasil5'];
	$idUsr=$_REQUEST['idUsr'];	
	//echo count();
	$radio=$_REQUEST['radio'];
	$c_chk=$_REQUEST['c_chk'];
	for($i=0;$i<=6;$i++){
		$edukasi.=$c_chk[$i].',';
		}
	

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
				$sql="INSERT INTO b_fom_resume_keperawatan (
  pelayanan_id,
  tekanan_darah,
  pernafasan,
  nadi,
  suhu,
  nutrisi,
  _diet,
  _batas,
  bab,
  bak,
  _tgl,
  kontraksi,
  _tinggi,
  vulva,
  lochea,
  _warna,
  _bau,
  luka,
  _cairan,
  transfer,
  alat,
  _lain,
  edukasi,
  diagnosa1,
  diagnosa2,
  anjuran1,
  anjuran2,
  anjuran3,
  anjuran4,
  lab,
  foto,
  scan,
  mri,
  usg,
  surat,
  surat_a,
  summary,
  buku,
  kartu,
  skl,
  serah,
  lain,
  hasil1,
  hasil2,
  hasil3,
  hasil4,
  hasil5,
  tgl_act,
  user_act
) 
VALUES
  (
  '$idPel',
  '$tekanan_darah',
  '$pernafasan',
  '$nadi',
  '$suhu',
  '$radio[0]',
  '$_diet',
  '$_batas',
  '$radio[1]',
  '$radio[2]',
  '$_tgl',
  '$radio[3]',
  '$_tinggi',
  '$radio[4]',
  '$radio[5]',
  '$_warna',
  '$_bau',
  '$radio[6]',
  '$_cairan',
  '$radio[7]',
  '$radio[8]',
  '$_lain',
  '".substr($edukasi,0,-1)."',
  '$diagnosa1',
  '$diagnosa2',
  '$anjuran1',
  '$anjuran2',
  '$anjuran3',
  '$anjuran4',
  '$lab',
  '$foto',
  '$scan',
  '$mri',
  '$usg',
  '$surat',
  '$surat_a',
  '$summary',
  '$buku',
  '$kartu',
  '$skl',
  '$serah',
  '$lain',
  '$hasil1',
  '$hasil2',
  '$hasil3',
  '$hasil4',
  '$hasil5',
  CURDATE(),
  '$idUsr') ;";
		$ex=mysql_query($sql);
		if($ex){
			$idx=mysql_insert_id();
			$i=0;
			
			foreach($txt_obat as $key){
				 $sqlD="INSERT INTO b_fom_resume_kep_terapi_pulang(resume_kep_id,nama_obat,jml,dosis,frekuensi,cara_beri,jam_pemberian,petunjuk) VALUES ('$idx','$txt_obat[$i]','$txt_jumlah[$i]','$txt_dosis[$i]','$txt_frek[$i]','$txt_beri[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]|$txt_jam5[$i]|$txt_jam6[$i]','$txt_petunjuk[$i]')";
				mysql_query($sqlD);
				$i++;
			}
/*--------------------------------------------------------------------------------------------------------------------*/				
				
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
/*---------------------------------------------------------------------------------------------------------------------------*/				
				
			//echo mysql_error();
				
			echo "Data berhasil disimpan !";
			}else{
				echo "Data gagal disimpan !";
				}
	break;
	case 'edit':
		$sql="UPDATE b_fom_resume_keperawatan SET pelayanan_id='$idPel',
  tekanan_darah= '$tekanan_darah',
  pernafasan='$pernafasan',
  nadi='$nadi',
  suhu='$suhu',
  nutrisi='$radio[0]',
  _diet='$_diet',
  _batas='$_batas',
  bab='$radio[1]',
  bak='$radio[2]',
  _tgl='$_tgl',
  kontraksi='$radio[3]',
  _tinggi='$_tinggi',
  vulva='$radio[4]',
  lochea='$radio[5]',
  _warna='$_warna',
  _bau='$_bau',
  luka='$radio[6]',
  _cairan='$_cairan',
  transfer='$radio[7]',
  alat='$radio[8]',
  _lain='$_lain',
  edukasi='$edukasi',
  diagnosa1='$diagnosa1',
  diagnosa2='$diagnosa2',
  anjuran1='$anjuran1',
  anjuran2='$anjuran2',
  anjuran3='$anjuran3',
  anjuran4='$anjuran4',
  lab='$lab',
  foto='$foto',
  scan='$scan',
  mri='$mri',
  usg='$usg',
  surat='$surat',
  surat_a='$surat_a',
  summary='$summary',
  buku='$buku',
  kartu='$kartu',
  skl='$skl',
  serah='$serah',
  lain='$lain',
  hasil1='$hasil1',
  hasil2='$hasil2',
  hasil3='$hasil3',
  hasil4='$hasil4',
  hasil5='$hasil5',
  tgl_act= CURDATE(),
  user_act='$idUsr' WHERE id='".$_REQUEST['id']."'";
		//echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_fom_resume_kep_terapi_pulang where resume_kep_id='".$_REQUEST['id']."'");
		$i=0;
			foreach($txt_obat as $key){
				$sqlD="INSERT INTO b_fom_resume_kep_terapi_pulang(resume_kep_id,nama_obat,jml,dosis,frekuensi,cara_beri,jam_pemberian,petunjuk) VALUES ('".$_REQUEST['id']."','$txt_obat[$i]','$txt_jumlah[$i]','$txt_dosis[$i]','$txt_frek[$i]','$txt_beri[$i]','$txt_jam1[$i]|$txt_jam2[$i]|$txt_jam3[$i]|$txt_jam4[$i]|$txt_jam5[$i]|$txt_jam6[$i]','$txt_petunjuk[$i]')";
				mysql_query($sqlD);
				$i++;
				}
/*--------------------------------------------------------*/
	//if($ex){
		mysql_query("delete from b_fom_resume_kep_kontrol where resume_kep_id='".$_REQUEST['id']."'");
		$ii=0;
			foreach($tgl as $key)
				{
					$tglx=$tgl[$ii];
					//echo $tglx;
					$tgl2=tglSQL($tglx);
				$sqlD2="INSERT INTO b_fom_resume_kep_kontrol(resume_kep_id,tgl,hari,jam,dokter) VALUES ('".$_REQUEST['id']."','$tgl2','$hari[$ii]','$jam[$ii]','$dokter[$ii]')";
				//echo $sqlD2;
				mysql_query($sqlD2);
				
				$ii++;
				}
	//}
/*--------------------------------------------------------*/
				
				
			echo "Data berhasil diupdate !";
			}else{
				echo "Data gagal diupdate !";
				}
	break;
	case 'hapus':
		$exx=mysql_query("delete from b_fom_resume_kep_terapi_pulang where resume_kep_id='".$_REQUEST['id']."'");
		$exx2=mysql_query("delete from b_fom_resume_kep_kontrol where resume_kep_id='".$_REQUEST['id']."'");
		
		if($exx){
			$sql="DELETE FROM b_fom_resume_keperawatan WHERE id='".$_REQUEST['id']."'";
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
