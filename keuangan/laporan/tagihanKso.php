<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "bt.tgl = '$tglAwal2' ";
		$waktu2 = "$dbkeuangan.k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "month(bt.tgl) = '$bln' AND year(bt.tgl) = '$thn' ";
		$waktu2 = "month($dbkeuangan.k_transaksi.tgl) = '$bln' AND year($dbkeuangan.k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "bt.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = "$dbkeuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
		
		$kso = $_REQUEST['cmbKsoRep'];
	
		if($kso==0){
			$fKso2 = "SEMUA";
		}else{
			$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
	WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
			$sKso = mysql_query($qKso);
			$wKso = mysql_fetch_array($sKso);
			$fKso2 = "'".$wKso['nama']."'";
			$fKso = " AND bt.kso_id = '".$wKso['id']."'";
		}
		
		//$fKso = "bt.kso_id = '".$rwKso['id']."'";
?>
<title>.: Laporan Pendapatan Penjamin :.</title>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b>
		  <?=$pemkabRS;?>
          <br />
          <?=$namaRS;?>
          <br />
          <?=$alamatRS;?>
          <br />
Telepon
<?=$tlpRS;?>
        </b></td>
	</tr>
	<tr>
		<td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">laporan pendapatan <?php echo $fKso2;?><br /><?php echo $Periode;?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="text-align:center; font-weight:bold;" height="30">
					<td width="5%" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">NO</td>
					<td width="30%" style="border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">UNIT PELAYANAN</td>
					<td width="15%" style="border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">TAGIHAN</td>
					<td width="15%" style="border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">VERIFIKASI</td>
					<td width="15%" style="border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">PEMBAYARAN</td>
					<td width="20%" style="border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">KETERANGAN</td>
				</tr>
				<?php
						$qJns = "SELECT * FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.islast = '0' AND $dbbilling.b_ms_unit.kategori = '2' AND $dbbilling.b_ms_unit.aktif = '1' AND $dbbilling.b_ms_unit.id<>50";
						$rsJns = mysql_query($qJns);
						$gjmlTagih = 0;
						$gjmlVer = 0;
						$gjmlBayar = 0;
						while($rwJns = mysql_fetch_array($rsJns))
						{
				?>
				<tr style="font-weight:bold;">
					<td style="border-left:1px solid; border-right:1px solid;">&nbsp;</td>
					<td style="border-right:1px solid; padding-left:10px; text-transform:uppercase; font-weight:bold; text-decoration:underline"><?php echo $rwJns['nama'];?></td>
					<td style="border-right:1px solid;">&nbsp;</td>
					<td style="border-right:1px solid;">&nbsp;</td>
					<td style="border-right:1px solid;">&nbsp;</td>
					<td style="border-right:1px solid;">&nbsp;</td>
				</tr>
				<?php
						$qUn = "SELECT * FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.parent_id = '".$rwJns['id']."' AND $dbbilling.b_ms_unit.aktif = '1' ORDER BY $dbbilling.b_ms_unit.nama";
						$rsUn = mysql_query($qUn);
						$no = 1;
						$jmlTagih = 0;
						$jmlBayar = 0;
						$jmlVer = 0;
						while($rwUn = mysql_fetch_array($rsUn))
						{
							
							$qTagih = "SELECT jmlPas+inapPas AS total FROM (SELECT SUM(biaya_kso) AS jmlPas, SUM(IFNULL(beban_kso,0)) AS inapPas FROM (SELECT bt.biaya_kso, btk.beban_kso FROM $dbbilling.b_ms_pasien bmp INNER JOIN $dbbilling.b_pelayanan bp ON bp.pasien_id = bmp.id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bp.unit_id INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id WHERE bmuu.id = '".$rwUn['id']."' AND $waktu $fKso GROUP BY bp.kunjungan_id) AS t1) AS t2";
							$rsTagih = mysql_query($qTagih);
							$rwTagih = mysql_fetch_array($rsTagih);
							
							if($kso==0){
								$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id <> '0'";
							}else{
								$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id = '".$wKso['id']."'";
							}
							
							$qBayar = "SELECT SUM($dbkeuangan.k_transaksi.nilai) AS total FROM $dbkeuangan.k_transaksi INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.unit_id = $dbkeuangan.k_transaksi.unit_id INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_pelayanan.unit_id_asal = $dbbilling.b_ms_unit.id WHERE $dbkeuangan.k_transaksi.unit_id = '".$rwUn['id']."' $fPenjamin AND $waktu2 ";
							$rsBayar = mysql_query($qBayar);
							$rwBayar = mysql_fetch_array($rsBayar);
				?>
				<tr>
					<td style="border-left:1px solid; border-right:1px solid; text-align:right; padding-right:10px;"><?php echo $no++;?></td>
					<td style="border-right:1px solid;">&nbsp;<?php echo $rwUn['nama']?></td>
					<td style="border-right:1px solid; text-align:right;"><?php echo number_format($rwTagih['total'],0,",",".");?>&nbsp;</td>
					<?php $ver = $rwTagih['total']-$rwBayar['total']?>
					<td style="border-right:1px solid; text-align:right;"><?php if($rwBayar['total']==0) echo ''; else echo $ver;?>&nbsp;</td>
					<td style="border-right:1px solid; text-align:right;"><?php echo number_format($rwBayar['total'],0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid;">&nbsp;</td>
				</tr>
				<?php
						$no++;
						$jmlTagih = $jmlTagih + $rwTagih['total'];
						$jmlBayar = $jmlBayar + $rwBayar['total'];
						//$ver = $rwTagih['total']-$rwBayar['total'];
						$jmlVer = $jmlVer + $ver;
						}
				?>
				<tr style="font-weight:bold;">
					<td style="border-left:1px solid; border-right:1px solid;">&nbsp;</td>
					<td style="border-right:1px solid; border-top:1px solid; border-bottom:1px solid;">&nbsp;JUMLAH</td>
					<td style="border-right:1px solid; border-top:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($jmlTagih,0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid; border-top:1px solid; border-bottom:1px solid; text-align:right"><?php if($jmlBayar==0) echo ''; else echo number_format($jmlVer,0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid; border-top:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($jmlBayar,0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid;">&nbsp;</td>
				</tr>
				<?php
						$gjmlTagih = $gjmlTagih + $jmlTagih;
						$gjmlBayar = $gjmlBayar + $jmlBayar;
						$gjmlVer = $gjmlVer + $jmlVer;
						}
				?>
				<tr style="font-weight:bold;">
					<td style="border-left:1px solid; border-right:1px solid; border-bottom:1px solid;">&nbsp;</td>
					<td style="border-right:1px solid; border-bottom:1px solid;">&nbsp;GRAND TOTAL</td>
					<td style="border-right:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($gjmlTagih,0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid; border-bottom:1px solid; text-align:right"><?php if($gjmlBayar==0) echo ''; else echo number_format($gjmlVer,0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid; border-bottom:1px solid; text-align:right"><?php echo number_format($gjmlBayar,0,",",".");?>&nbsp;</td>
					<td style="border-right:1px solid; border-bottom:1px solid;">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>