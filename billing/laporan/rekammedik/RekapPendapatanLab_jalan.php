<?php
session_start();
include("../../sesi.php");
?>
<title>.: Laporan Pendapatan dan Jumlah Penderita :.</title>
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
	
    $jnsLay = $_REQUEST['JnsLayanan'];
    $tmpLay = $_REQUEST['TmpLayanan'];
    $stsPas = $_REQUEST['StatusPas'];
	if($stsPas!=0)
	{
		$fKso = " AND b_kunjungan.kso_id = '".$stsPas."'";
	}
	
    $sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
    $rsUnit1 = mysql_query($sqlUnit1);
    $rwUnit1 = mysql_fetch_array($rsUnit1);

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);

    $sqlKso = "SELECT id,nama from b_ms_kso where id = '".$stsPas."'";
    $rsKso = mysql_query($sqlKso);
    $rwKso = mysql_fetch_array($rsKso);

    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="700" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
	<tr>
		<td height="70" valign="top" style="font-size:14px; font-weight:bold; text-align:center; text-transform:uppercase;">laporan pendapatan dan jumlah penderita<br>Status Pasien <?php echo $rwKso['nama'];?><br /><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td height="30">&nbsp;<b>Asal Tempat Layanan Rawat Jalan </b></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:9px;">
				<tr>
					<td rowspan="2" style="text-align:center; border-top:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">NO</td>
					<td rowspan="2" style="text-align:center; border-top:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">CARA BAYAR</td>
					<?php
							$sql = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
WHERE (b_ms_unit.inap = '0' OR b_ms_unit.id = '72' OR b_ms_unit.id = '112') 
AND b_pelayanan.unit_id = '".$tmpLay."' $waktu 
GROUP BY b_ms_unit.id
ORDER BY b_ms_unit.nama";
							$rs = mysql_query($sql);
							$col = 0;
							while($rw = mysql_fetch_array($rs))
							{
								$col++;
					?>
					<td colspan="2" style="text-align:center; font-size:9px; font-weight:bold; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;"><?php echo $rw['nama']?></td>
					<?php
							}
					?>
					<td colspan="2" style="text-align:center; font-size:14px; font-weight:bold; border-bottom:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000;">&sum;</td>
				</tr>
				<tr>
					<?php
				 		 for($i=0; $i<$col; $i++){
					?>
					<td style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">PX</td>
					<td style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;">(Rp.)</td>
					<?php
						}
					?>
					<td style="text-align:center; font-weight:bold; border-bottom:1px solid #000000; border-right:1px solid #000000;">PX</td>
					<td style="text-align:center; font-weight:bold; border-bottom:1px solid #000000; border-right:1px solid #000000;">(Rp.)</td>
				</tr>
				<?php
						$qSts = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id
INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
WHERE b_pelayanan.unit_id = '".$tmpLay."' $waktu AND b_ms_unit.inap = '0' $fKso
GROUP BY b_ms_kso.id
ORDER BY b_ms_kso.nama";
						$rsSts = mysql_query($qSts);
						$no = 1;
						while($rwSts = mysql_fetch_array($rsSts))
						{
							$totpx = 0;
							$totrp = 0;
							
				?>
				<tr>
					<td width="5" style="text-align:center; border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $no;?></td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;<?php echo $rwSts['nama']?></td>
					<?php
				 			$rs = mysql_query($sql);
							$j=0;
							while($rw = mysql_fetch_array($rs))
							{
								if($rwSts['id']!=1){
								$sqlQ = "SELECT COUNT(t.p) AS px, SUM(t.jml) AS rp, SUM(t.biaya) AS umum 
	FROM(SELECT b_pelayanan.pasien_id AS p, b_tindakan.biaya_kso AS jml, b_tindakan.biaya_pasien AS biaya
	FROM b_pelayanan
	INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
	WHERE b_tindakan.kso_id = '".$rwSts['id']."' AND b_pelayanan.unit_id_asal = '".$rw['id']."' AND b_pelayanan.unit_id = '".$tmpLay."' $waktu
	GROUP BY b_pelayanan.pasien_id) AS t";
								}else{
								$sqlQ = "SELECT COUNT(t.p) AS px, SUM(t.jml) AS rp
	FROM(SELECT b_pelayanan.pasien_id AS p, b_tindakan.biaya_pasien AS jml
	FROM b_pelayanan
	INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
	WHERE b_tindakan.kso_id = '".$rwSts['id']."' AND b_pelayanan.unit_id_asal = '".$rw['id']."' AND b_pelayanan.unit_id = '".$tmpLay."' $waktu
	GROUP BY b_pelayanan.pasien_id) AS t";
								}
								$rsQ = mysql_query($sqlQ);
								$rwQ = mysql_fetch_array($rsQ);
								$totpx = $totpx + $rwQ['px'];
								$totrp = $totrp + $rwQ['rp'];
								$px[$j] += $rwQ['px']; 
							 	$rp[$j] += $rwQ['rp'];
								$j++;
						
							 
					?>
					<td width="20" style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:center"><?php if($rwQ['px']=="") echo 0; else echo $rwQ['px']; ?></td>
					<td width="50" style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:right"><?php if($rwQ['rp']=="") echo 0; else echo number_format($rwQ['rp'],0,",",".");?>&nbsp;</td>
					<?php
							} mysql_free_result($rs);
							$totalpx += $totpx;
							$totalrp += $totrp;
					?>
					<td width="20" style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:center"><?php echo $totpx;?></td>
					<td width="50" style="border-bottom:1px solid #000000; border-right:1px solid #000000; text-align:right"><?php echo number_format($totrp,0,",",".");?>&nbsp;</td>
				</tr>
				<?php
						$no++;
						}mysql_free_result($rsSts);
				?>
				<tr>
					<td colspan="2" style="text-align:right; font-weight:bold; border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;" height="30">TOTAL&nbsp;</td>
					<?php
				  			for($i=0; $i<$col; $i++){
					?>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:center; font-weight:bold;"><?php echo $px[$i];?></td>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:right; font-weight:bold;"><?php echo number_format($rp[$i],0,",",".");?>&nbsp;</td>
					<?php
							}
					?>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:center; font-weight:bold;"><?php echo $totalpx;?></td>
					<td style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:right; font-weight:bold;"><?php echo number_format($totalrp,0,",",".");?>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
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