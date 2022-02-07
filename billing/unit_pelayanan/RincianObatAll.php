<?php
//session_start();
include("../sesi.php");
include ("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$jeniskasir=$_REQUEST['jenisKasir'];
$idPel=$_REQUEST['idPel'];
$inap=$_REQUEST['inap'];
$tipe=$_REQUEST['tipe'];
$for=$_REQUEST['for'];
$all = $_REQUEST['all'];
$idUser=$_REQUEST['idUser'];

$idUnitAmbulan=0;
$idUnitJenazah=0;
$sql="SELECT * FROM b_ms_reference WHERE stref=26";
$rsRef=mysql_query($sql);
if ($rwRef=mysql_fetch_array($rsRef)){
	$idUnitAmbulan=$rwRef["nama"];
}
$sql="SELECT * FROM b_ms_reference WHERE stref=27";
$rsRef=mysql_query($sql);
if ($rwRef=mysql_fetch_array($rsRef)){
	$idUnitJenazah=$rwRef["nama"];
}

$qUsr = mysql_query("SELECT nama,id FROM b_ms_pegawai WHERE id='".$_SESSION['userId']."'");
$rwUsr = mysql_fetch_array($qUsr);
//----------------------------------

$sqlPas="SELECT 
no_rm,
mp.nama nmPas,
mp.id as pasienId,
mp.alamat, 
mp.rt,
mp.rw,
mp.sex, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa,
DATE_FORMAT(k.tgl_sjp,'%d-%m-%Y') AS tgl_sjp
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
WHERE k.id='$idKunj'";
//echo $sqlPas."<br>";
$qPas=mysql_query($sqlPas);
$rw=mysql_fetch_array($qPas);
$pasienId=$rw['pasienId'];
$tgl_sjp=$rw['tgl_sjp'];

/* ======================= TGL ====================== */

if ($tipe=="1") {
	$sTglIn="SELECT
			CONCAT(DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl), '%d-%m-%Y'),' ',DATE_FORMAT(IFNULL(tk.tgl_in,p.tgl_act), '%H:%i')) tgl_in
			FROM b_pelayanan p 
			INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan=3
			ORDER BY tk.id LIMIT 1";
	
	$sTglOut="SELECT
			DATE_FORMAT(IF(k.pulang=1,k.tgl_pulang,tk.tgl_out), '%d-%m-%Y %H:%i') AS tgl_out
			FROM b_pelayanan p 
			INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan=3
			ORDER BY tk.id DESC LIMIT 1";
}
else if($tipe=="0"){
	$sTglIn="SELECT 
			CONCAT(DATE_FORMAT(IFNULL(p.tgl, k.tgl), '%d-%m-%Y'),' ',DATE_FORMAT(IFNULL(p.tgl_act, k.tgl_act), '%H:%i')) tgl_in
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan<>3
			ORDER BY p.id LIMIT 1";
	
	$sTglOut="SELECT 
			DATE_FORMAT(IFNULL(p.tgl_krs,''),'%d-%m-%Y %H:%i') tgl_out
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj' 
			AND p.jenis_kunjungan<>3
			ORDER BY p.id DESC LIMIT 1";
}
else {
	$sTglIn="SELECT 
			CONCAT(DATE_FORMAT(IFNULL(p.tgl, k.tgl), '%d-%m-%Y'),' ',DATE_FORMAT(IFNULL(p.tgl_act, k.tgl_act), '%H:%i')) tgl_in
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj'
			ORDER BY p.id LIMIT 1";
			
	$sTglOut="SELECT 
			DATE_FORMAT(IF(k.pulang=1,k.tgl_pulang,IF(p.sudah_krs=1,p.tgl_krs,'')), '%d-%m-%Y %H:%i') AS tgl_out
			FROM b_pelayanan p 
			INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
			WHERE 
			p.kunjungan_id='$idKunj'
			ORDER BY p.id DESC LIMIT 1";
}

//echo $sTglIn;
$qTglIn=mysql_query($sTglIn);
$rwTglIn=mysql_fetch_array($qTglIn);
$tglIn=$rwTglIn['tgl_in'];

//echo $sTglOut;
$qTglOut=mysql_query($sTglOut);
$rwTglOut=mysql_fetch_array($qTglOut);
$tglOut=$rwTglOut['tgl_out'];
/* =========================== END TGL ========================== */


$sql="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='$idKunj'";
$rsJaminan=mysql_query($sql);
$kodeGrouper="";
if (mysql_num_rows($rsJaminan)>0){
	$rwJaminan=mysql_fetch_array($rsJaminan);
	$kodeGrouper=$rwJaminan["kode_grouper_inacbg"];
}

//=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
if ($tipe=="2") {
	$skso="SELECT DISTINCT t.kso_id,mk.nama FROM b_pelayanan p
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_kso mk ON t.kso_id=mk.id
WHERE p.kunjungan_id='$idKunj'";
}elseif ($tipe=="1") {
	$skso="SELECT DISTINCT t.kso_id,mk.nama 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_kso mk ON t.kso_id=mk.id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan=3";
}elseif ($tipe=="0") {
	$skso="SELECT DISTINCT t.kso_id,mk.nama 
FROM b_pelayanan p INNER JOIN b_ms_unit mu ON p.unit_id=mu.id INNER JOIN b_tindakan t ON p.id=t.pelayanan_id INNER JOIN b_ms_kso mk ON t.kso_id=mk.id 
WHERE p.kunjungan_id='$idKunj' AND p.jenis_kunjungan<>3";
}
//echo $skso."<br>";
$qKso=mysql_query($skso);
$status="";
$isBPJS=0;
$isUMUM=0;
$isKSO=0;
while ($rwKso=mysql_fetch_array($qKso)){
	$status .=$rwKso['nama'].", ";
	if ($rwKso['kso_id']==6){
		$isBPJS=1;
	}
	
	if ($rwKso['kso_id']==1){
		$isUMUM=1;
	}
	
	if ($rwKso['kso_id']<>1 && $rwKso['kso_id']<>6){
		$isKSO=1;
	}
}


$status=substr($status,0,strlen($status)-2);
if ($isBPJS==1) $status ="<b> [ ".$kodeGrouper." ]</b>";

if ($tipe=="2"){
	$fJenisKunjungan="";	
}elseif ($tipe=="1"){
	$fJenisKunjungan="AND p.jenis_kunjungan=3";				
}elseif ($tipe=="0"){
	$fJenisKunjungan="AND p.jenis_kunjungan<>3";
}


