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
	$waktu = " AND tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(tgl) = '$bln' and year(tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND tgl between '$tglAwal2' and '$tglAkhir2' ";
	
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
    

if($_REQUEST['export']=='excel'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Laporan_rincian_per_pasien_rawa_inap_KSO.xls"');
}


//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('RINCIAN PER NAMA PASIEN PENERIMAAN RAWAT INAP KSO.xls');

$worksheet=&$workbook->addWorksheet('Laporan_rinci');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 25;

	$worksheet->setColumn (0, 0, 5);
	$worksheet->setColumn (1, 1, 8);
	$worksheet->setColumn (2, 2, 25);
	$worksheet->setColumn (3, 3, 25);
	$worksheet->setColumn (4, 4, 10);
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
$sheetTitleFormat2 =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center'));
$sheetTitleFormat3 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));

$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','height'=>25,'vAlign'=>'vcenter'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));

$garisAtas = & $workbook->addFormat(array('top'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$garisAtasKanan = & $workbook->addFormat(array('top'=>1,'right'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$garisAtasBawah = & $workbook->addFormat(array('top'=>1,'bottom'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$garisAtasKananBawah = & $workbook->addFormat(array('top'=>1,'right'=>1,'bottom'=>1,'size'=>8,'align'=>'right','vAlign'=>'vcenter','numFormat'=>'#,##0'));

$garisKanan = & $workbook->addFormat(array('right'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$garisKananBawah = & $workbook->addFormat(array('right'=>1,'bottom'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));


$Kosong = & $workbook->addFormat(array('size'=>8,'align'=>'left','vAlign'=>'vcenter'));
$Kosong2 = & $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$KosongAngka = & $workbook->addFormat(array('size'=>8,'align'=>'right','vAlign'=>'vcenter','numFormat'=>'#,##0'));

$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));


$textBold1 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$textBold2 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$textBold3 =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));

$textBiasa1 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));
$textBiasa2 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'center','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));
$textBiasa3 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'left','padding-left'=>'5','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));
$textBiasa4 =& $workbook->addFormat(array('bold'=>0,'size'=>8,'align'=>'right','bottom'=>1,'right'=>1,'top'=>1,'left'=>1));

$column = 0;
$row = 0;

$worksheet->write($row, $column, "PEMERINTAH KABUPATEN SIDOARJO", $sheetTitleFormat3);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,3);
$row += 1;
$worksheet->write($row, $column, "Rumah Sakit Umum Daerah Kabupaten Sidoarjo", $sheetTitleFormat3);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,3);
$row += 1;
$worksheet->write($row, $column, "Jl. Mojopahit 667 Sidoarjo", $sheetTitleFormat3);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,3);
$row += 1;
$worksheet->write($row, $column, "Telepon (031) 896 1649 ", $sheetTitleFormat3);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,3);
$row += 3;


