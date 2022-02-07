<?php 
include("../../koneksi/konek.php");
//==========Menangkap filter data====
$stsPas = $_REQUEST['StatusPas0'];
//if($stsPas>0) $fKso=" b_kunjungan.kso_id = '".$stsPas."' ";
$jnsLay = $_REQUEST['JnsLayananDenganInap'];
$tmpLay = $_REQUEST['TmpLayananInapSaja'];

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");
//$stsPas,$jnsLay,$tmpLay,$waktu,$tglAwal,$tglAhkir,$bln,$thn
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND b_bayar.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(b_bayar.tgl) = '$bln' and year(b_bayar.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND b_bayar.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

$sqlPenjamin = "SELECT nama FROM b_ms_kso WHERE id='".$stsPas."'";
$rsPenjamin = mysql_query($sqlPenjamin);
$hsPenjamin = mysql_fetch_array($rsPenjamin);

$sqlTmp = "SELECT nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
$rsTmp = mysql_query($sqlTmp);
$rwTmp = mysql_fetch_array($rsTmp);

$sqlJns = "SELECT nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
$rsJns = mysql_query($sqlJns);
$rwJns = mysql_fetch_array($rsJns);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Rincian Pendapatan Rawat Inap Umum</title>
<style type="text/css">

	body {
	background-color:#EEE;
	}
	
	table, table tr,table tr td {
	border-color:#000;
	border-collapse:collapse;
	}
   
	.isi{
	font-family:Arial, Helvetica, sans-serif; font-size:9px;
	text-align:center;
	}
   
	.jdl {
	border-top:1px solid #000000;
   	border-left:1px solid #000000;
	border-bottom:1px solid #000000;
	text-align:center;
	font-weight:bold;
	text-transform:uppercase;
	}
	.right
	{
	border-right:1px solid #000000;
	text-align:center;
	font-weight:bold;
	text-transform:uppercase;
	}
	
	.isigrid {
	border-left:1px solid #000;
	border-bottom:1px solid #000;
	border-right:1px right #000;
	}
	
	.isicol {
	border-left:1px solid #000;
	border-right:1px solid #000;
	}
	
	.isidlm {
	border-right:1px solid #000;
	border-bottom:1px solid #000;
	}
	
	.last {
	border-left:1px solid #000;
	border-bottom:1px solid #000;
	}
	
</style>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" width="2300"style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
<tr>
	<td><b>PEMERINTAH KABUPATEN SIDOARJO<br>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br>Jl. Mojopahit 667 Sidoarjo<br>Telepon (031) 896 1649</b>&nbsp;</td>
</tr>
<tr>
	<td align="center" valign="top" height="70" style="font-weight:bold; font-size:14px; text-transform:uppercase">rincian per nama pasien penerimaan rawat inap umum<br /><?php echo $Periode;?></td>
</tr>
<tr>
	<td align="center">
	<table width="100%" cellpadding="0" cellspacing="0" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
	<tr valign="top">
		<td width="1%" class="jdl" valign="middle">No</td>
		<td width="3%" class="jdl" valign="middle">No MR</td>
		<td width="8%" class="jdl" valign="middle">Nama Pasien</td>
		<td width="8%" class="jdl" valign="middle">Status</td>
		<td width="80%" class="jdl">
		<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-family:Arial, Helvetica, sans-serif; font-size:11px;">
		<tr style="text-align:center; font-weight:bold;">
			<td width="4%" class="right">MRS</td>
			<td width="4%" class="right">KRS</td>
			<td width="2%" class="right">HARI RAWAT</td>
			<td width="4%" class="right">RUANG RAWAT</td>
			<td width="4%" class="right">KELAS</td>
			<td width="4%" class="right">KAMAR</td>
			<td width="4%" class="right">MAKAN</td>
			<td width="4%" class="right">TINDAKAN NON OPERATIF</td>
			<td width="4%" class="right">JASA VISITE</td>
			<td width="3%" class="right">KONSUL GIZI</td>
			<td width="3%" class="right">IGD</td>
			<td width="3%" class="right">RWJ</td>
			<td width="4%" class="right">KONSUL POLI</td>
			<td width="4%" class="right">REHAB MEDIK</td>
			<td width="4%" class="right">TINDAKAN OPERATIF</td>
			<td width="4%" class="right">LAB PK</td>
			<td width="4%" class="right">RAD</td>
			<td width="4%" class="right">PA</td>
			<td width="4%" class="right">ENDOSCOPY</td>
			<td width="4%" class="right">HD</td>
			<td width="4%" class="right">JUMLAH TINDAKAN</td>
			<td width="4%" class="right">BAYAR TINDAKAN</td>
			<td width="3%" class="right">OBAT</td>
			<td width="3%" class="right">BAYAR OBAT</td>
			<td width="3%" class="right">PMI</td>
			<td width="4%" class="right">JUMLAH OBAT + TINDAKAN YANG DIBAYAR</td>
			<td width="4%" class="right">KEKURANGAN BAYAR</td>
		</tr>
		</table>
		</td>
	</tr>
	<form>
	<?php
	$fKso = "AND p.kso_id = '1'";
	$qry="SELECT DISTINCT mp.no_rm,mp.nama pasien,p.kunjungan_id 
FROM (SELECT * FROM b_bayar WHERE kasir_id=83 $waktu) b 
INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id INNER JOIN b_pelayanan p ON k.id = p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE mu.inap = '1' $fKso ORDER BY p.id";
	//echo $qry."<br>";
	$rs = mysql_query($qry);
	$i=0;
	$j=0;
	while($rw = mysql_fetch_array($rs)){					
	$i++;
	$tglKunj = $rw["tglKunj"];
	?>
	<tr valign="top" class="isigrid">
		<td class="isicol" width="1%" style="text-align:center;"><?php echo $i;?></td>
		<td class="isicol" width="3%" style="text-align:center;"><?php echo $rw['no_rm'];?></td>
		<td class="isicol" width="8%" style="padding-left:5px; text-transform:uppercase"><?php echo $rw['pasien'];?><br>
			<span id="txtNoP<?php echo $i;?>"><?php echo $rw['no_anggota'];?></span><br />
			<span id="NamaP<?php echo $i;?>"><?php echo $rw['nama_peserta'];?></span></td>
		<td class="isicol" width="8%" style="padding-left:5px; text-transform:uppercase;" align="center">UMUM</td>
		<td width="80%" class="tbl"> 
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td width="26%" colspan="7">
			<table width="100%" cellpadding="0" cellspacing="0">
			<?php
			$qLop = "SELECT DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS masuk,
					DATE_FORMAT(b_pelayanan.tgl_krs,'%d-%m-%Y') AS keluar, SUM(IF(b_tindakan_kamar.status_out=0, 
					IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
					DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
					IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
					DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS jHr, b_ms_kso.nama AS penjamin, 
					b_ms_unit.nama AS kamar, b_ms_kelas.nama AS kelas, b_pelayanan.unit_id, b_pelayanan.id AS pelayanan_id FROM b_pelayanan
					INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id OR (b_pelayanan.unit_id=47 OR b_pelayanan.unit_id=63)
					INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
					INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_ms_unit.inap='1' GROUP BY b_pelayanan.id";
			//echo $qLop."<br>";
			$rsLop = mysql_query($qLop);
			$jmlKmr = 0; $jmlMkn=0;
			while($rwLop = mysql_fetch_array($rsLop))
			{					 
				$qKamar = "SELECT SUM(cH.hari*cH.beban_pasien) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
						IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
						IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, 
						b_tindakan_kamar.beban_kso, b_tindakan_kamar.beban_pasien
						FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";
				$rsKamar = mysql_query($qKamar);
				$rwKamar = mysql_fetch_array($rsKamar);
				
				$qMakan = "SELECT SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS jml 
						FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id 
						INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
						INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id 
						WHERE b_pelayanan.id='".$rwLop['pelayanan_id']."' 
						AND b_ms_tindakan.id IN (742,746,747,748,749)";
				$rsMakan = mysql_query($qMakan);
				$rwMakan = mysql_fetch_array($rsMakan);
				?>
			<tr>
				<td class="isidlm" width="18%" align="center"><?php echo $rwLop['masuk']?><br /></td>
				<td class="isidlm" width="18%" align="center"><?php echo $rwLop['keluar']?></td>
				<td class="isidlm" width="8%" align="center"><?php echo $rwLop['jHr']?></td>
				<td class="isidlm" width="14%" align="center"><?php echo $rwLop['kamar']?></td>
				<td class="isidlm" width="14%" align="center"><?php echo $rwLop['kelas']?></td>
				<td class="isidlm" width="14%" align="right"><?php echo number_format($rwKamar['jml'],0,",",".");?></td>
				<td class="isidlm" width="14%" align="right"><?php echo number_format($rwMakan['jml'],0,",","."); ?></td>
			</tr>
			<?php
			$j++;
			$jmlKmr = $jmlKmr + $rwKamar['jml'];
			$jmlMkn = $jmlMkn + $rwMakan['jml'];
			}
			?>
			</table>
			</td>
			<?php
			$qTin = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
					INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND b_ms_unit.inap='1'
					AND b_ms_tindakan.id NOT IN (742,746,747,748,749,2387) 
					AND b_ms_tindakan.klasifikasi_id NOT IN (13,14) ) AS t";
			$rsTin = mysql_query($qTin);
			$rwTin = mysql_fetch_array($rsTin);

			$qVisite = "SELECT SUM(t.biaya) AS jml FROM (SELECT b_tindakan.qty*b_tindakan.biaya_pasien AS biaya 
					FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
					INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
					WHERE (b_ms_tindakan.klasifikasi_id = '13' OR b_ms_tindakan.klasifikasi_id = '14' AND b_ms_tindakan.id<>'2378') 
					AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3 GROUP BY b_tindakan.id) AS t";
			$rsVisite = mysql_query($qVisite);
			$rwVisite = mysql_fetch_array($rsVisite);

			$qGizi = "SELECT SUM(t.biaya) AS jml FROM (SELECT b_tindakan.qty*b_tindakan.biaya_pasien AS biaya FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
					INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
					WHERE (b_ms_tindakan.id = '2387' OR b_ms_tindakan.id='2378') 
					AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3) as t";
			$rsGizi = mysql_query($qGizi);
			$rwGizi = mysql_fetch_array($rsGizi);
			
			/*$qIGD = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND 
					b_pelayanan.jenis_layanan='44' AND b_ms_unit.inap='0' AND b_ms_unit.id<>47) AS t";*/
			$qIGD = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '2' AND b_ms_unit.inap='0' AND b_ms_unit.id<>47) AS t";
			$rsIGD = mysql_query($qIGD);
			$rwIGD = mysql_fetch_array($rsIGD);
			
			$qRWJ = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '1' AND b_ms_unit.inap='0') AS t";
			$rsRWJ = mysql_query($qRWJ);
			$rwRWJ = mysql_fetch_array($rsRWJ);
			
			$qPoli = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND 
					b_pelayanan.jenis_layanan='1' AND b_pelayanan.unit_id != '16') AS t";
			$rsPoli = mysql_query($qPoli);
			$rwPoli = mysql_fetch_array($rsPoli);
			
			$qRehab = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND 
					b_pelayanan.unit_id='16') AS t";
			$rsRehab = mysql_query($qRehab);
			$rwRehab = mysql_fetch_array($rsRehab);

			$qOp = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty,
					b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_pasien AS total FROM b_pelayanan
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'
					AND b_pelayanan.jenis_kunjungan=3 AND b_pelayanan.unit_id IN (47,63)) AS t";
			$rsOp = mysql_query($qOp);
			$rwOp = mysql_fetch_array($rsOp);
			
			$qPk = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_pasien AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='58') AS t";
			$rsPk = mysql_query($qPk);
			$rwPk = mysql_fetch_array($rsPk);
			
			$qRad = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_pasien AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='61') AS t";
			$rsRad = mysql_query($qRad);
			$rwRad = mysql_fetch_array($rsRad);
			
			$qPa = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_pasien AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='59') AS t";
			$rsPa = mysql_query($qPa);
			$rwPa = mysql_fetch_array($rsPa);
			
			$qHd = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_pasien AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='65') AS t";
			$rsHd = mysql_query($qHd);
			$rwHd = mysql_fetch_array($rsHd);
			
			$qEnd = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_pasien AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='67') AS t";
			$rsEnd = mysql_query($qEnd);
			$rwEnd = mysql_fetch_array($rsEnd);
			
			$qObat="SELECT SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS jml
					FROM (SELECT $dbbilling.b_pelayanan.id FROM $dbbilling.b_pelayanan
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE $dbbilling.b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND $dbbilling.b_pelayanan.jenis_kunjungan = '3') AS t2
					INNER JOIN $dbapotek.a_penjualan ap ON t2.id = ap.NO_KUNJUNGAN
					WHERE ap.NO_PASIEN = '".$rw['no_rm']."'";
										//echo $qObat."<br>";
			$rsObat = mysql_query($qObat);
			$rwObat = mysql_fetch_array($rsObat);
			
			$pmi = 0;
			
			$jmlTin = $jmlMkn + $jmlKmr + $rwTin['jml'] + $rwVisite['jml'] +
						$rwGizi['jml'] + $rwIGD['jml'] + $rwRWJ['jml'] + $rwPoli['jml'] + 
						$rwRehab['jml'] + $rwOp['jml'] + $rwPk['jml'] + $rwRad['jml'] +
						$rwPa['jml'] + $rwEnd['jml'] + $rwHd['jml'];
			$jmlTind = $jmlTin;
			
			/*$qByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
					INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id
					INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."'
					AND b_bayar_tindakan.tipe=0 AND b_bayar.kasir_id='83' $waktu
					GROUP BY b_bayar_tindakan.id 
					ORDER BY b_bayar_tindakan.id) AS t";*/
			$qByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
					INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id
					INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."'
					AND b_bayar_tindakan.tipe=0 $waktu
					GROUP BY b_bayar_tindakan.id 
					ORDER BY b_bayar_tindakan.id) AS t";
			//echo $qByr."<br>";
			$rsByr = mysql_query($qByr);
			$rwByr = mysql_fetch_array($rsByr);
			
			/*$qKamarByr = "SELECT SUM(cH.hari*cH.bayar_pasien) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
						IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
						IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.bayar_pasien
						FROM b_pelayanan 
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";*/
			$qKamarByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
					FROM b_pelayanan 
					INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
					INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id
					INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."'
					AND b_bayar_tindakan.tipe=1 $waktu
					GROUP BY b_bayar_tindakan.id 
					ORDER BY b_bayar_tindakan.id) AS t";
			//echo $qKamarByr."<br>";
			$rsKamarByr = mysql_query($qKamarByr);
			$rwKamarByr = mysql_fetch_array($rsKamarByr);
			$Bayar = $rwByr['jml'] + $rwKamarByr['jml'];
			
			$krgByr = $jmlTind + $rwObat['jml'] - $Bayar - $rwObat['jml'];
			
			$makan += $jmlMkn;
			$kamar += $jmlKmr;
			$tindakanNO += $rwTin['jml'];
			$visite += $rwVisite['jml'];
			$gizi += $rwGizi['jml'];
			$igd += $rwIGD['jml'];
			$rwj += $rwRWJ['jml'];
			$poli += $rwPoli['jml'];
			$rehab += $rwRehab['jml'];
			$tindakanO += $rwOp['jml'];
			$tin += $rwTin['jml'];
			$lab += $rwPk['jml'];
			$rad += $rwRad['jml'];
			$hd += $rwHd['jml'];
			$end += $rwEnd['jml'];
			$pa += $rwPa['jml'];
			$obat += $rwObat['jml'];
			$byrobat += $rwObat['jml'];
			$totpmi += $pmi;
			$totkrgByr +=$krgByr;
			
			$jmlTindakan += $jmlTind;
			$jmlTindakanByr += $Bayar;
			$jumlahTindakanObat += $Bayar+$obat;
			$jumlahTindakanPmi += $jmlTind+$obat;
			$jumlahBayar += $Bayar;
			$totalBiaya += $jmlTind-$Bayar+$obat;

			?>
			<td width="4%" align="right" class="isidlm"><?php if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63') echo "-"; else echo number_format($rwTin['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwVisite['jml'],0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($rwGizi['jml'],0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($rwIGD['jml'],0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($rwRWJ['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwPoli['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwRehab['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwOp['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwPk['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwRad['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwPa['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwEnd['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rwHd['jml'],0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($jmlTind,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($Bayar,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($rwObat['jml'],0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($rwObat['jml'],0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($pmi,0,",",".");?></td>
			<?php $jumlahTindakan = $Bayar+$rwObat['jml'];?>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($jumlahTindakan,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($krgByr,0,",",".");?></td>
		</tr>
		</table>
		</td>
	</tr>
	<?php
	}
	?>
	</form>
	<tr valign="top">
		<td width="1%" class="last">&nbsp;</td>
		<td width="3%" class="last">&nbsp;</td>
		<td width="8%" class="last">&nbsp;</td>
		<td width="8%" class="last">&nbsp;</td>
		<td width="80%" class="tbl">		 
		<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="5" width="18%" height="25" class="isidlm" style="font-weight:bold;text-align:center;border-left:1px solid #000">TOTAL</td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($kamar,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($makan,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($tindakanNO,0,",",".");?></span></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($visite,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($gizi,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($igd,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($rwj,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($poli,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rehab,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($tindakanO,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($lab,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($rad,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($pa,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($end,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($hd,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($jmlTindakan,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($jmlTindakanByr,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($obat,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($byrobat,0,",",".");?></td>
			<td width="3%" align="right" class="isidlm"><?php echo number_format($totpmi,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($jumlahTindakanObat,0,",",".");?></td>
			<td width="4%" align="right" class="isidlm"><?php echo number_format($totkrgByr,0,",",".");?></td>
		</tr>
		</table>
		</td>
	</tr>
	</table>	
	</td>
</tr>
<tr id="trTombol">
	<td class="noline" align="center" height="30">
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
		<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
	</td>
</tr>
</table>
</body>
<?php
	mysql_free_result($rsPenjamin);
	mysql_free_result($rsTmp);
	mysql_close($konek);
?>
</html>