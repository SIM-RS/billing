<?php 
include("../../koneksi/konek.php");

$stsPas = $_REQUEST['StatusPas0'];
//if($stsPas>0) $fKso=" b_kunjungan.kso_id = '".$stsPas."' ";
$jnsLay = $_REQUEST['JnsLayananDenganInap'];
$tmpLay = $_REQUEST['TmpLayananInapSaja'];

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");
//$stsPas,$jnsLay,$tmpLay,$waktu,$tglAwal,$tglAhkir,$bln,$thn
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$sqlPenjamin = "SELECT nama FROM b_ms_kso WHERE id='".$stsPas."'";
$rsPenjamin = mysql_query($sqlPenjamin);
$hsPenjamin = mysql_fetch_array($rsPenjamin);

$sqlTmp = "SELECT nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
$rsTmp = mysql_query($sqlTmp);
$rwTmp = mysql_fetch_array($rsTmp);

$sqlJns = "SELECT nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
$rsJns = mysql_query($sqlJns);
$rwJns = mysql_fetch_array($rsJns);

$tglAwal = explode('-',$_REQUEST['tglAwal']);
$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
//echo $arrBln[$tglAwal[1]];
$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
$waktu = " AND b_bayar.tgl between '$tglAwal2' and '$tglAkhir2' ";

$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";

/*
if($_REQUEST['export']=='excel'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Laporan_rinci.xls"');
}
*/

//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('RINCIAN_PER_NAMA_PASIEN_RAWAT_INAP_UMUM.xls');

$worksheet=&$workbook->addWorksheet('Laporan_rinci');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

	$worksheet->setColumn (0, 0, 5);
	$worksheet->setColumn (1, 1, 8);
	$worksheet->setColumn (2, 2, 30);
	$worksheet->setColumn (3, 3, 8);
	$worksheet->setColumn (4, 5, 15);
	$worksheet->setColumn (6, 6, 10);
	$worksheet->setColumn (7, 7, 15);
	$worksheet->setColumn (8, 8, 8);
	$worksheet->setColumn (9, 30, 15);

