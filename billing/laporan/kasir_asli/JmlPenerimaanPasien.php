<?php
	session_start();
	include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>Penerimaan Pasien</title>
</head>

<body>
<?php
	//session_start();
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
}else
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];

	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

if($_REQUEST['cmbKsr']!=0){
	$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$_REQUEST['cmbKsr']."'";
	$rsKasir = mysql_query($sqlKasir);
	$rwKasir = mysql_fetch_array($rsKasir);
	$fKsr = " AND b.user_act=".$_REQUEST['cmbKsr'];
}

if($_REQUEST['StatusPas']!=0){
	$sqlKso = "SELECT id,nama from b_ms_kso where id = ".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
}
?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="9"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <!--tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57)?"style='display:none;'":'';?>>&nbsp;</td>
    <td>&nbsp;</td>
  </tr-->
  <tr>
    <td colspan="9" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan Kasir<br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?><br />Jenis Layanan <?php echo $rwUnit1['nama'] ?> <br/>Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?></b></td>
  </tr>
  <!--tr>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57)?"style='display:none;'":'';?>>&nbsp;</td>
    <td colspan="7" align="right">&nbsp;</td>
  </tr-->
  <!--tr>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57)?"style='display:none;'":'';?>>&nbsp;</td>
    <td colspan="7" align="right"></td>
  </tr-->
  <tr>
    <td colspan="2" height="30">&nbsp;Kasir :&nbsp;&nbsp;&nbsp;<?php if($_REQUEST['cmbKsr']==0) echo 'Semua'; else echo $rwKasir['nama'];?></td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td colspan="4" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr height="30" style="font-weight:bold"> 
    <td width="5%" style="border-top:1px solid; border-bottom:1px solid;" align="center">&nbsp;No</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;" align="center">&nbsp;Tgl Bayar</td>
    <td width="15" <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"colspan='4'":"";?> style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Jumlah Pasien</td>
    <td width="20%" style="border-top:1px solid; border-bottom:1px solid;">&nbsp;Status</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid; <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"display:none;":'';?>" align="center">Retribusi&nbsp;</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;<?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"display:none;":'';?>" align="center">Tindakan&nbsp;</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;<?php echo ($_REQUEST['JnsLayanan']==60)?"display:none;":'';?>" align="center">Laboratorium&nbsp;</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;<?php echo ($_REQUEST['JnsLayanan']==57)?"display:none;":'';?>" align="center">Radiologi&nbsp;</td>
    <td width="10%" style="border-top:1px solid; border-bottom:1px solid;" align="center">Jumlah&nbsp;</td>
  </tr>
   <?php 
   $qKso = "SELECT DISTINCT mk.id,mk.nama
	FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
	inner join b_tindakan t on p.id = t.pelayanan_id
	inner join b_bayar_tindakan bt on t.id = bt.tindakan_id
	INNER JOIN b_bayar b ON bt.bayar_id=b.id
	INNER JOIN b_ms_kso mk ON k.kso_id=mk.id
	WHERE (DATE(b.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') and bt.tipe=0 ".$fTmpLay.$fKsr.$fKso;
  $rsLapKso = mysql_query($qKso);
	$jml=0;$jmlRet=0;$jmlLab=0;$jmlRad=0;$jmlTin=0;
  while($rwLapKso = mysql_fetch_array($rsLapKso)){
  ?>  
  <tr height="23">
    <td colspan="2" style="text-decoration:underline; font-weight:bold;">&nbsp;<?php echo $rwLapKso['nama'] ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57)?"style='display:none;'":'';?>>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
	$qUnit = "SELECT DISTINCT mu.id,mu.nama
		FROM b_kunjungan k
		INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
		inner join b_tindakan t on p.id = t.pelayanan_id
		inner join b_bayar_tindakan bt on t.id = bt.tindakan_id
		INNER JOIN b_bayar b ON bt.bayar_id=b.id
		INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
		WHERE (DATE(b.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') and bt.tipe=0
		AND k.kso_id=".$rwLapKso['id'].$fTmpLay.$fKsr;
  	$rsLapUnit = mysql_query($qUnit);
	$subtotal=0;
 	 while($rwLapUnit = mysql_fetch_array($rsLapUnit)){
	?>
	<tr height="23">
    <td>&nbsp;</td>
    <td style="text-decoration:underline; font-weight:bold;">&nbsp;<?php echo $rwLapUnit['nama'] ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  		if($_REQUEST['cmbKsr']!=0)
			$fKasir = "AND mp.id = '".$_REQUEST['cmbKsr']."'";
		$qKsr = "SELECT DISTINCT mp.id, mp.nama FROM b_kunjungan k
INNER JOIN b_pelayanan p ON p.kunjungan_id = k.id
INNER JOIN b_tindakan t ON p.id = t.pelayanan_id
INNER JOIN b_bayar_tindakan bt ON bt.tindakan_id = t.id
INNER JOIN b_bayar b ON b.id = bt.bayar_id
INNER JOIN b_ms_pegawai mp ON mp.id = b.user_act
INNER JOIN b_ms_unit mu ON mu.id = p.unit_id
WHERE (DATE(b.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') and bt.tipe=0
		AND k.kso_id='".$rwLapKso['id']."' $fKasir AND mu.id = '".$rwLapUnit['id']."' ";
		$rsKsr = mysql_query($qKsr);
		while($rwKsr = mysql_fetch_array($rsKsr))
		{
  ?>
  <tr height="23">
    <td>&nbsp;</td>
    <td colspan="2" style="padding-left:30px; text-decoration:underline; font-weight:bold;"><?php echo $rwKsr['nama']?></td>
    <td>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
    <td <?php echo ($_REQUEST['JnsLayanan']==57)?"style='display:none;'":'';?>>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
	<?php
		/*$qKunjPas = "SELECT k.id idKunj,p.id idPel,mp.nama,mp.no_rm,DATE_FORMAT(b.tgl_act,'%d-%m-%Y') tgl
		,TIME_FORMAT(b.tgl_act,'%H:%i:%s') jam,b.nobukti,mk.nama nmKso,
		(SELECT SUM(bt.nilai)
		FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
		INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
		INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
		INNER JOIN b_bayar b ON bt.bayar_id=b.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
		WHERE t.kunjungan_id=idKunj AND mt.klasifikasi_id=11
		AND p.unit_id=".$rwLapUnit['id'].$fKsr.") retribusi,
		(SELECT SUM(bt.nilai)
		FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
		INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
		INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
		INNER JOIN b_bayar b ON bt.bayar_id=b.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
		INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
		WHERE t.kunjungan_id=idKunj AND mt.klasifikasi_id!=11 AND mu.parent_id!=57
		AND mu.parent_id!=60 AND p.unit_id=".$rwLapUnit['id'].$fKsr.") biayaTind,
		(SELECT SUM(bt.nilai)
		FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
		INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
		INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
		INNER JOIN b_bayar b ON bt.bayar_id=b.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
		INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
		WHERE t.kunjungan_id=idKunj AND mt.klasifikasi_id!=11 AND mu.parent_id=57
		AND p.unit_id_asal=".$rwLapUnit['id'].$fKsr.") biayaLab,
		(SELECT SUM(bt.nilai)
		FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
		INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
		INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
		INNER JOIN b_bayar b ON bt.bayar_id=b.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
		INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
		WHERE t.kunjungan_id=idKunj AND mt.klasifikasi_id!=11
		AND mu.parent_id=6 AND p.unit_id_asal=".$rwLapUnit['id'].$fKsr.") biayaRad,
		(SELECT SUM(bt.nilai)
		FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
		INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
		INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
		INNER JOIN b_bayar b ON bt.bayar_id=b.id
		INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
		WHERE t.kunjungan_id=idKunj AND p.unit_id=".$rwLapUnit['id'].$fKsr.") jmlBiaya 
		FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
		INNER JOIN b_bayar b ON k.id=b.kunjungan_id
		INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
		INNER JOIN b_ms_kso mk ON k.kso_id=mk.id
		WHERE b.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'
		AND p.unit_id=".$rwLapUnit['id']." AND k.kso_id=".$rwLapKso['id'].$fKsr." GROUP BY k.id";*/
		$qKunjPas = "SELECT DATE_FORMAT(b.tgl_act,'%d-%m-%Y') tgl, COUNT(k.pasien_id) AS jml, mk.nama,b.tgl as b_tgl
		FROM b_kunjungan k
		INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
		inner join b_tindakan t on p.id = t.pelayanan_id
		inner join b_bayar_tindakan bt on bt.tindakan_id = t.id
		INNER JOIN b_bayar b ON b.id = bt.bayar_id
		INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
		INNER JOIN b_ms_kso mk ON k.kso_id=mk.id
		WHERE (DATE(b.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."')
		AND p.unit_id=".$rwLapUnit['id']." AND k.kso_id='".$rwLapKso['id']."' AND b.user_act='".$rwKsr['id']."' and bt.tipe=0 group by b.tgl";
		$rsKunjPas = mysql_query($qKunjPas);
		$no=0;$subtotal=0;$subtotTin=0;$subtotLab=0;$subtotRad=0;$subtotRet=0;
		while($rwKunjPas = mysql_fetch_array($rsKunjPas)){
		$tgl = $rwKunjPas['b_tgl'];
		$no++;
		$sqlRet = "SELECT SUM(bt.nilai) as retribusi
			FROM b_kunjungan k
			INNER JOIN b_pelayanan p ON p.kunjungan_id = k.id
			INNER JOIN b_tindakan t ON t.pelayanan_id = p.id
			INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
			INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
			INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
			INNER JOIN b_bayar b ON bt.bayar_id=b.id
			WHERE mt.klasifikasi_id=11 and bt.tipe=0 and b.tgl = '$tgl'
			AND b.user_act='".$rwKsr['id']."'
			AND p.unit_id='".$rwLapUnit['id']."'
			AND k.kso_id = '".$rwLapKso['id']."'";
		$rsRet = mysql_query($sqlRet);
		$rowRet = mysql_fetch_array($rsRet);
		
		$sqlTin = "SELECT SUM(bt.nilai) as biayaTin
			FROM b_kunjungan k
			INNER JOIN b_pelayanan p ON p.kunjungan_id = k.id
			INNER JOIN b_tindakan t ON t.pelayanan_id = p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
			INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
			INNER JOIN b_bayar_tindakan bt ON t.id=bt.tindakan_id
			INNER JOIN b_bayar b ON bt.bayar_id=b.id
			WHERE mt.klasifikasi_id<>11 and bt.tipe=0 and b.tgl = '$tgl'
			AND b.user_act='".$rwKsr['id']."'
			AND p.unit_id='".$rwLapUnit['id']."'
			AND k.kso_id = '".$rwLapKso['id']."'";
		$rsTin = mysql_query($sqlTin);
		$rowTin = mysql_fetch_array($rsTin);
		
		$sqlLab = "SELECT IFNULL(SUM(bt.nilai),0) AS biayaLab
			 FROM b_kunjungan k
INNER JOIN b_pelayanan p ON k.id = p.kunjungan_id
INNER JOIN b_tindakan t ON t.pelayanan_id = p.id
			   INNER JOIN b_bayar_tindakan bt
				ON bt.tindakan_id = t.id
			   INNER JOIN b_bayar b
				ON bt.bayar_id = b.id
				WHERE b.tgl = '$tgl' AND p.unit_id_asal = ".$rwLapUnit['id']."
				AND p.jenis_layanan = 57
				AND b.user_act='".$rwKsr['id']."'
				AND k.kso_id = '".$rwLapKso['id']."'";
		$rsLab = mysql_query($sqlLab);
		$rowLab = mysql_fetch_array($rsLab);
			
		$sqlRad = "SELECT IFNULL(SUM(bt.nilai),0) AS biayaRad
			 FROM b_kunjungan k
INNER JOIN b_pelayanan p ON k.id = p.kunjungan_id
INNER JOIN b_tindakan t ON t.pelayanan_id = p.id
			   INNER JOIN b_bayar_tindakan bt
				ON bt.tindakan_id = t.id
			   INNER JOIN b_bayar b
				ON bt.bayar_id = b.id
				WHERE b.tgl = '$tgl' AND p.unit_id_asal = ".$rwLapUnit['id']."
				AND p.jenis_layanan = 60
				AND b.user_act='".$rwKsr['id']."'
				AND k.kso_id = '".$rwLapKso['id']."'";
		$rsRad = mysql_query($sqlRad);
		$rowRad = mysql_fetch_array($rsRad);
		
		$biayaTotal = $rowRad['biayaRad']+$rowLab['biayaLab']+$rowRet['retribusi']+$rowTin['biayaTin'];
	?>
	<tr height="23">
  	<td>&nbsp;<?php echo $no; ?></td>
	<td>&nbsp;<?php echo $rwKunjPas['tgl']; ?></td>
	<td style="padding-left:20px;" <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"colspan='4'":'';?>>&nbsp;<?php echo $rwKunjPas['jml']; ?>&nbsp;Pasien</td>
	<td>&nbsp;<?php echo $rwKunjPas['nama']; ?></td>
	<td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> align="right"><?php echo number_format($rowRet['retribusi'],0,",",".") ; ?>&nbsp;</td>
	<td align="right"><?php echo number_format($rowTin['biayaTin'],0,",",".") ; ?>&nbsp;</td>
	<!--?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?--> 
	<td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> align="right"><?php echo number_format($rowLab['biayaLab'],0,",",".") ; ?>&nbsp;</td>
	<td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> align="right"><?php echo number_format($rowRad['biayaRad'],0,",",".") ; ?>&nbsp;</td>
	<td align="right"><?php echo number_format($biayaTotal,0,",",".");?>&nbsp;</td>
  </tr>
	<?php
	   $subtotRet += $rowRet['retribusi'];
	   $subtotTin += $rowTin['biayaTin'];
	   $subtotLab += $rowLab['biayaLab'];
	   $subtotRad += $rowRad['biayaRad'];
		$subtotal = $subtotal + $biayaTotal;
		}
		mysql_free_result($rsKunjPas);
		$jmlRet = $jmlRet + $subtotRet;
		$jmlTin = $jmlTin + $subtotTin;
		$jmlLab = $jmlLab + $subtotLab;
		$jmlRad = $jmlRad + $subtotRad;
	  	$jml = $jml + $subtotal;
  ?>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?>>&nbsp;</td>
	<td style="text-align:right; border-top:1px solid;">Subtotal&nbsp;</td>
	<td  <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> style="border-top:1px solid; text-align:right"><?php echo number_format($subtotRet,0,",",".");?>&nbsp;</td>
	<td <?php echo ($_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> style="border-top:1px solid; text-align:right"><?php echo number_format($subtotTin,0,",",".");?>&nbsp;</td>
	<td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> style="border-top:1px solid; text-align:right"><?php echo number_format($subtotLab,0,",",".");?>&nbsp;</td>
	<td <?php echo ($_REQUEST['JnsLayanan']==57||$_REQUEST['JnsLayanan']==60)?"style='display:none;'":'';?> style="border-top:1px solid; text-align:right"><?php echo number_format($subtotRad,0,",",".");?>&nbsp;</td>
    <td align="right" style="border-top:1px solid;"><?php echo number_format($subtotal,0,",",".");?>&nbsp;</td>
  </tr>
  <?php 
  	}}
	mysql_free_result($rsLapUnit);
  }
  ?>
  <tr style="font-weight:bold;">
	<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
  	<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
  	<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
  	<td style="border-bottom:1px solid; border-top:1px solid; text-align:right">Total&nbsp;</td>
  	<td style="border-bottom:1px solid; border-top:1px solid; text-align:right"><?php echo number_format($jmlRet,0,",",".")?>&nbsp;</td>
  	<td style="border-bottom:1px solid; border-top:1px solid; text-align:right"><?php echo number_format($jmlTin,0,",",".")?>&nbsp;</td>
  	<td style="border-bottom:1px solid; border-top:1px solid; text-align:right"><?php echo number_format($jmlLab,0,",",".")?>&nbsp;</td>
  	<td height="28" style="border-bottom:1px solid; border-top:1px solid; text-align:right"><?php echo number_format($jmlRad,0,",",".")?>&nbsp;</td>
	<td align="right" style="border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($jml,0,",",".")?>&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="9" height="30">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="7" align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="6" align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="9" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="6" align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php
  mysql_free_result($rsLapKso);
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="9" height="50">
	 <tr id="trTombol">
       <td colspan="10" class="noline" align="center">
            <select  name="select" id="cmbPrint2an" onchange="changeSize(this.value)">
              <option value="0">Printer non-Kretekan</option>
              <option value="1">Printer Kretekan</option>
            </select>
			<br />
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>		</td>
    </tr>
	</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

/*try{	
formatF4Portrait();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
function changeSize(par){
	if(par == 1){
		document.getElementById('tblPrint').width = 1200;
	}
	else{
		document.getElementById('tblPrint').width = 800;
	}
}

    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		window.print();
		window.close();
        }
    }
</script>
</html>