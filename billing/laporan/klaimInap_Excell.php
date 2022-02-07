<?php
session_start();
include "../sesi.php";
	include("../koneksi/konek.php");
	//==========Menangkap filter data====
	$stsPas = $_REQUEST['StatusPas0'];
	//if($stsPas>0) $fKso=" b_kunjungan.kso_id = '".$stsPas."' ";
	$jnsLay = $_REQUEST['JnsLayananDenganInap'];
	$tmpLay = $_REQUEST['TmpLayananInapSaja'];
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	//$stsPas,$jnsLay,$tmpLay,$waktu,$tglAwal,$tglAhkir,$bln,$thn
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_REQUEST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " AND DATE(b_kunjungan.tgl_pulang) = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}else if($waktu == 'Bulanan'){
		$bln = $_REQUEST['cmbBln'];
		$thn = $_REQUEST['cmbThn'];
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
	
	$penjamin=strtoupper($hsPenjamin['nama']);
	if ($stsPas==0) $penjamin="SEMUA";

//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Pengajuan_Klaim.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Klaim_Inap');
//$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);//No
$worksheet->setColumn (1, 1, 10);//No MR
$worksheet->setColumn (2, 2, 17);//Nama Px
$worksheet->setColumn (3, 3, 15);//Nama Perusahaan
$worksheet->setColumn (4, 4, 20);//Diagnosa
$worksheet->setColumn (5, 5, 10);//MRS
$worksheet->setColumn (6, 6, 10);//KRS
$worksheet->setColumn (7, 7, 6);//HR RWT
$worksheet->setColumn (8, 8, 12);//RUANG RWT
$worksheet->setColumn (9, 21, 10);//KELAS
/*$worksheet->setColumn (10, 10, 8);//KAMAR
$worksheet->setColumn (11, 11, 8);//MAKAN
$worksheet->setColumn (12, 12, 8);//T NON OP
$worksheet->setColumn (13, 13, 8);//J VISITE
$worksheet->setColumn (14, 14, 8);//KONSUL GIZI
$worksheet->setColumn (15, 15, 8);//KONSUL POLI
$worksheet->setColumn (16, 16, 8);//T OP
$worksheet->setColumn (17, 17, 8);//PK
$worksheet->setColumn (18, 18, 8);//PA
$worksheet->setColumn (19, 19, 8);//RAD
$worksheet->setColumn (20, 20, 8);//HD
$worksheet->setColumn (21, 21, 8);//END*/
$worksheet->setColumn (22, 22, 10);//JML TIND
$worksheet->setColumn (23, 23, 8);//OBAT
$worksheet->setColumn (24, 24, 10);//JML TIND + OBAT
$worksheet->setColumn (25, 25, 8);//PMI
$worksheet->setColumn (26, 29, 12);//JUMLAH
/*$worksheet->setColumn (27, 27, 10);//BYR TUNAI
$worksheet->setColumn (28, 28, 10);//TOT BIAYA PX
$worksheet->setColumn (29, 29, 10);//STATUS VERF*/
$worksheet->setColumn (30, 30, 15);//PENJAMIN PX

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>12,'align'=>'left','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','vAlign'=>'vcenter','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','vAlign'=>'vcenter','fgcolor'=>'yellow','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','vAlign'=>'vcenter','fgcolor'=>'yellow','pattern'=>1,'numFormat'=>'#,##0'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','vAlign'=>'vcenter','fgcolor'=>'yellow','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','vAlign'=>'vcenter','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','vAlign'=>'vcenter','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','vAlign'=>'vcenter','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatRB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right','vAlign'=>'vcenter','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatLNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'left','vAlign'=>'vcenter'));
$regularFormatCNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$regularFormatRNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right','vAlign'=>'vcenter'));
$gsTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','vAlign'=>'vcenter','fgcolor'=>'green','pattern'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 0, $pemkabRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,6);
$row += 1;
$worksheet->write($row, 0, $namaRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,6);
$row += 1;
$worksheet->write($row, 0, $alamatRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,6);
$row += 1;
$worksheet->write($row, 0, "Telepon ".$tlpRS, $sheetTitleFormat);
$worksheet->writeBlank($row, 1, $sheetTitleFormat);
$worksheet->writeBlank($row, 2, $sheetTitleFormat);
$worksheet->writeBlank($row, 3, $sheetTitleFormat);
$worksheet->writeBlank($row, 4, $sheetTitleFormat);
$worksheet->writeBlank($row, 5, $sheetTitleFormat);
$worksheet->writeBlank($row, 6, $sheetTitleFormat);
$worksheet->mergeCells($row,0,$row,6);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 2;
$worksheet->write($row, 10, "REKAPITULASI PENGAJUAN KLAIM PASIEN ".$penjamin, $sheetTitleFormat);
$row++;
$worksheet->write($row, 10, $Periode, $sheetTitleFormat);
$row +=2;
$worksheet->write($row, 0, "No", $columnTitleFormat);
$worksheet->write($row, 1, "No MR", $columnTitleFormat);
$worksheet->write($row, 2, "NAMA PENDERITA NO PESERTA NAMA PESERTA", $columnTitleFormat);
$worksheet->write($row, 3, "NAMA PERUSAHAAN", $columnTitleFormat);
$worksheet->write($row, 4, "DIAGNOSA", $columnTitleFormat);
$worksheet->write($row, 5, "MRS", $columnTitleFormat);
$worksheet->write($row, 6, "KRS", $columnTitleFormat);
$worksheet->write($row, 7, "HARI RWT", $columnTitleFormat);
$worksheet->write($row, 8, "RUANG RWT", $columnTitleFormat);
$worksheet->write($row, 9, "KELAS", $columnTitleFormat);
$worksheet->write($row, 10, "KAMAR", $columnTitleFormat);
$worksheet->write($row, 11, "MAKAN", $columnTitleFormat);
$worksheet->write($row, 12, "TIND NON OPERATIF", $columnTitleFormat);
$worksheet->write($row, 13, "JASA VISITE", $columnTitleFormat);
$worksheet->write($row, 14, "KONSUL GIZI", $columnTitleFormat);
$worksheet->write($row, 15, "KONSUL POLI", $columnTitleFormat);
$worksheet->write($row, 16, "TIND OPERATIF", $columnTitleFormat);
$worksheet->write($row, 17, "PK", $columnTitleFormat);
$worksheet->write($row, 18, "PA", $columnTitleFormat);
$worksheet->write($row, 19, "RAD", $columnTitleFormat);
$worksheet->write($row, 20, "HD", $columnTitleFormat);
$worksheet->write($row, 21, "ENDS", $columnTitleFormat);
$worksheet->write($row, 22, "JML TINDAKAN", $columnTitleFormat);
$worksheet->write($row, 23, "OBAT", $columnTitleFormat);
$worksheet->write($row, 24, "JML TINDAKAN + OBAT", $columnTitleFormat);
$worksheet->write($row, 25, "PMI", $columnTitleFormat);
$worksheet->write($row, 26, "JUMLAH", $columnTitleFormat);
$worksheet->write($row, 27, "BAYAR TUNAI", $columnTitleFormat);
$worksheet->write($row, 28, "TOTAL BIAYA PX", $columnTitleFormat);
$worksheet->write($row, 29, "STATUS VERIFIKASI", $columnTitleFormat);
$worksheet->write($row, 30, "PENJAMIN PX", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

/* $igd = $kamar = $makan = $tindakanNO = $visite = $gizi = $tindakanO = $lab = $rad = $pa = $jmlTindakan = $obat
= $jumlahTindakanObat = $pmi = $jumlahBayar = $totalBiaya = 0; */
if($stsPas!=0) $fKso = "AND b_pelayanan.kso_id = '".$stsPas."'"; else $fKso = "";

	$tmb = "INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id";
	//$fUnit = "b_pelayanan.jenis_layanan = '".$jnsLay."' AND b_ms_unit.inap='1'";
	$fUnit = "b_pelayanan.jenis_kunjungan = '3' AND b_ms_unit.inap='1'";

	$qry = "SELECT b_kunjungan.id AS kunjungan_id,b_kunjungan.tgl AS tglKunj, b_pelayanan.id AS pelayanan_id,
		b_pelayanan.kso_id AS kso_id,
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
		WHERE $fUnit $waktu $fKso GROUP BY b_kunjungan.id ORDER BY b_kunjungan.tgl_pulang";

//echo $qry."<br>";
$rs = mysql_query($qry);
$i=0;
$j=0;
while($rw = mysql_fetch_array($rs)){					
	$i++;
	$tglKunj = $rw["tglKunj"];
	
	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rw["no_rm"], $regularFormatC);
	$worksheet->write($row, 2, $rw["pasien"]." ".$rw["no_anggota"]." ".$rw["nama_peserta"], $regularFormat);
	$worksheet->write($row, 3, $rw["instansi"], $regularFormatC);
	
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
	$it=0;
	$bTin = 0; $bVisite = 0;
	while($rwLop = mysql_fetch_array($rsLop))
	{
		 $qKamar = "SELECT SUM(cH.hari*cH.beban_kso) AS jml,SUM(cH.hari*cH.beban_pasien) AS jml_umum FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
					IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
					DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
					IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
					DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.beban_kso,b_tindakan_kamar.beban_pasien FROM b_pelayanan 
					INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
					WHERE b_pelayanan.id = '".$rwLop['pelayanan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";
		 $rsKamar = mysql_query($qKamar);
		 $rwKamar = mysql_fetch_array($rsKamar);
		 
		 $qMakan = "SELECT SUM(b_tindakan.qty*b_tindakan.biaya_kso) AS jml,SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS jml_umum 
					 FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id 
					 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
					 INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id 
					 WHERE b_pelayanan.id='".$rwLop['pelayanan_id']."' 
					 AND b_ms_tindakan.id IN (742,746,747,748,749)";
		 $rsMakan = mysql_query($qMakan);
		 $rwMakan = mysql_fetch_array($rsMakan);
										 
		if ($rw['kso_id']=="1"){
			$bkamar = $rwKamar['jml_umum'];
			$bmakan = $rwMakan['jml_umum'];
		}else{
			$bkamar = $rwKamar['jml'];
			$bmakan = $rwMakan['jml'];
		}
		
		$jmlKmr = $jmlKmr + $bkamar;
		$jmlMkn = $jmlMkn + $bmakan;
	
		 $qTin = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
				 b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_kso AS total,b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum, 
				 b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
				 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
				 INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
				 INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
				 WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND 
				 b_tindakan.pelayanan_id='".$rwLop['pelayanan_id']."'
				 AND b_ms_tindakan.id NOT IN (742,746,747,748,749,2387) 
				 AND b_ms_tindakan.klasifikasi_id NOT IN (13,14) ) AS t";
		 $rsTin = mysql_query($qTin);
		 $rwTin = mysql_fetch_array($rsTin);
				 
		 $qVisite = "SELECT SUM(t.biaya) AS jml,SUM(t.biaya_umum) AS jml_umum FROM (SELECT SUM(b_tindakan.qty)*b_tindakan.biaya_kso AS biaya,SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS biaya_umum 
					 FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
					 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
					 INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
					 WHERE (b_ms_tindakan.klasifikasi_id = '13' OR b_ms_tindakan.klasifikasi_id = '14' AND b_ms_tindakan.id<>'2378') 
					 AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3 AND 
				     b_tindakan.pelayanan_id='".$rwLop['pelayanan_id']."' GROUP BY b_tindakan.id) AS t";
		 $rsVisite = mysql_query($qVisite);
		 $rwVisite = mysql_fetch_array($rsVisite);
										 
		 if ($rw['kso_id']=="1"){
			$bTinUmum= $rwTin['jml_umum'];
			$bVisiteUmum= $rwVisite['jml_umum'];
			$bTinTmp = $bTinUmum;
			$bVisiteTmp = $bVisiteUmum;
		 }else{
			$bTinKso= $rwTin['jml'];
			$bVisiteKso= $rwVisite['jml'];
			$bTinTmp = $bTinKso;
			$bVisiteTmp = $bVisiteKso;
		 }
		 
		$bTin += $bTinTmp;
		$bVisite += $bVisiteTmp;
		 
		$qDiag = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama FROM b_diagnosa_rm
		INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa_rm.ms_diagnosa_id
		WHERE b_diagnosa_rm.pelayanan_id = '".$rwLop['pelayanan_id']."'";
		$rsDiag = mysql_query($qDiag);
		$ndiag="";
		while($rwDiag = mysql_fetch_array($rsDiag))
		{
			$ndiag.=$rwDiag['nama'].',';
		}
		$ndiag=substr($ndiag,0,strlen($ndiag)-1);

		$worksheet->write($row+$it, 4, $ndiag, $regularFormat);
		$worksheet->write($row+$it, 5, $rwLop['masuk'], $regularFormatC);
		$worksheet->write($row+$it, 6, $rwLop['keluar'], $regularFormatC);
		$worksheet->write($row+$it, 7, $rwLop['jHr'], $regularFormatC);
		$worksheet->write($row+$it, 8, $rwLop['kamar'], $regularFormatC);
		$worksheet->write($row+$it, 9, $rwLop['kelas'], $regularFormatC);
		$worksheet->write($row+$it, 10, $bkamar, $regularFormatR);
		$worksheet->write($row+$it, 11, (($bmakan=="")?"0":$bmakan), $regularFormatR);
		$worksheet->write($row+$it, 12, $bTinTmp, $regularFormatR);
		$worksheet->write($row+$it, 13, $bVisiteTmp, $regularFormatR);
		
		$it++;
	}
			 
	 $qGizi = "SELECT SUM(t.biaya) AS jml,SUM(t.biaya_umum) AS jml_umum FROM (SELECT SUM(b_tindakan.qty)*b_tindakan.biaya_kso AS biaya,SUM(b_tindakan.qty*b_tindakan.biaya_pasien) AS biaya_umum FROM b_pelayanan 
				INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
				INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
				INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id
				WHERE (b_ms_tindakan.id = '2387' OR b_ms_tindakan.id='2378') 
				AND b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = 3) as t";
	 $rsGizi = mysql_query($qGizi);
	 $rwGizi = mysql_fetch_array($rsGizi);
			 
	 $qPoli = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.id, b_tindakan.biaya_kso, b_tindakan.qty, 
				 b_ms_tindakan.nama, b_ms_tindakan.klasifikasi_id, b_tindakan.qty*b_tindakan.biaya_kso AS total,b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum, 
				 b_pelayanan.unit_id FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
				 INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id 
				 INNER JOIN b_ms_tindakan ON b_ms_tindakan.id = b_ms_tindakan_kelas.ms_tindakan_id 
				 INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
				 WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND b_tindakan.jenis_kunjungan = '3' AND 
				 b_ms_unit.parent_id IN (1,132)
				 AND b_ms_tindakan.id NOT IN (742,746,747,748,749,2387) 
				 AND b_ms_tindakan.klasifikasi_id NOT IN (13,14) ) AS t";
	 $rsPoli = mysql_query($qPoli);
	 $rwPoli = mysql_fetch_array($rsPoli);
	
	 $qOp = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty,
			b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total,b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum FROM b_pelayanan
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."'
			AND b_pelayanan.jenis_kunjungan=3 AND b_pelayanan.unit_id IN (47,63)) AS t";
	 $rsOp = mysql_query($qOp);
	 $rwOp = mysql_fetch_array($rsOp);
			 
	 $qPk = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
			FROM b_pelayanan 
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='58') AS t";
	 $rsPk = mysql_query($qPk);
	 $rwPk = mysql_fetch_array($rsPk);
			 
	 $qRad = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
			FROM b_pelayanan 
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='61') AS t";
	 $rsRad = mysql_query($qRad);
	 $rwRad = mysql_fetch_array($rsRad);
			 
	$qPa = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
			FROM b_pelayanan 
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='59') AS t";
	 $rsPa = mysql_query($qPa);
	 $rwPa = mysql_fetch_array($rsPa);
			 
	 $qHd = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
			FROM b_pelayanan 
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='65') AS t";
	 $rsHd = mysql_query($qHd);
	 $rwHd = mysql_fetch_array($rsHd);
			 
	 $qEnd = "SELECT SUM(t.total) AS jml,SUM(t.total_umum) AS jml_umum FROM (SELECT b_tindakan.qty, b_tindakan.biaya_kso, b_tindakan.qty*b_tindakan.biaya_kso AS total, b_tindakan.qty*b_tindakan.biaya_pasien AS total_umum  
			FROM b_pelayanan 
			INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id 
			WHERE b_pelayanan.kunjungan_id='".$rw['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan='3' AND b_pelayanan.unit_id='67') AS t";
	 $rsEnd = mysql_query($qEnd);
	 $rwEnd = mysql_fetch_array($rsEnd);
			 
	if ($rw['kso_id']=="1"){
		$qObat="SELECT SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS jml
			FROM (SELECT $dbbilling.b_pelayanan.id FROM $dbbilling.b_pelayanan
			INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
			WHERE $dbbilling.b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND $dbbilling.b_pelayanan.jenis_kunjungan = '3') AS t2
			INNER JOIN $dbapotek.a_penjualan ap ON t2.id = ap.NO_KUNJUNGAN
			WHERE ap.NO_PASIEN = '".$rw['no_rm']."'";
	}else{
		$qObat="SELECT SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS jml
				FROM (SELECT $dbbilling.b_pelayanan.id FROM $dbbilling.b_pelayanan
				INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
				WHERE $dbbilling.b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' AND $dbbilling.b_pelayanan.jenis_kunjungan = '3') AS t2
				INNER JOIN $dbapotek.a_penjualan ap ON t2.id = ap.NO_KUNJUNGAN
				WHERE ap.NO_PASIEN = '".$rw['no_rm']."' AND ap.CARA_BAYAR=2";
	}
			//echo $qObat."<br>";
	$rsObat = mysql_query($qObat);
	$rwObat = mysql_fetch_array($rsObat);
	$bObat = $rwObat['jml'];
	
	if ($rw['kso_id']=="1"){
		$bOp= $rwOp['jml_umum'];
		//$bVisite= $rwVisite['jml_umum'];
		$bGizi= $rwGizi['jml_umum'];
		$bPoli= $rwPoli['jml_umum'];
		$bPk= $rwPk['jml_umum'];
		$bRad= $rwRad['jml_umum'];
		$bHd= $rwHd['jml_umum'];
		$bEnd= $rwEnd['jml_umum'];
		$bPa= $rwPa['jml_umum'];
		//$bTin= $rwTin['jml_umum'];
	}else{
		$bOp= $rwOp['jml'];
		//$bVisite= $rwVisite['jml'];
		$bGizi= $rwGizi['jml'];
		$bPoli= $rwPoli['jml'];
		$bPk= $rwPk['jml'];
		$bRad= $rwRad['jml'];
		$bHd= $rwHd['jml'];
		$bEnd= $rwEnd['jml'];
		$bPa= $rwPa['jml'];
		//$bTin= $rwTin['jml'];
	}
	
	$jmlTin = $bOp + $jmlMkn + $jmlKmr + $bVisite +
			$bGizi + $bPoli + $bPk + $bRad +
			$bHd + $bEnd + $bPa + $bTin;
	
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
	
	$qKamarByr = "SELECT SUM(cH.bayar_pasien) AS jml FROM (SELECT IF(b_tindakan_kamar.status_out=0, 
				IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()), b_tindakan_kamar.tgl_in)=0, 1, 
				DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)),
				IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
				DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))) AS hari, b_tindakan_kamar.bayar_pasien
				FROM b_pelayanan 
				INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
				WHERE b_pelayanan.kunjungan_id = '".$rw['kunjungan_id']."' GROUP BY b_tindakan_kamar.id ) AS cH";

	$rsKamarByr = mysql_query($qKamarByr);
	$rwKamarByr = mysql_fetch_array($rsKamarByr);
	
	$Bayar = $rwByr['jml'] + $rwKamarByr['jml'];
	
	// $igd += $rwIgd['jml'];
	$makan += $jmlMkn;
	$kamar += $jmlKmr;
	$tindakanNO += $bTin;
	$visite += $bVisite;
	$gizi += $bGizi;
	$poli += $bPoli;
	$tindakanO += $bOp;
	$tin += $bTin;
	$lab += $bPk;
	$rad += $bRad;
	$hd += $bHd;
	$end += $bEnd;
	$pa += $bPa;
	$jmlTindakan += $jmlTind;
	$obat += $bObat;
	$jumlahTindakanObat += $jmlTind+$bObat;
	$jumlahTindakanPmi += $jmlTind+$bObat;
	$jumlahBayar += $Bayar;
	$totalBiaya += $jmlTind+$Bayar+$bObat;
	
	$sqlver = "SELECT p.id FROM b_pelayanan p
				LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
				LEFT JOIN b_tindakan_kamar tk ON tk.pelayanan_id = p.id
				WHERE (p.verifikasi = 0 OR t.verifikasi = 0 OR tk.verifikasi = 0) AND p.id = '".$rw['pelayanan_id']."'";
	$rsver = mysql_query($sqlver);
	$verf="Sudah";
	if(mysql_num_rows($rsver) > 0){
		$verf="Belum";
	}
	
	//$tnonOP=$rwTin['jml'];
	//$tOP=$rwOp['jml'];
	$nObat=0;
	
	if ($rwLop['unit_id']=='47' || $rwLop['unit_id']=='63') $bTin=0;
	if ($bOp=='') $bOp=0;
	
	if($bObat=="") $bObat=0;
	$jumlahTindakan = $jmlTind+$bObat;

	$worksheet->write($row, 14, (($bGizi=="")?"0":$bGizi), $regularFormatR);
	$worksheet->write($row, 15, (($bPoli=="")?"0":$bPoli), $regularFormatR);
	$worksheet->write($row, 16, $bOp, $regularFormatR);
	$worksheet->write($row, 17, (($bPk=="")?"0":$bPk), $regularFormatR);
	$worksheet->write($row, 18, (($bPa=="")?"0":$bPa), $regularFormatR);
	$worksheet->write($row, 19, (($bRad=="")?"0":$bRad), $regularFormatR);
	$worksheet->write($row, 20, (($bHd=="")?"0":$bHd), $regularFormatR);
	$worksheet->write($row, 21, (($bEnd=="")?"0":$bEnd), $regularFormatR);
	$worksheet->write($row, 22, $jmlTind, $regularFormatR);
	$worksheet->write($row, 23, $bObat, $regularFormatR);
	$worksheet->write($row, 24, $jumlahTindakan, $regularFormatR);
	$worksheet->write($row, 25, "0", $regularFormatR);
	$worksheet->write($row, 26, $jumlahTindakan, $regularFormatR);
	$worksheet->write($row, 27, $Bayar, $regularFormatR);
	$worksheet->write($row, 28, $jumlahTindakan+$Bayar, $regularFormatR);
	$worksheet->write($row, 29, $verf, $regularFormatC);
	$worksheet->write($row, 30, $rwLop['penjamin'], $regularFormatC);
	
	if ($it>1){
		$worksheet->mergeCells($row,0,$row+$it-1,0);
		$worksheet->mergeCells($row,1,$row+$it-1,1);
		$worksheet->mergeCells($row,2,$row+$it-1,2);
		$worksheet->mergeCells($row,3,$row+$it-1,3);
		//$worksheet->mergeCells($row, 12, $row+$it-1, 12);
		//$worksheet->mergeCells($row, 13, $row+$it-1, 13);
		$worksheet->mergeCells($row, 14, $row+$it-1, 14);
		$worksheet->mergeCells($row, 15, $row+$it-1, 15);
		$worksheet->mergeCells($row, 16, $row+$it-1, 16);
		$worksheet->mergeCells($row, 17, $row+$it-1, 17);
		$worksheet->mergeCells($row, 18, $row+$it-1, 18);
		$worksheet->mergeCells($row, 19, $row+$it-1, 19);
		$worksheet->mergeCells($row, 20, $row+$it-1, 20);
		$worksheet->mergeCells($row, 21, $row+$it-1, 21);
		$worksheet->mergeCells($row, 22, $row+$it-1, 22);
		$worksheet->mergeCells($row, 23, $row+$it-1, 23);
		$worksheet->mergeCells($row, 24, $row+$it-1, 24);
		$worksheet->mergeCells($row, 25, $row+$it-1, 25);
		$worksheet->mergeCells($row, 26, $row+$it-1, 26);
		$worksheet->mergeCells($row, 27, $row+$it-1, 27);
		$worksheet->mergeCells($row, 28, $row+$it-1, 28);
		$worksheet->mergeCells($row, 29, $row+$it-1, 29);
		$worksheet->mergeCells($row, 30, $row+$it-1, 30);
	}

	$row +=$it;
}

