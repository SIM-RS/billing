<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
-->
</style><?php
include("../../koneksi/konek.php");
//====================================================================

	$id=$_REQUEST['id'];
	$idPel=$_REQUEST['idPel'];
	$idUsr=$_REQUEST['idUsr'];
	$tex_tgl=tglSQL($_REQUEST['tex_tgl']);
	$tex_jam=$_REQUEST['tex_jam'];
	
	$cek_triage=$_REQUEST['cek_triage'];
	$triage='';
	for($i=0;$i<=5;$i++){
		$triage.=$cek_triage[$i].',';
		}
		
	$cek_trauma=$_REQUEST['cek_trauma'];
	
	$cek_datang=$_REQUEST['cek_datang'];
//	$datang='';
//	for($d=0;$d<=1;$d++){
//		$datang.=$cek_datang[$d].',';
//		}
	
	$tex_antar=$_REQUEST['tex_antar'];
		
	$cek_kasus=$_REQUEST['cek_kasus'];
//	$kasus='';
//	for($k=0;$k<=1;$k++){
//		$kasus.=$cek_kasus[$k].',';
//		}
		
	$cek_riwayat=$_REQUEST['cek_riwayat'];
//	$riwayat='';
//	for($r=0;$r<=1;$r++){
//		$riwayat.=$cek_riwayat[$r].',';
//		}
		
	$tex_alergi=$_REQUEST['tex_alergi'];
	
	$cek_pemeriksaan=$_REQUEST['cek_pemeriksaan'];
//	$pemeriksaan='';
//	for($r=0;$p<=1;$p++){
//		$riwayat.=$cek_pemeriksaan[$p].',';
//		}
	
	$tex_fisik=$_REQUEST['tex_fisik'];

	$tex_utama=$_REQUEST['tex_utama'];
	$tex_tambahan=$_REQUEST['tex_tambahan'];
	$tex_sekarang=$_REQUEST['tex_sekarang'];
	$tex_dahulu=$_REQUEST['tex_dahulu'];
	
	
	$cek_keadaan=$_REQUEST['cek_keadaan'];