if ($isBPJS==1){
	$isNaikKelas=0;
	$isVIP_UMUM=0;
	$isVIP=0;
	
	$sHakKelas="SELECT id,level,nama FROM (
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
				INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
				inner join b_ms_kelas mk ON mk.id=t.kso_kelas_id
				WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan
				AND kso.id=6
				AND mk.tipe=0
				UNION
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				inner join b_ms_kelas mk ON mk.id=tk.kso_kelas_id
				WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan
				AND kso.id=6
				AND mk.tipe=0) AS tblhakkelas ORDER BY level DESC LIMIT 1";
	$qHakKelas=mysql_query($sHakKelas);
	$rwHakKelas=mysql_fetch_array($qHakKelas);
	$HakKelas_id=$rwHakKelas['id'];
	$HakKelas=$rwHakKelas['nama'];
	
	$sKelasTertinggi="SELECT id,level,nama FROM (
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
				INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
				INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
				INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
				inner join b_ms_kelas mk ON mk.id=t.kelas_id
				WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan 
				AND kso.id=6
				AND mk.tipe=0
				UNION
				SELECT  
				mk.id,
				mk.nama,
				mk.level
				FROM b_pelayanan p
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				inner join b_ms_kelas mk ON mk.id=tk.kelas_id
				WHERE p.kunjungan_id='$idKunj' $fJenisKunjungan
				AND kso.id=6
				AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
	$qKelasTertinggi=mysql_query($sKelasTertinggi);
	$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
	$KelasTertinggi_id=$rwKelasTertinggi['id'];
	$KelasTertinggi=$rwKelasTertinggi['nama'];
	
	if($rwKelasTertinggi['level'] > $rwHakKelas['level']){
		$isNaikKelas=1;
		
		$sTglNaikKelas="SELECT tgl 
						FROM (
						SELECT  
						t.tgl_act as tgl
						FROM b_pelayanan p
						INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
						INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
						INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
						INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
						inner join b_ms_kelas mk ON mk.id=t.kelas_id
						WHERE 
						p.kunjungan_id='$idKunj' 
						AND mk.id='$KelasTertinggi_id'
						AND kso.id=6
						$fJenisKunjungan
						UNION
						SELECT  
						tk.tgl_in as tgl
						FROM b_pelayanan p
						INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
						INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
						inner join b_ms_kelas mk ON mk.id=tk.kelas_id
						WHERE 
						p.kunjungan_id='$idKunj'
						AND mk.id='$KelasTertinggi_id'
						AND kso.id=6
						$fJenisKunjungan
						) AS tbl ORDER BY tgl ASC LIMIT 1";
		$qTglNaikKelas=mysql_query($sTglNaikKelas);
		$rwTglNaikKelas=mysql_fetch_array($qTglNaikKelas);
		$TglNaikKelas=$rwTglNaikKelas['tgl'];
	}
	
	$sVIP="SELECT * FROM (
				SELECT  
				p.id
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
				INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
				INNER JOIN b_ms_kelas mk ON mk.id=t.kelas_id
				WHERE p.kunjungan_id='$idKunj' 
				AND kso.id=6
				AND mk.tipe=2
				$fJenisKunjungan
				UNION
				SELECT  
				p.id
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				INNER JOIN b_ms_kelas mk ON mk.id=tk.kelas_id
				WHERE p.kunjungan_id='$idKunj'
				AND mk.tipe=2
				AND kso.id=6
				$fJenisKunjungan) AS tblhakkelas LIMIT 1";
	$qVIP=mysql_query($sVIP);
	
	$lbl_biaya_total="Nilai InaCBG's Kelas ".$KelasTertinggi;
	
	if(mysql_num_rows($qVIP)>0){
		$isNaikKelas=1;
		$isVIP=1;
		$lbl_biaya_total="Biaya Naik Kelas BPJS";
	}
	
	if($isVIP==1){
		/*
		$sTglPav="SELECT  
					p.tgl_act as tgl
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
					WHERE p.kunjungan_id='$idKunj' 
					AND mu.parent_id IN (50,132)
					ORDER BY p.id DESC LIMIT 1";
		//echo $sTglPav."<br><br>";
		$qTglPav=mysql_query($sTglPav);
		$rwTglPav=mysql_fetch_array($qTglPav);
		$TglPav=$rwTglPav['tgl'];
		*/
		
		/*
		$sPavUmum="SELECT IF(ipit>paviliun,1,0) AS pav_as_umum
					FROM
					(SELECT
					IFNULL((SELECT  
					tk.id
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
					INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
					INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
					WHERE p.kunjungan_id='$idKunj'
					AND mu.parent_id IN (50,132)
					AND kso.id=6
					ORDER BY tk.id DESC LIMIT 1),0) AS paviliun,
					IFNULL((SELECT  
					tk.id
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
					INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
					INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
					INNER JOIN b_ms_kelas mk ON mk.id=tk.kelas_id
					WHERE p.kunjungan_id='$idKunj'
					AND mk.tipe=1
					AND kso.id=6
					ORDER BY tk.id DESC LIMIT 1),0) AS ipit) AS tbl";
		$qPavUmum=mysql_query($sPavUmum);
		$rwPavUmum=mysql_fetch_array($qPavUmum);
		if($rwPavUmum['pav_as_umum']=='1'){
			$isVIP_UMUM=1;
		}
		*/
		
		$sTipeBayar="select bpjs_tipe_bayar from b_kunjungan where id = '".$idKunj."'";
		$qTipeBayar=mysql_query($sTipeBayar);
		$rwTipeBayar=mysql_fetch_array($qTipeBayar);
		if($rwTipeBayar['bpjs_tipe_bayar']=='1'){
			$isVIP_UMUM=1;
		}
	}
	
	if($isVIP_UMUM==1){
		$sKelasTertinggi="SELECT id,level,nama FROM (
					SELECT  
					mk.id,
					mk.nama,
					mk.level
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
					INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
					INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
					INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
					inner join b_ms_kelas mk ON mk.id=t.kelas_id
					WHERE p.kunjungan_id='$idKunj'
					AND mu.parent_id NOT IN (50,132)											
					AND kso.id=6
					AND mk.tipe=0
					UNION
					SELECT  
					mk.id,
					mk.nama,
					mk.level
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
					INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
					INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
					inner join b_ms_kelas mk ON mk.id=tk.kelas_id
					WHERE p.kunjungan_id='$idKunj'
					AND mu.parent_id NOT IN (50,132)
					AND kso.id=6
					AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
		$qKelasTertinggi=mysql_query($sKelasTertinggi);
		$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
		$KelasTertinggi_id=$rwKelasTertinggi['id'];
		$KelasTertinggi=$rwKelasTertinggi['nama'];
		
		$lbl_biaya_total="Nilai InaCBG's Kelas ".$KelasTertinggi;
	}
	
	if($isNaikKelas==0 || $isVIP_UMUM==1) $lbl_biaya_total="Nilai InaCBG's Kelas ".$HakKelas;
}

