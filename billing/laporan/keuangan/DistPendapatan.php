<?php
	session_start();
	include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Distribusi Pendapatan Berdasarkan Uraian Layanan</title>
</head>

<body>
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	
	//if($JnsLayanan>0) $fJns=" b_kunjungan.unit_id = '".$_REQUEST['stsPas']."' AND ";
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND pl.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " AND pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	
?>
<table width="1200" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="4"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="4" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Distribusi Pendapatan Berdasarkan Uraian Layanan<br /><?php echo $Periode;?></b></td>
  </tr>
  <?php
  	if($_REQUEST['cmbKsr']!='0'){
		$sqlPel = "SELECT id,nama FROM b_ms_pegawai WHERE id='".$_REQUEST['cmbKsr']."'";
		$rsPel = mysql_query($sqlPel);
		$rwPel = mysql_fetch_array($rsPel);
		mysql_free_result($rsPel);
		$fKsr = " AND b_tindakan.user_act=".$_REQUEST['cmbKsr'];
	}
  ?>
  <tr>
    <td width="20%" height="30">&nbsp;Pelaksana:&nbsp;<b><?php if($_REQUEST['cmbKsr']=='0') echo 'Semua'; else echo $rwPel['nama'];?></b></td>
    <td width="20%">&nbsp;</td>
    <td width="40%" align="right">&nbsp;Yang Mencetak :</td>
	<?php
			$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
			$rsPeg = mysql_query($sqlPeg);
			$rwPeg = mysql_fetch_array($rsPeg);
	?>
    <td width="20%">&nbsp;&nbsp;&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
  	<td colspan="4">
		<table width="1200" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr style="font-weight:bold">
				<td height="30" width="10%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Status Pasien</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Tempat Layanan</td>
				<td width="7%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Tgl MRS</td>
				<td width="5%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;No. RM</td>
				<td width="18%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Nama Pasien</td>
				<td width="7%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Tgl Transaksi</td>
				<td width="19%" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;Uraian Layanan</td>
				<td width="7%" style="border-bottom:1px solid; border-top:1px solid;" align="right">Biaya&nbsp;</td>
				<td width="7%" style="border-bottom:1px solid; border-top:1px solid;" align="right">Komponen&nbsp;</td>
				<td width="10%" style="border-bottom:1px solid; border-top:1px solid;" align="right">Dist. Biaya&nbsp;</td>
			</tr>
			<?php
					$sqlSts = "SELECT b_kunjungan.kso_id, b_ms_kso.nama AS statusPasien, b_ms_kso.id
						FROM b_tindakan 
						INNER JOIN b_kunjungan ON b_kunjungan.id = b_tindakan.kunjungan_id
						INNER JOIN b_ms_kso  ON b_ms_kso.id = b_kunjungan.kso_id
						WHERE b_kunjungan.kso_id = '".$_REQUEST['JnsLayanan']."'
						$fKsr
						AND (DATE(b_tindakan.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."')
						GROUP BY b_ms_kso.nama";
					$rsSts = mysql_query($sqlSts);
					while($rwSts = mysql_fetch_array($rsSts))
					{	
			?>
			<tr>
				<td colspan="10">&nbsp;<?php echo $rwSts['statusPasien'];?></td>
			</tr>
			<?php
					$sqlTmp = "SELECT b_kunjungan.unit_id, b_ms_unit.nama AS namaunit, b_ms_unit.id
								FROM b_tindakan 
								INNER JOIN b_kunjungan ON b_kunjungan.id = b_tindakan.kunjungan_id
								INNER JOIN b_ms_unit ON b_ms_unit.id = b_kunjungan.unit_id
								WHERE b_tindakan.kso_id = '".$_REQUEST['StatusPas']."'
								AND b_ms_unit.parent_id=".$_REQUEST['JnsLayanan']."
								$fKsr
								AND (DATE(b_tindakan.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') 
								GROUP BY b_ms_unit.nama";
					$rsTmp = mysql_query($sqlTmp);
					$total2=0;
					while($rwTmp = mysql_fetch_array($rsTmp))
					{
							
			?>
			<tr>
				<td>&nbsp;</td>
				<td colspan="9">&nbsp;<?php echo $rwTmp['namaunit'];?></td>
			</tr>
			<?php
					$sqlnya = "SELECT b_tindakan.id, b_kunjungan.tgl, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.id as idPasien
						FROM b_tindakan 
						INNER JOIN b_kunjungan ON b_kunjungan.id = b_tindakan.kunjungan_id
						INNER JOIN b_ms_unit ON b_ms_unit.id = b_kunjungan.unit_id
						INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id
						WHERE (DATE(b_tindakan.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') 
						AND  b_ms_unit.id = '".$rwTmp['id']."'
						AND b_tindakan.kso_id = '".$rwSts['id']."'
						$fKsr
						GROUP BY b_kunjungan.tgl";
					$rsnya = mysql_query($sqlnya);
					$no = 1;
					$total1 = 0;
					while($rwnya = mysql_fetch_array($rsnya))
					{
					?>
					<tr>
						<td>&nbsp;</td>
						<td align="right">&nbsp;<?php echo $no;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>&nbsp;<?php echo $rwnya['tgl'];?></td>
						<td>&nbsp;<?php echo $rwnya['no_rm'];?></td>
						<td>&nbsp;<?php echo $rwnya['nama'];?></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<?php
				$sqlTind = "SELECT b_tindakan.id AS idTind, b_tindakan.tgl, b_tindakan.ms_tindakan_kelas_id, b_ms_tindakan_kelas.ms_tindakan_id, 
							b_ms_tindakan.nama AS namaTindakan, b_ms_pasien.id, b_ms_pasien.nama, b_tindakan.biaya
							FROM b_tindakan 
							INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
							INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
							INNER JOIN b_pelayanan ON b_pelayanan.id = b_tindakan.pelayanan_id
							INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_pelayanan.pasien_id
							WHERE b_ms_pasien.id = '".$rwnya['idPasien']."'
							AND (DATE(b_tindakan.tgl) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') 
							AND b_tindakan.kso_id = '".$rwSts['id']."'
							AND b_pelayanan.unit_id = '".$rwTmp['id']."'
							GROUP BY b_tindakan.tgl
							ORDER BY b_tindakan.tgl";
				$rsTind = mysql_query($sqlTind);
				//$counter=1;
					while($rwTind = mysql_fetch_array($rsTind))
					{ 
					?>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;<?php echo $rwTind['tgl'];?></td>
							<td>&nbsp;<?php echo $rwTind['namaTindakan'];?></td>
							<td align="right">&nbsp;<?php echo $rwTind['biaya'];?></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<?php
						$sqlKomp = "SELECT b_tindakan_komponen.ms_komponen_id, b_ms_komponen.nama, b_tindakan_komponen.tarip AS distBiaya
									FROM b_tindakan_komponen 
									LEFT JOIN b_ms_komponen ON b_ms_komponen.id = b_tindakan_komponen.ms_komponen_id
									WHERE b_tindakan_komponen.tindakan_id = '".$rwTind['idTind']."'";
						$rsKomp = mysql_query($sqlKomp);
						while($rwKomp = mysql_fetch_array($rsKomp))
						{
							//$total1[$counter]+=$rwKomp['distBiaya'];
							//$counter++;
				
							?>
							<tr>
								<td colspan="8">&nbsp;</td>
								<td align="right"><?php echo $rwKomp['nama'];?>&nbsp;</td>
								<td align="right"><?php echo number_format($rwKomp['distBiaya'],2,",",".");?>&nbsp;</td>
							</tr>
							<?
							$total1 = $total1 + $rwKomp['distBiaya'];
						}mysql_free_result($rsKomp);
					}mysql_free_result($rsTind);
					
						?>
							<tr>
								<td colspan="8">&nbsp;</td>
								<td align="right"><b>Subtotal</b>&nbsp;</td>
								<td align="right"><b><?php echo number_format($total1,2,",",".");?></b>&nbsp;</td>
							</tr>
							<?
				$no++;
				}mysql_free_result($rsnya);	
				$total2=$total2+$total1;
				}mysql_free_result($rsTmp);
				$total = $total + $total2;
				}mysql_free_result($rsSts);
				
			?>
			<!--tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right"><b>Subtotal</b>&nbsp;</td>
				<td align="right"><b><?=$total1;?></b>&nbsp;</td>
				<td align="right"><b><?php echo array_sum($total1);?></b>&nbsp;</td>
			</tr-->
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right"><b>Subtotal</b>&nbsp;</td>
				<td align="right"><b><?php echo number_format($total2,2,",",".");?></b>&nbsp;</td>
			</tr>
		  <tr>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;">&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;" align="right"><b>Total</b>&nbsp;</td>
			<td style="border-bottom:1px solid; height:28; border-top:1px solid;" align="right"><b><?php echo number_format($total,2,",",".");?></b>&nbsp;</td>
		  </tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Tgl Cetak: <?=$date_now;?>&nbsp;Jam: <?=$jam;?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="4" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td colspan="2" align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php
  mysql_free_result($rsUnit1);
  mysql_free_result($rsPeg);
  mysql_close($konek);
  ?>
</table>
</body>
</html>