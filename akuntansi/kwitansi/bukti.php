<?php
include("../koneksi/konek.php");
$tipe = $_REQUEST['tipe'];
$tgl = $_REQUEST['tgl']; $x = explode("-",$tgl); $tgl2 = $x[2]."-".$x[1]."-".$x[0];
$kw = $_REQUEST['kw'];
$no_post = $_REQUEST['no_post'];
$terima_dari = $_REQUEST['terima'];
$sql = "SELECT ma.MA_KODE,ma.MA_NAMA,ma.CC_RV_KSO_PBF_UMUM,j.* FROM (SELECT * FROM $dbakuntansi.jurnal WHERE TGL='$tgl' AND NO_BUKTI='$kw' AND FK_ID_POSTING = '{$no_post}' AND SELISIH=0 AND PAJAK=0) AS j
INNER JOIN $dbakuntansi.ma_sak ma ON j.FK_SAK=ma.MA_ID"; 
// echo $sql;
$q = mysql_query($sql);

$sqlTotNilai = "SELECT IFNULL(SUM(DEBIT),0) AS nilaiD,IFNULL(SUM(KREDIT),0) AS nilaiK FROM (".$sql.") AS gab"; 
//echo $sql;
$qTotNilai = mysql_query($sqlTotNilai);
$rwTot = mysql_fetch_array($qTotNilai);
$nilai = $rwTot["nilaiD"];

