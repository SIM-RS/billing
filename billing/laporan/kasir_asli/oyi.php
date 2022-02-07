<?php 
session_start();
include("../../sesi.php");
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
	$waktu = " AND DATE(b_kunjungan.tgl_pulang) = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(b_kunjungan.tgl_pulang) = '$bln' and year(b_kunjungan.tgl_pulang) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND DATE(b_kunjungan.tgl_pulang) between '$tglAwal2' and '$tglAkhir2' ";
	
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

<html>
<head>
</head>
<body>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
<td rowspan="2">No</td>
<td rowspan="2">No MR</td>
<td rowspan="2">Nama Pasien</td>
<td colspan="21"><center>Tagihan KSO</center></td>
<td rowspan="2">JAMINAN KSO</td>
<td rowspan="2">IURAN BAYAR</td>
<td rowspan="2">OBAT</td>
<td rowspan="2">JUMLAH TINDAKAN+OBAT</td>
<td rowspan="2">PMI</td>
<td rowspan="2">JUMLAH TINDAKAN OBAT+PMI</td>
</tr>
	
			
<tr>
<td>STATUS KSO</td>
<td>MRS</td>
<td>KRS</td>
<td>HR RWT</td>
<td>RUANG RWT</td>
<td>KELAS</td>
<td>KAMAR</td>
<td>MAKAN</td>
<td>TINDAKAN NON OPERATIF</td>
<td>JASA VISIE</td>
<td>KONSULTASI GIZI</td>
<td>IGD</td>
<td>KONSUL POLI</td>
<td>REHAB MEDIK</td>
<td>TINDAKAN OPERATIF</td>
<td>LAB PK</td>
<td>RAD</td>
<td>PA</td>
<td>ENDOSCOPY</td>
<td>HD</td>
<td>JUMLAH TINDAKAN</td>
</tr>
<?php
    if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id = '".$stsPas."'";
    if($tmpLay==0){ 
	$tmb = "INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id";
	$fUnit = "b_pelayanan.jenis_layanan = '".$jnsLay."' AND b_ms_unit.inap='1'";
    }else{ $fUnit = "b_pelayanan.unit_id = '".$tmpLay."'";}
    
	$qry = "SELECT b_kunjungan.id AS kunjungan_id,b_kunjungan.tgl AS tglKunj, b_pelayanan.id AS pelayanan_id,b_ms_kso.nama AS kso,
			b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_ms_pasien.id,
			IF(b_ms_kso_pasien.no_anggota='','-',b_ms_kso_pasien.no_anggota) AS no_anggota, 
			IF(b_ms_kso_pasien.nama_peserta='','-',b_ms_kso_pasien.nama_peserta) AS nama_peserta, 
			IF(b_ms_kso_pasien.instansi_id=0,'-', b_ms_instansi.nama) AS instansi, b_ms_kso_pasien.instansi_id AS inst_id
            FROM b_ms_pasien
			INNER JOIN b_kunjungan ON b_ms_pasien.id = b_kunjungan.pasien_id
			INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id $tmb
			INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
			INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
			LEFT JOIN b_ms_kso_pasien ON b_ms_kso_pasien.pasien_id=b_ms_pasien.id
			LEFT JOIN b_ms_instansi ON b_ms_instansi.id=b_ms_kso_pasien.instansi_id
			WHERE $fUnit $waktu $fKso AND b_ms_kso.id = 1 GROUP BY b_pelayanan.id ORDER BY b_tindakan_kamar.tgl_out";

	$rs = mysql_query($qry);
	$i=0;
	$j=0;
	while($rw = mysql_fetch_array($rs)){					
	$i++;
	$tglKunj = $rw["tglKunj"];
	?>
	
<tr>
<td><?php echo $i;?></td>
<td><?php echo $rw['no_rm'];?></td>
<td><?php echo $rw['pasien'];?></td>
<td><?php echo $rw['no_anggota'];?></td>
<td><?php echo $rw['nama_peserta'];?></td>
<td><?php echo $rw['kso'];?></td>
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
			$jmlKmr = 0; $jmlMkn=0;
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
				?>
<td><?php echo $rwLop['masuk']?></td>
<td><?php echo $rwLop['keluar']?></td>
<td><?php echo $rwLop['jHr']?></td>
<td><?php echo $rwLop['kamar']?></td>
<td><?php echo $rwLop['kelas']?></td>
<td><?php echo number_format($rwKamar['jml'],0,",",".");?></td>
<td><?php echo number_format($rwMakan['jml'],0,",","."); ?></td>
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
					b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_kso AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
					INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND b_ms_unit.inap='1'
					AND b_ms_tindakan.id NOT IN (742,746,747,748,749,2387) 
					AND b_ms_tindakan.klasifikasi_id NOT IN (13,14) ) AS t";
			$rsTin = mysql_query($qTin);
			$rwTin = mysql_fetch_array($rsTin);

			$qVisite = "SELECT SUM(t.biaya) AS jml FROM (SELECT SUM(b_tindakan.qty)*b_tindakan.biaya_kso AS biaya 
					FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
					INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
					WHERE (b_ms_tindakan.klasifikasi_id = '13' OR b_ms_tindakan.klasifikasi_id = '14' AND b_ms_tindakan.id<>'2378') 
					AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3 GROUP BY b_tindakan.id) AS t";
			$rsVisite = mysql_query($qVisite);
			$rwVisite = mysql_fetch_array($rsVisite);

			$qGizi = "SELECT SUM(t.biaya) AS jml FROM (SELECT SUM(b_tindakan.qty)*b_tindakan.biaya_kso AS biaya FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
					INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
					WHERE (b_ms_tindakan.id = '2387' OR b_ms_tindakan.id='2378') 
					AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3) as t";
			$rsGizi = mysql_query($qGizi);
			$rwGizi = mysql_fetch_array($rsGizi);

			$qOp = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty,
					b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total FROM b_pelayanan
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'
					AND b_pelayanan.jenis_kunjungan=3 AND b_pelayanan.unit_id IN (47,63)) AS t";
			$rsOp = mysql_query($qOp);
			$rwOp = mysql_fetch_array($rsOp);
			
			$qPk = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='58') AS t";
			$rsPk = mysql_query($qPk);
			$rwPk = mysql_fetch_array($rsPk);
			
			$qRad = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='61') AS t";
			$rsRad = mysql_query($qRad);
			$rwRad = mysql_fetch_array($rsRad);
			
			$qPa = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='59') AS t";
			$rsPa = mysql_query($qPa);
			$rwPa = mysql_fetch_array($rsPa);
			
			$qHd = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total  
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='65') AS t";
			$rsHd = mysql_query($qHd);
			$rwHd = mysql_fetch_array($rsHd);
			
			$qEnd = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total  
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
			
			$jmlTin = $rwOp['jml'] + $jmlMkn + $jmlKmr + $rwVisite['jml'] +
						$rwGizi['jml'] + $rwPk['jml'] + $rwRad['jml'] +
						$rwHd['jml'] + $rwEnd['jml'] + $rwPa['jml'] + $rwTin['jml'];
			$jmlTind = $jmlTin;
			
			$qByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
					INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id
					INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3'
					GROUP BY b_bayar_tindakan.id 
					ORDER BY b_bayar_tindakan.id) AS t";
			$rsByr = mysql_query($qByr);
			$rwByr = mysql_fetch_array($rsByr);
			
			$qKamarByr = "SELECT SUM(cH.hari*cH.bayar_pasien) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
						IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
						IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
						DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.bayar_pasien
						FROM b_pelayanan 
						INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
						WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";
			$rsKamarByr = mysql_query($qKamarByr);
			$rwKamarByr = mysql_fetch_array($rsKamarByr);
			$Bayar = $rwByr['jml'] + $rwKamarByr['jml'];
			
			// $igd += $rwIgd['jml'];
			$makan += $jmlMkn;
			$kamar += $jmlKmr;
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
			$obat += $rwObat['jml'];
			$jumlahTindakanObat += $jmlTind+$obat;
			$jumlahTindakanPmi += $jmlTind+$obat;
			$jumlahBayar += $Bayar;
			$totalBiaya += $jmlTind-$Bayar+$obat;

			?>

<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
<?php
	}
	?>
</table>
</body>
<?php
	mysql_free_result($rsPenjamin);
	mysql_free_result($rsTmp);
	mysql_close($konek);
?>
</html>
