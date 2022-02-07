<?php 
	include("../../koneksi/konek.php");
	include("../../sesi.php");
	//==========Menangkap filter data====
	$stsPas = $_REQUEST['StatusPas0'];
	//if($stsPas>0) $fKso=" b_kunjungan.kso_id = '".$stsPas."' ";
	$jnsLay = $_REQUEST['JnsLayananDenganInap'];
	$tmpLay = $_REQUEST['TmpLayananInapSaja'];
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND DATE(b_tindakan_kamar.tgl_out) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " AND month(b_tindakan_kamar.tgl_out) = '$bln' and year(b_tindakan_kamar.tgl_out) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " AND DATE(b_tindakan_kamar.tgl_out) between '$tglAwal2' and '$tglAkhir2' ";
		
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
<title>Rekap Tagihan</title>
<style>
   .withline{
   border:1px solid #000000;
   }
   .isi{
   font-family:Arial, Helvetica, sans-serif; font-size:9px;}
   .jdl
   { 	border-top:1px solid #000000;
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
	.tbl
	{
		border-left:1px solid;
		border-bottom:1px solid;
	}
</style>
</head>

<body>
<table border="0" cellspacing="0" cellpadding="0" class="tabel" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" width="2300">
  <tr>
    <td><b><?=$pemkabRS?><br><?=$namaRS?><br><?=$alamatRS?><br>Telepon <?=$tlpRS?></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="top" height="70" style="font-weight:bold; font-size:14px; text-transform:uppercase">rekapitulasi pengajuan klaim pasien <?php if($stsPas==0) echo "SEMUA"; else echo $hsPenjamin['nama'];?><br /><?php echo $Periode;?></td>
  </tr>
  <tr>
      <td style="font-weight:bold;" height="30">Jenis Layanan : <?php echo $rwJns['nama'];?><br />Tempat Layanan : <?php if($tmpLay==0) echo "SEMUA"; else echo $rwTmp['nama'];?></td>
   </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
			<tr valign="top">
				<td width="1%" class="jdl">No</td>
				<td width="3%" class="jdl">No MR</td>
				<td width="8%" class="jdl">Nama Penderita<br />No Peserta<br />Nama Peserta<br></td>
				<td width="8%" class="jdl">Nama Perusahaan</td>
				<td width="80%" class="jdl">			 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr style="text-align:center; font-weight:bold;">
							<td width="5%" class="right">Diagnosa</td>
							<td width="4%" class="right">MRS</td>
							<td width="4%" class="right">KRS</td>
							<td width="2%" class="right">Hari<br />RWT</td>
							<td width="4%" class="right">Ruang<br />Rawat</td>
							<td width="4%" class="right">Kelas</td>
							<td width="4%" class="right">Kamar</td>
							<td width="4%" class="right">Makan</td>
							<td width="4%" class="right">Tindakan Non Operatif</td>
							<td width="4%" class="right">Jasa Visite</td>
							<td width="4%" class="right">Konsul Gizi</td>
							<td width="4%" class="right">Tindakan Operatif</td>
							<td width="4%" class="right">PK</td>
							<td width="4%" class="right">PA</td>
							<td width="3%" class="right">Rad</td>
							<td width="3%" class="right">HD</td>
							<td width="3%" class="right">Ends</td>
							<td width="4%" class="right">Jumlah Tindakan</td>
							<td width="4%" class="right">Obat</td>
							<td width="4%" class="right">Jumlah Tindakan<br />+ Obat</td>
							<td width="4%" class="right">PMI</td>
							<td width="4%" class="right">Jumlah</td>
							<td width="4%" class="right">Bayar Tunai</td>
							<td width="4%" class="right">Total<br />Biaya Px</td>
							<td width="4%" class="right">Status<br />Verifikasi</td>
						    <td width="4%" class="right">Penjamin<br />Px</td>
						</tr>
				  </table>
			  </td>
			</tr>
			<form>
			<?php
				/* $igd = $kamar = $makan = $tindakanNO = $visite = $gizi = $tindakanO = $lab = $rad = $pa = $jmlTindakan = $obat
					= $jumlahTindakanObat = $pmi = $jumlahBayar = $totalBiaya = 0; */
                    if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id = '".$stsPas."'";
                    if($tmpLay==0){ 
					$tmb = "INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id";
					$fUnit = "b_pelayanan.jenis_layanan = '".$jnsLay."' AND b_ms_unit.inap='1'";
                    }else{ $fUnit = "b_pelayanan.unit_id = '".$tmpLay."'";}
                   	$qry = "SELECT b_kunjungan.id AS kunjungan_id, b_pelayanan.id AS pelayanan_id,
                    	b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien
                    	FROM b_ms_pasien
                    	INNER JOIN b_kunjungan ON b_ms_pasien.id = b_kunjungan.pasien_id
                    	INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id $tmb
                    	INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
                    	WHERE $fUnit $waktu $fKso AND b_ms_kso.id <> 1 GROUP BY b_pelayanan.id ORDER BY b_tindakan_kamar.tgl_out";
                    $rs = mysql_query($qry);
                    while($rw = mysql_fetch_array($rs)){
                    $i++;
			?>
			<tr valign="top">
				<td width="1%" style="text-align:center;" class="tbl"><?php echo $i?></td>
				<td width="3%" class="tbl" style="text-align:center;"><?php echo $rw['no_rm']?></td>
				<td width="8%" class="tbl" style="padding-left:5px; text-transform:uppercase"><?php echo $rw['pasien'];?><br>
				<input id="txtNo" size="18" class="isi" /><br>
				<input id="txtNm" size="18" class="isi" maxlength="30" /></td>
				<td width="8%" class="tbl" style="padding-left:5px;"><textarea id="txtKntr" cols="25" class="isi"></textarea></td>
				<td width="80%" class="tbl">
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
						$rsLop = mysql_query($qLop);
						while($rwLop = mysql_fetch_array($rsLop))
						{							 
							 $qKamar = "SELECT SUM(cH.hari*cH.beban_kso) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.beban_kso
FROM b_pelayanan 
INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";
							 $rsKamar = mysql_query($qKamar);
							 $rwKamar = mysql_fetch_array($rsKamar);
							 
							 $qMakan = "SELECT SUM(b_tindakan.qty*b_tindakan.biaya_kso) AS jml 
                             FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id 
                             INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
                             INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id 
                             WHERE b_pelayanan.id='".$rwLop['pelayanan_id']."' 
                             AND b_ms_tindakan.id IN (742,746,747,748,749)";
							 $rsMakan = mysql_query($qMakan);
							 $rwMakan = mysql_fetch_array($rsMakan);
							 
							 $qTin = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
                             b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_kso AS total, 
                             b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
                             INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
                             INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
                             WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' 
                             AND b_ms_tindakan.id NOT IN (742,746,747,748,749,2387) 
                             AND b_ms_tindakan.klasifikasi_id NOT IN (13,14) ) AS t";
							 $rsTin = mysql_query($qTin);
							 $rwTin = mysql_fetch_array($rsTin);
							 
							 $qVisite = "SELECT SUM(t.biaya) AS jml FROM (SELECT SUM(b_tindakan.qty)*b_tindakan.biaya_kso AS biaya 
                             FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
                             INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
                             INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
                             WHERE (b_ms_tindakan.klasifikasi_id = '13' OR b_ms_tindakan.klasifikasi_id = '14' AND b_ms_tindakan.id<>'2378') 
                             AND b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan.id) AS t";
							 $rsVisite = mysql_query($qVisite);
							 $rwVisite = mysql_fetch_array($rsVisite);
							 
							 $qGizi = "SELECT SUM(t.biaya) AS jml FROM (SELECT SUM(b_tindakan.qty)*b_tindakan.biaya_kso AS biaya FROM b_pelayanan 
								INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
								INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
								INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
								WHERE (b_ms_tindakan.id = '2387' OR b_ms_tindakan.id='2378') AND b_pelayanan.id = '".$rwLop['pelayanan_id']."') as t";
							 $rsGizi = mysql_query($qGizi);
							 $rwGizi = mysql_fetch_array($rsGizi);
							 
							 $qOp = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty,
								b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan
								INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'
								AND b_pelayanan.unit_id = '".$rwLop['unit_id']."') AS t";
							 $rsOp = mysql_query($qOp);
							 $rwOp = mysql_fetch_array($rsOp);
							 
							 $qPk = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_pelayanan.id > '".$rwLop['pelayanan_id']."' AND b_pelayanan.unit_id = '58' AND b_pelayanan.unit_id_asal = '".$rwLop['unit_id']."') AS t";
							 $rsPk = mysql_query($qPk);
							 $rwPk = mysql_fetch_array($rsPk);
							 
							 $qRad = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'  AND b_pelayanan.id > '".$rwLop['pelayanan_id']."'  AND b_pelayanan.unit_id = '61'  AND b_pelayanan.unit_id_asal = '".$rwLop['unit_id']."') AS t";
							 $rsRad = mysql_query($qRad);
							 $rwRad = mysql_fetch_array($rsRad);
							 
							 $qPa = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'  AND b_pelayanan.id > '".$rwLop['pelayanan_id']."'  AND b_pelayanan.unit_id = '59'  AND b_pelayanan.unit_id_asal = '".$rwLop['unit_id']."') AS t";
							 $rsPa = mysql_query($qPa);
							 $rwPa = mysql_fetch_array($rsPa);
							 
							 $qHd = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'  AND b_pelayanan.id > '".$rwLop['pelayanan_id']."'  AND b_pelayanan.unit_id = '65'  AND b_pelayanan.unit_id_asal = '".$rwLop['unit_id']."') AS t";
							 $rsHd = mysql_query($qHd);
							 $rwHd = mysql_fetch_array($rsHd);
							 
							 $qEnd = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_pelayanan.id > '".$rwLop['pelayanan_id']."'  AND b_pelayanan.unit_id = '67'  AND b_pelayanan.unit_id_asal = '".$rwLop['unit_id']."') AS t";
							 $rsEnd = mysql_query($qEnd);
							 $rwEnd = mysql_fetch_array($rsEnd);
							 
							 
							if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63'){
								$jmlTin = $rwOp['jml'] + $rwPk['jml'] + $rwRad['jml'] +
										$rwHd['jml'] + $rwEnd['jml'] + $rwPa['jml'];
							}else{
								$jmlTin = $rwKamar['jml'] + $rwMakan['jml'] + $rwVisite['jml'] +
										$rwGizi['jml'] + $rwPk['jml'] + $rwRad['jml'] +
										$rwHd['jml'] + $rwEnd['jml'] + $rwPa['jml'] + $rwTin['jml'];
							}
							  //$jmlTin = $rwKamar['jml'] + $rwMakan['jml'] + $rwVisite['jml'] + $rwGizi['jml'] + $rwOp['jml'] + $rwPk['jml'] + $rwRad['jml'] + $rwHd['jml'] + $rwEnd['jml'] + $rwPa['jml'] + $rwTin['jml'];
							 //$rwKamar['jml'] + 
							 //$jmlTin2 = $rwIgd['jml'] + $rwMakan['jml'] + $rwVisite['jml'] + $rwGizi['jml'] + $rwOp['jml'] + $rwPk['jml'] + $rwRad['jml'] + $rwHd['jml'] + $rwEnd['jml'] + $rwPa['jml'];
							 //$tinOp = $rwTin['jml'] - $jmlTin2;
							 $jmlTind = $jmlTin;
							 
							 $qByr = "SELECT SUM(b_tindakan.bayar_pasien) AS jml, 
								(SELECT SUM(b_tindakan_kamar.bayar_pasien) AS bayar FROM b_tindakan_kamar 
								WHERE b_tindakan_kamar.pelayanan_id = b_pelayanan.id) AS bayarPas
								FROM b_pelayanan 
								INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
								INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id
								INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id
								WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'";
							$rsByr = mysql_query($qByr);
							$rwByr = mysql_fetch_array($rsByr);
							 
							 $Bayar = $rwByr['jml'] + $rwByr['bayar'];
							 
							 // $igd += $rwIgd['jml'];
							  $makan += $rwMakan['jml'];
							  $kamar += $rwKamar['jml'];
							  $tindakanNO += $rwTin['jml'];
							  $visite += $rwVisite['jml'];
							  $gizi += $rwGizi['jml'];
							  $tindakanO += $rwOp['jml'];
							  $tin += $rwTin['jml'];
							  $lab += $rwPk['jml'];
							  $rad += $rwRad['jml'];
							  $hd += $rwHd['jml'];
							  $end += $rwEnd['jml'];
							  $pa += $rwPa['jml'];
							  $jmlTindakan += $jmlTind;
							  $jumlahTindakanObat += $jmlTind;
							  $jumlahTindakanPmi += $jmlTind;
							  $jumlahBayar += $Bayar;
							  $totalBiaya += $jmlTind-$Bayar;
							  
							$sqlver = "SELECT p.id FROM b_pelayanan p
							LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
							LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = p.id
							WHERE (p.verifikasi = 0 OR t.verifikasi = 0 OR tk.verifikasi = 0) AND p.id = '".$rw['pelayanan_id']."'";
							$rsver = mysql_query($sqlver);
							if(mysql_num_rows($rsver) > 0){
								$verifikasi = 0;
							}
							else{
								$verifikasi = 1;
							}
					?>			 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td width="5%" style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:left; font-size:9px; padding-left:5px;">
							<?php								
								 $qDiag = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_diagnosa_rm
									INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
									WHERE b_diagnosa_rm.pelayanan_id = '".$rwLop['pelayanan_id']."'";
								 $rsDiag = mysql_query($qDiag);
								 while($rwDiag = mysql_fetch_array($rsDiag))
								 {
								 	echo '- '.$rwDiag['nama'].'<br>';
								}
							?>							</td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['masuk']?></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['keluar']?></td>
							<td width="2%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['jHr']?></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['kamar']?></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo $rwLop['kelas']?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwKamar['jml'],0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwMakan['jml'],0,",","."); ?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63') echo "-"; else echo number_format($rwTin['jml'],0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwVisite['jml'],0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwGizi['jml'],0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63') echo number_format($rwOp['jml'],0,",","."); else echo "-";?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwPk['jml'],0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwPa['jml'],0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwRad['jml'],0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwHd['jml'],0,",",".");?></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($rwEnd['jml'],0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><?php echo number_format($jmlTind,0,",","."); ?>
								<input type="text" id="jml_tind" value="<?php echo $jmlTind;?>" style="display:none" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="4" id="obat" onkeyup="summary(this,<?php echo $i-1;?>)" class="isi" style="text-align:right" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="jml_to" class="isi" value="<?php echo $jmlTind;?>" readonly style="text-align:right" />	</td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="4" id="pmi" onkeyup="summary(this,<?php echo $i-1;?>)" class="isi" style="text-align:right" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="jml" class="isi" value="<?php echo $jmlTind;?>" readonly style="text-align:right" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="4" id="bayar" class="isi" readonly style="text-align:right" value="<?php echo $Bayar;?>" /></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input size="6" id="total" class="isi" value="<?php echo $jmlTind-$Bayar;?>" readonly style="text-align:right" /></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;color:<?php echo ($verifikasi==0 || $verifikasi=='')?'#990000':'#000099';?>"><?php echo ($verifikasi==0 || $verifikasi=='')?'belum':'sudah';?></td>
						    <td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000; font-weight:bold;"><?php echo $rwLop['penjamin'];?></td>
						</tr>
				  </table>
				  <?php 	}	?>
			  </td>
			</tr>
			<?php
					}
			?>
			</form>
			<tr valign="top">
				<td width="1%" style="text-align:center;" class="tbl">&nbsp;</td>
				<td width="3%" class="tbl" style="text-align:center;">&nbsp;</td>
				<td width="8%" class="tbl" style="padding-left:5px; text-transform:uppercase">&nbsp;</td>
				<td width="8%" class="tbl" style="padding-left:5px;">&nbsp;</td>
				<td width="80%" class="tbl">		 
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td height="25" style="border-right:1px solid #000000; border-bottom:1px solid #000000; text-align:left; text-align:center; font-weight:bold;">TOTAL</td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_kamar" style="text-align:right"><?php echo number_format($kamar,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_makan" style="text-align:right"><?php echo number_format($makan,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_nonOperatif" style="text-align:right"><?php echo number_format($tindakanNO,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_visite" style="text-align:right"><?php echo number_format($visite,0,",",".");?></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_gizi" style="text-align:right"><?php echo number_format($gizi,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_operatif" style="text-align:right"><?php echo number_format($tindakanO,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_lab" style="text-align:right"><?php echo number_format($lab,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_pa" style="text-align:right"><?php echo number_format($pa,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_rad" style="text-align:right"><?php echo number_format($rad,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_rad" style="text-align:right"><?php echo number_format($hd,0,",",".");?></span></td>
							<td width="3%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_rad" style="text-align:right"><?php echo number_format($end,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_jumlahTindakan" style="text-align:right"><?php echo number_format($jmlTindakan,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_obat" style="text-align:right"><?php echo number_format($obat,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_tindakanObat" style="text-align:right"><?php echo number_format($jumlahTindakanObat,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_pmi" style="text-align:right"><?php echo number_format($pmi,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_jumlahPmi" style="text-align:right"><?php echo number_format($jumlahTindakanPmi,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_bayar" style="text-align:right"><?php echo number_format($jumlahBayar,0,",",".");?></span></td>
							<td width="4%" style="text-align:right; padding-right:5px; border-bottom:1px solid #000000; border-right:1px solid #000000;"><span id="span_totalBiaya" style="text-align:right"><?php echo number_format($totalBiaya,0,",",".");?></span></td>
							<td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
						    <td width="4%" style="text-align:center; border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
						</tr>
				  </table>
			  </td>
			</tr>
	  </table>	
	</td>
  </tr><tr id="trTombol">
        <td class="noline" align="center" height="30">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
  <tr>
    <td align="center">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" width="10%">&nbsp;</td>
				<td width="50%" height="150" valign="bottom"></td>
				<td align="center" valign="top" width="40%"><?=$kotaRS?>,&nbsp;<?php echo $date_now;?>&nbsp;<br /><br/>Pengaju Klaim<br/>Kasubbag Pendapatan</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center"><u><?php 
				$qVal=mysql_query("SELECT nama,nip from validasi where id=2");
				$hsVal1=mysql_fetch_array($qVal);
				echo $hsVal1['nama'];
				?></u>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">&nbsp;</td>
				<td></td>
				<td align="center">NIP: <?php echo $hsVal1['nip']?>&nbsp;</td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
</body>
<?php
      mysql_free_result($rsPenjamin);
      mysql_free_result($rsTmp);
      mysql_close($konek);
?>
<script type="text/JavaScript">
function summary(par,line){
	var tmp_o = tmp_pmi = tmp_jml_tot = tmp_jml_o = tmp_jml_pmi = 0, i = 0;
	if(document.forms[0].obat.length > 1){
		if(par.id == 'obat'){
			document.forms[0].jml_to[line].value = (document.forms[0].obat[line].value*1)+(document.forms[0].jml_tind[line].value*1);
			document.forms[0].jml[line].value = (document.forms[0].jml_to[line].value*1)+(document.forms[0].pmi[line].value*1);
			document.forms[0].total[line].value = (document.forms[0].jml[line].value*1)-(document.forms[0].bayar[line].value*1);
			while(i<document.forms[0].obat.length){
				tmp_o += (document.forms[0].obat[i].value*1);
				tmp_jml_o += (document.forms[0].jml_to[i].value*1);
				tmp_jml_pmi += (document.forms[0].jml[i].value*1);
				tmp_jml_tot += (document.forms[0].total[i].value*1);
				i++;
			}
			document.getElementById('span_obat').innerHTML = FormatNumberFloor(tmp_o,'.');//FormatNum(tmp_o,0);
			document.getElementById('span_tindakanObat').innerHTML = FormatNumberFloor(tmp_jml_o,'.');
			document.getElementById('span_jumlahPmi').innerHTML = FormatNumberFloor(tmp_jml_pmi,'.');
			document.getElementById('span_totalBiaya').innerHTML = FormatNumberFloor(tmp_jml_tot,'.');
		}
		else if(par.id == 'pmi'){
			document.forms[0].jml[line].value = (document.forms[0].jml_to[line].value*1)+(document.forms[0].pmi[line].value*1);
			document.forms[0].total[line].value = (document.forms[0].jml[line].value*1)-(document.forms[0].bayar[line].value*1);
			while(i<document.forms[0].obat.length){
				//tmp_o += (document.forms[0].obat[i].value*1);
				//tmp_jml_o += (document.forms[0].jml_to[i].value*1);
				tmp_pmi += (document.forms[0].pmi[i].value*1);
				tmp_jml_pmi += (document.forms[0].jml[i].value*1);
				tmp_jml_tot += (document.forms[0].total[i].value*1);
				i++;
			}
			//document.getElementById('span_obat').innerHTML = tmp_o;
			//document.getElementById('span_tindakanObat').innerHTML = tmp_jml_o;
			document.getElementById('span_pmi').innerHTML = FormatNumberFloor(tmp_pmi,'.');
			document.getElementById('span_jumlahPmi').innerHTML = FormatNumberFloor(tmp_jml_pmi,'.');
			document.getElementById('span_totalBiaya').innerHTML = FormatNumberFloor(tmp_jml_tot,'.');
		}
	}
	else{
		if(par.id == 'obat'){
			document.getElementById('jml_to').value = (document.getElementById('obat').value*1)+(document.getElementById('jml_tind').value*1);
			document.getElementById('jml').value = (document.getElementById('jml_to').value*1)+(document.getElementById('pmi').value*1);
			document.getElementById('total').value = (document.getElementById('jml').value*1)-(document.getElementById('bayar').value*1);
		}
		else if(par.id == 'pmi'){
			document.getElementById('jml').value = (document.getElementById('jml_to').value*1)+(document.getElementById('pmi').value*1);
			document.getElementById('total').value = (document.getElementById('jml').value*1)-(document.getElementById('bayar').value*1);
		}
	}
}
/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		if(document.forms[0].obat.length > 1){
			for(var i=0; i<document.forms[0].obat.length; i++){
				document.forms[0].obat[i].style.border = '0px';
				document.forms[0].jml_to[i].style.border = '0px';
				document.forms[0].jml[i].style.border = '0px';
				document.forms[0].pmi[i].style.border = '0px';
				document.forms[0].bayar[i].style.border = '0px';
				document.forms[0].total[i].style.border = '0px';
				document.forms[0].txtNo[i].style.border = '0px';
				document.forms[0].txtNm[i].style.border = '0px';
				document.forms[0].txtKntr[i].style.border = '0px';
			}
		}
		else{
			document.getElementById('obat').style.border = '0px';
			document.getElementById('pmi').style.border = '0px';
			document.getElementById('bayar').style.border = '0px';
			document.getElementById('jml_to').style.border = '0px';
			document.getElementById('jml').style.border = '0px';
			document.getElementById('total').style.border = '0px';
			document.getElementById('txtNo').style.border = '0px';
			document.getElementById('txtNm').style.border = '0px';
			document.getElementById('txtKntr').style.border = '0px';
		}
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>
</html>