$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormatL =& $workbook->addFormat(array('bold'=>1,'top'=>1,'left'=>1,'right'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter','height'=>25,'textWrap'=>1));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'right'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter','height'=>25,'textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));

$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormatL =& $workbook->addFormat(array('left'=>1,'top'=>1,'right'=>1,'size'=>8,'align'=>'left','textWrap'=>1));
$regularFormat =& $workbook->addFormat(array('top'=>1,'right'=>1,'size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatB =& $workbook->addFormat(array('top'=>1,'right'=>1,'bottom'=>1,'size'=>8,'align'=>'left','textWrap'=>1));
$blankFormatL =& $workbook->addFormat(array('left'=>1,'right'=>1,'size'=>8,'align'=>'left','textWrap'=>1));
$blankFormat =& $workbook->addFormat(array('right'=>1,'size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('top'=>1,'right'=>1,'size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatRFB =& $workbook->addFormat(array('top'=>1,'right'=>1,'bottom'=>1,'size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$TotFormat =& $workbook->addFormat(array('left'=>1,'top'=>1,'bottom'=>1,'right'=>1,'bold'=>1,'size'=>8,'align'=>'right','textWrap'=>1));
$TotFormatB =& $workbook->addFormat(array('bottom'=>1,'top'=>1,'bold'=>1,'size'=>8,'align'=>'right','textWrap'=>1));
$TotFormatRF =& $workbook->addFormat(array('bottom'=>1,'top'=>1,'right'=>1,'size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row = 0;

$worksheet->write($row,$column,"PEMERINTAH KABUPATEN SIDOARJO",$unitTitleFormat);
$row += 1;
$worksheet->write($row,$column,"Rumah Sakit Umum Daerah Kabupaten Sidoarjo",$unitTitleFormat);
$row += 1;
$worksheet->write($row,$column,"Jl.Mojopahit 667 Sidoarjo",$unitTitleFormat);
$row += 1;
$worksheet->write($row,$column,"Telepon (031) 896 1649",$unitTitleFormat);
$row += 2;

$worksheet->write($row, 11, "RINCIAN PER NAMA PASIEN PENERIMA RAWAT INAP UMUM", $sheetTitleFormat);
$worksheet->writeBlank($row, 12, $UnitTitleFormat);
$worksheet->writeBlank($row, 13, $UnitTitleFormat);
$worksheet->writeBlank($row, 14, $UnitTitleFormat);
$worksheet->writeBlank($row, 15, $UnitTitleFormat);
$worksheet->mergeCells($row,11,$row,15);
$row += 1;
$worksheet->write($row, 11, "PERIODE $periode", $sheetTitleFormat);
$worksheet->writeBlank($row, 12, $UnitTitleFormat);
$worksheet->writeBlank($row, 13, $UnitTitleFormat);
$worksheet->writeBlank($row, 14, $UnitTitleFormat);
$worksheet->writeBlank($row, 15, $UnitTitleFormat);
$worksheet->mergeCells($row,11,$row,15);
$row += 1;
if($tmpLay==0){
$worksheet->write($row, 11,"SEMUA", $sheetTitleFormat);
}else{
$worksheet->write($row, 11, $rwTmp['nama'], $sheetTitleFormat);
}
$worksheet->writeBlank($row, 12, $UnitTitleFormat);
$worksheet->writeBlank($row, 13, $UnitTitleFormat);
$worksheet->writeBlank($row, 14, $UnitTitleFormat);
$worksheet->writeBlank($row, 14, $UnitTitleFormat);
$worksheet->mergeCells($row,11,$row,15);
$row += 2;

//====================Header Field====================//
$worksheet->write($row,$column,"No",$columnTitleFormatL);
$worksheet->write($row,$column+1,"No MR",$columnTitleFormat);
$worksheet->write($row,$column+2,"Nama Pasien",$columnTitleFormat);
$worksheet->write($row,$column+3,"Status",$columnTitleFormat);
$worksheet->write($row,$column+4,"MRS",$columnTitleFormat);
$worksheet->write($row,$column+5,"KRS",$columnTitleFormat);
$worksheet->write($row,$column+6,"HARI RAWAT",$columnTitleFormat);
$worksheet->write($row,$column+7,"RUANG RAWAT",$columnTitleFormat);
$worksheet->write($row,$column+8,"KELAS",$columnTitleFormat);
$worksheet->write($row,$column+9,"KAMAR",$columnTitleFormat);
$worksheet->write($row,$column+10,"MAKAN",$columnTitleFormat);
$worksheet->write($row,$column+11,"TINDAKAN NON OPERATIF",$columnTitleFormat);
$worksheet->write($row,$column+12,"JASA VISITE",$columnTitleFormat);
$worksheet->write($row,$column+13,"KONSUL GIZI",$columnTitleFormat);
$worksheet->write($row,$column+14,"IGD",$columnTitleFormat);
$worksheet->write($row,$column+15,"RWJ",$columnTitleFormat);
$worksheet->write($row,$column+16,"KONSUL POLI",$columnTitleFormat);
$worksheet->write($row,$column+17,"REHAB MEDIK",$columnTitleFormat);
$worksheet->write($row,$column+18,"TINDAKAN OPERATIF",$columnTitleFormat);
$worksheet->write($row,$column+19,"LAB PK",$columnTitleFormat);
$worksheet->write($row,$column+20,"RAD",$columnTitleFormat);
$worksheet->write($row,$column+21,"PA",$columnTitleFormat);
$worksheet->write($row,$column+22,"ENDOSCOPY",$columnTitleFormat);
$worksheet->write($row,$column+23,"HD",$columnTitleFormat);
$worksheet->write($row,$column+24,"JUMLAH TINDAKAN",$columnTitleFormat);
$worksheet->write($row,$column+25,"BAYAR TINDAKAN",$columnTitleFormat);
$worksheet->write($row,$column+26,"OBAT",$columnTitleFormat);
$worksheet->write($row,$column+27,"BAYAR OBAT",$columnTitleFormat);
$worksheet->write($row,$column+28,"PMI",$columnTitleFormat);
$worksheet->write($row,$column+29,"JUMLAH OBAT + TINDAKAN YANG DIBAYAR",$columnTitleFormat);
$worksheet->write($row,$column+30,"KEKURANGAN BAYAR",$columnTitleFormat);


$row += 1;
$column = 0;

$fKso = "AND p.kso_id = '1'";
   
$qry="SELECT DISTINCT mp.no_rm,mp.nama pasien,p.kunjungan_id 
	FROM (SELECT * FROM b_bayar WHERE kasir_id=83 $waktu) b 
	INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id INNER JOIN b_pelayanan p ON k.id = p.kunjungan_id 
	INNER JOIN b_ms_unit mu ON p.unit_id = mu.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
	WHERE mu.inap = '1' $fKso ORDER BY p.id";

$rs = mysql_query($qry);
$i=0;
$j=0;

while($rw = mysql_fetch_array($rs)){			
	$i++;
	$tglKunj = $rw["tglKunj"];

	//===============================================//
	$worksheet->write($row,$column,$i,$regularFormatL);
	$worksheet->write($row,$column+1,$rw['no_rm'],$regularFormatL);
	$worksheet->write($row,$column+2,$rw['pasien'],$regularFormat);
	//$worksheet->write($row+1,$column+2,$rw['no_anggota'],$regularformat);
	//$worksheet->write($row+2,$column+2,$rw['nama_peserta'],$regularformat);
	$worksheet->write($row,$column+3,"UMUM",$regularFormat);

	$qLop = "SELECT DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') AS masuk,
			DATE_FORMAT(b_pelayanan.tgl_krs,'%d-%m-%Y') AS keluar, SUM(IF(b_tindakan_kamar.status_out=0,
			IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
			DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
			IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
			DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS jHr, b_ms_kso.nama AS penjamin,b_ms_unit.nama AS kamar,
			b_ms_kelas.nama AS kelas, b_pelayanan.unit_id, b_pelayanan.id AS pelayanan_id FROM b_pelayanan
			INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id OR (b_pelayanan.unit_id=47 OR b_pelayanan.unit_id=63)
			INNER JOIN b_ms_kelas ON b_ms_kelas.id = b_tindakan_kamar.kelas_id INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
			INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
			WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_ms_unit.inap='1' GROUP BY b_pelayanan.id";
			
	$rsLop = mysql_query($qLop);
	$jmlLop = mysql_num_rows($rsLop);
	$jmlKmr = 0;
	$jmlMkn=0;
	
	while($rwLop = mysql_fetch_array($rsLop)){
	
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
		
		$worksheet->write($row,$column+4,$rwLop['masuk'],$regularFormatB);
		$worksheet->write($row,$column+5,$rwLop['keluar'],$regularFormatB);
		$worksheet->write($row,$column+6,$rwLop['jHr'],$regularFormatB);
		$worksheet->write($row,$column+7,$rwLop['kamar'],$regularFormatB);
		$worksheet->write($row,$column+8,$rwLop['kelas'],$regularFormatB);
		$worksheet->write($row,$column+9,$rwKamar['jml'],$regularFormatRFB);
		$worksheet->write($row,$column+10,$rwMakan['jml'],$regularFormatRFB);
		
		$j++;
		$jmlKmr = $jmlKmr + $rwKamar['jml'];
		$jmlMkn = $jmlMkn + $rwMakan['jml'];
		$row++;
		$column = 0;
	}
	for($x=0;$x<=4;$x++){
		for($y=1;$y<=$jmlLop;$y++){
			$worksheet->writeBlank($row+$y,$column+$x,$blankFormat);
		}
	}
	
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
			WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '1' AND b_ms_unit.inap='0' AND b_ms_unit.id<>47) AS t";
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

	$rsObat = mysql_query($qObat);
	$rwObat = mysql_fetch_array($rsObat);
	
	$pmi = 0;
	
	$jmlTin = $jmlMkn + $jmlKmr + $rwTin['jml'] + $rwVisite['jml'] + $rwGizi['jml'] + $rwIGD['jml'] + $rwRWJ['jml'] + $rwPoli['jml'] + $rwRehab['jml'] + $rwOp['jml'] + 
				$rwPk['jml'] + $rwRad['jml'] + $rwPa['jml'] + $rwEnd['jml'] + $rwHd['jml'];

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
	$rsByr = mysql_query($qByr);
	$rwByr = mysql_fetch_array($rsByr);
	
	/*$qKamarByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
			FROM b_pelayanan 
			INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
			INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id
			INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."'
			AND b_bayar_tindakan.tipe=1 AND b_bayar.kasir_id='83' $waktu
			GROUP BY b_bayar_tindakan.id 
			ORDER BY b_bayar_tindakan.id) AS t";*/
	$qKamarByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
			FROM b_pelayanan 
			INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
			INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id
			INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."'
			AND b_bayar_tindakan.tipe=1 $waktu
			GROUP BY b_bayar_tindakan.id 
			ORDER BY b_bayar_tindakan.id) AS t";
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
	
	if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63'){
		$worksheet->write($row-1,$column+11,"-",$regularFormatRFB);
	}else{
		$worksheet->write($row-1,$column+11,$rwTin['jml'],$regularFormatRFB);
	}
	$worksheet->write($row-1,$column+12,$rwVisite['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+13,$rwGizi['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+14,$rwIGD['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+15,$rwRWJ['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+16,$rwPoli['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+17,$rwRehab['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+18,$rwOp['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+19,$rwPk['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+20,$rwRad['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+21,$rwPa['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+22,$rwEnd['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+23,$rwHd['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+24,$jmlTind,$regularFormatRFB);
	$worksheet->write($row-1,$column+25,$Bayar,$regularFormatRFB);
	$worksheet->write($row-1,$column+26,$rwObat['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+27,$rwObat['jml'],$regularFormatRFB);
	$worksheet->write($row-1,$column+28,$pmi,$regularFormatRFB);
	$worksheet->write($row-1,$column+29,$jumlahTindakan,$regularFormatRFB);
	$worksheet->write($row-1,$column+30,$krgByr,$regularFormatRFB);

}
$row += 1;
$column = 0;

$worksheet->writeBlank($row,$column,$TotFormat);
for($s=1;$s<8;$s++){
$worksheet->writeBlank($row,$column+$s,$TotFormatB);
}
$worksheet->mergeCells($row,$column,$row,$column+8);

$worksheet->write($row,$column+8,"TOTAL",$TotFormat);
$worksheet->write($row,$column+9,$kamar,$TotFormatRF);
$worksheet->write($row,$column+10,$makan,$TotFormatRF);
$worksheet->write($row,$column+11,$tindakanNO,$TotFormatRF);
$worksheet->write($row,$column+12,$visite,$TotFormatRF);
$worksheet->write($row,$column+13,$gizi,$TotFormatRF);
$worksheet->write($row,$column+14,$igd,$TotFormatRF);
$worksheet->write($row,$column+15,$rwj,$TotFormatRF);
$worksheet->write($row,$column+16,$poli,$TotFormatRF);
$worksheet->write($row,$column+17,$rehab,$TotFormatRF);
$worksheet->write($row,$column+18,$tindakanO,$TotFormatRF);
$worksheet->write($row,$column+19,$lab,$TotFormatRF);
$worksheet->write($row,$column+20,$rad,$TotFormatRF);
$worksheet->write($row,$column+21,$pa,$TotFormatRF);
$worksheet->write($row,$column+22,$end,$TotFormatRF);
$worksheet->write($row,$column+23,$hd,$TotFormatRF);
$worksheet->write($row,$column+24,$jmlTindakan,$TotFormatRF);
$worksheet->write($row,$column+25,$jmlTindakanByr,$TotFormatRF);
$worksheet->write($row,$column+26,$obat,$TotFormatRF);
$worksheet->write($row,$column+27,$byrobat,$TotFormatRF);
$worksheet->write($row,$column+28,$totpmi,$TotFormatRF);
$worksheet->write($row,$column+29,$jumlahTindakanObat,$TotFormatRF);
$worksheet->write($row,$column+30,$totkrgByr,$TotFormatRF);


$workbook->close();
mysql_free_result($rsPenjamin);
mysql_free_result($rsTmp);
mysql_close($konek);
?>