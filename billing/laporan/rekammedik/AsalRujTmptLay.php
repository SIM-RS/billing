<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="AsalRujTmptLay.xls"');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Asal Rujukan Pasien Berdasarkan Tempat Layanan</title>
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
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan Asal Rujukan Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br />Berdasarkan Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td align="right"><b>Yang Mencetak :&nbsp;<?php echo $rwPeg['nama'];?></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><b><?php echo 'Tgl Cetak:&nbsp;'.$date_now.'&nbsp;Jam:&nbsp;'.$jam?></b></td>
  </tr>
  <tr>
  	<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td>&nbsp;</td>
				<td colspan="2">&nbsp;JUMLAH/DETIL ASAL RUJUKAN</td>
			  </tr>
			  <tr>
				<td width="100" height="28">&nbsp;TEMPAT LAYANAN</td>
			  <?php
					if($_REQUEST['StatusPas']!=0){
						$fKso = " AND b_kunjungan.kso_id = ".$_REQUEST['StatusPas'];
					}
					if($_REQUEST['TmpLayanan']!=0){
						$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['TmpLayanan']."'";
					}
					else{
						$fUnit = " b_pelayanan.jenis_layanan = '".$_REQUEST['JnsLayanan']."'";
					}
					$sql = "SELECT b_kunjungan.asal_kunjungan, b_ms_asal_rujukan.nama, 
							b_ms_asal_rujukan.id
							FROM b_kunjungan
							INNER JOIN b_ms_asal_rujukan ON 
							b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							WHERE $fUnit $fKso $waktu
							GROUP BY b_ms_asal_rujukan.nama";
					$rs = mysql_query($sql);
					$col = 0;
					while($rw = mysql_fetch_array($rs))
					{
						$col++;
			  ?>
				<td width="80" style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php echo $rw['nama']?>&nbsp;</td>
				<?php }?>
				<td width="80" style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid;">TOTAL&nbsp;</td>
			  </tr>
			  <?php
			  		if($_REQUEST['TmpLayanan']!=0){
						$qTmp = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit 
							WHERE b_ms_unit.id = '".$_REQUEST['TmpLayanan']."'";
						$rsTmp = mysql_query($qTmp);
					}else{
						$qTmp = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit 
							WHERE b_ms_unit.parent_id = '".$_REQUEST['JnsLayanan']."'";
						$rsTmp = mysql_query($qTmp);
					}
					$ttlTot = 0;
					while($rwTmp = mysql_fetch_array($rsTmp))
					{
						$tot = 0;
			  ?>
			  <tr>
				<td style="border-left:1px solid; border-top:1px solid; text-transform:uppercase" height="20">&nbsp;<?php echo $rwTmp['nama']; ?></td>
				<?php 
					$rs = mysql_query($sql);
					$j = 0;
					while($rw=mysql_fetch_array($rs))
					{
						$qJml = "SELECT COUNT(b_kunjungan.pasien_id) AS jml, 
								b_kunjungan.asal_kunjungan 
								FROM b_kunjungan 
								INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
								WHERE b_pelayanan.unit_id = '".$rwTmp['id']."' 
								AND b_kunjungan.asal_kunjungan = '".$rw['id']."' $fKso $waktu
								GROUP BY b_kunjungan.asal_kunjungan";
						$rsJml = mysql_query($qJml);
						$rwJml = mysql_fetch_array($rsJml);
						mysql_free_result($rsJml);
						$tot = $tot + $rwJml['jml'];
						$jml[$j] += $rwJml['jml'];
						$j++;
						?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right;"><?php if($rwJml['jml']=='') echo 0; else echo $rwJml['jml']; ?>&nbsp;</td>
				<?php
						}
						
						$ttlTot += $tot;
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-right:1px solid;"><?php echo $tot?>&nbsp;</td>
			  </tr>
			  <?php } mysql_free_result($rsTmp);
			  ?>
			  <tr style="font-weight:bold;">
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;" height="20">Total&nbsp;</td>
				<?php
					for($i=0; $i<$col; $i++){
				?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;"><?php echo $jml[$i];?>&nbsp;</td>
				<?php 	} ?>
				<td style="border-left:1px solid; border-top:1px solid; text-align:right; border-bottom:1px solid;  border-right:1px solid;"><?php echo $ttlTot?>&nbsp;</td>
			  </tr>
		</table>
	</td>
  </tr>
  <tr id="trTombol" height="30" valign="bottom">
        <td class="noline" align="center">
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
</body>
</html>
<script type="text/JavaScript">
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
	window.print();
	window.close();
	}
}
</script>