$row++;
$worksheet->write($row, 9, "TOTAL", $regularFormatR);
$worksheet->write($row, 10, '=Sum(K10:K'.$row.')', $regularFormatR);
$worksheet->write($row, 11, '=Sum(L10:L'.$row.')', $regularFormatR);
$worksheet->write($row, 12, '=Sum(M10:M'.$row.')', $regularFormatR);
$worksheet->write($row, 13, '=Sum(N10:N'.$row.')', $regularFormatR);
$worksheet->write($row, 14, '=Sum(O10:O'.$row.')', $regularFormatR);
$worksheet->write($row, 15, '=Sum(P10:P'.$row.')', $regularFormatR);
$worksheet->write($row, 16, '=Sum(Q10:Q'.$row.')', $regularFormatR);
$worksheet->write($row, 17, '=Sum(R10:R'.$row.')', $regularFormatR);
$worksheet->write($row, 18, '=Sum(S10:S'.$row.')', $regularFormatR);
$worksheet->write($row, 19, '=Sum(T10:T'.$row.')', $regularFormatR);
$worksheet->write($row, 20, '=Sum(U10:U'.$row.')', $regularFormatR);
$worksheet->write($row, 21, '=Sum(V10:V'.$row.')', $regularFormatR);
$worksheet->write($row, 22, '=Sum(W10:W'.$row.')', $regularFormatR);
$worksheet->write($row, 23, '=Sum(X10:X'.$row.')', $regularFormatR);
$worksheet->write($row, 24, '=Sum(Y10:Y'.$row.')', $regularFormatR);
$worksheet->write($row, 25, '=Sum(Z10:Z'.$row.')', $regularFormatR);
$worksheet->write($row, 26, '=Sum(AA10:AA'.$row.')', $regularFormatR);
$worksheet->write($row, 27, '=Sum(AB10:AB'.$row.')', $regularFormatR);
$worksheet->write($row, 28, '=Sum(AC10:AC'.$row.')', $regularFormatR);

$workbook->close();
//mysql_free_result($rs);
mysql_close($konek);
?>