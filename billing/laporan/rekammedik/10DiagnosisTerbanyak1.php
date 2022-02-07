<?php
	include("../../sesi.php");
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");

	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];

	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and b_diagnosa_rm.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_diagnosa_rm.tgl) = '$bln' and year(b_diagnosa_rm.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_diagnosa_rm.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}

	if($_REQUEST['cmbJenisLayanan']==0){
		$jnslay = "RAWAT JALAN";
	}else{
		$jnslay = "RAWAT INAP";
	}
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbJenisLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['cmbTempatLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>15 Diagnosis Terbanyak Pasien</title>
</head>

<body>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase"><b>Laporan 15 Diagnosis Terbanyak Pasien <?php echo $jnslay ?> - <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
	</tr>
	<tr>
		<td height="30" width="50%"><b>Penjamin Pasien: <?php if($rwKso['id']==0) echo "Semua"; else echo $rwKso['nama'];?></b></td>
		<td height="30" width="50%" align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr height="30">
					<td width="5%" height="28" style="border-top:1px solid #663399; border-bottom:1px solid #663399; font-weight:bold;">&nbsp;No</td>
					<td width="10%" style="border-top:1px solid #663399; border-bottom:1px solid #663399; font-weight:bold;">&nbsp;ICD X</td>
					<td style="border-top:1px solid #663399; border-bottom:1px solid #663399; font-weight:bold;">&nbsp;Diagnosis</td>
					<td width="20%" align="right" style="border-top:1px solid #663399; border-bottom:1px solid #663399; font-weight:bold;">Jumlah&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<?php
					if($_REQUEST['StatusPas']!=0)
						$fKso = " AND b_pelayanan.kso_id = ".$_REQUEST['StatusPas'];
					if($_REQUEST['cmbTempatLayanan']==0){
						$fUnit = " b_ms_unit.inap = '".$_REQUEST['cmbJenisLayanan']."'";
					}else{
						$fUnit = " b_pelayanan.unit_id = '".$_REQUEST['cmbTempatLayanan']."' ";
					}
				
				$sqlDiag = "SELECT b_diagnosa_rm.diagnosa_id, b_ms_diagnosa.nama, b_ms_diagnosa.kode,
					COUNT(b_diagnosa_rm.pelayanan_id) AS jml
					FROM b_ms_diagnosa
					INNER JOIN b_diagnosa_rm ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
					INNER JOIN b_pelayanan ON b_pelayanan.id = b_diagnosa_rm.pelayanan_id
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE $fUnit $fKso $waktu GROUP BY b_ms_diagnosa.id
					ORDER BY jml DESC, nama LIMIT 15";
					$rsDiag = mysql_query($sqlDiag);
					$no = 1;
					$jml = 0;
					//echo $sqlDiag;
					while($rwDiag = mysql_fetch_array($rsDiag))
					{
						$qtot = "SELECT COUNT(b_diagnosa_rm.pelayanan_id) AS tot FROM b_pelayanan 
							INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
							INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id 
							WHERE $fUnit $fKso $waktu";
						$stot = mysql_query($qtot);
						$wtot = mysql_fetch_array($stot);
				?>
				<tr>
					<td height="20">&nbsp;<?php echo $no; ?></td>
					<td>&nbsp;<?php echo $rwDiag['kode']; ?></td>
					<td style="text-transform:uppercase">&nbsp;<?php echo $rwDiag['nama']; ?></td>
					<td align="right" style="padding-right:20px"><?php echo $rwDiag['jml']; ?></td>
				</tr>
				<?php
					$no++;
					$jml = $jml + $rwDiag['jml'];
					}mysql_free_result($rsDiag);
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td height="25" style="padding-right:20px; text-align:right; font-weight:bold;">Jumlah</td>
					<td style="padding-right:20px; text-align:right; font-weight:bold; border-top:1px solid #999999;"><?php echo $jml?></td>
				</tr>
				<?php 
					$sisa = $wtot['tot'] - $jml;
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td height="25" style="padding-right:20px; text-align:right; font-weight:bold;">Sisa</td>
					<td style="padding-right:20px; text-align:right; font-weight:bold;"><?php echo $sisa?></td>
				</tr>
				<tr>
					<td style="border-top:2px solid #999999;">&nbsp;</td>
					<td style="border-top:2px solid #999999;">&nbsp;</td>
					<td height="25" style="padding-right:20px; text-align:right; font-weight:bold; border-top:2px solid #999999;">Total</td>
					<td style="padding-right:20px; text-align:right; font-weight:bold; border-top:2px solid #999999;"><?php echo $wtot['tot'];?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="right">Yang Mencetak</td>
	</tr>
	<tr>
		<td colspan="2" height="50" valign="bottom" align="center">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
	</tr>
	<tr id="trTombol">
		<td class="noline" align="center" colspan="5">
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
		<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
	</tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
		/* try{
		mulaiPrint();
		}
		catch(e){
		window.print();
		} */
		window.print();
		window.close();
	}
}
</script>