if ($isBPJS==1){	
	$BPJS_iurbayar=0;
	$BPJS_jaminan=0;
	$BPJS_biayanaikkelas=0;
	
	$sJaminan="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='$idKunj'";
	$qJaminan=mysql_query($sJaminan);
	if (mysql_num_rows($qJaminan)>0){
		$rwJaminan=mysql_fetch_array($qJaminan);
		
		$BPJS_jaminan=$rwJaminan["biaya_kso"];
		$BPJS_iurbayar=$rwJaminan["biaya_px"];
		$BPJS_biayanaikkelas=$BPJS_jaminan+$BPJS_iurbayar;
		if($tipe==0) $BPJS_biayanaikkelas=$BPJS_jaminan;
		$blmEntryKodeGrouper=0;
	}elseif ($isNaikKelas==1){
		$blmEntryKodeGrouper=1;
	}
	
	
	$totBiayaPaviliun_BPJS=0;
	$totBiayaPaviliun_BPJS_UMUM=0;
	if ($isVIP==1){
		//$isVIP_UMUM=1;
		if ($isVIP_UMUM==1){
			$plusRJRD=0;
			if ($tipe=="2"){
				$fJenisKunjungan="";	
			}elseif ($tipe=="1"){
				$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=3";				
			}elseif ($tipe=="0"){
				$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan<>3";
			}
			
			$sPavU="SELECT 
					  SUM(nilai) AS total 
					FROM
					  (SELECT
						1,  
						SUM(tbl_tindakan.biaya) AS nilai 
					  FROM
						(SELECT 
						(b_tindakan.qty*b_tindakan.biaya) AS biaya 
						FROM
						  b_pelayanan  
						  INNER JOIN b_tindakan 
							ON b_tindakan.pelayanan_id = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN b_ms_kelas mk 
							ON mk.id = b_pelayanan.kelas_id
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_tindakan.kso_id = 6
						$fJenisKunjungan 
						AND mk.tipe = 2
						) AS tbl_tindakan 
					  UNION
					  SELECT
						2,  
						SUM(kmr.biaya) AS nilai 
					  FROM
						(SELECT
						  IF(b_tindakan_kamar.status_out = 0, 
						  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
						  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya 
						FROM
						  b_tindakan_kamar 
						  INNER JOIN b_pelayanan 
							ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN b_ms_kelas mk 
							ON mk.id = b_pelayanan.kelas_id 
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_tindakan_kamar.kso_id = 6 
						AND b_tindakan_kamar.aktif = 1
						$fJenisKunjungan
						AND mk.tipe = 2 
						) AS kmr) AS gab";
			//echo $sPavU."<br></br>";
			$qPavU=mysql_query($sPavU);
			$rwPavU=mysql_fetch_array($qPavU);
			$totBiayaPaviliun_BPJS_UMUM+=$rwPavU['total'];
			
			
			$sPavObatU="SELECT
					  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
					FROM
					  $dbapotek.a_penjualan ap 
					  INNER JOIN b_pelayanan 
						ON ap.NO_KUNJUNGAN = b_pelayanan.id
					  INNER JOIN b_ms_unit 
						ON b_ms_unit.id = b_pelayanan.unit_id
					  INNER JOIN b_ms_unit b_ms_unit_asal 
						ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
					  INNER JOIN $dbapotek.a_mitra am 
						ON am.IDMITRA=ap.KSO_ID
					  INNER JOIN b_ms_kso kso 
						ON kso.id=b_pelayanan.kso_id
					  INNER JOIN b_kunjungan
						ON b_kunjungan.id = b_pelayanan.kunjungan_id
					  INNER JOIN b_ms_kelas k 
						ON k.id=b_pelayanan.kelas_id
					WHERE 
					b_pelayanan.kunjungan_id = '$idKunj'
					$fJenisKunjungan
					AND kso.id = 6
					AND ap.CARA_BAYAR=2
					AND ap.KRONIS<>2
					AND k.tipe=2";
			//echo $sPavObatU;
			$qPavObatU=mysql_query($sPavObatU);
			$rwPavObatU=mysql_fetch_array($qPavObatU);
			$totBiayaPaviliun_BPJS_UMUM+=$rwPavObatU['SUBTOTAL'];			
		}
		else{
			
			$totBiayaRJRD_BPJS=0;
			if($tipe=='1'){
				$plusRJRD=1;
				$sRJRD="SELECT 
						  SUM(nilai) AS total 
						FROM
						  (SELECT
							1,  
							SUM(tbl_tindakan.biaya) AS nilai 
						  FROM
							(SELECT 
							(b_tindakan.qty*b_tindakan.biaya) AS biaya 
							FROM
							  b_pelayanan  
							  INNER JOIN b_tindakan 
								ON b_tindakan.pelayanan_id = b_pelayanan.id
							  INNER JOIN b_ms_unit 
								ON b_ms_unit.id = b_pelayanan.unit_id
							  INNER JOIN b_ms_unit b_ms_unit_asal 
								ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
							  LEFT JOIN b_ms_kelas mk 
								ON mk.id = b_tindakan.kelas_id
							WHERE 
							b_pelayanan.kunjungan_id = '$idKunj'
							AND b_tindakan.kso_id = 6
							AND b_pelayanan.jenis_kunjungan <> 3
							) AS tbl_tindakan 
						  ) AS gab";
				//echo $sRJRD."<br></br>";
				$qRJRD=mysql_query($sRJRD);
				$rwRJRD=mysql_fetch_array($qRJRD);
				$totBiayaRJRD_BPJS+=$rwRJRD['total'];
			
				$sRJRDObat="SELECT
						  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
						FROM
						  $dbapotek.a_penjualan ap 
						  INNER JOIN b_pelayanan 
							ON ap.NO_KUNJUNGAN = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN $dbapotek.a_mitra am 
							ON am.IDMITRA=ap.KSO_ID
						  INNER JOIN b_ms_kso kso 
							ON kso.id=b_pelayanan.kso_id
						  INNER JOIN b_kunjungan
							ON b_kunjungan.id = b_pelayanan.kunjungan_id
						  LEFT JOIN b_ms_kelas k 
							ON k.id=b_pelayanan.kelas_id 
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_pelayanan.jenis_kunjungan <> 3
						AND kso.id = 6
						AND ap.KRONIS<>2
						AND ap.CARA_BAYAR=2";
				//echo $sPavObat;
				$qRJRDObat=mysql_query($sRJRDObat);
				$rwRJRDObat=mysql_fetch_array($qRJRDObat);
				$totBiayaRJRD_BPJS+=$rwRJRDObat['SUBTOTAL'];
			}
			
			if ($tipe=="2"){
				$fJenisKunjungan="";	
			}elseif ($tipe=="1"){
				$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=3";				
			}elseif ($tipe=="0"){
				$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan<>3";
			}
			
			$fJK="";
			if($tipe=='1'){
				$fJK="AND b_pelayanan.jenis_kunjungan=3";	
			}
			
			$sPav="SELECT 
					  SUM(nilai) AS total 
					FROM
					  (SELECT
						1,  
						SUM(tbl_tindakan.biaya) AS nilai 
					  FROM
						(SELECT 
						(b_tindakan.qty*b_tindakan.biaya) AS biaya 
						FROM
						  b_pelayanan  
						  INNER JOIN b_tindakan 
							ON b_tindakan.pelayanan_id = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  LEFT JOIN b_ms_kelas mk 
							ON mk.id = b_tindakan.kelas_id
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_tindakan.kso_id = 6
						$fJK
						) AS tbl_tindakan 
					  UNION
					  SELECT
						2,  
						SUM(kmr.biaya) AS nilai 
					  FROM
						(SELECT
						  IF(b_tindakan_kamar.status_out = 0, 
						  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
						  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya 
						FROM
						  b_tindakan_kamar 
						  INNER JOIN b_pelayanan 
							ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						  INNER JOIN b_ms_unit 
							ON b_ms_unit.id = b_pelayanan.unit_id
						  INNER JOIN b_ms_unit b_ms_unit_asal 
							ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
						  INNER JOIN b_ms_kelas mk 
							ON mk.id = b_tindakan_kamar.kelas_id  
						WHERE 
						b_pelayanan.kunjungan_id = '$idKunj'
						AND b_tindakan_kamar.kso_id = 6 
						AND b_tindakan_kamar.aktif = 1
						$fJK
						) AS kmr) AS gab";
			//echo $sPav."<br></br>";
			$qPav=mysql_query($sPav);
			$rwPav=mysql_fetch_array($qPav);
			$totBiayaPaviliun_BPJS+=$rwPav['total'];
			
			$sPavObat="SELECT
					  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
					FROM
					  $dbapotek.a_penjualan ap 
					  INNER JOIN b_pelayanan 
						ON ap.NO_KUNJUNGAN = b_pelayanan.id
					  INNER JOIN b_ms_unit 
						ON b_ms_unit.id = b_pelayanan.unit_id
					  INNER JOIN b_ms_unit b_ms_unit_asal 
						ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
					  INNER JOIN $dbapotek.a_mitra am 
						ON am.IDMITRA=ap.KSO_ID
					  INNER JOIN b_ms_kso kso 
						ON kso.id=b_pelayanan.kso_id
					  INNER JOIN b_kunjungan
						ON b_kunjungan.id = b_pelayanan.kunjungan_id
					  LEFT JOIN b_ms_kelas k 
						ON k.id=b_pelayanan.kelas_id 
					WHERE 
					b_pelayanan.kunjungan_id = '$idKunj'
					$fJK
					AND kso.id = 6
					AND ap.CARA_BAYAR=2
					AND ap.KRONIS<>2";
			//echo $sPavObat;
			$qPavObat=mysql_query($sPavObat);
			$rwPavObat=mysql_fetch_array($qPavObat);
			$totBiayaPaviliun_BPJS+=$rwPavObat['SUBTOTAL'];
			
			$BPJS_biayanaikkelas=$totBiayaPaviliun_BPJS;
			if($totBiayaPaviliun_BPJS>$BPJS_jaminan)
				$BPJS_iurbayar=$BPJS_biayanaikkelas - $BPJS_jaminan;
					
		}
	}
	
}

$totBiaya_umum=0;
if($isUMUM==1){
	if ($tipe=="2"){
			$fJenisKunjungan="";	
		}elseif ($tipe=="1"){
			$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=3";				
		}elseif ($tipe=="0"){
			$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan<>3";
		}
		
		$sUmum="SELECT 
				  SUM(nilai) AS total 
				FROM
				  (SELECT
					1,  
					SUM(tbl_tindakan.biaya) AS nilai 
				  FROM
					(SELECT 
					(b_tindakan.qty*b_tindakan.biaya) AS biaya 
					FROM
					  b_pelayanan  
					  INNER JOIN b_tindakan 
						ON b_tindakan.pelayanan_id = b_pelayanan.id
					WHERE 
					b_pelayanan.kunjungan_id = '$idKunj'
					AND b_tindakan.kso_id = 1
					$fJenisKunjungan
					) AS tbl_tindakan 
				  UNION
				  SELECT
					2,  
					SUM(kmr.biaya) AS nilai 
				  FROM
					(SELECT
					  IF(b_tindakan_kamar.status_out = 0, 
					  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
					  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya 
					FROM
					  b_tindakan_kamar 
					  INNER JOIN b_pelayanan 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id  
					WHERE 
					b_pelayanan.kunjungan_id = '$idKunj'
					AND b_tindakan_kamar.kso_id = 1 
					AND b_tindakan_kamar.aktif = 1
					$fJenisKunjungan
					) AS kmr) AS gab";
		//echo $sUmum."<br></br>";
		$qUmum=mysql_query($sUmum);
		$rwUmum=mysql_fetch_array($qUmum);
		$totBiaya_umum+=$rwUmum['total'];
		
		$sUmumObat="SELECT
				  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
				FROM
				  $dbapotek.a_penjualan ap 
				  INNER JOIN b_pelayanan 
					ON ap.NO_KUNJUNGAN = b_pelayanan.id
				  INNER JOIN $dbapotek.a_mitra am 
					ON am.IDMITRA=ap.KSO_ID
				  INNER JOIN b_ms_kso kso 
					ON kso.id=b_pelayanan.kso_id
				  INNER JOIN b_kunjungan
					ON b_kunjungan.id = b_pelayanan.kunjungan_id 
				WHERE 
				b_pelayanan.kunjungan_id = '$idKunj'
				$fJenisKunjungan
				AND kso.id = 1
				AND ap.CARA_BAYAR=2
				AND ap.KRONIS<>2";
		//echo $sPavObat;
		$qUmumObat=mysql_query($sUmumObat);
		$rwUmumObat=mysql_fetch_array($qUmumObat);
		$totBiaya_umum+=$rwUmumObat['SUBTOTAL'];
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Tagihan Obat :.</title>
    </head>

    <body style="margin-top:0px">
        <table width="1225" border="0" cellspacing="0" cellpadding="0" align="left" class="kwi">
            <tr>
                <td colspan="2" style="font-size:14px">
                    <b><!--PEMERINTAH KABUPATEN SIDOARJO<br />-->
					<?=$namaRS?><br />
                    <?php echo strtoupper($alamatRS." ".$kotaRS);?><br />
                    Telepon <?php echo strtoupper($tlpRS);?><br/></b>&nbsp;
                </td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2" align="center" style="font-weight:bold;font-size:13px;">
                    Rincian Tagihan Obat
                </td>
            </tr>
            <tr class="kwi">
                <td colspan="2">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="11%" style="font-size:12px;padding-left:25px;">No RM</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="56%" style="font-size:12px">&nbsp;<?php echo $rw['no_rm'];?></td>
                            <td width="9%" style="font-size:12px">Tgl Mulai</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="20%" style="font-size:12px">&nbsp;<?php echo $tglIn;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px;padding-left:25px;">Nama Pasien </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmPas']);?></td>
                            <td width="9%" style="font-size:12px">Tgl Selesai </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td width="20%" style="font-size:12px">&nbsp;<?php echo $tglOut;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px;padding-left:25px;">Jenis Kelamin </td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['sex']);?></td>
                            <?php
							if($isBPJS==0){
								$disp_BPJS_tgl_SEP = "visibility:hidden;";
							}
							?>
                            <td width="9%" style="font-size:12px;<?php echo $disp_BPJS_tgl_SEP; ?>">Tgl SEP</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px;<?php echo $disp_BPJS_tgl_SEP; ?>">:</td>
                            <td width="20%" style="font-size:12px;<?php echo $disp_BPJS_tgl_SEP; ?>">&nbsp;<?php echo $tgl_sjp;?></td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px;padding-left:25px;">Alamat</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px;">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['alamat']);?></td>
                            <td width="9%" style="font-size:12px">&nbsp;</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="20%" style="font-size:12px">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="11%" style="font-size:12px;padding-left:25px;">Kel. / Desa</td>
                          	<td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['nmDesa']);?></td>
                          	<td width="9%" style="font-size:12px">&nbsp;</td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td width="20%"></td>
                        </tr>
                        <tr>
                            <td width="11%"><span style="font-size:12px;padding-left:25px;">RT / RW</span></td>
                          	<td width="2%" align="center" style="font-weight:bold;font-size:12px">:</td>
                            <td style="font-size:12px">&nbsp;<?php echo strtolower($rw['rt']." / ".$rw['rw']);?></td>
                          	<td width="9%" style="font-size:12px"><?php if ($isBPJS==1) echo "Kode Grouper"; else ""; ?></td>
                            <td width="2%" align="center" style="font-weight:bold;font-size:12px"><?php if ($isBPJS==1) echo ":"; else ""; ?></td>
                            <td width="20%">&nbsp;<?php if ($isBPJS==1) echo $status; else echo "";?></td>
                        </tr>
                        <tr id="trProporsional_Px_Umum" style="font-size:12px; display:none;">
                          <td height="25" colspan="6" align="center" style="font-size:12px">&nbsp;<?php echo $txtPropor_px_umum; ?></td>
                        </tr>
              </table>	</td>
            </tr>
            <tr>
            	<td width="618">&nbsp;</td>
            </tr>
            <tr class="kwi">
                <td height="30" colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr height="30">
                          <td width="28" align="left"  style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; font-weight:bold;font-size:12px">&nbsp;</td>
                            <td align="left" width="367" style="padding-left:0px;border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; font-weight:bold;font-size:12px">Uraian Layanan</td>
                            <td align="center" width="114" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Hak Kelas</td>
                            <td align="center" width="118" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Kelas</td>
                            <td align="center" width="90" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Tanggal</td>
                            <td align="center" width="77" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px">Jumlah</td>
                            <td align="right" width="153" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px;">Biaya&nbsp;</td>
                            <td align="right" width="114" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px;">Nilai Jaminan&nbsp;</td>
                            <td align="center" width="164" style="border-top:#000000 solid 1px; border-bottom:#000000 solid 1px; border-left:none; font-weight:bold;font-size:12px;">Keterangan</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        	<td>&nbsp;</td>
                        </tr>
						<?php
						if ($tipe=="2"){
                        	$sKSO="SELECT id,nama,urutan FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama,
									p.id as urutan
									FROM b_pelayanan p
									INNER JOIN $dbapotek.a_penjualan ap ON ap.NO_KUNJUNGAN=p.id
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_ms_kso kso ON kso.id=p.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									) AS tblkso GROUP BY id ORDER BY urutan";
                        }elseif ($tipe=="1"){
                        	$sKSO="SELECT id,nama FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama,
									p.id as urutan
									FROM b_pelayanan p
									INNER JOIN $dbapotek.a_penjualan ap ON ap.NO_KUNJUNGAN=p.id
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_ms_kso kso ON kso.id=p.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan=3
									) AS tblkso GROUP BY id ORDER BY urutan";
                        }elseif ($tipe=="0"){
                        	$sKSO="SELECT id,nama FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama,
									p.id as urutan 
									FROM b_pelayanan p
									INNER JOIN $dbapotek.a_penjualan ap ON ap.NO_KUNJUNGAN=p.id
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_ms_kso kso ON kso.id=p.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan<>3
									) AS tblkso GROUP BY id ORDER BY urutan";
                        }
						//echo $sKSO."<br>";
						$qKSO=mysql_query($sKSO);
						$totBiaya=0;
						$totBiayaKSO=0;
						$totNilaiJaminan=0;
						$totBebanPasien=0;
						while($rwKSO=mysql_fetch_array($qKSO)){
						?>
						<tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:0px;font-size:12px;font-weight:bold"><?php echo $rwKSO['nama']?></td>
                        </tr>
						
                        <?php
                        //=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
						if ($tipe=="2"){
                        	$sUnit="SELECT * FROM (
									SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM 
									$dbapotek.a_penjualan ap
									INNER JOIN b_pelayanan p ON p.id=ap.NO_KUNJUNGAN
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND p.kso_id='".$rwKSO['id']."'
									) AS tblkso GROUP BY id ORDER BY id";
                        }elseif ($tipe=="1"){
                        	$sUnit="SELECT * FROM (
									SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM 
									$dbapotek.a_penjualan ap
									INNER JOIN b_pelayanan p ON p.id=ap.NO_KUNJUNGAN
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND p.jenis_kunjungan=3
									AND p.kso_id='".$rwKSO['id']."'
									) AS tblkso GROUP BY id ORDER BY id";
                        }elseif ($tipe=="0"){
                        	$sUnit="SELECT * FROM (
									SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM 
									$dbapotek.a_penjualan ap
									INNER JOIN b_pelayanan p ON p.id=ap.NO_KUNJUNGAN
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND p.kso_id='".$rwKSO['id']."'
									AND p.jenis_kunjungan<>3
									) AS tblkso GROUP BY id ORDER BY id";
                        }
						
						$subBiaya=0;
						$subBiayaKSO=0;
						$subNilaiJaminan=0;
						$subBebanPasien=0;
						
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
						while($rwUnit=mysql_fetch_array($qUnit)) {
						?>
                        <tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:25px;font-size:12px; font-weight:bold"><?php echo $rwUnit['nmUnit']?></td>
                        </tr>
                            
                        <?php
							$fCaraBayar="AND ap.CARA_BAYAR=2";
							
                        	$sKonsul="SELECT 
							DISTINCT ap.NO_PENJUALAN,ap.DOKTER,au.UNIT_NAME 
							FROM $dbapotek.a_penjualan ap
							inner join b_pelayanan p on p.id=ap.NO_KUNJUNGAN 
							inner join b_ms_kso kso on kso.id=p.kso_id
							inner join $dbapotek.a_unit au on au.UNIT_ID=ap.UNIT_ID  
							WHERE 
							ap.NO_PASIEN='".$rw['no_rm']."' 
							AND ap.NO_KUNJUNGAN='".$rwUnit['id']."'
							AND kso.id='".$rwKSO['id']."'
							$fCaraBayar
							";
							
							$tObat=0;
							$tObatJamin=0;
							
							$qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)) {
                        ?>
                        <tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:50px;font-size:12px"><?php echo $rwKonsul['DOKTER']." - Nota Resep ".$rwKonsul['NO_PENJUALAN']." - ".$rwKonsul['UNIT_NAME'];?></td>
                        </tr>
						<?php
						
						$sObat="SELECT *, 
									  IF(RETUR=0,'',CONCAT('(',RETUR,')')) AS nretur
									  FROM 
									  (SELECT
									  ao.OBAT_NAMA,
									  ap.DOKTER,
									  ap.NO_PENJUALAN,
									  ac.id AS CARA_BAYAR_ID,
									  ac.nama AS CARA_BAYAR,
									  SUM(ap.QTY_JUAL) QTY_JUAL, 
									  SUM(ap.QTY_RETUR) QTY_RETUR,
									  SUM(ap.QTY_JUAL - ap.QTY_RETUR) QTY, 
									  DATE_FORMAT(ap.TGL, '%d-%m-%Y') AS TGL,
									  am.NAMA KSO, 
									  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL,
									  SUM(IF(ap.CARA_BAYAR=2,((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN),0)) AS DIJAMIN,
									  SUM(ap.QTY_RETUR * ap.HARGA_SATUAN) AS RETUR,
									  k.nama AS kelas,
									  if(hk.id=1,'-',hk.nama) AS hakkelas,
									  k.level AS kelas_level,
									  k.tipe AS kelas_tipe,
									  hk.level AS hakkelas_level,
									  ap.TGL_ACT,
									  b_pelayanan.is_paviliun,
									  ap.KRONIS
									FROM
									  (SELECT 
										* 
									  FROM
										$dbapotek.a_penjualan 
									  WHERE NO_KUNJUNGAN = '".$rwUnit['id']."' AND NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."' AND DOKTER='".$rwKonsul['DOKTER']."') AS ap 
									  INNER JOIN $dbapotek.a_penerimaan pn 
										ON ap.PENERIMAAN_ID = pn.ID 
									  INNER JOIN $dbapotek.a_obat ao 
										ON pn.OBAT_ID = ao.OBAT_ID 
									  INNER JOIN $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
									  INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA=ap.KSO_ID
									  INNER JOIN b_pelayanan 
										ON ap.NO_KUNJUNGAN = b_pelayanan.id
									  inner join b_ms_kso kso on kso.id=b_pelayanan.kso_id
									  INNER JOIN b_kunjungan
									    ON b_kunjungan.id = b_pelayanan.kunjungan_id
									  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
									  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id
									  where kso.id='".$rwKSO['id']."'
									  $fCaraBayar
									GROUP BY ao.OBAT_ID) AS tbl ORDER BY OBAT_NAMA";
						//echo $sObat."<br><br>";
						$qObat=mysql_query($sObat);
						
						$subTotal=0;
						$subTotalJaminan=0;
						
						while($rwObat=mysql_fetch_array($qObat)){
							
							$nBiayaJaminanObat=$rwObat['DIJAMIN'];
							
							$bObat=$rwObat['SUBTOTAL'];
							$txtKetObat="";
							if($rwObat['KRONIS']=='2'){ // OBAT PAKET
								$bObat=0;
								$nBiayaJaminanObat=0;
								$txtKetObat="PAKET";	
							}
							
							if($rwKSO['id']==6){
								$nBiayaJaminanObat=0;
							}
							else if($rwKSO['id']==9){
								$nBiayaJaminanObat=0;	
							}
							else{
								if($rwKSO['id']==1){
									$nBiayaJaminanObat=0;	
								}
							}
							
						?>   
                        <tr>
                          <td align="left">&nbsp;</td>
                            <td align="left" style="padding-left:75px"><?php echo $rwObat['OBAT_NAMA'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwObat['hakkelas'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwObat['kelas'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwObat['TGL'];?></td>
                            <td align="center" style="font-size:12px;"><?php echo $rwObat['QTY'];?></td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($bObat,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($nBiayaJaminanObat,0,",",".");?>&nbsp;</td>
                            <td align="center" style="font-size:12px;"><?php echo $txtKetObat; ?></td>
                        </tr>
                        <?php
							$subTotal+=$bObat;
							$subTotalJaminan+=$nBiayaJaminanObat;
							}
						?>
                        <tr style="vertical-align:bottom" height="20">
                        	<td colspan="5">&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px; border-top:solid #000000 1px;">Subtotal&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px;"><?php echo number_format($subTotal,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px;"><?php echo number_format($subTotalJaminan,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px;">&nbsp;</td>
                        </tr>
                        <?php
							$subBiaya+=$subTotal;
							$subNilaiJaminan+=$subTotalJaminan;
						}
						?>
                        <?php
						
                        } // END UNIT
						?>
                        <tr>
                        	<td>&nbsp;</td>
                        </tr>
                        <tr style="vertical-align:bottom" height="20">
                        	<td>&nbsp;</td>
                        	<td colspan="5" align="right" style="font-weight:bold; font-size:12px; border-top:solid #000000 1px;">Total&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px;"><?php echo number_format($subBiaya,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px;"><?php echo number_format($subNilaiJaminan,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px;">&nbsp;</td>
                        </tr>
                        <tr id="trSubTotalSpasi" style="display:none">
                          <td colspan="9" align="center">&nbsp;</td>
                        </tr>
                        <?php
							$totBiaya+=$subBiaya;
							$totNilaiJaminan+=$subNilaiJaminan;
						} // END KSO
						?>
                        <tr height="10">
                            <td colspan="9" style="font-weight:bold; border-bottom:solid #000000 1px;"></td>
                        </tr>
                        <tr height="30">
                          <td align="left" style=" font-size:12px">&nbsp;</td>
                            <td align="left" style="padding-left:60px; font-size:12px">&nbsp;</td>
                            <td colspan="4" align="right" style="font-weight:bold; font-size:12px">Grand Total&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px"><?php echo number_format($totBiaya,0,",",".");?>&nbsp;</td>
                            <td style="font-weight:bold; font-size:12px">&nbsp;</td>
                            <td style="font-weight:bold; font-size:12px">&nbsp;</td>
                        </tr>
                        <tr>
                        	<td colspan="9" style="border-top:1px solid">&nbsp;</td>
                        </tr>
                     </table>
                      </td>
            		</tr>
                 	<?php
$totBiayaKSO=0;
$totNilaiJaminan=0;
if($isKSO==1){
	if ($tipe=="2"){
			$fJenisKunjungan="";	
		}elseif ($tipe=="1"){
			$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=3";				
		}elseif ($tipe=="0"){
			$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan<>3";
		}
		
		$sKSO="SELECT 
				  SUM(nilai) AS total,
				  SUM(jaminan) AS total_jaminan 
				FROM
				  (SELECT
					1,  
					SUM(tbl_tindakan.biaya) AS nilai,
					SUM(tbl_tindakan.biaya_kso) AS jaminan 
				  FROM
					(SELECT 
					(b_tindakan.qty*b_tindakan.biaya) AS biaya,
					(b_tindakan.qty*b_tindakan.biaya_kso) AS biaya_kso 
					FROM
					  b_pelayanan  
					  INNER JOIN b_tindakan 
						ON b_tindakan.pelayanan_id = b_pelayanan.id
					WHERE 
					b_pelayanan.kunjungan_id = '$idKunj'
					AND b_tindakan.kso_id NOT IN (1,6)
					$fJenisKunjungan
					) AS tbl_tindakan 
				  UNION
				  SELECT
					2,  
					SUM(kmr.biaya) AS nilai,
					SUM(kmr.jaminan) AS jaminan 
				  FROM
					(SELECT
					  IF(b_tindakan_kamar.status_out = 0, 
					  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip), 
					  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.tarip)) biaya,
					  
					  IF(b_tindakan_kamar.status_out = 0, 
					  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso), 
					  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)) * (b_tindakan_kamar.beban_kso)) jaminan 
					FROM
					  b_tindakan_kamar 
					  INNER JOIN b_pelayanan 
						ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id  
					WHERE 
					b_pelayanan.kunjungan_id = '$idKunj'
					AND b_tindakan_kamar.kso_id NOT IN (1,6) 
					AND b_tindakan_kamar.aktif = 1
					$fJenisKunjungan
					) AS kmr) AS gab";
		//echo $sKSO."<br></br>";
		$qKSO=mysql_query($sKSO);
		$rwKSO=mysql_fetch_array($qKSO);
		$totBiayaKSO+=$rwKSO['total'];
		$totNilaiJaminan+=$rwKSO['total_jaminan'];
		
		$sKSOObat="SELECT
				  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
				FROM
				  $dbapotek.a_penjualan ap 
				  INNER JOIN b_pelayanan 
					ON ap.NO_KUNJUNGAN = b_pelayanan.id
				  INNER JOIN $dbapotek.a_mitra am 
					ON am.IDMITRA=ap.KSO_ID
				  INNER JOIN b_ms_kso kso 
					ON kso.id=b_pelayanan.kso_id
				  INNER JOIN b_kunjungan
					ON b_kunjungan.id = b_pelayanan.kunjungan_id 
				WHERE 
				b_pelayanan.kunjungan_id = '$idKunj'
				$fJenisKunjungan
				AND kso.id NOT IN (1,6)
				AND ap.CARA_BAYAR=2
				AND ap.KRONIS<>2";
		//echo $sPavObat;
		$qKSOObat=mysql_query($sKSOObat);
		$rwKSOObat=mysql_fetch_array($qKSOObat);
		$totBiayaKSO+=$rwKSOObat['SUBTOTAL'];
		$totNilaiJaminan+=$rwKSOObat['SUBTOTAL'];
}

