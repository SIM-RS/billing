<?php
	session_start();
	include("../../koneksi/konek.php");
	include("../../sesi.php");
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	
	
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
if($_REQUEST['TmpLayanan']!='0'){
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fUnit = " AND mu.id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND mu.parent_id=".$_REQUEST['JnsLayanan'];
	
if($_REQUEST['StatusPas']!='0'){
	$sqlKso = "SELECT nama FROM b_ms_kso WHERE id=".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND k.kso_id=".$_REQUEST['StatusPas'];
}
	
	$userId = $_REQUEST['userId'];
	
?>
<title>Klaim Jaminan Berdasarkan Jenis Layanan</title>
<table width="1200" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td height="50" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td height="30" colspan="2" align="center" style="text-transform:uppercase; font-weight:bold">daftar pengajuan klaim <?php echo $rwUnit1['nama'];?><br>
	  <?=$namaRS?> untuk <?php if($_REQUEST['StatusPas']=='0') echo 'Semua'; else echo $rwKso['nama'];?><br/>
      Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></td>
	</tr>
	<tr>
		<td height="30" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="1200" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="4%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">NO</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">KAMAR<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">MAKAN<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">TINDAKAN<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">VISITE<br>(Rp.)</td>
					<td width="8%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">TRANSFER IRD<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">OPERASI<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">LABORAT<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">RAD<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">PA<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">PMI<br>(Rp.)</td>
					<td width="8%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">JUMLAH<br>(Rp.)</td>
					<td width="7%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; text-align:center">OBAT<br>(Rp.)</td>
					<td width="10%" style="border-left:2px solid; border-top:2px solid; border-bottom:2px solid; border-right:2px solid; text-align:center">JML. TINDAKAN<br>+ OBAT<br>(Rp.)</td>
				</tr>
				<?php
						$sqlJml = "SELECT (SELECT SUM(DATEDIFF(tk.tgl_out,tk.tgl_in)+1*tk.tarip) FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' AND tk.tgl_out IS NOT NULL $fKso $fUnit) AS kamar, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE (mtk.ms_tindakan_id = 742 OR mtk.ms_tindakan_id = 746 OR mtk.ms_tindakan_id = 747 OR mtk.ms_tindakan_id = 748 OR mtk.ms_tindakan_id = 749) AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS makan, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.id=mtk.ms_tindakan_id INNER	JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu on p.unit_id=mu.id WHERE mt.klasifikasi_id = 1 AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS tindakan, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.id=mtk.ms_tindakan_id INNER	JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu on p.unit_id=mu.id WHERE mt.klasifikasi_id = 13 AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS visite, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id = mtk.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
								WHERE (mtk.ms_tindakan_id = 351 OR mtk.ms_tindakan_id = 824 OR mtk.ms_tindakan_id = 1344 OR mtk.ms_tindakan_id = 1352 
								OR mtk.ms_tindakan_id = 1353 OR mtk.ms_tindakan_id = 1354 OR mtk.ms_tindakan_id = 1355 OR mtk.ms_tindakan_id = 1356 
								OR mtk.ms_tindakan_id = 1357 OR mtk.ms_tindakan_id = 1364 OR mtk.ms_tindakan_id = 1368 OR mtk.ms_tindakan_id = 1369 
								OR mtk.ms_tindakan_id = 1370 OR mtk.ms_tindakan_id = 1371 OR mtk.ms_tindakan_id = 1372 OR mtk.ms_tindakan_id = 1373 OR mtk.ms_tindakan_id = 1374) AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS operasi, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.id=mtk.ms_tindakan_id INNER	JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu on p.unit_id=mu.id WHERE mt.klasifikasi_id = 5 AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS laborat, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.id=mtk.ms_tindakan_id INNER	JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu on p.unit_id=mu.id WHERE mt.klasifikasi_id = 6 AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS rad, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.id=mtk.ms_tindakan_id INNER	JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu on p.unit_id=mu.id WHERE t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' AND t.ms_tindakan_unit_id=59 $fKso $fUnit) AS pa, 
							(SELECT SUM(tarip) FROM b_kunjungan k INNER JOIN b_pelayanan p ON p.kunjungan_id=k.id INNER JOIN b_tindakan t ON t.pelayanan_id=p.id INNER JOIN b_ms_tindakan_kelas mtk ON t.id=mtk.ms_tindakan_id INNER	JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_unit mu on p.unit_id=mu.id WHERE mt.klasifikasi_id = 7 AND t.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2' $fKso $fUnit) AS obat";
					$rsJml = mysql_query($sqlJml);
					$no = 1;
					while($rwJml = mysql_fetch_array($rsJml))
					{
						$totkamar=$totkamar+$rwJml['kamar'];
						$totmakan=$totmakan+$rwJml['makan'];
						$tottindakan=$tottindakan+$rwJml['tindakan'];
						$totvisite=$totvisite+$rwJml['visite'];
						$totoperasi=$totoperasi+$rwJml['operasi'];
						$totlaborat=$totlaborat+$rwJml['laborat'];
						$totrad=$totrad+$rwJml['rad'];
						$totpa=$totpa+$rwJml['pa'];
						$totobat=$totobat+$rwJml['obat'];
				?>
				<tr>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:center"><?php echo $no;?></td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['kamar']=="") echo "--"; else echo number_format($rwJml['kamar'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['makan']=="") echo "--"; else echo number_format($rwJml['makan'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['tindakan']=="") echo "--"; else echo number_format($rwJml['tindakan'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['visite']=="") echo "--"; else	echo number_format($rwJml['visite'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right">&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['operasi']=="") echo "--"; else echo number_format($rwJml['operasi'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['laborat']=="") echo "--"; else echo number_format($rwJml['laborat'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['rad']=="") echo "--"; else echo number_format($rwJml['rad'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['pa']=="") echo "--"; else	echo number_format($rwJml['pa'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right">&nbsp;</td>
					<?php 
						$jml=$rwJml['kamar']+$rwJml['makan']+$rwJml['tindakan']+$rwJml['visite']+$rwJml['operasi']+$rwJml['laborat']+$rwJml['rad']+$rwJml['pa'];
						$jml2=$rwJml['tindakan']+$rwJml['obat'];
					?>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($jml,2,",",".")?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php if($rwJml['obat']=="") echo "--"; else echo number_format($rwJml['obat'],2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid;"><?php echo number_format($jml2,2,",",".")?>&nbsp;</td>
				</tr>
				<?php
						$totjml=$totjml+$jml;
						$totjml2=$totjml2+$jml2;
					$no++;
					} 
				?>
				<tr>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:center">&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totkamar,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totmakan,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($tottindakan,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totvisite,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right">&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totoperasi,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totlaborat,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totrad,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totpa,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right">&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totjml,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($totobat,2,",",".");?>&nbsp;</td>
					<td style="border-left:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid;"><?php echo number_format($totjml2,2,",",".");?>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="28" colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="70%">&nbsp;</td>
		<td width="30%">&nbsp;<?=$kotaRS?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo gmdate('F Y',mktime(date('H')+7))?></td>
	</tr>
	<tr>
		<td width="70%">&nbsp;</td>
		<td width="30%">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="70%">&nbsp;</td>
		<td width="30%">&nbsp;Pengaju Klaim</td>
	</tr>
	
	<tr>
		<td width="70%">&nbsp;</td>
		<td width="30%">&nbsp;Kasubbag Pendapatan</td>
	</tr>
	
	<tr>
		<td width="70%" height="50">&nbsp;</td>
		<td width="30%">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="70%">&nbsp;</td>
		<td width="30%">&nbsp;</td>
	</tr>
	
	<tr>
		<td width="70%">&nbsp;</td>
		<td width="30%">&nbsp;</td>
	</tr>
</table>