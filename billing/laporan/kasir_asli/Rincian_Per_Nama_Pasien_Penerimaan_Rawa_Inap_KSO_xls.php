<?php
session_start();
include("../../sesi.php"); 
//session_start();
include("../../koneksi/konek.php");
set_time_limit(3000000);

//==========Menangkap filter data====
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
	
	$sqlJns = "SELECT nama FROM b_ms_unit WHERE id = '27'";
	$rsJns = mysql_query($sqlJns);
	$rwJns = mysql_fetch_array($rsJns);
    

if($_REQUEST['export']=='excel'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Laporan_rincian_per_pasien_rawa_inap_KSO.xls"');
}


//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('RINCIAN PER NAMA PASIEN PENERIMAAN RAWAT INAP.xls');

$worksheet=&$workbook->addWorksheet('Laporan_rinci');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

	$worksheet->setColumn (0, 0, 5);
	$worksheet->setColumn (1, 1, 8);
	$worksheet->setColumn (2, 2, 25);
	$worksheet->setColumn (3, 3, 15);
	$worksheet->setColumn (4, 4, 15);
	$worksheet->setColumn (5, 5, 10);
	$worksheet->setColumn (6, 6, 15);
	$worksheet->setColumn (7, 7, 15);
	$worksheet->setColumn (8, 8, 15);
	$worksheet->setColumn (9, 31, 15);
	$worksheet->setColumn (32, 32, 18);
	$worksheet->setColumn (33, 33, 10);
	$worksheet->setColumn (34, 34, 18);
	$worksheet->setColumn (35, 38, 12);

$sheetTitleFormat =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'left'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','height'=>25,'vAlign'=>'vcenter'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));

$garisKanan = & $workbook->addFormat(array('right'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$garisKananBawah = & $workbook->addFormat(array('right'=>1,'bottom'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));


$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$garisAtas =& $workbook->addFormat(array('size'=>8,'align'=>'left','top'=>1));
$textBold1 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$textBold2 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$textBold3 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));

$textBiasa1 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));
$textBiasa2 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'center','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));
$textBiasa3 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left','padding-left'=>'5','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));
$textBiasa4 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));

$column = 0;
$row = 0;


$worksheet->write($row, $column, "RINCIAN PER NAMA PASIEN PENERIMAAN RAWAT INAP", $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,3);
$row += 1;
$worksheet->write($row, $column, $Periode, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,3);
$row += 1;
$worksheet->writeBlank($row, $column, $UnitTitleFormat);
$row += 1;

//====================Header Field====================//
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "NO MR", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "NAMA PASIEN", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "MRS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "KRS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "HR RAWAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "RUANG RWT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "KLS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "KAMAR", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "MAKAN", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "TINDK. NON OPERATIF", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "JASA VISITE", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "KONSUL GIZI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "IGD", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "KONSUL POLI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "REHAB MEDIK", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "TINDKAN OPERATIF", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "LAB PK", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "RAD", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "PA", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "ENDOSCOPY", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "HD", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "JUMLAH TINDAKAN", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "OBAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "JUMLAH TINDAKAN+OBAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "PMI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "JUMLAH", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "BAYAR TUNAI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "TOTAL BIAYA PX", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);