$jenisKunj="";
if($tipe==2){
	$jenisKunj="";
}
else if($tipe==1){
	$jenisKunj="AND jenis_kunjungan=3";
}
else{
	$jenisKunj="AND jenis_kunjungan<>3";
}

$totBAYAR=0;
$sBayar="select sum(nilai) as nilai from b_bayar where kunjungan_id='$idKunj' and tipe=0 $jenisKunj";
$qBayar=mysql_query($sBayar);
$rwBayar=mysql_fetch_array($qBayar);
$totBAYAR+=$rwBayar['nilai'];

$sBayarObat="SELECT 
		SUM(aku.TOTAL_HARGA) AS BAYAR
		FROM $dbapotek.a_kredit_utang aku
		INNER JOIN b_pelayanan p ON p.id=aku.NO_PELAYANAN
		WHERE p.kunjungan_id='$idKunj' and aku.CARA_BAYAR=2 $jenisKunj";
$qBayarObat=mysql_query($sBayarObat);
$rwBayarObat=mysql_fetch_array($qBayarObat);
$totBAYAR+=$rwBayarObat['BAYAR'];


$sTitipan="select sum(titipan) as titipan from b_bayar where kunjungan_id='$idKunj' and tipe=1 $jenisKunj";
$qTitipan=mysql_query($sTitipan);
$rwTitipan=mysql_fetch_array($qTitipan);
$titipan=$rwTitipan['titipan'];

