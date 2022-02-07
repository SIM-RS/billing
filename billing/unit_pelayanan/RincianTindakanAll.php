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

$qwe="SELECT t.id FROM b_tindakan t WHERE t.biaya_pasien > 0 AND t.kunjungan_id = '".$idKunj."';";
$rsQwe=mysql_query($qwe);
$cekIurKRS=0;
if(mysql_num_rows($rsQwe)>0){
	$cekIurKRS=1;
}
//echo "CEK".$cekIurKRS;

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


/* =========================== BPJS ============================= */

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
$isJR=0;
$isUMUM=0;
$isKSO=0;
$stNilai_Jaminan="Nilai Jaminan";
while ($rwKso=mysql_fetch_array($qKso)){
	$idKSOnew=$rwKso['kso_id'];
	$status .=$rwKso['nama'].", ";
	//if ($rwKso['kso_id']==6){
	if (strpos(",,".$idKsoBPJS.",",",".$rwKso['kso_id'].",")>0){
		$isBPJS=1;
	}
	
	//if ($rwKso['kso_id']==9){
	if (strpos(",,".$idKsoJR.",",",".$rwKso['kso_id'].",")>0){
		$isJR=1;
		$stNilai_Jaminan="Plafon Jaminan";
	}
	
	//if ($rwKso['kso_id']==1){
	if ($rwKso['kso_id']==$idKsoUmum){
		$isUMUM=1;
	}
	
	//if ($rwKso['kso_id']<>1 && $rwKso['kso_id']<>6){
	if (($rwKso['kso_id']<>$idKsoUmum) && (strpos(",,".$idKsoBPJS.",",",".$rwKso['kso_id'].",")<=0)){
		$isKSO=1;
	}
}


$status=substr($status,0,strlen($status)-2);
if ($isBPJS==1) $status ="<b> [ ".$kodeGrouper." ]</b>";

