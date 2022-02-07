<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Kunjungan Pasien</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_pelayanan.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="6"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="6" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Kunjungan <?php echo $rwUnit1['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;<b>Penjamin Pasien: <?php if($rwKso['nama']=='') echo "Semua"; else echo $rwKso['nama'];?></b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right" height="30"><b>Yang Mencetak :&nbsp;<?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr height="30" style="font-size:12px; font-weight:bold;">
    <td width="15%" style="border-top:1px solid;">&nbsp;Janis Layanan</td>
    <td width="20%" style="border-top:1px solid;">&nbsp;Tempat Layanan</td>
    <td width="15%" style="border-top:1px solid;">&nbsp;</td>
    <td width="15%" align="right" style="border-top:1px solid;">Kunjungan Baru</td>
    <td width="15%" align="right" style="border-top:1px solid;">Kunjungan Lama</td>
    <td width="20%" align="right" style="border-top:1px solid;">Total&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td style="border-top:1px solid;">&nbsp;<b><?php echo $rwUnit1['nama'] ?></b></td>
    <td style="border-top:1px solid;">&nbsp;</td>
    <td style="border-top:1px solid;">&nbsp;</td>
    <td style="border-top:1px solid;">&nbsp;</td>
    <td style="border-top:1px solid;">&nbsp;</td>
    <td style="border-top:1px solid;">&nbsp;</td>
  </tr>
  <?php
		if($_REQUEST['StatusPas']!=0){
			$fKso = " AND b_pelayanan.kso_id = ".$_REQUEST['StatusPas'];
		}
		if($_REQUEST['TmpLayanan']==0)
		{
			$sqlKunj = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit
						WHERE b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."'
						GROUP BY b_ms_unit.nama";
			$rsKunj = mysql_query($sqlKunj);
		}
		else
		{
			$sqlKunj = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit
						WHERE b_ms_unit.id = '".$_REQUEST['TmpLayanan']."' 
						GROUP BY b_ms_unit.nama";
			$rsKunj = mysql_query($sqlKunj);
		}
		$jmlBr = 0;
		$jmlLm = 0;
		while($rwKunj = mysql_fetch_array($rsKunj))
		{
			
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;<?php echo $rwKunj['nama'] ?></td>
    <td>&nbsp;</td>
	<?php
		$qBr = "SELECT COUNT(b_pelayanan.pasien_id) AS jml 
		FROM b_kunjungan 
		INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
		WHERE b_kunjungan.isbaru = 1 
		AND b_pelayanan.unit_id = '".$rwKunj['id']."' $waktu $fKso GROUP BY b_pelayanan.unit_id";
		$sBr = mysql_query($qBr);
		$wBr = mysql_fetch_array($sBr);
	?>
    <td style="text-align:right; padding-right:20px;"><?php if($wBr['jml']=='') echo 0; else echo $wBr['jml']; ?></td>
	<?php
		$qLm = "SELECT COUNT(b_pelayanan.pasien_id) AS jml 
		FROM b_kunjungan 
		INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
		WHERE b_kunjungan.isbaru = 0  
		AND b_pelayanan.unit_id = '".$rwKunj['id']."' $waktu $fKso GROUP BY b_pelayanan.unit_id";
		$sLm = mysql_query($qLm);
		$wLm = mysql_fetch_array($sLm);
	?>
    <td style="text-align:right; padding-right:20px;"><?php if($wLm['jml']=='') echo 0; else echo $wLm['jml']; ?></td>
    <td align="right"><?php echo $wBr['jml']+$wLm['jml']; ?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <?
  			$jmlBr = $jmlBr + $wBr['jml'];
			$jmlLm = $jmlLm + $wLm['jml'];
		}
		mysql_free_result($sBr);
		mysql_free_result($sLm);	
		mysql_free_result($rsKunj);
  ?>
  <tr><td colspan="6">&nbsp;</td></tr>
  <tr style="font-weight:bold;" height="30">
  	<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
	<td style="border-top:1px solid; border-bottom:1px solid;">&nbsp;</td>
	<td style="border-top:1px solid; border-bottom:1px solid;" align="right">Total&nbsp;&nbsp;&nbsp;</td>
	<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:20px;"><?php echo $jmlBr; ?></td>
	<td style="border-top:1px solid; border-bottom:1px solid; text-align:right; padding-right:20px;"><?php echo $jmlLm; ?></td>
	<td style="border-top:1px solid; border-bottom:1px solid;" align="right"><?php echo $jmlBr+$jmlLm; ?>&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="3" align="right"><?php echo 'Tgl Cetak:&nbsp;'.$date_now.'&nbsp;Jam:&nbsp;'.$jam;?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="6" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr><td colspan="6">&nbsp;</td></tr>
  <tr id="trTombol">
        <td class="noline" align="center" colspan="6">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsKso);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
<script type="text/JavaScript">
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
	}
}
</script>
</body>
</html>