$sKeringanan="select sum(keringanan) as keringanan from b_bayar where kunjungan_id='$idKunj' $jenisKunj";
$qKeringanan=mysql_query($sKeringanan);
$rwKeringanan=mysql_fetch_array($qKeringanan);
$keringanan=$rwKeringanan['keringanan'];

$iurbayar_BPJS=0;
if(($BPJS_biayanaikkelas+$totBiayaRJRD_BPJS)>$BPJS_jaminan) $iurbayar_BPJS=($BPJS_biayanaikkelas+$totBiayaRJRD_BPJS)-$BPJS_jaminan;

$iurbayar_KSO=0;
if($totBiayaKSO>$totNilaiJaminan) $iurbayar_KSO=$totBiayaKSO-$totNilaiJaminan;

//$totIURBAYAR=$totBebanPasien+$BPJS_iurbayar;

$total_tagihan_pasien=$totBiaya_umum+$totBiayaPaviliun_BPJS_UMUM+$iurbayar_BPJS+$iurbayar_KSO;

$SUM=$total_tagihan_pasien-$totBAYAR-$titipan-$keringanan;

$txtSUM="Kurang Bayar";
$nSUM=$SUM;
if($SUM<0){
	$txtSUM="Lebih Bayar";
	$nSUM=abs($SUM);
}