$nRS="RS PELABUHAN MEDAN (PELINDO)";
$nAlamatRS="JL. Stasiun No. 92";
$nBukti="";
if($tipe=='1')
{
	$nBukti="BBM ".$kw;
	$sqlN="SELECT * FROM ($sql) AS tNilai WHERE tNilai.MA_KODE LIKE '11102%' AND tNilai.D_K='D'";
	//echo $sqlN."<br>";
	$rsNilai=mysql_query($sqlN);
	$rwNilai=mysql_fetch_array($rsNilai);
	$nAkun=explode('-',$rwNilai["MA_NAMA"]);
	$nBank=$nAkun[0];
	$nRek=$nAkun[1];
	$nKas=$rwNilai["DEBIT"];
	$nket=$rwNilai["URAIAN"];
	while ($rwNilai=mysql_fetch_array($rsNilai)){
		$nKas +=$rwNilai["DEBIT"];
		$nket .="<br>".$rwNilai["URAIAN"];
	}
?>
<html>
<head>
<title>BUKTI BANK MASUK</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="9"><strong><?=$nRS;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"><strong><?=$nAlamatRS;?></strong></td>
    <td width="133"><strong>Nomor</strong></td>
    <td width="12"><strong>:</strong></td>
    <td width="262"><strong><?php echo $nBukti; ?></strong></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><strong>Tanggal</strong></td>
    <td><strong>:</strong></td>
    <td><?=$tgl2;?></td>
  </tr>
  <tr>
    <td colspan="6"><center>
      <strong>BUKTI BANK MASUK</strong>
    </center></td>
    <td><strong>Nama Bank</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?=$nBank;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><strong>Nomor Rekening</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?=$nRek;?></strong></td>
  </tr>
  <tr>
    <td colspan="7" rowspan="3"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Diterima    dari</td>
    <td>:</td>
    <td colspan="5"><?=$terima_dari?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td width="137">Sebesar</td>
    <td width="9">:</td>
    <td colspan="5"><?php echo number_format($nKas,0,",","."); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Terbilang</td>
    <td>:</td>
    <td colspan="5"><?php echo terbilang($nKas,3); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Uraian</td>
    <td>:</td>
    <td colspan="5"><?php echo $nket; ?></td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td></td>
    <td width="23"></td>
    <td width="23"></td>
    <td width="23"></td>
    <td width="385"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  </table>
<p>&nbsp;</p>
<table width="1000" cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000000">
    <tr style="font-weight:bold;">
      <td width="50" align="center">No</td>
      <td width="100" align="center">No. Akun</td>
      <td align="center">Nama Akun</td>
      <td width="90" align="center">Debit</td>
      <td width="90" align="center">Kredit</td>
    </tr>
	<?php
	$i=1;
	while($data = mysql_fetch_array($q))
	{
		$ma_kode=$data['MA_KODE'];
		$ma_nama=$data['MA_NAMA'];
	?>
   <tr>
      <td align="center">&nbsp;<?=$i;?></td>
     <td align="center">&nbsp;<?=$ma_kode;?></td>
      <td>&nbsp;<?=$ma_nama;?></td>
      <td align="right">&nbsp;<?=number_format($data['DEBIT'],0,",",".");?></td>
      <td align="right">&nbsp;<?=number_format($data['KREDIT'],0,",",".");?></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<br />
<table width="1000" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td width="500">&nbsp;</td>
    <td width="125">Penerima</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>Bukti :&nbsp;<input type="checkbox" />&nbsp;Terlampir&nbsp;<input type="checkbox" />&nbsp;Tidak Ada</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Dibukukan </td>
    <td align="center">Disetujui</td>
    <td align="center">Diperiksa</td>
    <td align="center">Disetor</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Akuntansi</td>
    <td>&nbsp;</td>
    <td align="center">Bendahara Penerimaan</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php 
}
else if($tipe=='2')
{
	$nBukti="BBK ".$kw;
	$sqlN="SELECT * FROM ($sql) AS tNilai WHERE tNilai.MA_KODE LIKE '11102%' AND tNilai.D_K='K'";
	//echo $sqlN."<br>";
	$rsNilai=mysql_query($sqlN);
	$rwNilai=mysql_fetch_array($rsNilai);
	$nAkun=explode('-',$rwNilai["MA_NAMA"]);
	$nBank=$nAkun[0];
	$nRek=$nAkun[1];
	$nKas=$rwNilai["KREDIT"];
	$nket=$rwNilai["URAIAN"];
	while ($rwNilai=mysql_fetch_array($rsNilai)){
		$nKas +=$rwNilai["KREDIT"];
		$nket .="<br>".$rwNilai["URAIAN"];
	}
?>
  
<html>
<head>
<title>BUKTI BANK KELUAR</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="9"><strong><?=$nRS;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"><strong><?=$nAlamatRS;?></strong></td>
    <td width="121"><strong>Nomor</strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="340"><strong><?php echo $nBukti; ?></strong></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><strong>Tanggal</strong></td>
    <td><strong>:</strong></td>
    <td><?=$tgl2;?></td>
  </tr>
  <tr>
    <td colspan="6"><center>
      <strong>BUKTI BANK KELUAR</strong>
    </center></td>
    <td><strong>Nama Bank</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?=$nBank;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><strong>Nomor Rekening</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?=$nRek;?></strong></td>
  </tr>
  <tr>
    <td colspan="7" rowspan="3"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Dibayarkan Kepada</td>
    <td>:</td>
    <td colspan="5"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td width="155">Sebesar</td>
    <td width="11">:</td>
    <td colspan="5"><?php echo number_format($nKas,0,",","."); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Terbilang</td>
    <td>:</td>
    <td colspan="5"><?php echo terbilang($nKas,3); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Uraian</td>
    <td>:</td>
    <td colspan="5"><?php echo $nket; ?></td>
    <td></td>
    <td></td>
  </tr>
  
  <tr>
    <td></td>
    <td></td>
    <td width="28"></td>
    <td width="28"></td>
    <td width="28"></td>
    <td width="459"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="1000" cellspacing="0" cellpadding="0" border="1" bordercolor="#000000">
    <tr style="font-weight:bold;">
      <td width="50" align="center">No</td>
      <td width="100" align="center">No. Akun</td>
      <td align="center">Nama Akun</td>
      <td width="90" align="center">Debit</td>
      <td width="90" align="center">Kredit</td>
    </tr>
	<?php
	$i=1;
	while($data = mysql_fetch_array($q))
	{
		$ma_kode=$data['MA_KODE'];
		$ma_nama=$data['MA_NAMA'];
	?>
   <tr>
      <td align="center">&nbsp;<?=$i;?></td>
     <td align="center">&nbsp;<?=$ma_kode;?></td>
      <td>&nbsp;<?=$ma_nama;?></td>
      <td align="right">&nbsp;<?=number_format($data['DEBIT'],0,",",".");?></td>
      <td align="right">&nbsp;<?=number_format($data['KREDIT'],0,",",".");?></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<br />
<table width="1000" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td width="500">&nbsp;</td>
    <td width="125">Penerima</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>Bukti :&nbsp;<input type="checkbox" />&nbsp;Terlampir&nbsp;<input type="checkbox" />&nbsp;Tidak Ada</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Dibukukan </td>
    <td align="center">Disetujui</td>
    <td align="center">Diperiksa</td>
    <td align="center">Diajukan</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Akuntansi</td>
    <td>&nbsp;</td>
    <td align="center">Bendahara Pengeluaran</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php 
}else if($tipe=='3'){
	$nBukti="BKM ".$kw;
	$sqlN="SELECT * FROM ($sql) AS tNilai WHERE tNilai.MA_KODE LIKE '11101%' AND tNilai.D_K='D'";
	//echo $sqlN."<br>";
	$rsNilai=mysql_query($sqlN);
	$rwNilai=mysql_fetch_array($rsNilai);
	$nAkun=explode('-',$rwNilai["MA_NAMA"]);
	$nBank=$nAkun[0];
	$nRek=$nAkun[1];
	$nKas=$rwNilai["DEBIT"];
	$nket=$rwNilai["URAIAN"];
	while ($rwNilai=mysql_fetch_array($rsNilai)){
		$nKas +=$rwNilai["DEBIT"];
		$nket .="<br>".$rwNilai["URAIAN"];
	}
?>
<html>
<head>
<title>BUKTI KAS MASUK</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="9"><strong><?=$nRS;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"><strong><?=$nAlamatRS;?></strong></td>
    <td width="121"><strong>Nomor</strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="340"><strong><?php echo $nBukti; ?></strong></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><strong>Tanggal</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?=$tgl2;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"><center>
      <strong>BUKTI KAS MASUK</strong>
    </center></td>
    <td><!--strong>Nama Bank</strong--></td>
    <td><!--strong>:</strong--></td>
    <td><!--strong><?=$nBank;?></strong--></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><!--strong>Nomor Rekening</strong--></td>
    <td><!--strong>:</strong--></td>
    <td><!--strong><?=$nRek;?></strong--></td>
  </tr>
  <tr>
    <td colspan="7" rowspan="3"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Diterima    dari</td>
    <td>:</td>
    <td colspan="5"><?=$terima_dari?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td width="155">Sebesar</td>
    <td width="11">:</td>
    <td colspan="5"><?php echo number_format($nKas,0,",","."); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Terbilang</td>
    <td>:</td>
    <td colspan="5"><?php echo terbilang($nKas,3); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Uraian</td>
    <td>:</td>
    <td colspan="5"><?php echo $nket; ?></td>
    <td></td>
    <td></td>
  </tr>
  <!--tr>
    <td></td>
    <td></td>
    <td colspan="5">&nbsp; ....................................................................................................................................................................</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="5">&nbsp;&nbsp;....................................................................................................................................................................</td>
    <td></td>
    <td></td>
  </tr-->
  <tr>
    <td></td>
    <td></td>
    <td width="28"></td>
    <td width="28"></td>
    <td width="28"></td>
    <td width="459"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<br />
<table width="1000" cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000000">
    <tr style="font-weight:bold;">
      <td width="50" align="center">No</td>
      <td width="100" align="center">No. Akun</td>
      <td align="center">Nama Akun</td>
      <td width="90" align="center">Debit</td>
      <td width="90" align="center">Kredit</td>
    </tr>
	<?php
	$i=1;
	while($data = mysql_fetch_array($q))
	{
		$ma_kode=$data['MA_KODE'];
		$ma_nama=$data['MA_NAMA'];
		$ccrv=$data['CC_RV_KSO_PBF_UMUM'];
		$ccrv_kso_pbf_id=$data['CC_RV_KSO_PBF_UMUM_ID'];
		//echo $ccrv;
		switch($ccrv){
			case 1:
				$sqlccrv="SELECT * FROM ak_ms_unit WHERE tipe=1 AND id=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["nama"];
				break;
			case 2:
				$sqlccrv="SELECT * FROM $dbbilling.b_ms_kso WHERE id=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["nama"];
				break;
			case 3:
				$sqlccrv="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["PBF_NAMA"];
				break;
			case 4:
				$sqlccrv="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["namarekanan"];
				break;
		}
	?>
   <tr>
      <td align="center">&nbsp;<?=$i;?></td>
     <td align="center">&nbsp;<?=$ma_kode;?></td>
      <td>&nbsp;<?=$ma_nama;?></td>
     <td align="right">&nbsp;<?=number_format($data['DEBIT'],0,",",".");?></td>
      <td align="right">&nbsp;<?=number_format($data['KREDIT'],0,",",".");?></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<br />
<table width="1000" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td width="500">&nbsp;</td>
    <td width="125" align="center">Penerima</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>Bukti :&nbsp;<input type="checkbox" />&nbsp;Terlampir&nbsp;<input type="checkbox" />&nbsp;Tidak Ada</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Dibukukan </td>
    <td align="center">Disetujui</td>
    <td align="center">Diperiksa</td>
    <td align="center">Disetor</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Akuntansi</td>
    <td>&nbsp;</td>
    <td align="center">Bendahara Penerimaan</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php 
}else if($tipe=='4'){
	$nBukti="BKK ".$kw;
//	$sqlN="SELECT * FROM ($sql) AS tNilai WHERE tNilai.MA_KODE LIKE '11101%' AND tNilai.D_K='K'";
	$sqlN="SELECT * FROM ($sql) AS tNilai WHERE tNilai.MA_KODE LIKE '111%' AND tNilai.D_K='K'";
	$rsNilai=mysql_query($sqlN);
	$rwNilai=mysql_fetch_array($rsNilai);
	$nAkun=explode('-',$rwNilai["MA_NAMA"]);
	$nBank=$nAkun[0];
	$nRek=$nAkun[1];
	$nKas=$rwNilai["KREDIT"];
	$nket=$rwNilai["URAIAN"];
	while ($rwNilai=mysql_fetch_array($rsNilai)){
		$nKas +=$rwNilai["KREDIT"];
		$nket .="<br>".$rwNilai["URAIAN"];
	}
?>
<html>
<head>
<title>BUKTI KAS KELUAR</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="9"><strong><?=$nRS;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"><strong><?=$nAlamatRS;?></strong></td>
    <td width="121"><strong>Nomor</strong></td>
    <td width="10"><strong>:</strong></td>
    <td width="340"><strong><?php echo $nBukti; ?></strong></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><strong>Tanggal</strong></td>
    <td><strong>:</strong></td>
    <td><strong><?=$tgl2;?></strong></td>
  </tr>
  <tr>
    <td colspan="6"><center>
      <strong>BUKTI KAS KELUAR</strong>
    </center></td>
    <td><!--strong>Nama Bank</strong--></td>
    <td><!--strong>:</strong--></td>
    <td><!--strong><?=$nBank;?></strong--></td>
  </tr>
  <tr>
    <td colspan="6"></td>
    <td><!--strong>Nomor Rekening</strong--></td>
    <td><!--strong>:</strong--></td>
    <td><!--strong><?=$nRek;?></strong--></td>
  </tr>
  <tr>
    <td colspan="7" rowspan="3"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Dibayarkan Kepada</td>
    <td>:</td>
    <!--td colspan="5">:    ..............................................................................................................................</td-->
    <td colspan="5">&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td width="155">Sebesar</td>
    <td width="11">:</td>
    <td colspan="5"><?php echo number_format($nKas,0,",","."); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Terbilang</td>
    <td>:</td>
    <td colspan="5"><?php echo terbilang($nKas,3); ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Uraian</td>
    <td>:</td>
    <td colspan="5"><?php echo $nket; ?></td>
    <td></td>
    <td></td>
  </tr>
  <!--tr>
    <td></td>
    <td></td>
    <td colspan="5">&nbsp; ....................................................................................................................................................................</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="5">&nbsp;&nbsp;....................................................................................................................................................................</td>
    <td></td>
    <td></td>
  </tr-->
  <tr>
    <td></td>
    <td></td>
    <td width="28"></td>
    <td width="28"></td>
    <td width="28"></td>
    <td width="459"></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<br />
<table width="1000" cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000000">
    <tr style="font-weight:bold;">
      <td width="50" align="center">No</td>
      <td width="100" align="center">No. Akun</td>
      <td align="center">Nama Akun</td>
      <td width="90" align="center">Debit</td>
      <td width="90" align="center">Kredit</td>
    </tr>
	<?php
	$i=1;
	while($data = mysql_fetch_array($q))
	{
		$ma_kode=$data['MA_KODE'];
		$ma_nama=$data['MA_NAMA'];
		$ccrv=$data['CC_RV_KSO_PBF_UMUM'];
		$ccrv_kso_pbf_id=$data['CC_RV_KSO_PBF_UMUM_ID'];
		//echo $ccrv;
		switch($ccrv){
			case 1:
				$sqlccrv="SELECT * FROM ak_ms_unit WHERE tipe=1 AND id=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["nama"];
				break;
			case 2:
				$sqlccrv="SELECT * FROM $dbbilling.b_ms_kso WHERE id=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["nama"];
				break;
			case 3:
				$sqlccrv="SELECT * FROM $dbapotek.a_pbf WHERE PBF_ID=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["PBF_NAMA"];
				break;
			case 4:
				$sqlccrv="SELECT * FROM $dbaset.as_ms_rekanan WHERE idrekanan=".$ccrv_kso_pbf_id;
				$rsccrv=mysql_query($sqlccrv);
				$rwccrv=mysql_fetch_array($rsccrv);
				$ma_nama .=" - ".$rwccrv["namarekanan"];
				break;
		}
	?>
   <tr>
      <td align="center">&nbsp;<?=$i;?></td>
     <td align="center">&nbsp;<?=$ma_kode;?></td>
      <td>&nbsp;<?=$ma_nama;?></td>
     <td align="right">&nbsp;<?=number_format($data['DEBIT'],0,",",".");?></td>
      <td align="right">&nbsp;<?=number_format($data['KREDIT'],0,",",".");?></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<br />
<table width="1000" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td width="500">&nbsp;</td>
    <td width="125" align="center">Penerima</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>Bukti :&nbsp;<input type="checkbox" />&nbsp;Terlampir&nbsp;<input type="checkbox" />&nbsp;Tidak Ada</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Dibukukan </td>
    <td align="center">Disetujui</td>
    <td align="center">Diperiksa</td>
    <td align="center">Diajukan</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">Akuntansi</td>
    <td>&nbsp;</td>
    <td align="center">Bendahara Pengeluaran</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php
}
else if($tipe=='5')
{
$nBukti="BMM ".$kw;
?>
  <p>&nbsp;</p>
<html>
<head>
<title>BUKTI MEMORIAL</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<table width="1000" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><strong><?=$nRS;?></strong></td>
      <td width="30"></td>
      <td width="69"></td>
      <td width="228"></td>
    </tr>
    <tr>
      <td colspan="2"><strong><?=$nAlamatRS;?></strong></td>
      <td></td>
      <td><strong>No Bukti</strong></td>
      <td><strong>: <?php echo $nBukti; ?></strong></td>
    </tr>
    <tr>
      <td width="327"></td>
      <td width="341"></td>
      <td></td>
      <td></td>
      <td></td>
      <td width="1"></td>
      <td width="1"></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2">&nbsp;</td>
      <td><strong>Tanggal</strong></td>
      <td><strong>: <?=$tgl2;?></strong></td>
    </tr>
    <tr>
      <td></td>
      <td colspan="2"><strong>BUKTI MEMORIAL</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td width="1"></td>
    </tr>
    
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
</table>
<p>&nbsp;</p>
<table width="1000" cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse" bordercolor="#000000">
    <tr style="font-weight:bold;">
      <td width="50" align="center">No</td>
      <td width="100" align="center">No. Akun</td>
      <td align="center">Nama Akun</td>
      <td width="90" align="center">Debit</td>
      <td width="90" align="center">Kredit</td>
    </tr>
	<?php
	$i=1;
	while($data = mysql_fetch_array($q))
	{
		$ma_kode=$data['MA_KODE'];
		$ma_nama=$data['MA_NAMA'];
	?>
   <tr>
      <td align="center">&nbsp;<?=$i;?></td>
     <td align="center">&nbsp;<?=$ma_kode;?></td>
      <td>&nbsp;<?=$ma_nama;?></td>
     <td align="right">&nbsp;<?=number_format($data['DEBIT'],0,",",".");?></td>
      <td align="right">&nbsp;<?=number_format($data['KREDIT'],0,",",".");?></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<br />
<table width="1000" border="0" cellpadding="1" cellspacing="0">
<tr>
	<td width="500">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td width="125">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">Dibukukan</td>
    <td align="center">Diperiksa</td>
    <td align="center">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td height="50">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">Akuntansi</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
<?php
}
?>
<p>&nbsp;</p>
  <p align="center"><BUTTON type="button" onClick="this.style.display='none';window.print();window.close();" style="cursor:pointer;"><IMG SRC="../icon/contact-us.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Print</BUTTON></p>
</body>
</html>