<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "AND bt.tgl = '$tglAwal2' ";
		$waktu2 = "btt.tgl = '$tglAwal2' ";
		$waktu3 = "$dbkeuangan.k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "AND (month(bt.tgl) = '$bln' AND year(bt.tgl) = '$thn')";
        $waktu2 = "(month(btt.tgl) = '$bln' AND year(btt.tgl) = '$thn')";
		$waktu3 = "month($dbkeuangan.k_transaksi.tgl) = '$bln' AND year($dbkeuangan.k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "AND bt.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = "btt.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu3 = "$dbkeuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
		
    }
		
		$kso = $_REQUEST['cmbKsoRep'];
		//$stsPas = $_REQUEST['cmbKsoRep'];
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama
FROM $dbbilling.b_ms_kso WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		$rsKso = mysql_query($qKso);
		$rwKso = mysql_fetch_array($rsKso);
		
		if($kso==0){
			$fKso = "SEMUA";
		}else{
			$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
	WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
			$sKso = mysql_query($qKso);
			$wKso = mysql_fetch_array($sKso);
			$fKso = "'".$wKso['nama']."'";
			$fKso1 = "AND bt.kso_id = '".$wKso['id']."' ";
			$fKso2 = "AND btt.kso_id = '".$wKso['id']."' ";
		}
