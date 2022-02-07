<?php
	include("../sesi.php");
    include("../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "bb.tgl = '$tglAwal2' ";
		$waktu2 = "$dbkeuangan.k_transaksi.tgl = '$tglAwal2' ";
		$waktuL = "AND k_transaksi.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "month(bb.tgl) = '$bln' AND year(bb.tgl) = '$thn' ";
		$waktu2 = "month($dbkeuangan.k_transaksi.tgl) = '$bln' AND year($dbkeuangan.k_transaksi.tgl) = '$thn' ";
		$waktuL = "AND month(k_transaksi.tgl) = '$bln' AND year(k_transaksi.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "bb.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktu2 = "$dbkeuangan.k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
		$waktuL = "AND k_transaksi.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$kso = $_REQUEST['cmbKsoRep'];
	
	if($kso==0){
		$fKso = "SEMUA";
	}else{
		$qKso = "SELECT $dbbilling.b_ms_kso.id, $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso
WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
		$sKso = mysql_query($qKso);
		$wKso = mysql_fetch_array($sKso);
		$fKso = "'".$wKso['nama']."'";
	}
?>
<title>.: Rekap Penerimaan Harian :.</title>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
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
        <td style="font-size:14px; height:70px; text-transform:uppercase; text-align:center; font-weight:bold;" valign="top">rekapitulasi penerimaan<br />Penjamin pasien <?php echo $fKso?><br><?php echo $Periode;?></td>
    </tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr style="text-align:center; font-weight:bold">
				  	<td width="3%" style="border-top:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td width="20%" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">URAIAN</td>
					<td colspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">PASIEN RSPM</td>
					<td colspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">PASIEN PAVILYUN</td>
					<td rowspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">TUNAI<br>RSPM & PAV</td>
					<td rowspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">PEMBAYARAN PIUTANG<br>RSPM & PAV</td>
					<td rowspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">TOTAL</td>
					<td rowspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">TARGET<br>Jan s/d Okt<br>90 Milyard</td>
					<td rowspan="3" style="border-top:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">SELISIH<br>LEBIH/KURANG</td>
				</tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-bottom:1px solid; border-right:1px solid;">PENDAPATAN</td>
					<td rowspan="2" style="border-bottom:1px solid #000000; border-right:1px solid;">TUNAI & <br>IUR BYR</td>
					<td rowspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;">PIUTANG<br>YG TERTAGIH</td>
					<td rowspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;">JUMLAH</td>
					<td rowspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;">TUNAI & <br>IUR BYR</td>
					<td rowspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;">PIUTANG<br>YG TERTAGIH</td>
					<td rowspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;">JUMLAH</td>
				</tr>
				<tr style="text-align:center; font-weight:bold">
				  	<td style="border-bottom:1px solid #000000; border-right:1px solid #000000; border-left:1px solid #000000;">1</td>
					<td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">2</td>
				</tr>
				<?php
						$qJns = "SELECT * FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.islast = '0' AND $dbbilling.b_ms_unit.kategori = '2' AND $dbbilling.b_ms_unit.aktif = '1'";
						$rsJns = mysql_query($qJns);
						$gjml1 = 0;
						$gjml2 = 0;
						$gjml3 = 0;
						$gjml4 = 0;
						$gjml5 = 0;
						$gjml6 = 0;
						$gjml7 = 0;
						$gjml8 = 0;
						$gjml9 = 0;
						while($rwJns = mysql_fetch_array($rsJns))
						{
							if($rwJns['id']==50)
							{
								$fPav = "";
								$fPav2 = "AND bmu.id = '".$rwUn['id']."'";
							}
							else{
								$fPav = "AND bmu.parent_id = '50'";
								$fPav2 = "";
							}
				?>
				<tr>
				 	<td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;"><?php echo $rwJns['nama'];?></td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
				<?php
						$qUn = "SELECT * FROM $dbbilling.b_ms_unit WHERE $dbbilling.b_ms_unit.parent_id = '".$rwJns['id']."' AND $dbbilling.b_ms_unit.aktif = '1' ORDER BY $dbbilling.b_ms_unit.nama";
						$rsUn = mysql_query($qUn);
						$no = 1;
						$jml1 = 0;
						$jml2 = 0;
						$jml3 = 0;
						$jml4 = 0;
						$jml5 = 0;
						$jml6 = 0;
						$jml7 = 0;
						$jml8 = 0;
						$jml9 = 0;
						while($rwUn = mysql_fetch_array($rsUn))
						{
							if($kso!=0) $fKso2 = "AND bk.kso_id = '".$kso."'";
							$qTunai = "SELECT jmlPas+inapPas AS total FROM (SELECT SUM(bayar_pasien) AS jmlPas, SUM(IFNULL(bayPas,0)) AS inapPas FROM (SELECT bk.id AS kunjungan_id, bp.id, bb.nilai AS bayar_pasien, btk.bayar_pasien AS bayPas FROM $dbbilling.b_kunjungan bk INNER JOIN $dbbilling.b_pelayanan bp ON bp.kunjungan_id = bk.id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bp.unit_id INNER JOIN $dbbilling.b_ms_unit bmu ON bmu.id = bp.unit_id_asal INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id INNER JOIN $dbbilling.b_bayar_tindakan bbt ON bbt.tindakan_id = bt.id INNER JOIN $dbbilling.b_bayar bb ON bb.id = bbt.bayar_id WHERE (bmuu.id = '".$rwUn['id']."' $fPav2) AND $waktu $fKso2 GROUP BY bp.id) AS t1) AS t2";
							$rsTunai = mysql_query($qTunai);
							$rwTunai = mysql_fetch_array($rsTunai);
							
							if($kso==0){
								$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id <> '0'";
							}else{
								$fPenjamin = "AND $dbkeuangan.k_transaksi.kso_id = '".$wKso['id']."'";
							}
							
							$qTagih = "SELECT SUM($dbkeuangan.k_transaksi.nilai) AS total FROM $dbkeuangan.k_transaksi INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.unit_id = $dbkeuangan.k_transaksi.unit_id INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_pelayanan.unit_id_asal = $dbbilling.b_ms_unit.id WHERE $dbkeuangan.k_transaksi.unit_id = '".$rwUn['id']."' AND $dbbilling.b_ms_unit.parent_id <> '50' $fPenjamin AND $waktu2 ";
							$rsTagih = mysql_query($qTagih);
							$rwTagih = mysql_fetch_array($rsTagih);
							
							if($kso!=0) $fKso2 = "AND bk.kso_id = '".$kso."'";
							$qTunaiPav = "SELECT jmlPas+inapPas AS total FROM (SELECT SUM(bayar_pasien) AS jmlPas, SUM(IFNULL(bayPas,0)) AS inapPas FROM (SELECT bk.id AS kunjungan_id, bp.id, bb.nilai AS bayar_pasien, btk.bayar_pasien AS bayPas FROM $dbbilling.b_kunjungan bk INNER JOIN $dbbilling.b_pelayanan bp ON bp.kunjungan_id = bk.id INNER JOIN $dbbilling.b_ms_unit bmuu ON bmuu.id = bp.unit_id INNER JOIN $dbbilling.b_ms_unit bmu ON bmu.id = bp.unit_id_asal INNER JOIN $dbbilling.b_tindakan bt ON bt.pelayanan_id = bp.id LEFT JOIN $dbbilling.b_tindakan_kamar btk ON btk.pelayanan_id = bt.pelayanan_id INNER JOIN $dbbilling.b_bayar_tindakan bbt ON bbt.tindakan_id = bt.id INNER JOIN $dbbilling.b_bayar bb ON bb.id = bbt.bayar_id WHERE (bmuu.id = '".$rwUn['id']."' $fPav) AND $waktu $fKso2 GROUP BY bp.id) AS t1) AS t2";
							$rsTunaiPav = mysql_query($qTunaiPav);
							$rwTunaiPav = mysql_fetch_array($rsTunaiPav);
							
							$qTagihPav = "SELECT SUM($dbkeuangan.k_transaksi.nilai) AS total FROM $dbkeuangan.k_transaksi INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.unit_id = $dbkeuangan.k_transaksi.unit_id INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_pelayanan.unit_id_asal = $dbbilling.b_ms_unit.id WHERE $dbkeuangan.k_transaksi.unit_id = '".$rwUn['id']."' AND $dbbilling.b_ms_unit.parent_id = '50' $fPenjamin AND $waktu2 ";
							$rsTagihPav = mysql_query($qTagihPav);
							$rwTagihPav = mysql_fetch_array($rsTagihPav);
							
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; padding-right:15px; text-align:right"><?php echo $no;?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwUn['nama']?></td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwTunai['total'],0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwTagih['total'],0,",",".")?>&nbsp;</td>
					<?
						$jumlah = $rwTunai['total'] + $rwTagih['total'];
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jumlah,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwTunaiPav['total'],0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwTagihPav['total'],0,",",".")?>&nbsp;</td>
					<?php
						$jumlahPav = $rwTunaiPav['total'] + $rwTagihPav['total'];
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jumlahPav,0,",",".")?>&nbsp;</td>
					<?php
						$jmlTunai = $rwTunai['total'] + $rwTunaiPav['total'];
						$jmlTagih = $rwTagih['total'] + $rwTagihPav['total'];
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jmlTunai,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jmlTagih,0,",",".")?>&nbsp;</td>
					<?php
							$total = $jmlTunai + $jmlTagih;
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($total,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				</tr>
				<?php
						$no++;
						$jml1 = $jml1 + $rwTunai['total'];
						$jml2 = $jml2 + $rwTagih['total'];
						$jml3 = $jml3 + $jumlah;
						$jml4 = $jml4 + $rwTunaiPav['total'];
						$jml5 = $jml5 + $rwTagihPav['total'];
						$jml6 = $jml6 + $jumlahPav;
						$jml7 = $jml7 + $jmlTunai;
						$jml8 = $jml8 + $jmlTagih;
						$jml9 = $jml9 + $total;
						}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml1,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml2,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml3,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml4,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml5,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml6,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml7,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml8,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jml9,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
				</tr>
				<?php
						
						$gjml1 = $gjml1 + $jml1;
						$gjml2 = $gjml2 + $jml2;
						$gjml3 = $gjml3 + $jml3;
						$gjml4 = $gjml4 + $jml4;
						$gjml5 = $gjml5 + $jml5;
						$gjml6 = $gjml6 + $jml6;
						$gjml7 = $gjml7 + $jml7;
						$gjml8 = $gjml8 + $jml8;
						$gjml9 = $gjml9 + $jml9;
						}
				?>
				<tr>
				 	<td colspan="2" style="border-left:1px solid #000000; border-right:1px solid #000000; padding-left:50px; font-weight:bold; text-decoration:underline;">Lain - Lain</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
					<td width="7%" style="border-right:1px solid #000000;">&nbsp;</td>
				</tr>
				<?php
						$qLain = "SELECT id, nama FROM k_ms_transaksi WHERE k_ms_transaksi.tipe = '1'";
						$rsLain = mysql_query($qLain);
						$hrf = 1;
						$jmlL = 0;
						while($rwLain = mysql_fetch_array($rsLain))
						{
							//if($kso!=0) $fKL = "AND k_transaksi.kso_id = '".$kso."'";
							$qL = "SELECT SUM(k_transaksi.nilai) AS total FROM k_transaksi INNER JOIN k_ms_transaksi ON k_ms_transaksi.id = k_transaksi.id_trans WHERE k_ms_transaksi.id = '".$rwLain['id']."' $waktuL";
							$rsL = mysql_query($qL);
							$rwL = mysql_fetch_array($rsL);
				?>
				<tr>
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; padding-right:15px; text-align:right"><?php echo $hrf;?></td>
					<td style="border-right:1px solid #000000; text-transform:uppercase">&nbsp;<?php echo $rwLain['nama']?></td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($rwL['total'],0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
					<?php
							$jumlahL = $rwL['total'];
					?>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jumlahL,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jumlahL,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;"><?php echo number_format($jumlahL,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
					<td style="border-right:1px solid #000000; text-align:right;">&nbsp;</td>
				</tr>
				<?php
						$hrf++;
						$jmlL = $jmlL + $rwL['total'];
						$jumlahLain = $jumlahLain + $jumlahL;
						}
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;JUMLAH</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jmlL,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jumlahLain,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jumlahLain,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">0&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jumlahLain,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
				</tr>
				<?php 
						$jmlAKhir = $gjml1 + $jmlL;
						$jumlahAkhir = $gjml3 + $jumlahLain;
						$jumlahTunai = $jumlahLain + $gjml7;
						$jumlahTotal = $jumlahLain + $gjml9;
				?>
				<tr style="font-weight:bold;">
				  	<td style="border-left:1px solid #000000; border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;GRAND TOTAL</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jmlAKhir,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($gjml2,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jumlahAkhir,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($gjml4,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($gjml5,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($gjml6,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jumlahTunai,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($gjml8,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;"><?php echo number_format($jumlahTotal,0,",",".")?>&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
					<td style="border-right:1px solid #000000; border-top:1px solid #000000; border-bottom:1px solid #000000; text-align:right;">&nbsp;</td>
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
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>