//	$keadaan='';
//	for($k=0;$k<=2;$k++){
//		$keadaan.=$cek_keadaan[$k].',';
//		}
		
	$tex_e=$_REQUEST['tex_e'];
	$tex_m=$_REQUEST['tex_m'];
	$tex_v=$_REQUEST['tex_v'];
	$tex_kepala=$_REQUEST['tex_kepala'];
	$tex_leher=$_REQUEST['tex_leher'];
	$tex_dada=$_REQUEST['tex_dada'];
	$tex_perut=$_REQUEST['tex_perut'];
	$tex_kulit=$_REQUEST['tex_kulit'];
	$tex_alat=$_REQUEST['tex_alat'];
	
	$cek_n=$_REQUEST['cek_n'];
	$n='';
	for($y=0;$y<=10;$y++){
		$n.=$cek_n[$y].',';
		}
	
	//$tgl=tglSQL($_REQUEST['tgl']);
	
	
	$tgla=$_REQUEST['tgla'];
	$jam=$_REQUEST['jam'];
	$infus=$_REQUEST['infus'];
	$nama=$_REQUEST['nama'];
	
	$tgll=$_REQUEST['tgll'];
	$jam2=$_REQUEST['jam2'];
	$obat=$_REQUEST['obat'];
	$dosis=$_REQUEST['dosis'];
	$pemberian=$_REQUEST['pemberian'];
	$nama2=$_REQUEST['nama2'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
$sql="INSERT INTO b_ms_status_ugd (
  	pelayanan_id,
	tanggal,
	jam,
	triage,
	trauma,
	pasien_datang,
	ket_pasien_datang,
	kasus,
	riwayat_alergi,
	ket_riwayat_alergi,
	pemeriksaan_fisik,
	ket_pemeriksaan_fisik,
	keluhan_utama,
	keluhan_tambahan,
	penyakit_sekarang,
	penyakit_dahulu,
	keadaan_umum,
	e,
	m,
	v,
	kepala,
	leher,
	dada,
	perut,
	kulit,
	alat,
	nilai_nyeri,
  	tgl_act,
  	user_act
) 
VALUES
  (
	'$idPel',
	'$tex_tgl',
	'$tex_jam',
	'".substr($triage,0,-1)."',
	'$cek_trauma',
	'$cek_datang',
	'$tex_antar',
	'$cek_kasus',
	'$cek_riwayat',
	'$tex_alergi',
	'$cek_pemeriksaan',
	'$tex_fisik',
	'$tex_utama',
	'$tex_tambahan',
	'$tex_sekarang',
	'$tex_dahulu',
	'$cek_keadaan',
	'$tex_e',
	'$tex_m',
	'$tex_v',
	'$tex_kepala',
	'$tex_leher',
	'$tex_dada',
	'$tex_perut',
	'$tex_kulit',
	'$tex_alat',
	'".substr($n,0,-1)."',
  	CURDATE(),
 	 '$idUsr') ;";
  echo $sql;
  $ex=mysql_query($sql);
  		if($ex){
			$idx=mysql_insert_id();
  //------------------------------------------------------------------------------------------------------------------
			$i=0;
			foreach($tgll as $key)
				{
				$tgllx=$tgll[$i];
				$tgl3=tglSQL($tgllx);
				 $sqlD="INSERT INTO b_ms_status_ugd_obat(ugd_id,tanggal,jam,obat,dosis,pemberian,paraf_nama) VALUES ('$idx','$tgl3','$jam2[$i]','$obat[$i]','$dosis[$i]','$pemberian[$i]','$nama2[$i]')";
				mysql_query($sqlD);
				$i++;
			}
	//------------------------------------------------------------------------------------------------------------------
		
			$ii=0;
			foreach($tgla as $key)
				{
				$tglly=$tgll[$ii];
				$tgl4=tglSQL($tglly);
				 $sqlDD="INSERT INTO b_ms_status_ugd_infus(ugd_id,tanggal,jam,infus,paraf_nama) VALUES ('$idx','$tgl4','$jam[$ii]','$infus[$ii]','$nama[$ii]')";
				mysql_query($sqlDD);
				$ii++;
			}
			
	//--------------------------------------------------------------------------------------------------------------------		
		
			echo "Data berhasil disimpan !";
		}
		else
		{
			echo "Data gagal disimpan !";
		}

	break;
	case 'edit':
		$sql="UPDATE b_ms_status_ugd SET pelayanan_id='$idPel', 
		tanggal='$tex_tgl',
		jam='$tex_jam',
		triage='".substr($triage,0,-1)."',
		trauma='$cek_trauma',
		pasien_datang='$cek_datang',
		ket_pasien_datang='$tex_antar',
		kasus='$cek_kasus',
		riwayat_alergi='cek_riwayat',
		ket_riwayat_alergi='$tex_alergi',
		pemeriksaan_fisik='$cek_pemeriksaan',
		ket_pemeriksaan_fisik='$tex_fisik',
		keluhan_utama='$tex_utama',
		keluhan_tambahan='$tex_tambahan',
		penyakit_sekarang='$tex_sekarang',
		penyakit_dahulu='$tex_dahulu',
		keadaan_umum='$cek_keadaan',
		e='$tex_e',
		m='$tex_m',
		v='$tex_v',
		kepala='$tex_kepala',
		leher='$tex_leher',
		dada='$tex_dada',
		perut='$tex_perut',
		kulit='$tex_kulit',
		alat='$tex_alat',
		nilai_nyeri='".substr($n,0,-1)."',
		tgl_act=CURDATE(),
		user_act='$idUsr'
		WHERE id='".$_REQUEST['id']."'";
	echo $sql;
	$ex=mysql_query($sql);
	if($ex){
		mysql_query("delete from b_ms_status_ugd_obat where ugd_id ='".$_REQUEST['id']."'");
		mysql_query("delete from b_ms_status_ugd_infus where ugd_id ='".$_REQUEST['id']."'");
	//----------------------------------------	
			$i=0;
			foreach($tgll as $key)
				{
				$tgllx=$tgll[$i];
				$tgl3=tglSQL($tgllx);
				 $sqlD="INSERT INTO b_ms_status_ugd_obat(ugd_id,tanggal,jam,obat,dosis,pemberian,paraf_nama) VALUES ('".$_REQUEST['id']."','$tgl3','$jam2[$i]','$obat[$i]','$dosis[$i]','$pemberian[$i]','$nama2[$i]')";

				 
				 
				mysql_query($sqlD);
				$i++;
			}
			
	//--------------------------------------------------
		$ii=0;
			foreach($tgla as $key)
				{
				$tglly=$tgll[$ii];
				$tgl4=tglSQL($tglly);
				 $sqlDD="INSERT INTO b_ms_status_ugd_infus(ugd_id,tanggal,jam,infus,paraf_nama) VALUES ('".$_REQUEST['id']."','$tgl4','$jam[$ii]','$infus[$ii]','$nama[$ii]')";
				mysql_query($sqlDD);
				$ii++;
			}
	//--------------------------------------------------		
			
			echo "Data berhasil diupdate !";
		}
		else
		{
			echo "Data gagal diupdate !";
		}
	break;
	case 'hapus':
	
		$exx=mysql_query("delete from b_ms_status_ugd_obat where ugd_id ='".$_REQUEST['id']."'");
		$exx=mysql_query("delete from b_ms_status_ugd_infus where ugd_id ='".$_REQUEST['id']."'");
	if($exx){
		$sql="DELETE FROM b_ms_status_ugd WHERE id='".$_REQUEST['id']."'";
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