?>
<title>.: Laporan Pengajuan Klaim :.</title>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td colspan="3"><b><?=$pemkabRS;?><br><?=$$namaRS;?><br><?=$alamatRS;?><br>Telepon <?=$tlpRS;?></b></td>
	</tr>
	<tr>
		<td width="45%" valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr valign="top">
					<td colspan="5" height="50" valign="middle" style="text-transform:uppercase; font-weight:bold;">&nbsp;<?php echo $fKso?>&nbsp;<?php echo $Periode;?> / RAWAT INAP</td>
				</tr>
				<tr style="font-weight:bold;" valign="top">
					<td style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;" width="5%">NO</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="35%">Tindakan</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="20%">Pengajuan</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="20%">Verifikasi</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="20%">Pembayaran</td>
				</tr>
				<?php
					$qInap = "SELECT bmuu.id, bmuu.nama FROM (SELECT bp.id AS pelayanan_id, bmu.id AS unitId, bmu.nama AS unitNama, bt.biaya_kso AS biaya_kso, IFNULL(btk.beban_kso,0) AS beban_kso FROM $dbbilling.b_pelayanan bp INNER JOIN $dbbilling.b_ms_unit bmu ON bmu.id = bp.unit_id_asal INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id WHERE bmu.inap = '1' $waktu $fKso1 GROUP BY bp.id) AS t1 INNER JOIN $dbbilling.b_pelayanan bpl ON bpl.id = t1.pelayanan_id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bpl.unit_id LEFT JOIN $dbbilling.b_tindakan btt ON btt.pelayanan_id = bpl.id LEFT JOIN $dbbilling.b_tindakan_kamar btkk ON btkk.pelayanan_id = bpl.id WHERE $waktu2 $fKso2 GROUP BY bmuu.id ORDER BY bmuu.nama";
					$sInap = mysql_query($qInap);
					$no = 1;
					$jml1 = 0;
					$jml2 = 0;
					$jml3 = 0;
					while($wInap = mysql_fetch_array($sInap))
					{
						$qTagih = "SELECT b1+bb1+b2+bb2 AS total FROM (SELECT t1.biaya_kso AS b1, t1.beban_kso AS bb1, SUM(btt.biaya_kso) AS b2, SUM(IFNULL(btkk.beban_kso,0)) AS bb2 FROM (SELECT bp.id AS pelayanan_id, bmu.id AS unitId, bmu.nama AS unitNama, SUM(bt.biaya_kso) AS biaya_kso, SUM(IFNULL(btk.beban_kso,0)) AS beban_kso, bp.unit_id FROM $dbbilling.b_pelayanan bp INNER JOIN $dbbilling.b_ms_unit bmu ON bmu.id = bp.unit_id_asal INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id WHERE bmu.inap = '1' $waktu $fKso1 GROUP BY bp.unit_id) AS t1 INNER JOIN $dbbilling.b_pelayanan bpl ON bpl.id = t1.pelayanan_id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bpl.unit_id INNER JOIN $dbbilling.b_tindakan btt ON btt.pelayanan_id = bpl.id LEFT JOIN $dbbilling.b_tindakan_kamar btkk ON btkk.pelayanan_id = bpl.id WHERE bmuu.id = '".$wInap['id']."' AND $waktu2 $fKso2 GROUP BY bmuu.id) AS t2";
						$rsTagih = mysql_query($qTagih);
						$rwTagih = mysql_fetch_array($rsTagih);
						
						if($kso==0){
							$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id <> '0'";
						}else{
							$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id = '".$wKso['id']."'";
						}
						
						$qBayar = "SELECT SUM($dbkeuangan.k_transaksi.nilai) AS total FROM $dbkeuangan.k_transaksi INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.unit_id = $dbkeuangan.k_transaksi.unit_id INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_pelayanan.unit_id_asal = $dbbilling.b_ms_unit.id WHERE $dbkeuangan.k_transaksi.unit_id = '".$wInap['id']."' $fPenjamin AND $waktu3 ";
						$rsBayar = mysql_query($qBayar);
						$rwBayar = mysql_fetch_array($rsBayar);
						
						
				?>
				<tr valign="top">
					<td style="border-left:1px solid; border-right:1px solid; padding-right:10px; text-align:right"><?php echo $no;?></td>
					<td style="border-right:1px solid; text-transform:uppercase">&nbsp;<?php echo $wInap['nama']?></td>
					<td style="border-right:1px solid; text-align:right"><?php echo number_format($rwTagih['total'],0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid; text-align:right"><?php if($rwBayar['total']==0) echo ''; else echo $rwBayar['total']-$rwTagih['total']?>&nbsp;</td>
					<td style="border-right:1px solid; text-align:right"><?php echo number_format($rwBayar['total'],0,",",".")?>&nbsp;</td>
				</tr>
				<?php
						$no++;
						$jml1 = $jml1 + $rwTagih['total'];
						$jml2 = $jml2 + ($rwBayar['total']-$rwTagih['total']);
						$jml3 = $jml3 + $rwBayar['total'];
						}
				?>
				<tr style="font-weight:bold;" valign="top">
					<td style="border-bottom:1px solid; border-top:1px solid; border-left:1px solid; border-right:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">&nbsp;Total</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right"><?php echo number_format($jml1,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right"><?php if($jml3==0) echo ''; else echo number_format($jml2,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right"><?php echo number_format($jml3,0,",",".")?>&nbsp;</td>
				</tr>
			</table>
		</td>
		<td width="10%">&nbsp;</td>
		<td width="45%" valign="top">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr valign="top">
					<td colspan="5" height="50" valign="middle" style="text-transform:uppercase; font-weight:bold;">&nbsp;<?php echo $fKso?>&nbsp;<?php echo $Periode;?> / RAWAT JALAN</td>
				</tr>
				<tr style="font-weight:bold;" valign="top">
					<td style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;" width="5%">NO</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="35%">Tindakan</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="20%">Pengajuan</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="20%">Verifikasi</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" width="20%">Pembayaran</td>
				</tr>
				<?php
					$qJalan = "SELECT bmuu.id, bmuu.nama FROM (SELECT bp.id AS pelayanan_id, bmu.id AS unitId, bmu.nama AS unitNama, bt.biaya_kso AS biaya_kso, IFNULL(btk.beban_kso,0) AS beban_kso FROM $dbbilling.b_pelayanan bp INNER JOIN $dbbilling.b_ms_unit bmu ON bmu.id = bp.unit_id_asal INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id WHERE bmu.inap = '0'  $waktu $fKso1 GROUP BY bp.id) AS t1 INNER JOIN $dbbilling.b_pelayanan bpl ON bpl.id = t1.pelayanan_id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bpl.unit_id LEFT JOIN $dbbilling.b_tindakan btt ON btt.pelayanan_id = bpl.id LEFT JOIN $dbbilling.b_tindakan_kamar btkk ON btkk.pelayanan_id = bpl.id WHERE bmuu.inap = '0' AND $waktu2 $fKso2 GROUP BY bmuu.id ORDER BY bmuu.nama";
					$sJalan = mysql_query($qJalan);
					$no = 1;
					$jml4 = 0;
					$jml5 = 0;
					$jml6 = 0;
					while($wJalan = mysql_fetch_array($sJalan))
					{
						$qTagih2 = "SELECT b1+bb1+b2+bb2 AS total FROM (SELECT t1.biaya_kso AS b1, t1.beban_kso AS bb1, SUM(btt.biaya_kso) AS b2, SUM(IFNULL(btkk.beban_kso,0)) AS bb2 FROM (SELECT bp.id AS pelayanan_id, bmu.id AS unitId, bmu.nama AS unitNama, SUM(bt.biaya_kso) AS biaya_kso, SUM(IFNULL(btk.beban_kso,0)) AS beban_kso, bp.unit_id FROM $dbbilling.b_pelayanan bp INNER JOIN $dbbilling.b_ms_unit bmu ON bmu.id = bp.unit_id_asal INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id WHERE bmu.inap = '0' $waktu $fKso1 GROUP BY bp.unit_id) AS t1 INNER JOIN $dbbilling.b_pelayanan bpl ON bpl.id = t1.pelayanan_id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bpl.unit_id INNER JOIN $dbbilling.b_tindakan btt ON btt.pelayanan_id = bpl.id LEFT JOIN $dbbilling.b_tindakan_kamar btkk ON btkk.pelayanan_id = bpl.id WHERE bmuu.inap = '0' AND bmuu.id = '".$wJalan['id']."' AND $waktu2 $fKso2 GROUP BY bmuu.id) AS t2";
						$rsTagih2 = mysql_query($qTagih2);
						$rwTagih2 = mysql_fetch_array($rsTagih2);
						
						if($kso==0){
							$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id <> '0'";
						}else{
							$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id = '".$wKso['id']."'";
						}
						
						$qBayar2 = "SELECT SUM($dbkeuangan.k_transaksi.nilai) AS total FROM $dbkeuangan.k_transaksi INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.unit_id = $dbkeuangan.k_transaksi.unit_id INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_pelayanan.unit_id_asal = $dbbilling.b_ms_unit.id WHERE $dbkeuangan.k_transaksi.unit_id = '".$wJalan['id']."' $fPenjamin AND $waktu3 ";
												
						$rsBayar2 = mysql_query($qBayar2);
						$rwBayar2 = mysql_fetch_array($rsBayar2);
				?>
				<tr valign="top">
					<td style="border-left:1px solid; border-right:1px solid; padding-right:10px; text-align:right"><?php echo $no;?></td>
					<td style="border-right:1px solid; text-transform:uppercase">&nbsp;<?php echo $wJalan['nama']?></td>
					<td style="border-right:1px solid; text-align:right"><?php echo number_format($rwTagih2['total'],0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid; text-align:right"><?php if($rwBayar2['total']==0) echo ''; else echo $rwBayar2['total']-$rwTagih2['total']?>&nbsp;</td>
					<td style="border-right:1px solid; text-align:right"><?php echo number_format($rwBayar2['total'],0,",",".")?>&nbsp;</td>
				</tr>
				<?php
						$no++;
						$jml4 = $jml4 + $rwTagih2['total'];
						$jml5 = $jml5 + ($rwBayar2['total']-$rwTagih2['total']);
						$jml6 = $jml6 + $rwBayar2['total'];
						}
				?>
				<tr style="font-weight:bold;" valign="top">
					<td style="border-bottom:1px solid; border-top:1px solid; border-left:1px solid; border-right:1px solid;">&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">&nbsp;Total</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right"><?php echo number_format($jml4,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right"><?php if($jml6==0) echo ''; else echo number_format($jml5,0,",",".")?>&nbsp;</td>
					<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:right"><?php echo number_format($jml6,0,",",".")?>&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>