$row+=3;
$column =0;


				/* $igd = $kamar = $makan = $tindakanNO = $visite = $gizi = $tindakanO = $lab = $rad = $pa = $jmlTindakan = $obat
					= $jumlahTindakanObat = $pmi = $jumlahBayar = $totalBiaya = 0; */
                    if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id != '1'";
                    if($tmpLay==0){ 
					$tmb = "INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id";
					$fUnit = "b_pelayanan.jenis_layanan = '".$jnsLay."' AND b_ms_unit.inap='1'";
                    }else{ $fUnit = "b_pelayanan.unit_id = '".$tmpLay."'";}
                   	/* $qry = "SELECT b_kunjungan.id AS kunjungan_id, b_pelayanan.id AS pelayanan_id,
                    	b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien
                    	FROM b_ms_pasien
                    	INNER JOIN b_kunjungan ON b_ms_pasien.id = b_kunjungan.pasien_id
                    	INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id $tmb
                    	INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
						INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id
                    	WHERE $fUnit $waktu $fKso AND b_ms_kso.id <> 1 GROUP BY b_pelayanan.id ORDER BY b_tindakan_kamar.tgl_out"; */
					$qry = "SELECT b_kunjungan.id AS kunjungan_id,b_kunjungan.tgl AS tglKunj, b_pelayanan.id AS pelayanan_id,
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
                    	WHERE $fUnit $waktu $fKso GROUP BY b_pelayanan.id ORDER BY b_tindakan_kamar.tgl_out";
					//echo $qry."<br>";
                    $rs = mysql_query($qry);
					$i=0;
					$j=0;
                    while($rw = mysql_fetch_array($rs)){					
                    $i++;
					$tglKunj = $rw["tglKunj"];
					
$worksheet->write($row, $column, $i, $textBiasa2);
$worksheet->write($row, $column+1, $rw['no_rm'], $textBiasa1);
$worksheet->write($row, $column+2, $rw['pasien'], $textBiasa1);
$worksheet->write($row+1, $column+2, $rw['no_anggota'], $textBiasa1);
$worksheet->write($row+2, $column+2, $rw['nama_peserta'], $textBiasa1);

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
//echo $qLop;
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
		 $tot_makan = mysql_num_rows($rsMakan);

$worksheet->write($row, $column+3, $rwLop['masuk'], $textBiasa1);
$worksheet->write($row, $column+4, $rwLop['keluar'], $textBiasa1);
$worksheet->write($row, $column+5, $rwLop['jHr'], $textBiasa1);
$worksheet->write($row, $column+6, $rwLop['kamar'], $textBiasa1);
$worksheet->write($row, $column+7, $rwLop['kelas'], $textBiasa1);
$worksheet->write($row, $column+8, number_format($rwKamar['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+9, number_format($rwMakan['jml'],0,",","."), $textBiasa4);

$jmlKmr = $jmlKmr + $rwKamar['jml'];
$jmlMkn = $jmlMkn + $rwMakan['jml'];

$row+=1;
}
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

$sqlver = "SELECT p.id FROM b_pelayanan p
LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = p.id
WHERE (p.verifikasi = 0 OR t.verifikasi = 0 OR tk.verifikasi = 0) AND p.id = '".$rw['pelayanan_id']."'";
$rsver = mysql_query($sqlver);
if(mysql_num_rows($rsver) > 0){
$verifikasi = 0;
}else{
$verifikasi = 1;
}
//======== lanjutan dari isi record nama pasien=========
if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63')
{ 
	$tno=='-';
}
else
{ 
	$tno = number_format($rwTin['jml'],0,",",".");
}
$worksheet->write($row, $column+10, $tno, $textBiasa4);
$worksheet->write($row, $column+11, number_format($rwVisite['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+12, number_format($rwGizi['jml'],0,",","."), $textBiasa4);
$worksheet->writeBlank($row, $column+13, $textBiasa4);
$worksheet->writeBlank($row, $column+14, $textBiasa4);
$worksheet->writeBlank($row, $column+15, $textBiasa4);
if($rwOp['jml']!="")
{ 
	$to = number_format($rwOp['jml'],0,",",".");
}
else
{ 
	$to = "-";
}
$worksheet->write($row, $column+16, $to, $textBiasa4);
$worksheet->write($row, $column+17, number_format($rwPk['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+18, number_format($rwRad['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+19, number_format($rwPa['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+20, number_format($rwEnd['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+21, number_format($rwHd['jml'],0,",","."), $textBiasa4);
$worksheet->write($row, $column+22, number_format($jmlTind,0,",","."), $textBiasa4);
if($rwObat['jml']=="")
{ 
	$obat = "0";
}
else
{ 
	$obat = number_format($rwObat['jml'],0,",",".");
}
$worksheet->write($row, $column+23, $obat, $textBiasa4);
$jumlahTindakan = number_format($jmlTind,0,",",".")+$obat;
$worksheet->write($row, $column+24, $jumlahTindakan, $textBiasa4);
$worksheet->write($row, $column+25, "xxx", $textBiasa4);
$worksheet->write($row, $column+26, $jumlahTindakan, $textBiasa4);
$worksheet->write($row, $column+27, $Bayar, $textBiasa4);
$worksheet->write($row, $column+28, $jumlahTindakan+$Bayar, $textBiasa4);

$row+=2;			
}
$row=$row+2;
$worksheet->writeBlank($row, $column, $columnTitleFormat);
$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
$worksheet->write($row, $column+2, "JUMLAH", $columnTitleFormat);
$worksheet->writeBlank($row, $column+3, $columnTitleFormat);		
$worksheet->writeBlank($row, $column+4, $columnTitleFormat);
$worksheet->writeBlank($row, $column+5, $columnTitleFormat);
$worksheet->writeBlank($row, $column+6, $columnTitleFormat);
$worksheet->writeBlank($row, $column+7, $columnTitleFormat);
$worksheet->write($row, $column+8, number_format($kamar,0,",","."), $textBiasa4);
$worksheet->write($row, $column+9, number_format($makan,0,",","."), $textBiasa4);
$worksheet->write($row, $column+10, number_format($tindakanNO,0,",","."), $textBiasa4);
$worksheet->write($row, $column+11, number_format($visite,0,",","."), $textBiasa4);
$worksheet->write($row, $column+12, number_format($gizi,0,",","."), $textBiasa4);
$worksheet->writeBlank($row, $column+13, $columnTitleFormat);		
$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
$worksheet->writeBlank($row, $column+15, $columnTitleFormat);
$worksheet->write($row, $column+16, number_format($tindakanO,0,",","."), $textBiasa4);
$worksheet->write($row, $column+17, number_format($lab,0,",","."), $textBiasa4);
$worksheet->write($row, $column+18, number_format($rad,0,",","."), $textBiasa4);
$worksheet->write($row, $column+19, number_format($pa,0,",","."), $textBiasa4);
$worksheet->write($row, $column+20, number_format($end,0,",","."), $textBiasa4);
$worksheet->write($row, $column+21, number_format($hd,0,",","."), $textBiasa4);
$worksheet->write($row, $column+22, number_format($jmlTindakan,0,",","."), $textBiasa4);
$worksheet->write($row, $column+23, number_format($obat,0,",","."), $textBiasa4);
$worksheet->write($row, $column+24, number_format($jumlahTindakanObat,0,",","."), $textBiasa4);
$worksheet->write($row, $column+25, number_format($pmi,0,",","."), $textBiasa4);
$worksheet->write($row, $column+26, number_format($jumlahTindakanPmi,0,",","."), $textBiasa4);
$worksheet->write($row, $column+27, number_format($jumlahBayar,0,",","."), $textBiasa4);
$worksheet->write($row, $column+28, number_format($totalBiaya,0,",","."), $textBiasa4);

$workbook->close();
mysql_free_result($rsPenjamin);
mysql_free_result($rsTmp);
mysql_close($konek);
?>