if ($tipe=="2"){
	$fJenisKunjungan="";
	$fJenisKunjungan2="";	
}elseif ($tipe=="1"){
	$fJenisKunjungan="AND p.jenis_kunjungan=3";
	$fJenisKunjungan2="AND b.jenis_kunjungan=3";	
}elseif ($tipe=="0"){
	$fJenisKunjungan="AND p.jenis_kunjungan<>3";
	$fJenisKunjungan2="AND b.jenis_kunjungan<>3";
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
	//echo $sHakKelas."<br>";
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
	//echo $sKelasTertinggi."<br>";
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
		//echo $sTglNaikKelas."<br>";
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
				AND mk.tipe=2
				AND kso.id=6
				$fJenisKunjungan
				UNION
				SELECT  
				p.id
				FROM b_pelayanan p
				INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
				INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
				INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
				INNER JOIN b_ms_kelas mk ON mk.id=tk.kelas_id
				WHERE 
				p.kunjungan_id='$idKunj'
				AND kso.id=6
				AND mk.tipe=2
				$fJenisKunjungan) AS tblhakkelas LIMIT 1";
	//echo $sVIP."<br>";
	$qVIP=mysql_query($sVIP);
	
	$lbl_biaya_total="Nilai InaCBG's Kelas ".$KelasTertinggi;
	
	if(mysql_num_rows($qVIP)>0){
		$isNaikKelas=1;
		$isVIP=1;
		$lbl_biaya_total="Biaya Naik Kelas BPJS";
	}else{
		$sVIP="SELECT * FROM (
					SELECT  
					p.id
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
					INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
					INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
					INNER JOIN b_ms_kelas mk ON mk.id=t.kelas_id
					WHERE p.kunjungan_id='$idKunj' 
					AND p.unit_id='$idPavilyunHCU'
					AND kso.id=6
					$fJenisKunjungan
					UNION
					SELECT  
					p.id
					FROM b_pelayanan p
					INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
					INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
					INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
					INNER JOIN b_ms_kelas mk ON mk.id=tk.kelas_id
					WHERE 
					p.kunjungan_id='$idKunj'
					AND kso.id=6
					AND p.unit_id='$idPavilyunHCU'
					$fJenisKunjungan) AS tblhakkelas LIMIT 1";
		$qVIP=mysql_query($sVIP);
		if(mysql_num_rows($qVIP)>0){
			$isNaikKelas=1;
			$isVIP=1;
			$lbl_biaya_total="Biaya Naik Kelas BPJS";
		}
	}
	
	if($isVIP==1){		
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
/* =========================== END BPJS ========================== */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/print.css" />
        <title>.: Rincian Tagihan Pasien :.</title>
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
                    Rincian Tagihan Pasien
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
									t.id as urutan
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									UNION
									SELECT 
									DISTINCT 
									kso.id,
									kso.nama,
									tk.id as urutan
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
									WHERE p.kunjungan_id='$idKunj') AS tblkso GROUP BY id ORDER BY urutan";
                        }elseif ($tipe=="1"){
                        	$sKSO="SELECT id,nama FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama 
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan=3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									UNION
									SELECT 
									DISTINCT 
									kso.id,
									kso.nama 
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
									WHERE p.kunjungan_id='$idKunj') AS tblkso GROUP BY id ORDER BY nama";
                        }elseif ($tipe=="0"){
                        	$sKSO="SELECT id,nama FROM (SELECT 
									DISTINCT 
									kso.id,
									kso.nama 
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan<>3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									) AS tblkso GROUP BY id ORDER BY nama";
                        }
						$qKSO=mysql_query($sKSO);
						
						$totBiaya=0;
						$totBiayaKSO=0;
						$totNilaiJaminan=0;
						$totBebanPasien=0;
						
						$totBiaya_umum=0;
						
						while($rwKSO=mysql_fetch_array($qKSO)){
						?>
						<tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:0px;font-size:12px;font-weight:bold"><?php echo $rwKSO['nama']?></td>
                        </tr>
						
                        <?php
                        //=====tipe=2-->RJ+RI, tipe=1-->RI, tipe=0-->RJ======
						if ($tipe=="2"){
                        	$sUnit="SELECT * FROM (SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									WHERE p.kunjungan_id='$idKunj' 
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									AND t.kso_id='".$rwKSO['id']."' 
									UNION
									SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND tk.kso_id='".$rwKSO['id']."'
									UNION
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
                        	$sUnit="SELECT * FROM (SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan=3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									AND t.kso_id='".$rwKSO['id']."'
									UNION
									SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_unit mu ON mu.id=p.unit_id
									WHERE p.kunjungan_id='$idKunj'
									AND tk.kso_id='".$rwKSO['id']."'
									UNION
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
                        	$sUnit="SELECT * FROM (SELECT 
									DISTINCT 
									p.id,
									mu.nama nmUnit,
									mu.id idUnit,
									mu.inap 
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									WHERE p.kunjungan_id='$idKunj' 
									AND p.jenis_kunjungan<>3
									/*AND mu.kategori<>5 
									AND p.unit_id<>$idUnitAmbulan 
									AND p.unit_id<>$idUnitJenazah*/
									AND t.kso_id='".$rwKSO['id']."'
									UNION
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
                        //echo $sUnit."<br>";
                        $qUnit=mysql_query($sUnit);
						
						
						$subBiaya=0;
						$subBiayaKSO=0;
						$subNilaiJaminan=0;
						$subBebanPasien=0;
						$ObtDijaminBPJS = 0;
						
                        while($rwUnit=mysql_fetch_array($qUnit)) {
						
							$subTotal=0;
							$subTotalJaminan=0;	
						?>
                        <tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:25px;font-size:12px; font-weight:bold"><?php echo $rwUnit['nmUnit']?></td>
                        </tr>
                            <?php
							if ($rwUnit["inap"]==1){
								$sKmr="SELECT 
								tk.tgl_in as tgl_masuk,
								tk.id,
								mk.id idKmr,
								mk.kode kdKmr,
								mk.nama nmKmr, 
								mKls.nama nmKls,
								if(hk.id=1,'-',hk.nama) as hakkelas, 
								DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in,
					 
								IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip), 
								IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip)) biaya,
								 
								IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso, 
								IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_kso) biaya_kso,
								 
								IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_pasien, 
								IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*tk.beban_pasien) biaya_px,
								
								tk.bayar,tk.bayar_kso, 
								
								IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)),
								IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))) cHari,
								
								mKls.tipe AS kelas_tipe,
								mKls.level AS kelas_level,
								hk.level AS hakkelas_level,
								tk.is_paviliun
								
								FROM b_tindakan_kamar tk 
								INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id 
								LEFT JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
								LEFT JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id 
								INNER JOIN b_ms_kso kso ON tk.kso_id=kso.id
								LEFT JOIN b_ms_kelas hk ON hk.id=tk.kso_kelas_id 
								WHERE kunjungan_id='$idKunj' 
								AND p.id='".$rwUnit['id']."' 
								AND tk.kso_id='".$rwKSO['id']."'
								AND tk.aktif=1
								ORDER BY tk.tgl_in";
								//echo $sKmr."<br><br>";
								$qKmr=mysql_query($sKmr);
								while($rwKmr=mysql_fetch_array($qKmr)) {
									
									$nBiayaJaminanKamar=$rwKmr['biaya_kso'];
									$txtKetKamar="";
									//if($rwKSO['id']==6){
									if (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")>0){
										$nBiayaJaminanKamar=0;
										
										if(($rwKmr['hakkelas_level']>=$rwKmr['kelas_level']) || ($isVIP_UMUM==1 && $rwKmr['kelas_tipe']=='1') || ($rwKmr['kelas_tipe']=='1' && $rwKmr['is_paviliun']=='0') || ($isNaikKelas==0 && $rwKmr['kelas_tipe']=='1'))
											$txtKetKamar="Paket BPJS";
									}
									//else if($rwKSO['id']==9){
									else if (strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")>0){
										//$nBiayaJaminanKamar=0;	//Jaminan JASA RAHARJA
										$subBiayaKSO+=$rwKmr['biaya'];
									}
									else{
										//if($rwKSO['id']==1){
										if($rwKSO['id']==$idKsoUmum){
											$nBiayaJaminanKamar=0;
											$totBiaya_umum+=$rwKmr['biaya'];	
										}
										else{
											$subBiayaKSO+=$rwKmr['biaya'];	
										}
									}
                            ?>
                        <tr>
                          <td align="left" style="font-size:12px">&nbsp;</td>
                            <td align="left" style="padding-left:75px;font-size:12px"><?php echo "Kamar"; ?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwKmr['hakkelas']?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwKmr['nmKls']?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwKmr['tgl_in']?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwKmr['cHari']?></td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($rwKmr['biaya'],0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($nBiayaJaminanKamar,0,",",".");?>&nbsp;</td>
                            <td align="center" style="font-size:12px;">&nbsp;</td>
                        </tr>
                                <?php 
									$subBiaya+=$rwKmr['biaya'];
									$subNilaiJaminan+=$nBiayaJaminanKamar;
									
									$subTotal+=$rwKmr['biaya'];
									$subTotalJaminan+=$nBiayaJaminanKamar;
									
									//if($rwKSO['id']!=1 && $rwKSO['id']!=6 && $rwKSO['id']!=9){
									if($rwKSO['id']!=$idKsoUmum && (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")<=0) && (strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")<=0)){
										$nBebanPasienKamar=$rwKmr['biaya']-$nBiayaJaminanKamar;
										$subBebanPasien+=$nBebanPasienKamar;
									}
								}
							}
					$umum_stlh_krs = " ";
					$umum_stlh_krs2 = " ";	
					if($cekIurKRS==1){
						$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
						$umum_stlh_krs2 = " AND t._krs<>1 ";
					}else if($isNaikKelas==1){
						$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
						$umum_stlh_krs2 = " AND t._krs<>1 ";
					}else if($isVIP==1){
						$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
						$umum_stlh_krs2 = " AND t._krs<>1 ";
					} 
						
                            $sKonsul="SELECT user_id,ppds_id,IFNULL(b_ms_pegawai.nama,'-') konsul,IFNULL(mp.nama,'-') ppds 
							FROM b_tindakan 
							LEFT JOIN b_ms_pegawai ON b_tindakan.user_id=b_ms_pegawai.id 
							LEFT JOIN b_ms_pegawai mp ON b_tindakan.ppds_id=mp.id 
							WHERE b_tindakan.pelayanan_id='".$rwUnit['id']."' 
							AND b_tindakan.kso_id='".$rwKSO['id']."' $umum_stlh_krs
							GROUP BY b_tindakan.user_id,b_tindakan.ppds_id";
                            //echo $sKonsul."<br>";
                            $qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)){
								$dokter=$rwKonsul['konsul'].(($rwKonsul['ppds']=="-")?"":" / ".$rwKonsul['ppds']);
							?>
                        <tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:50px;font-size:12px"><?php echo $dokter;?></td>
                        </tr>
                                <?php
								if ($rwUnit["inap"]==1){
									$sTind="SELECT 
											t.id,
											t.tgl_act,
											DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,
											mt.nama nmTind, 
											t.kso_id, 
											kso.nama namaKso, 
											SUM((t.biaya)*t.qty) AS biaya,
											SUM(t.biaya_kso*t.qty) AS biaya_kso,
											SUM(t.biaya_pasien*t.qty) AS iurbiaya,
											SUM(t.bayar) bayar,
											SUM(t.bayar_kso) bayarKSO,
											SUM(t.qty) cTind,
											k.nama AS kelas,
											if(hk.id=1,'-',hk.nama) AS hakkelas,
											k.level AS kelas_level,
											k.tipe AS kelas_tipe,
											hk.level AS hakkelas_level,
											t.is_paviliun 
											FROM b_tindakan t 
											INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
											INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
											INNER JOIN b_ms_kso kso ON t.kso_id=kso.id
											LEFT JOIN b_ms_kelas k ON k.id=t.kelas_id
											INNER JOIN b_ms_kelas hk ON hk.id=t.kso_kelas_id
											WHERE 
											t.kunjungan_id=".$idKunj." 
											AND t.pelayanan_id=".$rwUnit['id']." 
											AND user_id='".$rwKonsul['user_id']."'
											AND ppds_id='".$rwKonsul['ppds_id']."'
											AND t.kso_id='".$rwKSO['id']."' $umum_stlh_krs2
											GROUP BY mt.id 
											ORDER BY t.id";
								}
								else{
									$sTind="SELECT 
											t.id,
											t.tgl_act,
											DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl,
											mt.nama nmTind, 
											t.kso_id, 
											kso.nama namaKso, 
											((t.biaya)*t.qty) AS biaya,
											(t.biaya_kso*t.qty) AS biaya_kso,
											(t.biaya_pasien*t.qty) AS iurbiaya,
											(t.bayar) bayar,
											(t.bayar_kso) bayarKSO,
											(t.qty) cTind,
											k.nama AS kelas,
											if(hk.id=1,'-',hk.nama) AS hakkelas,
											k.level AS kelas_level,
											k.tipe AS kelas_tipe,
											hk.level AS hakkelas_level,
											t.is_paviliun 
											FROM b_tindakan t 
											INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
											INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
											INNER JOIN b_ms_kso kso ON t.kso_id=kso.id
											LEFT JOIN b_ms_kelas k ON k.id=t.kelas_id
											INNER JOIN b_ms_kelas hk ON hk.id=t.kso_kelas_id
											WHERE 
											t.kunjungan_id=".$idKunj." 
											AND t.pelayanan_id=".$rwUnit['id']." 
											AND user_id='".$rwKonsul['user_id']."'
											AND ppds_id='".$rwKonsul['ppds_id']."'
											AND t.kso_id='".$rwKSO['id']."' $umum_stlh_krs2 
											ORDER BY t.id";
								}
                                //echo $sTind."<br>";
                                $qTind=mysql_query($sTind);
                                while($rwTind=mysql_fetch_array($qTind)) {
                                	$sqlPegAnastesi="SELECT mp.nip,mp.nama FROM b_tindakan_dokter_anastesi bta INNER JOIN b_ms_pegawai mp ON bta.dokter_id=mp.id WHERE bta.tindakan_id=".$rwTind["id"];
									$rsPegAnastesi=mysql_query($sqlPegAnastesi);
									$dokAnastesi="";
									while ($rwPegAnastesi=mysql_fetch_array($rsPegAnastesi)){
										$dokAnastesi .=$rwPegAnastesi["nama"].", ";
									}
									if ($dokAnastesi!="") $dokAnastesi=" - (".substr($dokAnastesi,0,strlen($dokAnastesi)-2).")"; 
									
									
									$nBiayaJaminanTindakan=$rwTind['biaya_kso'];
									$txtKetTindakan="";
									//if($rwKSO['id']==6){
									if (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")>0){
										$nBiayaJaminanTindakan=0;
										
										if(($rwTind['hakkelas_level']>=$rwTind['kelas_level']) || ($isVIP_UMUM==1 && $rwTind['kelas_tipe']=='1') || ($rwTind['kelas_tipe']=='1' && $rwTind['is_paviliun']=='0') || ($isNaikKelas==0 && $rwTind['kelas_tipe']=='1'))
											$txtKetTindakan="Paket BPJS";
									}
									//else if($rwKSO['id']==9){
									else if(strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")>0){
										//$nBiayaJaminanTindakan=0;		//Jaminan JASA RAHARJA
										$subBiayaKSO+=$rwTind['biaya'];	
									}
									else{
										//if($rwKSO['id']==1){
										if($rwKSO['id']==$idKsoUmum){
											$nBiayaJaminanTindakan=0;
											$totBiaya_umum+=$rwTind['biaya'];	
										}
										else{
											$subBiayaKSO+=$rwTind['biaya'];	
										}
									}
								?>
                        <tr>
                          <td align="left" >&nbsp;</td>
                            <td align="left" style="padding-left:75px"><?php echo strtolower($rwTind['nmTind']).$dokAnastesi;?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwTind['hakkelas'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwTind['kelas'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwTind['tgl'];?></td>
                            <td align="center" style="font-size:12px;"><?php echo $rwTind['cTind'];?></td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($rwTind['biaya'],0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($nBiayaJaminanTindakan,0,",",".");?>&nbsp;</td>
                            <td align="center" style="font-size:12px;">&nbsp;</td>
                        </tr>
                              	<?php
									$subBiaya+=$rwTind['biaya'];
									$subNilaiJaminan+=$nBiayaJaminanTindakan;
									
									$subTotal+=$rwTind['biaya'];
									$subTotalJaminan+=$nBiayaJaminanTindakan;
									
									//if($rwKSO['id']!=1 && $rwKSO['id']!=6 && $rwKSO['id']!=9){
									if($rwKSO['id']!=$idKsoUmum && (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")<=0) && (strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")<=0)){
										$nBebanPasienTindakan=$rwTind['biaya']-$nBiayaJaminanTindakan;
										$subBebanPasien+=$nBebanPasienTindakan;
									}
                                }
                                ?>
                                <?php
                            }
							?>
                            
                        <?php
							$fCaraBayar="AND ap.CARA_BAYAR=2";
							
                        	$sKonsul="SELECT 
							DISTINCT ap.NO_PENJUALAN,ap.DOKTER,au.UNIT_NAME, ap.UNIT_ID
							FROM $dbapotek.a_penjualan ap
							inner join b_pelayanan p on p.id=ap.NO_KUNJUNGAN 
							inner join b_ms_kso kso on kso.id=p.kso_id
							inner join $dbapotek.a_unit au on au.UNIT_ID=ap.UNIT_ID  
							WHERE 
							ap.NO_PASIEN='".$rw['no_rm']."' 
							AND ap.NO_KUNJUNGAN='".$rwUnit['id']."'
							AND kso.id='".$rwKSO['id']."'
							$fCaraBayar";
							//echo $sKonsul."<br>";
							/*
							$sKonsul2="SELECT DISTINCT ap.NO_PENJUALAN,ap.DOKTER,ap.CARA_BAYAR,ac.nama FROM $dbapotek.a_penjualan ap inner join $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id WHERE ap.NO_PASIEN='".$rw['no_rm']."' AND ap.NO_KUNJUNGAN='".$rwUnit['id']."' AND ap.CARA_BAYAR=2";*/
                            //echo $sKonsul.";<br>";
                            $tObat=0;
							$tObatJamin=0;
							$qKonsul=mysql_query($sKonsul);
                            while($rwKonsul=mysql_fetch_array($qKonsul)) {
                        ?>
                        <tr>
                        	<td></td>
                            <td colspan="8" align="left" style="padding-left:50px;font-size:12px"><?php echo $rwKonsul['DOKTER']." - Nota Penjualan ".$rwKonsul['NO_PENJUALAN']." - ".$rwKonsul['UNIT_NAME'];?></td>
                        </tr>
						<?php
						
						$sObat="SELECT *, 
									  IF(RETUR=0,'',CONCAT('(',RETUR,')')) AS nretur
									  FROM 
									  (SELECT
									  pn.OBAT_ID,
									  ao.OBAT_NAMA,
									  ap.DOKTER,
									  ap.NO_PENJUALAN,
									  ap.NO_PASIEN,
									  ac.id AS CARA_BAYAR_ID,
									  ac.nama AS CARA_BAYAR,
									  SUM(ap.QTY_JUAL) QTY_JUAL, 
									  SUM(ap.QTY_RETUR) QTY_RETUR,
									  /* SUM(ap.QTY_JUAL - ap.QTY_RETUR) QTY, */
									  SUM(ap.QTY_JUAL) QTY,
									  DATE_FORMAT(ap.TGL, '%d-%m-%Y') AS TGL,
									  am.NAMA KSO, 
									  /* SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL, */
									  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN) AS SUBTOTAL,
									  /* IF(ap.DIJAMIN=1,SUM(IF(ap.CARA_BAYAR=2,((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN),0)),'0') AS DIJAMIN, */
									  IF(ap.DIJAMIN=1,SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0') AS DIJAMIN,
									  SUM(ap.QTY_RETUR * ap.HARGA_SATUAN) AS RETUR,
									  k.nama AS kelas,
									  if(hk.id=1,'-',hk.nama) AS hakkelas,
									  k.level AS kelas_level,
									  k.tipe AS kelas_tipe,
									  hk.level AS hakkelas_level,
									  ap.TGL_ACT,
									  b_pelayanan.is_paviliun,
									  ap.KRONIS,
									  ap.DIJAMIN AS STAT_DIJAMIN, ap.id AS idpenjualan, ap.UNIT_ID
									FROM
									  (SELECT 
										* 
									  FROM
										$dbapotek.a_penjualan 
									  WHERE NO_KUNJUNGAN = '".$rwUnit['id']."' AND NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."' AND UNIT_ID='".$rwKonsul['UNIT_ID']."' AND DOKTER='".$rwKonsul['DOKTER']."') AS ap 
									  INNER JOIN $dbapotek.a_penerimaan pn 
										ON ap.PENERIMAAN_ID = pn.ID 
									  INNER JOIN $dbapotek.a_obat ao 
										ON pn.OBAT_ID = ao.OBAT_ID 
									  INNER JOIN $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
									  LEFT JOIN $dbapotek.a_mitra am ON am.IDMITRA=ap.KSO_ID
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
						//if ($rwKonsul['NO_PENJUALAN']=="015277"){
						//	echo $sObat."<br>";
						//}
						$qObat=mysql_query($sObat);
						
						while($rwObat=mysql_fetch_array($qObat)){
							
							//$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' $fJenisKunjungan2 ORDER BY b.id DESC";
							$queByr = "SELECT ku.TGL_BAYAR FROM $dbapotek.a_kredit_utang ku WHERE ku.FK_NO_PENJUALAN='".$rwObat['NO_PENJUALAN']."' AND ku.NORM='".$rwObat['NO_PASIEN']."'";
							//if ($rwKonsul['NO_PENJUALAN']=="083478"){
							//	echo $queByr."<br/><br/>";
							//}
							$dByr = mysql_fetch_array(mysql_query($queByr));
							
							//awal query cek retur
							/*$sRetur="SELECT SUM(a.QTY_RETUR) QTY, SUM(a.QTY_RETUR * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) AS DIJAMIN,
								b.TGL_BAYAR, c.tgl_retur, c.qty_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
								FROM $dbapotek.a_penjualan a
								LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
								LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
								WHERE a.ID = '".$rwObat['idpenjualan']."' ";*/
							$sRetur="SELECT
									  /*SUM(a.QTY_RETUR)    QTY,
									  SUM(a.QTY_RETUR * a.HARGA_SATUAN) AS SUBTOTAL,
									  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) AS DIJAMIN,*/
									  b.TGL_BAYAR,
									  c.tgl_retur,
									  SUM(c.qty_retur)    QTY,
									  SUM(c.qty_retur * a.HARGA_SATUAN) AS SUBTOTAL,
									  SUM(IF(a.CARA_BAYAR=2,(c.qty_retur * a.HARGA_SATUAN),0)) AS DIJAMIN,
									  DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek,
									  IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
									FROM $dbapotek.a_penjualan a
									  INNER JOIN $dbapotek.a_penerimaan ap
										ON a.PENERIMAAN_ID = ap.ID
									  INNER JOIN $dbapotek.a_return_penjualan c
										ON a.ID = c.idpenjualan
									  LEFT JOIN $dbapotek.a_kredit_utang b
										ON (a.NO_PENJUALAN = b.FK_NO_PENJUALAN
										  AND a.UNIT_ID = b.UNIT_ID
										  AND a.NO_KUNJUNGAN = b.NO_PELAYANAN
										  AND a.NO_PASIEN = b.NORM)
									WHERE a.NO_KUNJUNGAN='".$rwUnit['id']."' 
										AND a.NO_PENJUALAN='".$rwKonsul['NO_PENJUALAN']."' 
										AND a.UNIT_ID='".$rwKonsul['UNIT_ID']."'
										AND ap.OBAT_ID = '".$rwObat['OBAT_ID']."'";
							$qRetur=mysql_query($sRetur);
							$rwRetur=mysql_fetch_array($qRetur);
							//if ($rwKonsul['NO_PENJUALAN']=="083478"){
							//	echo $sRetur."<br/>";
								//echo "qty_obat=".$rwObat['QTY'].", qty_retur=".$rwRetur['QTY'];
							//}
								if($rwRetur['DiffDate']==0){
									$subtotObat=$rwObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
									$dijaminObt=$rwObat['DIJAMIN']-$rwRetur['DIJAMIN'];
									$qtyObt=$rwObat['QTY']-$rwRetur['QTY'];
									$rrr=0;
								}else{
									$subtotObat=$rwObat['SUBTOTAL'];
									$dijaminObt=$rwObat['DIJAMIN'];
									$qtyObt=$rwObat['QTY'];
									$rrr=1;
								}
							//akhir query cek retur
							
							//echo "Nma".$rwObat['OBAT_NAMA']."SUbTot--".$subtotObat."||".$rrr."--Akhr";
							
							//$nBiayaJaminanObat=$rwObat['DIJAMIN'];
							$nBiayaJaminanObat=$dijaminObt;
							
							//$bObat=$rwObat['SUBTOTAL'];
							$bObat=$subtotObat;
							
							$txtKetObat="";
							if($rwObat['KRONIS']=='2'){ // OBAT PAKET
								$bObat=0;
								$nBiayaJaminanObat=0;
								$txtKetObat="PAKET";	
							}
							
							if($rwKSO['id']!=1){
								if($rwObat['STAT_DIJAMIN']=='0'){ // KET  OBAT TIDAK DIJAMIN
									$txtKetObat="Tidak Dijamin";
									//if($rwKSO['id']==6){
									if (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")>0){
										$ObtDijaminBPJS+=$bObat;
									}
									
								}
							}
							//if ($rwKonsul['NO_PENJUALAN']=="077585"){
							//echo "obattdkdijamin=".$ObtDijaminBPJS."<br>";
							//}
							//if($rwKSO['id']==6){
							if (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")>0){
								$nBiayaJaminanObat=0;
								
								/*
								if(($rwObat['hakkelas_level']>=$rwObat['kelas_level']) || ($isVIP_UMUM==1 && $rwObat['kelas_tipe']=='1') || ($rwObat['kelas_tipe']=='1' && $rwObat['is_paviliun']=='0') || ($isNaikKelas==0 && $rwObat['kelas_tipe']=='1'))
									$txtKetObat="Paket BPJS";
								*/
							}
							//else if($rwKSO['id']==9){
							else if(strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")>0){
								//$nBiayaJaminanObat=0;		//Jaminan JASA RAHARJA
								$subBiayaKSO+=$bObat;	
							}
							else{
								//if($rwKSO['id']==1){
								if($rwKSO['id']==$idKsoUmum){
									$nBiayaJaminanObat=0;
									$totBiaya_umum+=$bObat;	
								}
								else{
									$subBiayaKSO+=$bObat;		
								}
							}
						?>   
                        <tr>
                          <td align="left">&nbsp;</td>
                            <td align="left" style="padding-left:75px"><?php echo $rwObat['OBAT_NAMA'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwObat['hakkelas'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwObat['kelas'];?></td>
                            <td align="center" style="font-size:12px"><?php echo $rwObat['TGL'];?></td>
                            <td align="center" style="font-size:12px;"><?php echo $qtyObt;//$rwObat['QTY'];?></td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($bObat,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-size:12px;"><?php echo number_format($nBiayaJaminanObat,0,",",".");?>&nbsp;</td>
                            <td align="center" style="font-size:12px;"><?php echo $txtKetObat; ?></td>
                        </tr>
                        <?php
							$subBiaya+=$bObat;
							$subNilaiJaminan+=$nBiayaJaminanObat;
							
							$subTotal+=$bObat;
							$subTotalJaminan+=$nBiayaJaminanObat;
							
							//if($rwKSO['id']!=1 && $rwKSO['id']!=6 && $rwKSO['id']!=9){
							if($rwKSO['id']!=$idKsoUmum && (strpos(",,".$idKsoBPJS.",",",".$rwKSO['id'].",")<=0) && (strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")<=0)){
								$nBebanPasienObat+=$bObat-$nBiayaJaminanObat;
								$subBebanPasien+=$nBebanPasienObat;
							}
							
							}
						}
						?>
                        <tr id="trSubTotal" style="display:table-row; vertical-align:bottom" height="20">
                        	<td colspan="5">&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px; border-top:solid #000000 1px;">Subtotal&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px;"><?php echo number_format($subTotal,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; border-top:solid #000000 1px;font-size:12px;"><?php echo number_format($subTotalJaminan,0,",",".");?>&nbsp;</td>
                            <td align="right" style="font-weight:bold; font-size:12px;">&nbsp;</td>
                        </tr>
                            <?php
                        } // END UNIT
						?>
                        <tr>
                        	<td>&nbsp;</td>
                        </tr>
                        <tr id="trSubTotal" style="display:table-row; vertical-align:bottom" height="20">
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
							$totBiayaKSO+=$subBiayaKSO;
								//if($rwKSO['id']==9){
								if(strpos(",,".$idKsoJR.",",",".$rwKSO['id'].",")>0){
									$jaminJRH="SELECT * FROM b_jaminan_kso WHERE kunjungan_id='".$idKunj."'";
									$jaminJRHx=mysql_query($jaminJRH);
						
									if (mysql_num_rows($jaminJRHx)>0){
										$jaminJRHrow=mysql_fetch_array($jaminJRHx);
										if($jaminJRHrow['biaya_kso'] > 0){
											$totNilaiJaminan=$jaminJRHrow['biaya_kso'];
										}else{
											$totNilaiJaminan+=$subNilaiJaminan;
										}
									}else{
									$totNilaiJaminan+=$subNilaiJaminan;
									}
								}else{
									$totNilaiJaminan+=$subNilaiJaminan;
								}
							$totBebanPasien+=$subBebanPasien;
						} // END KSO
						?>
                        
						<?php
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
										$fJenisKunjungan2="";
									}elseif ($tipe=="1"){
										$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=3";
										$fJenisKunjungan2="AND b.jenis_kunjungan=3";
									}elseif ($tipe=="0"){
										$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan<>3";
										$fJenisKunjungan2="AND b.jenis_kunjungan<>3";
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
											  (ap.QTY_JUAL * ap.HARGA_SATUAN) AS SUBTOTAL, ap.ID AS idpenjualan 
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
									while($rwPavObatU=mysql_fetch_array($qPavObatU)){
									
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' $fJenisKunjungan2 ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
										$sRetur="SELECT /*SUM(a.QTY_RETUR) QTY, SUM(a.QTY_RETUR * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) AS DIJAMIN,*/
											b.TGL_BAYAR, c.tgl_retur, SUM(c.qty_retur) QTY, SUM(c.qty_retur * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(c.qty_retur * a.HARGA_SATUAN),0)) AS DIJAMIN, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
											FROM $dbapotek.a_penjualan a
											LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
											LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
											WHERE a.ID = '".$rwPavObatU['idpenjualan']."' ";
										//if ($rwPavObatU["idpenjualan"]=='14374578'){
										//echo $sRetur."<br/>";
										//}
										$qRetur=mysql_query($sRetur);
										$rwRetur=mysql_fetch_array($qRetur);
											if($rwRetur['DiffDate']==0){
												$subtotObat=$rwPavObatU['SUBTOTAL']-$rwRetur['SUBTOTAL'];
												//$dijaminObt=$rwPavObatU['DIJAMIN']-$rwRetur['DIJAMIN'];
												//$qtyObt=$rwPavObatU['QTY']-$rwRetur['QTY'];
												$rrr=0;
											}else{
												$subtotObat=$rwPavObatU['SUBTOTAL'];
												//$dijaminObt=$rwPavObatU['DIJAMIN'];
												//$qtyObt=$rwPavObatU['QTY'];
												$rrr=1;
											}
										//akhir query cek retur
									
									//$totBiayaPaviliun_BPJS_UMUM+=$rwPavObatU['SUBTOTAL'];
									$totBiayaPaviliun_BPJS_UMUM+=$subtotObat;

									}
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
												  /* SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL */
													(ap.QTY_JUAL * ap.HARGA_SATUAN) AS SUBTOTAL, ap.ID AS idpenjualan
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
												AND ap.CARA_BAYAR=2
												AND ap.KRONIS<>2";
										//echo $sRJRDObat;
										$qRJRDObat=mysql_query($sRJRDObat);
										while($rwRJRDObat=mysql_fetch_array($qRJRDObat)){
										
										$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' $fJenisKunjungan2 ORDER BY b.id DESC";
										//echo $queByr."<br/><br/>";
										$dByr = mysql_fetch_array(mysql_query($queByr));
							
										//awal query cek retur
										$sRetur="SELECT /*SUM(a.QTY_RETUR) QTY, SUM(a.QTY_RETUR * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) AS DIJAMIN,*/
											b.TGL_BAYAR, c.tgl_retur, SUM(c.qty_retur) QTY, SUM(c.qty_retur * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(c.qty_retur * a.HARGA_SATUAN),0)) AS DIJAMIN, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
											FROM $dbapotek.a_penjualan a
											LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
											LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
											WHERE a.ID = '".$rwRJRDObat['idpenjualan']."' ";
										//echo $sRetur."<br/>";
										$qRetur=mysql_query($sRetur);
										$rwRetur=mysql_fetch_array($qRetur);
											if($rwRetur['DiffDate']==0){
												$subtotObat=$rwRJRDObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
												//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
												//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
												$rrr=0;
											}else{
												$subtotObat=$rwRJRDObat['SUBTOTAL'];
												//$dijaminObt=$rwRJRDObat['DIJAMIN'];
												//$qtyObt=$rwRJRDObat['QTY'];
												$rrr=1;
											}
										//akhir query cek retur
										
										//$totBiayaRJRD_BPJS+=$rwRJRDObat['SUBTOTAL'];
										$totBiayaRJRD_BPJS+=$subtotObat;
										
										}
									}
									
									if ($tipe=="2"){
										$fJenisKunjungan="";
										$fJenisKunjungan2="";
									}elseif ($tipe=="1"){
										$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan=3";
										$fJenisKunjungan2="AND b.jenis_kunjungan=3";
									}elseif ($tipe=="0"){
										$fJenisKunjungan="AND b_pelayanan.jenis_kunjungan<>3";
										$fJenisKunjungan2="AND b.jenis_kunjungan<>3";
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
											  /* SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL */
												(ap.QTY_JUAL * ap.HARGA_SATUAN) AS SUBTOTAL, ap.ID AS idpenjualan
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
									while($rwPavObat=mysql_fetch_array($qPavObat)){
									
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' $fJenisKunjungan2 ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT /*SUM(a.QTY_RETUR) QTY, SUM(a.QTY_RETUR * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) AS DIJAMIN,*/
										b.TGL_BAYAR, c.tgl_retur, SUM(c.qty_retur) QTY, SUM(c.qty_retur * a.HARGA_SATUAN) AS SUBTOTAL, SUM(IF(a.CARA_BAYAR=2,(c.qty_retur * a.HARGA_SATUAN),0)) AS DIJAMIN, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.ID = '".$rwPavObat['idpenjualan']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
										if($rwRetur['DiffDate']==0){
											$subtotObat=$rwPavObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
											//$dijaminObt=$rwPavObat['DIJAMIN']-$rwRetur['DIJAMIN'];
											//$qtyObt=$rwPavObat['QTY']-$rwRetur['QTY'];
											$rrr=0;
										}else{
											$subtotObat=$rwPavObat['SUBTOTAL'];
											//$dijaminObt=$rwPavObat['DIJAMIN'];
											//$qtyObt=$rwPavObat['QTY'];
											$rrr=1;
										}
									//akhir query cek retur
									
									//$totBiayaPaviliun_BPJS+=$rwPavObat['SUBTOTAL'];
									$totBiayaPaviliun_BPJS+=$subtotObat;
									
									}
									
									$BPJS_biayanaikkelas=$totBiayaPaviliun_BPJS-$ObtDijaminBPJS;
									if($totBiayaPaviliun_BPJS>$BPJS_jaminan)
										$BPJS_iurbayar=$BPJS_biayanaikkelas - $BPJS_jaminan;
											
								}
							}
							
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
						
						/*
						$sBayarObat="SELECT SUM(BAYAR) AS BAYAR FROM (SELECT
									  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS BAYAR,
									  p.jenis_kunjungan
									FROM
									  $dbapotek.a_penjualan ap
									  INNER JOIN b_pelayanan p ON p.id=ap.NO_KUNJUNGAN
									  INNER JOIN $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
									  INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA=ap.KSO_ID
									  inner join b_ms_kso kso on kso.id=am.kso_id_billing
									  where 
									  kso.id=1
									  AND ap.CARA_BAYAR=1 
									  AND p.kunjungan_id='$idKunj' GROUP BY p.jenis_kunjungan) AS zxc WHERE 0=0 $jenisKunj";
						*/
						$sBayarObat="SELECT 
								SUM(aku.TOTAL_HARGA) AS BAYAR
								FROM $dbapotek.a_kredit_utang aku
								INNER JOIN b_pelayanan p ON p.id=aku.NO_PELAYANAN
								WHERE aku.IS_AKTIF=1 and p.kunjungan_id='$idKunj' and aku.CARA_BAYAR=2 $jenisKunj";
						$qBayarObat=mysql_query($sBayarObat);
						$rwBayarObat=mysql_fetch_array($qBayarObat);
						$totBAYAR+=$rwBayarObat['BAYAR'];
						
						$qReturObat="SELECT IFNULL(SUM(nilai),0) AS nretur 
									FROM (SELECT ap.NO_PENJUALAN,ap.NO_KUNJUNGAN,ap.TGL_BAYAR,ap.TGL_BAYAR_ACT,
									rp.no_retur,rp.balik_uang,rp.bayar,rp.nilai,rp.qty_retur,rp.tgl_retur 
									FROM $dbapotek.a_penjualan ap INNER JOIN $dbapotek.a_return_penjualan rp ON ap.ID=rp.idpenjualan
									INNER JOIN $dbbilling.b_pelayanan p ON ap.NO_KUNJUNGAN=p.id
									WHERE p.kunjungan_id='$idKunj' AND ap.QTY_RETUR>0 AND ap.CARA_BAYAR=2 $jenisKunj 
									AND ap.TGL_BAYAR_ACT<rp.tgl_retur) AS gab";
						$rsReturObat=mysql_query($qReturObat);
						$rwReturObat=mysql_fetch_array($rsReturObat);
						$nReturObat=$rwReturObat["nretur"];																		
						
						$sTitipan="select sum(titipan) as titipan from b_bayar where kunjungan_id='$idKunj' and tipe=1 $jenisKunj";
						$qTitipan=mysql_query($sTitipan);
						$rwTitipan=mysql_fetch_array($qTitipan);
						$titipan=$rwTitipan['titipan'];
						
						$sKeringanan="select sum(keringanan) as keringanan from b_bayar where kunjungan_id='$idKunj' $jenisKunj";
						$qKeringanan=mysql_query($sKeringanan);
						$rwKeringanan=mysql_fetch_array($qKeringanan);
						$keringanan=$rwKeringanan['keringanan'];
						
						$qReturBayar = "SELECT
										  DATE_FORMAT(r.tgl_return, '%d-%m-%Y %H:%i') AS tgl,
										  r.no_return nokwi,
										  r.nilai_retur nominal,
										  kso.nama status_penj,
										  peg.nama kasir
										FROM $dbbilling.b_return_pembayaran r
										  INNER JOIN $dbbilling.b_bayar b
											ON r.bayar_id = b.id
										  INNER JOIN keuangan.k_ms_user peg
											ON r.user_act = peg.id
										  INNER JOIN $dbbilling.b_ms_kso kso
											ON b.kso_id = kso.id
										WHERE b.kunjungan_id='$idKunj' $jenisKunj";
						//echo $qReturBayar."<br>";
										
						$qTotReturBayar="SELECT IFNULL(SUM(nominal),0) AS nilai FROM (".$qReturBayar.") AS gab";
						$rsTotReturBayar = mysql_query($qTotReturBayar);
						$rwTotReturBayar=mysql_fetch_array($rsTotReturBayar);
						$totReturBayar = $rwTotReturBayar["nilai"];
						//echo "totReturBayar=".$totReturBayar."<br>";
						
						$iurbayar_BPJS=0;
						if(($BPJS_biayanaikkelas+$totBiayaRJRD_BPJS)>$BPJS_jaminan) $iurbayar_BPJS=($BPJS_biayanaikkelas+$totBiayaRJRD_BPJS)-$BPJS_jaminan;
						
						$iurbayar_KSO=0;
						if($totBiayaKSO>$totNilaiJaminan) $iurbayar_KSO=$totBiayaKSO-$totNilaiJaminan;
						
						//$totIURBAYAR=$totBebanPasien+$BPJS_iurbayar;
						
						$total_tagihan_pasien=$totBiaya_umum+$totBiayaPaviliun_BPJS_UMUM+$iurbayar_BPJS+$iurbayar_KSO+$ObtDijaminBPJS;
						
						$SUM=$total_tagihan_pasien-$totBAYAR-$titipan-$keringanan+$nReturObat+$totReturBayar;
						
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
                    <tr class="kwi">
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
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;"><?php echo $stNilai_Jaminan; ?> :&nbsp;</td>
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
						<tr <?php echo $disp_BPJS; ?>>
                            <td height="19" align="right" style="font-weight:bold;font-size:12px;">Obat Tidak Dijamin :&nbsp;</td>
                            <td align="right" style="font-weight:bold;font-size:12px;"><?php echo number_format($ObtDijaminBPJS,0,",","."); ?>&nbsp;</td>
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
                        <?php
						if($nReturObat>0){
						?>
                       <tr>
                         <td height="19" align="right" style="font-weight:bold;font-size:12px">Total Retur Obat :&nbsp;</td>
                         <td align="right" style="font-weight:bold;font-size:12px"><?php echo number_format($nReturObat,0,",",".");?>&nbsp;</td>
                       </tr>
                        <?php
						}
						?>
                        <?php
						if($totReturBayar>0){
						?>
                       <tr>
                         <td height="19" align="right" style="font-weight:bold;font-size:12px">Total Retur Billing :&nbsp;</td>
                         <td align="right" style="font-weight:bold;font-size:12px"><?php echo "(".number_format($totReturBayar,0,",",".").")";?>&nbsp;</td>
                       </tr>
                        <?php
						}
						?>
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
							<td width="15%" align="center" style="font-weight:bold;font-size:10px;">Status Px&nbsp;</td>
                            <td width="15%" align="right" style="font-weight:bold;font-size:10px;">Pembayaran&nbsp;/&nbsp;Retur</td>
                            <td width="21%" align="center" style="font-weight:bold;font-size:10px;">Kasir</td>
                            <td width="21%" align="center" style="font-weight:bold;font-size:10px;">&nbsp;</td>
                            
                        </tr>
                        <?php
						/* $sPembayaran="SELECT * FROM
										(select 
										concat(date_format(b.tgl,'%d-%m-%Y'),' ',date_format(b.tgl_act,'%H:%i')) as tgl,
										b.no_kwitansi as nokwi,
										pg.nama as kasir,
										if(b.tipe=1,b.titipan,b.nilai) as nominal,
										bm.nama AS status_penj
										from 
										(select * from b_bayar where 0=0 $jenisKunj) b 
										inner join b_ms_pegawai pg on pg.id=b.user_act
										INNER JOIN b_ms_kso bm ON b.kso_id = bm.id
										where b.kunjungan_id='$idKunj'
										UNION
										select
										date_format(aku.TGL_BAYAR,'%d-%m-%Y %H:%i') as tgl,
										aku.NO_BAYAR as nokwi,
										au.username as kasir,
										aku.TOTAL_HARGA as nominal,
										am.NAMA AS status_penj
										from
										$dbapotek.a_kredit_utang aku
										inner join $dbapotek.a_user au on au.kode_user=aku.USER_ID
										INNER JOIN b_pelayanan p ON p.id=aku.NO_PELAYANAN
										INNER JOIN (SELECT KSO_ID, NO_PENJUALAN FROM $dbapotek.a_penjualan) ap ON ap.NO_PENJUALAN = aku.FK_NO_PENJUALAN
									    INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA = ap.KSO_ID
										where aku.IS_AKTIF = 1 and p.kunjungan_id='$idKunj' and aku.CARA_BAYAR=2 $jenisKunj) as tbl ORDER BY tgl"; */
										
						$BBilling = "select 
										concat(date_format(b.tgl,'%d-%m-%Y'),' ',date_format(b.tgl_act,'%H:%i')) as tgl,
										b.no_kwitansi as nokwi,
										pg.nama as kasir,
										if(b.tipe=1,b.titipan,b.nilai) as nominal,
										bm.nama AS status_penj
										from 
										(select * from b_bayar where 0=0 {$jenisKunj}) b 
										inner join b_ms_pegawai pg on pg.id=b.user_act
										INNER JOIN b_ms_kso bm ON b.kso_id = bm.id
										where b.kunjungan_id='{$idKunj}'";
						
						$BApotek = "SELECT DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i') AS tgl, ku.NO_BAYAR nokwi, u.username kasir,
									   ku.TOTAL_HARGA nominal, m.NAMA status_penj
									FROM $dbapotek.a_kredit_utang ku
									INNER JOIN $dbapotek.a_penjualan ap
									   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
									  AND ap.NO_PASIEN = ku.NORM
									  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
									INNER JOIN b_pelayanan p
									   ON p.id = ku.NO_PELAYANAN
									INNER JOIN $dbapotek.a_user u
									   ON u.kode_user = ku.USER_ID
									INNER JOIN $dbapotek.a_mitra m
									   ON m.IDMITRA = ap.KSO_ID
									WHERE ku.IS_AKTIF = 1
									  AND p.kunjungan_id = '{$idKunj}'
									  AND ku.CARA_BAYAR = 2
									  {$jenisKunj}
									GROUP BY ku.NO_BAYAR, ku.FK_NO_PENJUALAN";
									
						$sPembayaran="SELECT * FROM ({$BBilling} UNION {$BApotek}) as tbl ORDER BY tgl";
						$qPembayaran=mysql_query($sPembayaran);
						$no=0;
						while($rwPembayaran=mysql_fetch_array($qPembayaran)){
							$no++;
						?>
                        <tr>
                            <td align="left" style="font-size:12px;font-size:10px;">&nbsp;</td>
                            <td width="8%" align="center" style="font-size:12px;font-size:10px;"><?php echo $no; ?>.</td>
                            <td width="18%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['tgl']; ?></td>
                            <td width="20%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['nokwi']; ?></td>
							<td width="14%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['status_penj']; ?></td>
                            <td align="right" style="font-size:12px;font-size:10px;"><?php echo number_format($rwPembayaran['nominal'],0,",","."); ?>&nbsp;</td>
                            <td width="21%" align="center" style="font-size:12px;font-size:10px;"><?php echo $rwPembayaran['kasir']; ?></td>
                            <td width="21%" align="right" style="font-size:12px;font-size:10px;">&nbsp;</td>
                            
                        </tr>
                        <?php
						}
						
						$rsReturBayar = mysql_query($qReturBayar);
						$totReturBayar = 0;
						while ($rwReturBayar=mysql_fetch_array($rsReturBayar)){
							$no++;
							//$totReturBayar+=$rwReturBayar['nominal'];
						?>
                        <tr>
                            <td align="left" style="font-size:12px;font-size:10px;">&nbsp;</td>
                            <td align="center" style="font-size:12px;font-size:10px;"><?php echo $no; ?>.</td>
                            <td align="center" style="font-size:12px;font-size:10px;"><?php echo $rwReturBayar['tgl']; ?></td>
                            <td align="center" style="font-size:12px;font-size:10px;"><?php echo $rwReturBayar['nokwi']; ?></td>
							<td align="center" style="font-size:12px;font-size:10px;"><?php echo $rwReturBayar['status_penj']; ?></td>
                            <td align="right" style="font-size:12px;font-size:10px;"><?php echo "(".number_format($rwReturBayar['nominal'],0,",",".").")"; ?>&nbsp;</td>
                            <td align="center" style="font-size:12px;font-size:10px;"><?php echo $rwReturBayar['kasir']; ?></td>
                            <td align="right" style="font-size:12px;font-size:10px;">&nbsp;</td>
                            
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