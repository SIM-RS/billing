<?php
session_start();
include("../../sesi.php");
?>
<title>.:Rekapitulasi Pasien Keluar :.</title>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND (DATE(b_kunjungan.tgl_pulang) = '$tglAwal2' OR DATE(b_pelayanan.tgl_krs) = '$tglAwal2')";
		//$waktu = " AND DATE(b_tindakan_kamar.tgl_out) = '$tglAwal2'";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND ((month(b_kunjungan.tgl_pulang) = '$bln' and year(b_kunjungan.tgl_pulang) = '$thn') OR  (month(b_pelayanan.tgl_krs) = '$bln' and year(b_pelayanan.tgl_krs) = '$thn'))";
		//$waktu = " AND (month(b_tindakan_kamar.tgl_out) = '$bln' and year(b_tindakan_kamar.tgl_out) = '$thn')";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and ((DATE(b_kunjungan.tgl_pulang) between '$tglAwal2' and '$tglAkhir2') OR (DATE(b_pelayanan.tgl_krs) between '$tglAwal2' and '$tglAkhir2'))  ";
		//$waktu = " and DATE(b_tindakan_kamar.tgl_out) between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$jnsLayanan = $_REQUEST['JnsLayananInapSaja'];
	$tmpLayanan = $_REQUEST['TmpLayananInapSaja'];
	$stsPas = $_REQUEST['StatusPas'];
		
	if($stsPas!=0){
		$fKso = "AND b_kunjungan.kso_id = '".$stsPas."'";
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLayanan."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id = '".$stsPas."'";
	$rsKso = mysql_query($qKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">laporan pasien keluar - <?php echo $rwUnit1['nama'];?><br>tempat layanan - <?php if($tmpLayanan==0) echo "SEMUA"; else echo $rwUnit2['nama']?><br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="font-weight:bold; text-align:center">
					<td width="5%" height="30" style="border-top:1px solid; border-bottom:1px solid;">No</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Tgl MRS</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Tgl KRS</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No RM</td>
					<td width="25%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
					<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Tindakan</td>
					<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Jmlh<br>Tindakan</td>
					<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Bayar</td>
				</tr>
				<?php
						if($tmpLayanan==0){
							$fUnit = "b_ms_unit.parent_id = '".$jnsLayanan."'";
						}else{
							$fUnit = "b_ms_unit.id = '".$tmpLayanan."'";
						}
						if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id = '".$stsPas."'";
						$qTmp = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit INNER JOIN b_pelayanan ON b_pelayanan.unit_id = b_ms_unit.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id WHERE $fUnit AND (b_kunjungan.pulang = '1' OR b_pelayanan.dilayani = '2') $waktu $fKso GROUP BY b_ms_unit.id ORDER BY b_ms_unit.nama ";
						$rsTmp = mysql_query($qTmp);
						while($rwTmp = mysql_fetch_array($rsTmp))
						{
				?>
				<tr>
					<td colspan="8" style="padding-left:10px; text-transform:uppercase; text-decoration:underline; font-weight:bold;"><?php echo $rwTmp['nama']?></td>
				</tr>
				<?php
						$qSts = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_ms_kso INNER JOIN b_kunjungan ON b_kunjungan.kso_id = b_ms_kso.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.unit_id = '".$rwTmp['id']."' $waktu AND (b_kunjungan.pulang = '1' OR b_pelayanan.dilayani = '2') $fKso GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";
						$rsSts = mysql_query($qSts);
						while($rwSts = mysql_fetch_array($rsSts))
						{
				?>
				<tr>
					<td colspan="8" style="padding-left:50px; text-transform:uppercase; font-weight:bold;"><?php echo $rwSts['nama']?></td>
				</tr>
				<?php
						$sql = "SELECT b_pelayanan.id AS pelayanan_id, b_ms_pasien.id, b_ms_pasien.nama, b_ms_pasien.no_rm, DATE_FORMAT(b_tindakan_kamar.tgl_in,'%d-%m-%Y') AS mrs, b_kunjungan.tgl_pulang, b_kunjungan.pulang, b_pelayanan.dilayani, DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d-%m-%Y') AS krs FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id = b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id LEFT JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.unit_id = '".$rwTmp['id']."' AND b_kunjungan.kso_id = '".$rwSts['id']."' AND (b_kunjungan.pulang = '1' OR b_pelayanan.dilayani = '2') $waktu GROUP BY b_pelayanan.id";
						$rs = mysql_query($sql);
						$no = 1;
						while($rw = mysql_fetch_array($rs))
						{
							$sqlKam = "SELECT t.kamar, t.tarip, t.qty, (t.tarip*t.qty) AS bayar FROM(SELECT b_tindakan_kamar.nama AS kamar, b_tindakan_kamar.tarip, DATEDIFF(DATE(b_tindakan_kamar.tgl_out), DATE(b_tindakan_kamar.tgl_in)) AS qty FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id WHERE b_pelayanan.id = '".$rw['pelayanan_id']."' AND (b_kunjungan.pulang = '1' OR b_pelayanan.dilayani = '2') $waktu) AS t";
							$rsKam = mysql_query($sqlKam);
							$rwKam = mysql_fetch_array($rsKam);
							mysql_free_result($rsKam);
				?>
				<tr>
					<td style="text-align:center"><?php echo $no;?></td>
					<td style="text-align:center"><?php echo $rw['mrs']?></td>
					<td style="text-align:center"><?php echo $rw['krs']?></td>
					<td style="text-align:center"><?php echo $rw['no_rm']?></td>
					<td colspan="2" style="text-transform:uppercase;"><?php echo $rw['nama']?></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td colspan="2" style="padding-left:10px; text-transform:uppercase;"><?php echo $rwKam['kamar'];?></td>
					  <td style="text-align:center"><?php echo $rwKam['qty'].'&nbsp;Hari';?></td>
					  <td style="text-align:right; padding-right:30px;"><?php echo number_format($rwKam['bayar'],0,",",".")?></td>
			  	</tr>
				<?php
						$qT = "SELECT t.id, t.tindakan, t.nama, COUNT(t.id) AS jml, SUM(t.biaya) AS total FROM (SELECT b_ms_tindakan.id, b_ms_tindakan.nama AS tindakan, b_ms_pegawai.nama, b_tindakan.biaya, b_tindakan.qty, (b_tindakan.biaya*b_tindakan.qty) AS bayar FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_tindakan.user_id INNER JOIN b_kunjungan ON b_kunjungan.id = b_pelayanan.kunjungan_id WHERE b_pelayanan.id = '".$rw['pelayanan_id']."' AND (b_kunjungan.pulang = '1' OR b_pelayanan.dilayani = '2')) AS t GROUP BY t.id, t.nama";
						$rsT = mysql_query($qT);
						$sub = 0;
						while($rwT = mysql_fetch_array($rsT))
						{
							
				?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2" style="text-transform:uppercase;"><?php echo $rwT['tindakan'].'&nbsp;-&nbsp;'.$rwT['nama']?></td>
					<td style="text-align:center"><?php echo $rwT['jml']?></td>
					<td style="text-align:right; padding-right:30px;"><?php echo number_format($rwT['total'],0,",",".");?></td>
				</tr>
				<?php
						$sub = $sub + $rwT['total'];
						} mysql_free_result($rsT);
				?>
				<tr>
					<td colspan="7" style="text-align:right">Subtotal&nbsp;</td>
					<td style="text-align:right; padding-right:30px; border-top:1px solid;"><?php echo number_format($sub+$rwKam['bayar'],0,",",".");?></td>
				</tr>
				<?php
						$no++;
						} mysql_free_result($rs);
						} mysql_free_result($rsSts);
						} mysql_free_result($rsTmp);
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr id="trTombol">
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
<script type="text/JavaScript">
	
	function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
	window.print();
	window.close();
	}
}
    
</script>