$worksheet->write($row, $column, "RINCIAN PER NAMA PASIEN PENERIMAAN RAWAT INAP KSO", $sheetTitleFormat2);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,31);
$row += 1;
$worksheet->write($row, $column, $Periode, $sheetTitleFormat2);
$worksheet->writeBlank($row, 1, $UnitTitleFormat);
$worksheet->writeBlank($row, 2, $UnitTitleFormat);
$worksheet->writeBlank($row, 3, $UnitTitleFormat);
$worksheet->mergeCells($row,0,$row,31);
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
$worksheet->write($row, $column, "STATUS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;

$worksheet->write($row, $column, "TAGIHAN KSO", $columnTitleFormat);
for($n=1;$n<19;$n++)
{
$worksheet->writeBlank($row, $column+$n, $garisAtas);
}
$worksheet->writeBlank($row, $column+$n, $garisAtasKanan);
$worksheet->mergeCells($row, $column, $row, $column+19);

$row+=1;// UNTUK SUB HEADER
$worksheet->write($row, $column, "MRS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "KRS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "HR RAWAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "RUANG RWT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "KLS", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "KAMAR", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "MAKAN", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "TINDK. NON OPERATIF", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "JASA VISITE", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "KONSUL GIZI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "IGD", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "KONSUL POLI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "REHAB MEDIK", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "TINDKAN OPERATIF", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "LAB PK", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "RAD", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "PA", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "ENDOSCOPY", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "HD", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$worksheet->write($row, $column, "JUMLAH TINDAKAN", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+1,$column);
$column +=1;
$row-=1;
$worksheet->write($row, $column, "JAMINAN KSO", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "IUR BAYAR", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "BAYAR TINDAKAN", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "OBAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "BAYAR OBAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "PMI", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "JUMLAH TINDAKAN+OBAT", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);
$column +=1;
$worksheet->write($row, $column, "KEKURANGAN BAYAR", $columnTitleFormat);
$worksheet->writeBlank($row+1, $column, $garisKanan);
$worksheet->writeBlank($row+2, $column, $garisKananBawah);
$worksheet->mergeCells($row,$column,$row+2,$column);


$row+=3;
$column =0;

$fKso = "AND p.kso_id != '1'";
$qry="SELECT DISTINCT mp.no_rm,mp.nama pasien,p.kunjungan_id, mk.nama 
FROM (SELECT * FROM b_bayar WHERE kasir_id=83 $waktu) b 
INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id INNER JOIN b_pelayanan p ON k.id = p.kunjungan_id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id   INNER JOIN b_ms_kso mk
    ON mk.id = p.kso_id
WHERE mu.inap = '1' $fKso ORDER BY p.id";
	//echo $qry."<br>";
	$rs = mysql_query($qry);
	$i=0;
	$j=0;
	while($rw = mysql_fetch_array($rs))
	{					
	$i++;
	$tglKunj = $rw["tglKunj"];
	
	$worksheet->write($row, $column, $i, $Kosong);
	$worksheet->write($row, $column+1, $rw['no_rm'], $Kosong);
	$worksheet->write($row, $column+2, $rw['pasien'], $Kosong);
	$worksheet->write($row+1, $column+2, $rw['no_anggota'], $Kosong);
	$worksheet->write($row+2, $column+2, $rw['nama_peserta'], $Kosong);
	$worksheet->write($row, $column+3, $rw['nama'], $Kosong);
	
	
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
			$jum_bar = mysql_num_rows($rsLop);
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
			
			$worksheet->write($row, $column+4, $rwLop['masuk'], $Kosong);
			$worksheet->write($row, $column+5, $rwLop['keluar'], $Kosong);
			$worksheet->write($row, $column+6, $rwLop['jHr'], $Kosong);
			$worksheet->write($row, $column+7, $rwLop['kamar'], $Kosong);
			$worksheet->write($row, $column+8, $rwLop['kelas'], $Kosong);
			$worksheet->write($row, $column+9, $rwKamar['jml'], $KosongAngka);
			$worksheet->write($row, $column+10, $rwMakan['jml'], $KosongAngka);
			
			$j++;
			$jmlKmr = $jmlKmr + $rwKamar['jml'];
			$jmlMkn = $jmlMkn + $rwMakan['jml'];
			$row+=1;
			}
			$row-=$jum_bar;
			
			// Mulai mengambil data kolom TIndakan Non Operatif
			$qTin = "SELECT SUM(t.total) AS jml, SUM(t.total_biaya) AS jml1, SUM(t.total_kso) AS jml2 FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_pasien AS total, b_tindakan.qty*b_tindakan.biaya AS total_biaya,
                    b_tindakan.qty*b_tindakan.biaya_kso AS total_kso, 
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
			
			$qIGD = "SELECT SUM(t.total) AS jml FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
					b_tindakan.qty*b_tindakan.biaya_pasien AS total, 
					b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
					WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND 
					b_pelayanan.jenis_layanan='44' AND b_ms_unit.inap='0' AND b_ms_unit.id<>47) AS t";
			$rsIGD = mysql_query($qIGD);
			$rwIGD = mysql_fetch_array($rsIGD);
			
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
						$rwGizi['jml'] + $rwIGD['jml'] + $rwPoli['jml'] + 
						$rwRehab['jml'] + $rwOp['jml'] + $rwPk['jml'] + $rwRad['jml'] +
						$rwPa['jml'] + $rwEnd['jml'] + $rwHd['jml'];
			$jmlTind = $jmlTin;
			
			$qByr = "SELECT SUM(t.nilai) AS jml FROM (SELECT b_bayar_tindakan.nilai
					FROM b_pelayanan 
					INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id
					INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id
					INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id
					WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3'
					AND b_bayar_tindakan.tipe=0
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
			
			$krgByr = $jmlTind + $rwObat['jml'] - $Bayar - $rwObat['jml'];
			
			$makan += $jmlMkn;
			$kamar += $jmlKmr;
			$tindakanNO += $rwTin['jml'];
			$visite += $rwVisite['jml'];
			$gizi += $rwGizi['jml'];
			$igd += $rwIGD['jml'];
			$poli += $rwPoli['jml'];
			$rehab += $rwRehab['jml'];
			$tindakanO += $rwOp['jml'];
			$tin += $rwTin['jml'];
			$JKSO += $rwTin['jml2'];
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
			
			if($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63')
			{
				$rwTin['jml'] = "-";
			}
			$worksheet->write($row, $column+11, $rwTin['jml'], $KosongAngka);
			$worksheet->write($row, $column+12, $rwVisite['jml'], $KosongAngka);
			$worksheet->write($row, $column+13, $rwGizi['jml'], $KosongAngka);
			$worksheet->write($row, $column+14, $rwIGD['jml'], $KosongAngka);
			$worksheet->write($row, $column+15, $$rwPoli['jml'], $KosongAngka);
			$worksheet->write($row, $column+16, $rwRehab['jml'], $KosongAngka);
			$worksheet->write($row, $column+17, $rwOp['jml'], $KosongAngka);
			$worksheet->write($row, $column+18, $rwPk['jml'], $KosongAngka);
			$worksheet->write($row, $column+19, $rwRad['jml'], $KosongAngka);
			$worksheet->write($row, $column+20, $rwPa['jml'], $KosongAngka);
			$worksheet->write($row, $column+21, $rwEnd['jml'], $KosongAngka);
			$worksheet->write($row, $column+22, $rwHd['jml'], $KosongAngka);
			$worksheet->write($row, $column+23, $jmlTind, $KosongAngka);
			
			$worksheet->write($row, $column+24, $rwTin['jml2'], $KosongAngka);
			$worksheet->write($row, $column+25, $rwTin['jml'], $KosongAngka);
			$worksheet->write($row, $column+26, $Bayar, $KosongAngka);
			$worksheet->write($row, $column+27, $rwObat['jml'], $KosongAngka);
			$worksheet->write($row, $column+28, $rwObat['jml'], $KosongAngka);
			$worksheet->write($row, $column+29, $pmi, $KosongAngka);
			$jumlahTindakan = $Bayar+$rwObat['jml'];
			$worksheet->write($row, $column+30, $jumlahTindakan, $KosongAngka);
			$worksheet->write($row, $column+31, $krgByr, $KosongAngka);
			
		if($jum_bar<=3)
		{
			$add = 3;
		}
		else
		{
			$add = $jum_bar;
		}
	$row+=$add;
	}
	
$worksheet->write($row, $column, "", $columnTitleFormat);	
$worksheet->write($row, $column+1, "", $columnTitleFormat);	
$worksheet->write($row, $column+2, "", $columnTitleFormat);	
$worksheet->write($row, $column+3, "", $columnTitleFormat);	
$worksheet->write($row, $column+4, "Total", $columnTitleFormat);
$worksheet->writeBlank($row, $column+5, $garisAtasBawah);
$worksheet->writeBlank($row, $column+6, $garisAtasBawah);
$worksheet->writeBlank($row, $column+7, $garisAtasBawah);
$worksheet->writeBlank($row, $column+8, $columnTitleFormat);
$worksheet->mergeCells($row,$column+4,$row,$column+8);

$worksheet->write($row, $column+9, $kamar, $garisAtasKananBawah);
$worksheet->write($row, $column+10, $makan, $garisAtasKananBawah);
$worksheet->write($row, $column+11, $tindakanNO, $garisAtasKananBawah);
$worksheet->write($row, $column+12, $visite, $garisAtasKananBawah);
$worksheet->write($row, $column+13, $gizi, $garisAtasKananBawah);
$worksheet->write($row, $column+14, $igd, $garisAtasKananBawah);
$worksheet->write($row, $column+15, $poli, $garisAtasKananBawah);
$worksheet->write($row, $column+16, $rehab, $garisAtasKananBawah);
$worksheet->write($row, $column+17, $tindakanO, $garisAtasKananBawah);
$worksheet->write($row, $column+18, $lab, $garisAtasKananBawah);
$worksheet->write($row, $column+19, $rad, $garisAtasKananBawah);
$worksheet->write($row, $column+20, $pa, $garisAtasKananBawah);
$worksheet->write($row, $column+21, $end, $garisAtasKananBawah);
$worksheet->write($row, $column+22, $hd, $garisAtasKananBawah);
$worksheet->write($row, $column+23, $jmlTindakan, $garisAtasKananBawah);
$worksheet->write($row, $column+24, $JKSO, $garisAtasKananBawah);
$worksheet->write($row, $column+25, $tin, $garisAtasKananBawah);
$worksheet->write($row, $column+26, $jmlTindakanByr, $garisAtasKananBawah);
$worksheet->write($row, $column+27, $obat, $garisAtasKananBawah);
$worksheet->write($row, $column+28, $byrobat, $garisAtasKananBawah);
$worksheet->write($row, $column+29, $totpmi, $garisAtasKananBawah);
$worksheet->write($row, $column+30, $jumlahTindakanObat, $garisAtasKananBawah);
$worksheet->write($row, $column+31, $totkrgByr, $garisAtasKananBawah);

	
	

	mysql_free_result($rsPenjamin);
	mysql_free_result($rsTmp);
	mysql_close($konek);
$workbook->close();

?>