$disp_UMUM="";
if($isUMUM==0){
	$disp_UMUM = 'style="display:none"';
}


$disp_BPJS="";
if($isBPJS==0){
	$disp_BPJS = 'style="display:none"';
}

$disp_KSO="";
if($isKSO==0){
	$disp_KSO = 'style="display:none"';
}

if($isVIP_UMUM==0){
	$disp_BPJS_Pav_UMUM = 'style="display:none"';
}

					?>
                    <tr class="kwi" style="display:none;">
                    	<td style="vertical-align:top">
                        <table width="94%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="54%" align="center" style="font-size:12px"></td>
                            <td align="right" style="font-size:12px;"></td>
                            <td width="27%" align="right" style="font-size:12px;"></td>
                        </tr> 
                        <tr <?php echo $disp_BPJS_Pav_UMUM; ?>>
                          <td width="58%" height="19" align="right" style="font-weight:bold;font-size:12px">Biaya Paviliun :&nbsp;</td>
                          <td style="font-weight:bold;font-size:12px" align="right"><?php echo number_format($totBiayaPaviliun_BPJS_UMUM,0,",","."); ?></td>
                          <td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
                          </tr>
                        <tr <?php echo $disp_BPJS_Pav_UMUM; ?>>
                          <td width="58%" height="19" align="right" style="font-weight:bold;font-size:12px">&nbsp;</td>
                          <td style="font-weight:bold;font-size:12px" align="right">&nbsp;</td>
                          <td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
                          </tr>
                        <?php  
                        if($plusRJRD=='1' && $totBiayaRJRD_BPJS>0){
							?>
							<tr>
								<td width="58%" height="19" align="right" style="font-weight:bold;font-size:12px">Biaya RJ/IGD BPJS :&nbsp;</td>
								<td style="font-weight:bold;font-size:12px" align="right"><?php echo number_format($totBiayaRJRD_BPJS,0,",","."); ?></td>
								<td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
							</tr>
							<?php	
						}
						?>  
                        <tr <?php echo $disp_BPJS; ?>>
                          <td width="58%" height="19" align="right" style="font-weight:bold;font-size:12px"><?php echo $lbl_biaya_total; ?> :&nbsp;</td>
                          <td style="font-weight:bold;font-size:12px" align="right"><?php echo number_format($BPJS_biayanaikkelas,0,",","."); ?></td>
                          <td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
                        </tr>
                        <tr <?php echo $disp_BPJS; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Nilai Hak Kelas <?php echo $HakKelas; ?> :&nbsp;</td>
                            <td style="font-weight:bold;font-size:12px;" align="right"><?php echo number_format($BPJS_jaminan,0,",","."); ?></td>
                            <td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
                          </tr>
                        <tr <?php echo $disp_BPJS; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Iur Bayar BPJS :&nbsp;</td>
                            <td style="font-weight:bold;font-size:12px; border-top:1px solid;" align="right"><?php echo number_format($iurbayar_BPJS,0,",","."); ?></td>
                            <td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
                          </tr>
                        <tr <?php echo $disp_BPJS; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px">&nbsp;</td>
                            <td style="font-weight:bold;font-size:12px;" align="right">&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px;">&nbsp;</td>
                          </tr>
                        <tr <?php echo $disp_KSO; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Total Biaya KSO Lain :&nbsp;</td>
                            <td style="font-weight:bold;font-size:12px;" align="right"><?php echo number_format($totBiayaKSO,0,",","."); ?></td>
                            <td align="right" style="font-weight:bold;font-size:12px"></td>
                          </tr>
                        <tr <?php echo $disp_KSO; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Nilai Jaminan :&nbsp;</td>
                            <td style="font-weight:bold;font-size:12px; " align="right"><?php echo number_format($totNilaiJaminan,0,",","."); ?></td>
                            <td align="right" style="font-weight:bold;font-size:12px">&nbsp;</td>
                          </tr>
                        <tr <?php echo $disp_KSO; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Iur Bayar KSO Lain :&nbsp;</td>
                            <td style="font-weight:bold;font-size:12px; border-top:1px solid;" align="right"><?php echo number_format($iurbayar_KSO,0,",","."); ?></td>
                            <td align="right" style="font-weight:bold;font-size:12px">&nbsp;</td>
                          </tr>
                       <tr>
                            <td height="19" align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td colspan="2" align="right" style="font-weight:bold;font-size:12px">&nbsp;</td>
                          </tr>
                        <tr>
                            <td height="25" align="left" style="padding-left:60px;font-size:12px">&nbsp;</td>
                            <td colspan="2" align="right" style="font-weight:bold; font-size:12px">&nbsp;</td>
                          </tr>
                    </table>
              </td>
              <td width="607" style="vertical-align:top">
              		<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
                        <tr>
                            <td width="54%" align="center" style="font-size:12px"></td>
                            <td align="right" style="font-size:12px;"></td>
                            <td width="27%" align="right" style="font-size:12px;"></td>
                        </tr>
                        <tr <?php echo $disp_UMUM; ?>>
                          <td height="19" align="right" style="font-weight:bold;font-size:12px;"><span style="font-weight:bold; font-size:12px">Total Biaya Status Umum :&nbsp;</span></td>
                          <td width="19%" align="right" style="font-weight:bold;font-size:12px;"><?php echo number_format($totBiaya_umum,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <tr <?php echo $disp_BPJS_Pav_UMUM; ?>>
                          <td height="19" align="right" style="font-weight:bold;font-size:12px;"><span style="font-weight:bold; font-size:12px">Total Biaya Paviliun :&nbsp;</span></td>
                          <td width="19%" align="right" style="font-weight:bold;font-size:12px;"><?php echo number_format($totBiayaPaviliun_BPJS_UMUM,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <tr <?php echo $disp_BPJS; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Iur Bayar BPJS :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px;"><?php echo number_format($iurbayar_BPJS,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <tr <?php echo $disp_KSO; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Iur Bayar KSO Lain :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px;"><?php echo number_format($iurbayar_KSO,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Total Tagihan Pasien :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px; border-top:1px solid;"><?php echo number_format($total_tagihan_pasien,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px"></td>
                            <td align="right" style="font-weight:bold;font-size:12px">&nbsp;</td>
                        </tr>
                        <?php
						if($keringanan>0){
						?>
                        <tr>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px">Keringanan :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($keringanan,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <?php
						}
						?>
                        
                        <?php
						if($titipan>0){
						?>
                        <tr>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px">Titipan :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($titipan,0,",","."); ?>&nbsp;</td>
                        </tr>
                        <?php
						}
						?>
                       <tr>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px">Total Bayar :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($totBAYAR,0,",",".");?>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="25" align="right" style="font-weight:bold; font-size:12px"><?php echo $txtSUM; ?> :&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px; border-top:1px solid;"><?php echo number_format($nSUM,0,",",".");?>&nbsp;</td>
                        </tr>
                    </table>
              </td>
            </tr>
            <tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr class="kwi">
            	<td colspan="2">
                	<table width="1176">
                    <tr>
                    <td width="720" style="vertical-align:top;">
                	<table width="87%" border="0" cellpadding="0" cellspacing="0"> 
                        <tr>
                            <td width="3%" align="left" style="font-weight:bold;font-size:10px;">&nbsp;</td>
                            <td width="8%" align="center" style="font-weight:bold;font-size:10px;">No.</td>
                            <td width="18%" align="center" style="font-weight:bold;font-size:10px;">Tgl Bayar</td>
                            <td width="14%" align="center" style="font-weight:bold;font-size:10px;">No Kwitansi</td>
                            <td width="15%" align="right" style="font-weight:bold;font-size:10px;">Pembayaran&nbsp;</td>
                            <td width="21%" align="center" style="font-weight:bold;font-size:10px;">Kasir</td>
                            <td width="21%" align="center" style="font-weight:bold;font-size:10px;">&nbsp;</td>
                            
                        </tr>
                        <?php
						$sPembayaran="SELECT * FROM
										(select 
										concat(date_format(b.tgl,'%d-%m-%Y'),' ',date_format(b.tgl_act,'%H:%i')) as tgl,
										b.no_kwitansi as nokwi,
										pg.nama as kasir,
										if(b.tipe=1,b.titipan,b.nilai) as nominal
										from 
										(select * from b_bayar where 0=0 $jenisKunj) b 
										inner join b_ms_pegawai pg on pg.id=b.user_act
										where b.kunjungan_id='$idKunj'
										UNION
										select
										date_format(aku.TGL_BAYAR,'%d-%m-%Y %H:%i') as tgl,
										aku.NO_BAYAR as nokwi,
										au.username as kasir,
										aku.TOTAL_HARGA as nominal
										from
										$dbapotek.a_kredit_utang aku
										inner join $dbapotek.a_user au on au.kode_user=aku.USER_ID
										INNER JOIN b_pelayanan p ON p.id=aku.NO_PELAYANAN
										where p.kunjungan_id='$idKunj' and aku.CARA_BAYAR=2 $jenisKunj) as tbl ORDER BY tgl";
						$qPembayaran=mysql_query($sPembayaran);
						$no=0;
						while($rwPembayaran=mysql_fetch_array($qPembayaran)){
							$no++;
						?>
                        <tr>
                            <td align="left" style="font-size:12px;font-size:10px;">&nbsp;</td>
                            <td width="8%" align="center" style="font-size:12px;font-size:10px;"><?php echo $no; ?>.</td>
                            <td width="18%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['tgl']; ?></td>
                            <td width="14%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['nokwi']; ?></td>
                            <td align="right" style="font-size:12px;font-size:10px;"><?php echo number_format($rwPembayaran['nominal'],0,",","."); ?>&nbsp;</td>
                            <td width="21%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['kasir']; ?></td>
                            <td width="21%" align="right" style="font-size:12px;font-size:10px;">&nbsp;</td>
                            
                        </tr>
                        <?php
						}
						?>
                    </table>
              </td>
              <td width="444" align="center" style="font-weight:bold; vertical-align:top">Sidoarjo, <?php echo gmdate('d-m-Y',mktime(date('H')+7));?><br/>
                    Yang Mencetak,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>( <?php echo $rwUsr['nama']?> )
              </td>
            </tr>
            </table>
            </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="trTombol">
                <td colspan="2" class="noline" align="center">
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
                    <input id="btnExpExcl" type="button" value="Export --> Excell" onClick="window.open('RincianTindakanKSOExcell.php?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&idUser=<?php echo $idUser; ?>&inap=<?php echo $inap; ?>&tipe=<?php echo $tipe; ?>&for=<?php echo $for; ?>');"/>
                    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
        </table>
        <script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak Rician Tagihan Pembayaran ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
        </script>
    </body>
</html>
<?php 
mysql_close($konek);
?>