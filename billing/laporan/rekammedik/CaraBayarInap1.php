<title>.: Laporan Cara Bayar - Rawat Inap :.</title>
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
		$waktu = " and MONTH(b_tindakan_kamar.tgl_out) = '$tglAwal[1]' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(b_tindakan_kamar.tgl_out) = '$bln' and year(b_tindakan_kamar.tgl_out) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and b_tindakan_kamar.tgl_out between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$jnsLayanan = $_REQUEST['JnsLayanan'];
	$tmpLayanan = $_REQUEST['TmpLayanan'];
	$stsPas = $_REQUEST['StatusPas'];
	
	$qTmp = "SELECT id, nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	$rsTmp = mysql_query($qTmp);
	$rwTmp = mysql_fetch_array($rsTmp);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
?>
<style>
	.jdl
	{
		border-top:1px solid;
		border-bottom:1px solid;
		border-left:1px solid;
	}
	.jdlkn
	{
		border-top:1px solid;
		border-bottom:1px solid;
		border-left:1px solid;
		border-right:1px solid;
	}
	.isi
	{
		border-bottom:1px solid;
		border-left:1px solid;
	}
	.isikn
	{
		border-bottom:1px solid;
		border-left:1px solid;
		border-right:1px solid;
	}
</style>
<table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td valign="top" height="70" style="text-transform:uppercase; text-align:center; font-weight:bold; font-size:14px;">laporan cara bayar rawat inap<br><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td style="font-weight:bold" height="30">&nbsp;Tempat Layanan : <?php echo $rwTmp['nama']; ?></td>
	</tr>
	<tr>
		<td>
			<table width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="text-align:center">
					<td rowspan="3" class="jdl">TGL</td>
					<td colspan="8" class="jdl">Jumlah Pasien</td>
					<td rowspan="3" class="jdl">TOTAL</td>
					<td colspan="8" class="jdl">Jumlah Lama Dirawat</td>
					<td rowspan="3" class="jdlkn">TOTAL</td>
				</tr>
				<tr style="text-align:center">
					<td rowspan="2" class="isi">Umum</td>
					<td colspan="2" class="isi">ASKES</td>
					<td colspan="2" class="isi">JAMKESMAS</td>
					<td colspan="2" class="isi">JPKM</td>
					<td rowspan="2" class="isi">KSO lain</td>
					<td rowspan="2" class="isi">Umum</td>
					<td colspan="2" class="isi">ASKES</td>
					<td colspan="2" class="isi">JAMKESMAS</td>
					<td colspan="2" class="isi">JPKM</td>
					<td rowspan="2" class="isi">KSO lain</td>
				</tr>
				<tr style="text-align:center">
					<td class="isi">Sos/PNS</td>
					<td class="isi">Koms/Swas</td>
					<td class="isi">DB</td>
					<td class="isi">NON DB</td>
					<td class="isi">TC</td>
					<td class="isi">Jamsostek</td>
					<td class="isi">Sos/PNS</td>
					<td class="isi">Koms/Swas</td>
					<td class="isi">DB</td>
					<td class="isi">NON DB</td>
					<td class="isi">TC</td>
					<td class="isi">Jamsostek</td>
				</tr>
				<?php
					$sql = "SELECT t.d
						FROM
							(SELECT b_pelayanan.pasien_id, DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS d
							FROM b_pelayanan
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."' $waktu) AS t
						GROUP BY t.d ORDER BY t.d";
					$rs = mysql_query($sql);
					$col = 0;
					while($row=mysql_fetch_array($rs))
					{
						$col++;
						$qUmum = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '1' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsUmum = mysql_query($qUmum);
						$rwUmum = mysql_fetch_array($rsUmum);
						
						$qPns = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '4' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsPns = mysql_query($qPns);
						$rwPns = mysql_fetch_array($rsPns);
						
						$qKom = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '6' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsKom = mysql_query($qKom);
						$rwKom = mysql_fetch_array($rsKom);
						
						$qDb = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '38' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsDb = mysql_query($qDb);
						$rwDb = mysql_fetch_array($rsDb);
						
						$qNon = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '39' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsNon = mysql_query($qNon);
						$rwNon = mysql_fetch_array($rsNon);
						
						$qTc = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '16' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsTc = mysql_query($qTc);
						$rwTc = mysql_fetch_array($rsTc);
						
						$qJam = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND b_kunjungan.kso_id = '2' $waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsJam = mysql_query($qJam);
						$rwJam = mysql_fetch_array($rsJam);
						
						$qLain = "SELECT COUNT(tt.pasien_id) AS jml, SUM(tt.lama) AS lama FROM (SELECT t.pasien_id, t.tgl_in, t.tgl_out, t.keluar, DATEDIFF(t.tgl_out, t.tgl_in) AS lama
							FROM (SELECT b_pelayanan.pasien_id, DATE(b_tindakan_kamar.tgl_in) AS tgl_in, 
							DATE(b_tindakan_kamar.tgl_out) AS tgl_out,
							DATE_FORMAT(b_tindakan_kamar.tgl_out,'%d') AS keluar
							FROM b_kunjungan
							INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
							INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
							INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
							WHERE b_pelayanan.unit_id = '".$tmpLayanan."'
							AND (b_kunjungan.kso_id <> '1' AND b_kunjungan.kso_id <> '4' AND b_kunjungan.kso_id <> '6'
							AND b_kunjungan.kso_id <> '38' AND b_kunjungan.kso_id <> '39' AND b_kunjungan.kso_id <> '16' AND b_kunjungan.kso_id <> '2')
							$waktu
							GROUP BY b_pelayanan.pasien_id ORDER BY b_tindakan_kamar.tgl_out) AS t
							WHERE t.keluar = '".$row['d']."') AS tt";
						$rsLain = mysql_query($qLain);
						$rwLain = mysql_fetch_array($rsLain);
						
						mysql_free_result($rsUmum);
						mysql_free_result($rsPns);
						mysql_free_result($rsKom);
						mysql_free_result($rsDb);
						mysql_free_result($rsNon);
						mysql_free_result($rsTc);
						mysql_free_result($rsJam);
						mysql_free_result($rsLain);
			      
				?>
				<tr>
					<td class="isi" align="center" width="4%"><?php echo $row['d'];?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php echo $rwUmum['jml']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php echo $rwPns['jml']?></td>
					<td class="isi" width="6%" style="text-align:right; padding-right:20px;"><?php echo $rwKom['jml']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php echo $rwDb['jml']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php echo $rwNon['jml']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php echo $rwTc['jml']?></td>
					<td class="isi" width="6%" style="text-align:right; padding-right:20px;"><?php echo $rwJam['jml']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php echo $rwLain['jml']?></td>
					<?php
						$total1 = $rwUmum['jml'] + $rwPns['jml'] + $rwKom['jml'] + $rwDb['jml'] + $rwNon['jml'] + $rwTc['jml'] + $rwJam['jml'] + $rwLain['jml'];
					?>
					<td class="isi" width="6%" style="text-align:right; padding-right:20px;"><?php echo $total1;?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php if($rwUmum['lama']=='') echo 0; else echo $rwUmum['lama']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php if($rwPns['lama']=='') echo 0; else echo $rwPns['lama']?></td>
					<td class="isi" width="6%" style="text-align:right; padding-right:20px;"><?php if($rwKom['lama']=='') echo 0; else echo $rwKom['lama']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php if($rwDb['lama']=='') echo 0; else echo $rwDb['lama']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php if($rwNon['lama']=='') echo 0; else echo $rwNon['lama']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php if($rwTc['lama']=='') echo 0; else echo $rwTc['lama']?></td>
					<td class="isi" width="6%" style="text-align:right; padding-right:20px;"><?php if($rwJam['lama']=='') echo 0; else echo $rwJam['lama']?></td>
					<td class="isi" width="5%" style="text-align:right; padding-right:20px;"><?php if($rwLain['lama']=='') echo 0; else echo $rwLain['lama']?></td>
					<?php
						$total2 = $rwUmum['lama'] + $rwPns['lama'] + $rwKom['lama'] + $rwDb['lama'] + $rwNon['lama'] + $rwTc['lama'] + $rwJam['lama'] + $rwLain['lama'];
					?>
					<td class="isikn" width="6%" style="text-align:right; padding-right:20px;"><?php echo $total2;?></td>
				</tr>
				<?php
					} mysql_free_result($rs);
				?>
			</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td style="text-align:right; height:70" valign="top">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;<br>Yang Mencetak,</td>
	</tr>
	<tr>
		<td style="text-align:right; font-weight:bold;"><?php echo $rwPeg['nama']?>&nbsp;</td>
	</tr>
	<tr id="trTombol">
        <td class="noline" align="center">
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
		<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
	</tr>
</table>
<?php
	mysql_free_result($rsTmp);
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
