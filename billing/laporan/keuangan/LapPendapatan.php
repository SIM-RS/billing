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

<body style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
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
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan3']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	/* 
	$jnsLayanan = $_REQUEST['JnsLayanan3'];
	$tmpLayanan = $_REQUEST['TmpLayanan'];
	if($tmpLayanan == 0){
	$fUnit = " u.parent_id = $jnsLayanan";
	}else{
		$fUnit = " u.id = $tmpLayanan";
	} */
	
?>
<table width="1200" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4" style="font-size:13px;"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" height="50" style="font-size:15px;"><b>Laporan Pendapatan <?php echo $rwUnit1['nama'];?> Berdasarkan Nama Kasir<br /><?php echo $Periode;s?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="40%" align="right">&nbsp;Yang Mencetak :</td>
	<?php
			$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
			$rsPeg = mysql_query($sqlPeg);
			$rwPeg = mysql_fetch_array($rsPeg);
	?>
    <td width="20%" align="right">&nbsp;&nbsp;&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php 
  	if($_REQUEST['cmbKsr']!='0'){
		$sqlPel = "SELECT id,nama FROM b_ms_pegawai WHERE id='".$_REQUEST['cmbKsr']."'";
		$rsPel = mysql_query($sqlPel);
		$rwPel = mysql_fetch_array($rsPel);
		$fKsr = " AND t.user_act=".$_REQUEST['cmbKsr']." ";
		mysql_free_result($rsPel);
	}
  ?>
  <tr>
    <td colspan="2">&nbsp;Pelaksana&nbsp;:&nbsp;&nbsp;&nbsp;<b><?php if($_REQUEST['cmbKsr']=='0') echo 'Semua'; else echo $rwPel['nama'];?></b></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="4">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td rowspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">NO.</td>
				<td rowspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">RUANGAN</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">PENDAPATAN</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">MAKAN</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">LAB. PK</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">RADIOLOGI</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">REHAB</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;" align="center">LAB. PA</td>
				<td colspan="2" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" align="center">JUMLAH</td>
			</tr>
			<tr>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">IUR</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">IUR</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">IUR</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">IUR</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">IUR</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">IUR</td>
				<td style="border-left:1px solid; border-bottom:1px solid;" align="center">TUNAI</td>
				<td style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;" align="center">IUR</td>
			</tr>
			<?php
				/* $qUnit = "SELECT id, nama FROM b_ms_unit WHERE parent_id = '".$_REQUEST['JnsLayanan3']."'"; */
				$qUnit = "SELECT us.id, us.nama as namaUnit, u.nama FROM b_kunjungan k
						INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
						INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
						INNER JOIN b_ms_unit u ON pl.jenis_layanan = u.parent_id
						INNER JOIN b_ms_unit us ON us.id = pl.unit_id
						WHERE pl.jenis_layanan = '".$_REQUEST['JnsLayanan3']."' $waktu
						GROUP BY us.nama";
				$rsUnit = mysql_query($qUnit);
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
				$jml10 = 0;
				$jml11 = 0;
				$jml12 = 0;
				$jml13 = 0;
				$jmlIur1 = 0;
				while($rwUnit = mysql_fetch_array($rsUnit))
				{
					$jml = 0;
					/* Tunai */
					$qBayar = "SELECT SUM(t.bayar_pasien) AS bayart, SUM(tk.bayar_pasien) AS bayartk, 
								SUM(t.bayar_pasien)+SUM(tk.bayar_pasien) AS total
								FROM b_tindakan t 
								INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id = t.pelayanan_id
								INNER JOIN b_pelayanan pl ON tk.pelayanan_id = pl.id
								WHERE pl.unit_id = '".$rwUnit['id']."' $waktu $fKsr
								AND t.kso_id = 1";
					$rsBayar = mysql_query($qBayar);
					$rwBayar = mysql_fetch_array($rsBayar);
					
					/* IUR */
					$qBayar2 = "SELECT SUM(t.bayar_pasien) AS bayart, SUM(tk.bayar_pasien) AS bayartk,
								SUM(t.bayar_pasien)+SUM(tk.bayar_pasien) AS total
								FROM b_tindakan t 
								INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id = t.pelayanan_id
								INNER JOIN b_pelayanan pl ON tk.pelayanan_id = pl.id
								WHERE pl.unit_id = '".$rwUnit['id']."' $waktu $fKsr
								AND t.kso_id <> 1";
					$rsBayar2 = mysql_query($qBayar2);
					$rwBayar2 = mysql_fetch_array($rsBayar2);
					
					/* Tunai */
					$qMakan = "SELECT SUM(t.bayar_pasien) AS bayar FROM b_tindakan t 
								INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id 
								INNER JOIN b_ms_tindakan ti ON ti.id = tk.ms_tindakan_id 
								INNER JOIN b_pelayanan pl ON t.pelayanan_id = pl.id 
								WHERE t.kso_id = '1' AND (ti.id = 742 OR ti.id = 746 OR ti.id = 748 OR ti.id = 749) 
								AND pl.unit_id = '".$rwUnit['id']."' $waktu $fKsr";
					$rsMakan = mysql_query($qMakan);
					$rwMakan = mysql_fetch_array($rsMakan);
					
					/* IUR */
					$qMakan2 = "SELECT SUM(t.bayar_pasien) AS bayar FROM b_tindakan t 
								INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id 
								INNER JOIN b_ms_tindakan ti ON ti.id = tk.ms_tindakan_id 
								INNER JOIN b_pelayanan pl ON t.pelayanan_id = pl.id 
								WHERE t.kso_id <> '1' AND (ti.id = 742 OR ti.id = 746 OR ti.id = 748 OR ti.id = 749) 
								AND pl.unit_id = '".$rwUnit['id']."' $waktu $fKsr";
					$rsMakan2 = mysql_query($qMakan2);
					$rwMakan2 = mysql_fetch_array($rsMakan2);
					
					/* Tunai */
					$qPk = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '58' AND t.kso_id = '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu";
					$rsPk = mysql_query($qPk);
					$rwPk = mysql_fetch_array($rsPk);
					
					/* IUR */
					$qPk2 = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '58' AND t.kso_id <> '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu";
					$rsPk2 = mysql_query($qPk2);
					$rwPk2 = mysql_fetch_array($rsPk2);
					
					/* Tunai */
					$qRad = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '61' AND t.kso_id = '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu";
					$rsRad = mysql_query($qRad);
					$rwRad = mysql_fetch_array($rsRad);
					
					/* IUR */
					$qRad2 = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '61' AND t.kso_id <> '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu";
					$rsRad2 = mysql_query($qRad2);
					$rwRad2 = mysql_fetch_array($rsRad2);
					
					/* Tunai */
					$qRehab = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '16' AND t.kso_id = '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu ";
					$rsRehab = mysql_query($qRehab);
					$rwRehab = mysql_fetch_array($rsRehab);
					
					/* IUR */
					$qRehab2 = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '16' AND t.kso_id <> '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu ";
					$rsRehab2 = mysql_query($qRehab2);
					$rwRehab2 = mysql_fetch_array($rsRehab2);
					
					/* Tunai */
					$qPa = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '59' AND t.kso_id = '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu";
					$rsPa = mysql_query($qPa);
					$rwPa = mysql_fetch_array($rsPa);
					
					/* IUR */
					$qPa2 = "SELECT SUM(t.bayar_pasien) AS bayar
							FROM b_tindakan t
							INNER JOIN b_pelayanan pl ON pl.kunjungan_id = t.kunjungan_id
							INNER JOIN b_ms_tindakan_unit tu ON tu.ms_tindakan_kelas_id = t.ms_tindakan_kelas_id
							WHERE tu.ms_unit_id = '59' AND t.kso_id <> '1'
							AND pl.unit_id_asal = '".$rwUnit['id']."'
							$fKsr $waktu";
					$rsPa2 = mysql_query($qPa2);
					$rwPa2 = mysql_fetch_array($rsPa2);
					
			?>
			<!-- '".$_REQUEST['cmbPelaksana']."' -->
			<tr>
				<td width="2%" style="border-left:1px solid; border-bottom:1px solid;" align="center"><?php echo $no;?></td>
				<td width="12%" style="border-left:1px solid; border-bottom:1px solid;">&nbsp;<?php echo $rwUnit['namaUnit'];?></td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwBayar['total']=="") echo "-"; else echo number_format($rwBayar['total'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwBayar2['total']=="") echo "-"; else echo number_format($rwBayar2['total'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwMakan['bayar']=="") echo "-"; else echo number_format($rwMakan['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwMakan2['bayar']=="") echo "-"; else echo number_format($rwMakan2['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwPk['bayar']=="") echo "-"; else echo number_format($rwPk['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwPk2['bayar']=="") echo "-"; else echo number_format($rwPk2['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwRad['bayar']=="") echo "-"; else echo number_format($rwRad['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwRad2['bayar']=="") echo "-"; else echo number_format($rwRad2['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwRehab['bayar']=="") echo "-"; else echo number_format($rwRehab['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwRehab2['bayar']=="") echo "-"; else echo number_format($rwRehab2['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwPa['bayar']=="") echo "-"; else echo number_format($rwPa['bayar'],0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($rwPa2['bayar']=="") echo "-"; else echo number_format($rwPa2['bayar'],0,",",".");?>&nbsp;</td>
				<?php
					$tmbh = $rwMakan['bayar'] + $rwPk['bayar'] + $rwRad['bayar'] + $rwRehab['bayar'] + $rwPa['bayar'];
					$tmbh2 = $rwBayar['total'] - $tmbh;
					$jml = $jml + $tmbh2;
				?>
				<td width="7%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml=="") echo "-"; else echo number_format($jml,0,",",".");?>&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;" align="right"><?php if ($rwIur1['iur']=="") echo "-"; else echo number_format($rwIur1['iur'],0,",",".");?>&nbsp;</td>
			</tr>
			<?php
				$jml1 = $jml1 + $rwBayar['total'];
				$jml13 = $jml13 + $rwBayar2['total'];
				$jml2 = $jml2 + $rwMakan['bayar'];
				$jml8 = $jml8 + $rwMakan2['bayar'];
				$jml3 = $jml3 + $rwPk['bayar'];
				$jml9 = $jml9 + $rwPk2['bayar'];
				$jml4 = $jml4 + $rwRad['bayar'];
				$jml10 = $jml10 + $rwRad2['bayar'];
				$jml5 = $jml5 + $rwRehab['bayar'];
				$jml11 = $jml11 + $rwRehab2['bayar'];
				$jml6 = $jml6 + $rwPa['bayar'];
				$jml12 = $jml12 + $rwPa2['bayar'];
				$jml7 = $jml7 + $jml;
				$jmlIur1 = $jmlIur1 + $rwIur1['iur'];
				$no++;
				
				}
				
			?>
			<tr>
				<td colspan="2" align="center" style="border-left:1px solid; border-bottom:1px solid;">JUMLAH</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml1=="") echo "-"; else echo number_format($jml1,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml13=="") echo "-"; else echo number_format($jml13,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml2=="") echo "-"; else echo number_format($jml2,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml8=="") echo "-"; else echo number_format($jml8,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml3=="") echo "-"; else echo number_format($jml3,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml9=="") echo "-"; else echo number_format($jml9,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml4=="") echo "-"; else echo number_format($jml4,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml10=="") echo "-"; else echo number_format($jml10,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml5=="") echo "-"; else echo number_format($jml5,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml11=="") echo "-"; else echo number_format($jml11,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml6=="") echo "-"; else echo number_format($jml6,0,",",".");?>&nbsp;</td>
				<td width="6%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml12=="") echo "-"; else echo number_format($jml12,0,",",".");?>&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px solid;" align="right"><?php if($jml7=="") echo "-"; else echo number_format($jml7,0,",",".");?>&nbsp;</td>
				<td width="7%" style="border-left:1px solid; border-bottom:1px solid; border-right:1px solid;" align="right"><?php if($jmlIur1=="") echo "-"; else echo number_format($jmlIur1,0,",",".");?>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;PENDAPATAN</td>
				<td align="right"><?php echo number_format($jml1,0,",",".")?>&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<?php
					$krg = $jml2+$jml3+$jml4+$jml5+$jml6;
				?>
				<td align="right" style="border-bottom:1px solid;"><?php if($krg=="") echo "-"; else echo number_format($krg,0,",",".");?>&nbsp;</td>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;<?php echo $rwUnit1['nama'];?></td>
				<?php $tot = $jml1 - $krg;?>
				<td align="right"><?php if($tot=="") echo "-"; else echo number_format($tot,0,",",".");?>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
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
  mysql_free_result($rsUnit2);
  mysql_free_result($rsPeg);
  mysql_free_result($rsUnit);
  mysql_free_result($rsBayar);
  mysql_free_result($rsMakan);
  mysql_free_result($rsPk);
  mysql_free_result($rsRad);
  mysql_free_result($rsRehab);
  mysql_free_result($rsPa);
  mysql_close($konek);
  ?>
</table>
</body>
</html>