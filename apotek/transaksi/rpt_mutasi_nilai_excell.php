<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//Paging,Sorting dan Filter======
$tipe=$_REQUEST['tipe'];
$bulan=$_REQUEST['bulan'];
$bulan=$_REQUEST['bulan'];
convert_var($tglctk,$tgl,$tglact,$tipe,$bulan);
$bulann=$_REQUEST['bulann'];
$tahun=$_REQUEST['tahun'];
$bulan1=$_REQUEST['bulan1'];
$bulan1n=$_REQUEST['bulan1n'];
$tahun1=$_REQUEST['tahun1'];
convert_var($bulann,$tahun,$bulan1,$bulan1n,$tahun1);

//$defaultsort="t6.OBAT_NAMA,t6.KEPEMILIKAN_ID";
$idunit1=$_REQUEST['idunit1'];
convert_var($idunit1);
$unitn="ALL UNIT";
if ($idunit1!="0"){
	$sql="SELECT * FROM a_unit WHERE UNIT_ID=".$idunit1;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$unitn=$rows["UNIT_NAME"];
	}
}
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$kpid=$_REQUEST['kpid'];
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
convert_var($sorting,$filter,$kpid,$kelas,$golongan);
$jenis=$_REQUEST['jenis'];
convert_var($jenis);
if ($kpid=="0") $filter=""; else $filter=" AND KEPEMILIKAN_ID=".$kpid;
if ($kelas=="") $fkelas=""; else{ $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if ($kelas=="") $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}

$kpid1=$_REQUEST['kpid1'];
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
convert_var($kpid1,$g1,$k1,$j1);
//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Mutasi_Obat_'.$bulann.'_'.$tahun.'.xls');

$worksheet=&$workbook->addWorksheet('Lap_Mutasi_Obat');
$worksheet->setPaper("letter");

$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 10;
if ($idunit1=="0"){
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 1, 17);
	$worksheet->setColumn (2, 2, 8);
	$worksheet->setColumn (3, 3, 5);
	$worksheet->setColumn (4, 4, 11);
	$worksheet->setColumn (5, 5, 3);
	$worksheet->setColumn (6, 6, 10);
	$worksheet->setColumn (7, 7, 3);
	$worksheet->setColumn (8, 8, 10);
	$worksheet->setColumn (9, 9, 3);
	$worksheet->setColumn (10, 10, 10);
	$worksheet->setColumn (11, 11, 3);
	$worksheet->setColumn (12, 12, 10);
	$worksheet->setColumn (13, 13, 3);
	$worksheet->setColumn (14, 14, 10);
	$worksheet->setColumn (15, 15, 3);
	$worksheet->setColumn (16, 16, 10);
	$worksheet->setColumn (17, 17, 3);
	$worksheet->setColumn (18, 18, 10);
	$worksheet->setColumn (19, 19, 3);
	$worksheet->setColumn (20, 20, 10);
	$worksheet->setColumn (21, 21, 3);
	$worksheet->setColumn (22, 22, 10);
	$worksheet->setColumn (23, 23, 3);
	$worksheet->setColumn (24, 24, 10);
	$worksheet->setColumn (25, 25, 3);
	$worksheet->setColumn (26, 26, 10);
	$worksheet->setColumn (27, 27, 3);
	$worksheet->setColumn (28, 28, 10);
	$worksheet->setColumn (29, 29, 5);
	$worksheet->setColumn (30, 30, 11);
}else{
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 1, 17);
	$worksheet->setColumn (2, 2, 8);
	$worksheet->setColumn (3, 3, 5);
	$worksheet->setColumn (4, 4, 11);
	$worksheet->setColumn (5, 5, 3);
	$worksheet->setColumn (6, 6, 10);
	$worksheet->setColumn (7, 7, 3);
	$worksheet->setColumn (8, 8, 10);
	$worksheet->setColumn (9, 9, 3);
	$worksheet->setColumn (10, 10, 10);
	$worksheet->setColumn (11, 11, 3);
	$worksheet->setColumn (12, 12, 10);
	$worksheet->setColumn (13, 13, 3);
	$worksheet->setColumn (14, 14, 10);
	$worksheet->setColumn (15, 15, 3);
	$worksheet->setColumn (16, 16, 10);
	$worksheet->setColumn (17, 17, 3);
	$worksheet->setColumn (18, 18, 10);
	$worksheet->setColumn (19, 19, 3);
	$worksheet->setColumn (20, 20, 10);
	$worksheet->setColumn (21, 21, 3);
	$worksheet->setColumn (22, 22, 10);
	$worksheet->setColumn (23, 23, 3);
	$worksheet->setColumn (24, 24, 10);
	$worksheet->setColumn (25, 25, 5);
	$worksheet->setColumn (26, 26, 11);
}

$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;


$worksheet->write($row, 6, "LAPORAN MUTASI OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "KEPEMILIKAN : $kpid1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "KELAS : $k1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "GOLONGAN : $g1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "JENIS : $j1", $sheetTitleFormat);
$row += 1;
if ($tipe=="1"){
	$worksheet->write($row, 6, "PERIODE : ".strtoupper($bulann)." ".$tahun, $sheetTitleFormat);
}else{
	$worksheet->write($row, 6, "PERIODE : ".strtoupper($bulann)." ".$tahun." s/d ".strtoupper($bulan1n)." ".$tahun1, $sheetTitleFormat);
}

$row += 1;
if ($idunit1=="0"){
	$worksheet->write($row, $column, "No", $columnTitleFormat);
	$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
	$worksheet->write($row, $column+2, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+3, "Saldo Awal", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+4, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+3,$row,$column+4);
	$worksheet->write($row, $column+5, "Masuk", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+6, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+7, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+8, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+9, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+10, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+13, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+5,$row,$column+14);
	$worksheet->write($row, $column+15, "Keluar", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+16, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+17, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+18, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+19, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+20, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+21, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+22, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+23, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+24, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+25, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+26, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+15,$row,$column+26);
	$worksheet->write($row, $column+27, "Adj", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+28, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+27,$row,$column+28);
	$worksheet->write($row, $column+29, "Saldo Akhir", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+30, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+29,$row,$column+30);
}else{
	$worksheet->write($row, $column, "No", $columnTitleFormat);
	$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
	$worksheet->write($row, $column+2, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+3, "Saldo Awal", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+4, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+3,$row,$column+4);
	$worksheet->write($row, $column+5, "Masuk", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+6, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+7, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+8, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+9, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+10, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+5,$row,$column+12);
	$worksheet->write($row, $column+13, "Keluar", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+15, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+16, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+17, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+18, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+19, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+20, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+21, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+22, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+13,$row,$column+22);
	$worksheet->write($row, $column+23, "Adj", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+24, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+23,$row,$column+24);
	$worksheet->write($row, $column+25, "Saldo Akhir", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+26, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+25,$row,$column+26);
}
$row += 1;

if ($idunit1=="0"){
	$worksheet->writeBlank($row, $column, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column,$row,$column);
	$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+1,$row,$column+1);
	$worksheet->writeBlank($row, $column+2, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+2,$row,$column+2);
	$worksheet->write($row, $column+3, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+5, "Pbf", $columnTitleFormat);
	$worksheet->write($row, $column+6, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+7, "Prod", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+12, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+13, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+14, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+15, "Jual", $columnTitleFormat);
	$worksheet->write($row, $column+16, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+17, "Prod", $columnTitleFormat);
	$worksheet->write($row, $column+18, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+19, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+20, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+21, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+22, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+23, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+24, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+25, "Hapus", $columnTitleFormat);
	$worksheet->write($row, $column+26, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+27, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+28, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+29, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+30, "Nilai", $columnTitleFormat);
}else{
	$worksheet->writeBlank($row, $column, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column,$row,$column);
	$worksheet->writeBlank($row, $column+1, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+1,$row,$column+1);
	$worksheet->writeBlank($row, $column+2, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+2,$row,$column+2);
	$worksheet->write($row, $column+3, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
	if ($idunit1=="17")
		$worksheet->write($row, $column+5, "Prod", $columnTitleFormat);
	else
		$worksheet->write($row, $column+5, "Pbf", $columnTitleFormat);
		
	$worksheet->write($row, $column+6, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+7, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+12, "Nilai", $columnTitleFormat);
	if ($idunit1=="17")
		$worksheet->write($row, $column+13, "Prod", $columnTitleFormat);
	else
		$worksheet->write($row, $column+13, "Jual", $columnTitleFormat);
		
	$worksheet->write($row, $column+14, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+15, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+16, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+17, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+18, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+19, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+20, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+21, "Hapus", $columnTitleFormat);
	$worksheet->write($row, $column+22, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+23, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+24, "Nilai", $columnTitleFormat);
	$worksheet->write($row, $column+25, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+26, "Nilai", $columnTitleFormat);
}

$row++;

  if ($sorting=="") $sorting=$defaultsort;
  if ($tipe=="1"){
	  if ($idunit1=="0"){
	  	$sql="SELECT ao.OBAT_NAMA,ak.NAMA,SUM(arpt.QTY_AWAL) AS QTY_AWAL,SUM(FLOOR(arpt.NILAI_AWAL)) AS NILAI_AWAL,
SUM(arpt.PBF) AS PBF,SUM(FLOOR(arpt.PBF_NILAI)) AS PBF_NILAI,SUM(arpt.UNIT_IN) AS UNIT_IN,
SUM(FLOOR(arpt.UNIT_IN_NILAI)) AS UNIT_IN_NILAI,SUM(arpt.MILIK_IN) AS MILIK_IN,SUM(FLOOR(arpt.MILIK_IN_NILAI)) AS MILIK_IN_NILAI,
SUM(arpt.RETURN_IN) AS RETURN_IN,SUM(FLOOR(arpt.RETURN_IN_NILAI)) AS RETURN_IN_NILAI,SUM(arpt.PRODUKSI_IN) AS PRODUKSI_IN,
SUM(FLOOR(arpt.PRODUKSI_IN_NILAI)) AS PRODUKSI_IN_NILAI,SUM(arpt.JUAL) AS JUAL,SUM(FLOOR(arpt.JUAL_NILAI)) AS JUAL_NILAI,
SUM(arpt.UNIT_OUT) AS UNIT_OUT,SUM(FLOOR(arpt.UNIT_OUT_NILAI)) AS UNIT_OUT_NILAI,SUM(arpt.RETURN_OUT) AS RETURN_OUT, 
SUM(FLOOR(arpt.RETURN_OUT_NILAI)) AS RETURN_OUT_NILAI,SUM(arpt.MILIK_OUT) AS MILIK_OUT, 
SUM(FLOOR(arpt.MILIK_OUT_NILAI)) AS MILIK_OUT_NILAI,SUM(arpt.HAPUS) AS HAPUS,SUM(FLOOR(arpt.HAPUS_NILAI)) AS HAPUS_NILAI, 
SUM(arpt.PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(FLOOR(arpt.PRODUKSI_OUT_NILAI)) AS PRODUKSI_OUT_NILAI,SUM(arpt.ADJUST) AS ADJUST, 
SUM(FLOOR(arpt.ADJUST_NILAI)) AS ADJUST_NILAI,SUM(arpt.QTY_AKHIR) AS QTY_AKHIR,SUM(FLOOR(arpt.NILAI_AKHIR)) AS NILAI_AKHIR
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun".$filter.") AS arpt INNER JOIN a_obat ao ON arpt.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
".$fkelas.$fgolongan.$fjenis." GROUP BY arpt.OBAT_ID,arpt.KEPEMILIKAN_ID ORDER BY ao.OBAT_NAMA,ak.ID";
	  }else{
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,arpt.* 
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun AND UNIT_ID=$idunit1".$filter.") AS arpt 
INNER JOIN a_obat ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
".$fkelas.$fgolongan.$fjenis." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }
  }else{
  	  if ($bulan<10) $tgl_awal=$tahun."-0".$bulan; else $tgl_awal=$tahun."-".$bulan;
	  if ($bulan1<10) $tgl_akhir=$tahun1."-0".$bulan1; else $tgl_akhir=$tahun1."-".$bulan1;
	  if ($idunit1=="0"){
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,arpt.* FROM 
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_AWAL1) AS QTY_AWAL,SUM(FLOOR(NILAI_AWAL1)) AS NILAI_AWAL,SUM(PBF) AS PBF,SUM(FLOOR(PBF_NILAI)) AS PBF_NILAI,
SUM(UNIT_IN) AS UNIT_IN,SUM(FLOOR(UNIT_IN_NILAI)) AS UNIT_IN_NILAI,SUM(MILIK_IN) AS MILIK_IN,SUM(FLOOR(MILIK_IN_NILAI)) AS MILIK_IN_NILAI,
SUM(RETURN_IN) AS RETURN_IN,SUM(FLOOR(RETURN_IN_NILAI)) AS RETURN_IN_NILAI,SUM(PRODUKSI_IN) AS PRODUKSI_IN,SUM(FLOOR(PRODUKSI_IN_NILAI)) AS PRODUKSI_IN_NILAI,
SUM(JUAL) AS JUAL,SUM(FLOOR(JUAL_NILAI)) AS JUAL_NILAI,SUM(UNIT_OUT) AS UNIT_OUT,SUM(FLOOR(UNIT_OUT_NILAI)) AS UNIT_OUT_NILAI,SUM(RETURN_OUT) AS RETURN_OUT,
SUM(FLOOR(RETURN_OUT_NILAI)) AS RETURN_OUT_NILAI,SUM(MILIK_OUT) AS MILIK_OUT,SUM(FLOOR(MILIK_OUT_NILAI)) AS MILIK_OUT_NILAI,SUM(HAPUS) AS HAPUS,
SUM(FLOOR(HAPUS_NILAI)) AS HAPUS_NILAI,SUM(PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(FLOOR(PRODUKSI_OUT_NILAI)) AS PRODUKSI_OUT_NILAI,SUM(ADJUST) AS ADJUST,
SUM(FLOOR(ADJUST_NILAI)) AS ADJUST_NILAI,SUM(QTY_AKHIR1) AS QTY_AKHIR,SUM(FLOOR(NILAI_AKHIR1)) AS NILAI_AKHIR FROM 
(SELECT *,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',QTY_AWAL,0) AS QTY_AWAL1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',NILAI_AWAL,0) AS NILAI_AWAL1,
IF(CONCAT(TAHUN,'-',BULAN)='".$tahun1."-".$bulan1."',QTY_AKHIR,0) AS QTY_AKHIR1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun1."-".$bulan1."',NILAI_AKHIR,0) AS NILAI_AKHIR1
FROM a_rpt_mutasi WHERE UNIT_ID=$idunit1".$filter." AND CONCAT(TAHUN,'-',IF (BULAN<10,CONCAT('0',BULAN),BULAN)) 
BETWEEN '$tgl_awal' AND '$tgl_akhir') AS tmp1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS arpt 
INNER JOIN a_obat ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
".$fkelas.$fgolongan.$fjenis." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }else{
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,arpt.* FROM 
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_AWAL1) AS QTY_AWAL,SUM(FLOOR(NILAI_AWAL1)) AS NILAI_AWAL,SUM(PBF) AS PBF,SUM(FLOOR(PBF_NILAI)) AS PBF_NILAI,
SUM(UNIT_IN) AS UNIT_IN,SUM(FLOOR(UNIT_IN_NILAI)) AS UNIT_IN_NILAI,SUM(MILIK_IN) AS MILIK_IN,SUM(FLOOR(MILIK_IN_NILAI)) AS MILIK_IN_NILAI,
SUM(RETURN_IN) AS RETURN_IN,SUM(FLOOR(RETURN_IN_NILAI)) AS RETURN_IN_NILAI,SUM(PRODUKSI_IN) AS PRODUKSI_IN,SUM(FLOOR(PRODUKSI_IN_NILAI)) AS PRODUKSI_IN_NILAI,
SUM(JUAL) AS JUAL,SUM(FLOOR(JUAL_NILAI)) AS JUAL_NILAI,SUM(UNIT_OUT) AS UNIT_OUT,SUM(FLOOR(UNIT_OUT_NILAI)) AS UNIT_OUT_NILAI,SUM(RETURN_OUT) AS RETURN_OUT,
SUM(FLOOR(RETURN_OUT_NILAI)) AS RETURN_OUT_NILAI,SUM(MILIK_OUT) AS MILIK_OUT,SUM(FLOOR(MILIK_OUT_NILAI)) AS MILIK_OUT_NILAI,SUM(HAPUS) AS HAPUS,
SUM(FLOOR(HAPUS_NILAI)) AS HAPUS_NILAI,SUM(PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(FLOOR(PRODUKSI_OUT_NILAI)) AS PRODUKSI_OUT_NILAI,SUM(ADJUST) AS ADJUST,
SUM(FLOOR(ADJUST_NILAI)) AS ADJUST_NILAI,SUM(QTY_AKHIR1) AS QTY_AKHIR,SUM(FLOOR(NILAI_AKHIR1)) AS NILAI_AKHIR FROM 
(SELECT *,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',QTY_AWAL,0) AS QTY_AWAL1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',NILAI_AWAL,0) AS NILAI_AWAL1,
IF(CONCAT(TAHUN,'-',BULAN)='".$tahun1."-".$bulan1."',QTY_AKHIR,0) AS QTY_AKHIR1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun1."-".$bulan1."',NILAI_AKHIR,0) AS NILAI_AKHIR1
FROM a_rpt_mutasi WHERE UNIT_ID=$idunit1".$filter." AND CONCAT(TAHUN,'-',IF (BULAN<10,CONCAT('0',BULAN),BULAN)) 
BETWEEN '$tgl_awal' AND '$tgl_akhir') AS tmp1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS arpt 
INNER JOIN a_obat ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
".$fkelas.$fgolongan.$fjenis." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }
  }

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($idunit1=="0"){
	while ($rows=mysqli_fetch_array($rs)){
		$qty_akhir=$rows['QTY_AKHIR'];
		$nilai_akhir=floor($rows['NILAI_AKHIR']);
		$kode_obat=$rows['OBAT_KODE'];
		$worksheet->write($row, 0, $row-8, $regularFormatC);
		$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
		$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
		$worksheet->write($row, 3, $rows['QTY_AWAL'], $regularFormatR);
		$worksheet->write($row, 4, floor($rows['NILAI_AWAL']), $regularFormatRF);
		$worksheet->write($row, 5, $rows['PBF'], $regularFormatR);
		$worksheet->write($row, 6, $rows['PBF_NILAI'], $regularFormatRF);
		$worksheet->write($row, 7, $rows['PRODUKSI_IN'], $regularFormatR);
		$worksheet->write($row, 8, $rows['PRODUKSI_IN_NILAI'], $regularFormatRF);
		$worksheet->write($row, 9, $rows['UNIT_IN'], $regularFormatR);
		$worksheet->write($row, 10, $rows['UNIT_IN_NILAI'], $regularFormatRF);
		$worksheet->write($row, 11, $rows['MILIK_IN'], $regularFormatR);
		$worksheet->write($row, 12, $rows['MILIK_IN_NILAI'], $regularFormatRF);
		$worksheet->write($row, 13, $rows['RETURN_IN'], $regularFormatR);
		$worksheet->write($row, 14, $rows['RETURN_IN_NILAI'], $regularFormatRF);
		$worksheet->write($row, 15, $rows['JUAL'], $regularFormatR);
		$worksheet->write($row, 16, $rows['JUAL_NILAI'], $regularFormatRF);
		$worksheet->write($row, 17, $rows['PRODUKSI_OUT'], $regularFormatR);
		$worksheet->write($row, 18, $rows['PRODUKSI_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 19, $rows['UNIT_OUT'], $regularFormatR);
		$worksheet->write($row, 20, $rows['UNIT_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 21, $rows['RETURN_OUT'], $regularFormatR);
		$worksheet->write($row, 22, $rows['RETURN_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 23, $rows['MILIK_OUT'], $regularFormatR);
		$worksheet->write($row, 24, $rows['MILIK_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 25, $rows['HAPUS'], $regularFormatR);
		$worksheet->write($row, 26, $rows['HAPUS_NILAI'], $regularFormatRF);
		$worksheet->write($row, 27, $rows['ADJUST'], $regularFormatR);
		$worksheet->write($row, 28, $rows['ADJUST_NILAI'], $regularFormatRF);
		$worksheet->write($row, 29, $qty_akhir, $regularFormatR);
		$worksheet->write($row, 30, $nilai_akhir, $regularFormatRF);
		$row++;
	}
	$worksheet->write($row, 2, "Total ", $regularFormatR);
	$worksheet->writeBlank($row, 3, $regularFormatR);
	$worksheet->mergeCells($row,2,$row,3);
	$worksheet->write($row, 4, '=Sum(E10:E'.$row.')', $regularFormatRF);
	$worksheet->write($row, 6, '=Sum(G10:G'.$row.')', $regularFormatRF);
	$worksheet->write($row, 8, '=Sum(I10:I'.$row.')', $regularFormatRF);
	$worksheet->write($row, 10, '=Sum(K10:K'.$row.')', $regularFormatRF);
	$worksheet->write($row, 12, '=Sum(M10:M'.$row.')', $regularFormatRF);
	$worksheet->write($row, 14, '=Sum(O10:O'.$row.')', $regularFormatRF);
	$worksheet->write($row, 16, '=Sum(Q10:Q'.$row.')', $regularFormatRF);
	$worksheet->write($row, 18, '=Sum(S10:S'.$row.')', $regularFormatRF);
	$worksheet->write($row, 20, '=Sum(U10:U'.$row.')', $regularFormatRF);
	$worksheet->write($row, 22, '=Sum(W10:W'.$row.')', $regularFormatRF);
	$worksheet->write($row, 24, '=Sum(Y10:Y'.$row.')', $regularFormatRF);
	$worksheet->write($row, 26, '=Sum(AA10:AA'.$row.')', $regularFormatRF);
	$worksheet->write($row, 28, '=Sum(AC10:AC'.$row.')', $regularFormatRF);
	$worksheet->write($row, 30, '=Sum(AE10:AE'.$row.')', $regularFormatRF);
}else{
	while ($rows=mysqli_fetch_array($rs)){
		$qty_akhir=$rows['QTY_AKHIR'];
		$nilai_akhir=floor($rows['NILAI_AKHIR']);
		$kode_obat=$rows['OBAT_KODE'];
		$worksheet->write($row, 0, $row-8, $regularFormatC);
		$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
		$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
		$worksheet->write($row, 3, $rows['QTY_AWAL'], $regularFormatR);
		$worksheet->write($row, 4, floor($rows['NILAI_AWAL']), $regularFormatRF);
		if ($idunit1=="17"){
			$worksheet->write($row, 5, $rows['PRODUKSI_IN'], $regularFormatR);
			$worksheet->write($row, 6, $rows['PRODUKSI_IN_NILAI'], $regularFormatRF);
		}else{
			$worksheet->write($row, 5, $rows['PBF'], $regularFormatR);
			$worksheet->write($row, 6, $rows['PBF_NILAI'], $regularFormatRF);
		}

		$worksheet->write($row, 7, $rows['UNIT_IN'], $regularFormatR);
		$worksheet->write($row, 8, $rows['UNIT_IN_NILAI'], $regularFormatRF);
		$worksheet->write($row, 9, $rows['MILIK_IN'], $regularFormatR);
		$worksheet->write($row, 10, $rows['MILIK_IN_NILAI'], $regularFormatRF);
		$worksheet->write($row, 11, $rows['RETURN_IN'], $regularFormatR);
		$worksheet->write($row, 12, $rows['RETURN_IN_NILAI'], $regularFormatRF);
		if ($idunit1=="17"){
			$worksheet->write($row, 13, $rows['PRODUKSI_OUT'], $regularFormatR);
			$worksheet->write($row, 14, $rows['PRODUKSI_OUT_NILAI'], $regularFormatRF);
		}else{
			$worksheet->write($row, 13, $rows['JUAL'], $regularFormatR);
			$worksheet->write($row, 14, $rows['JUAL_NILAI'], $regularFormatRF);
		}

		$worksheet->write($row, 15, $rows['UNIT_OUT'], $regularFormatR);
		$worksheet->write($row, 16, $rows['UNIT_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 17, $rows['RETURN_OUT'], $regularFormatR);
		$worksheet->write($row, 18, $rows['RETURN_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 19, $rows['MILIK_OUT'], $regularFormatR);
		$worksheet->write($row, 20, $rows['MILIK_OUT_NILAI'], $regularFormatRF);
		$worksheet->write($row, 21, $rows['HAPUS'], $regularFormatR);
		$worksheet->write($row, 22, $rows['HAPUS_NILAI'], $regularFormatRF);
		$worksheet->write($row, 23, $rows['ADJUST'], $regularFormatR);
		$worksheet->write($row, 24, $rows['ADJUST_NILAI'], $regularFormatRF);
		$worksheet->write($row, 25, $qty_akhir, $regularFormatR);
		$worksheet->write($row, 26, $nilai_akhir, $regularFormatRF);
		$row++;
	}
	$worksheet->write($row, 2, "Total ", $regularFormatR);
	$worksheet->writeBlank($row, 3, $regularFormatR);
	$worksheet->mergeCells($row,2,$row,3);
	$worksheet->write($row, 4, '=Sum(E10:E'.$row.')', $regularFormatRF);
	$worksheet->write($row, 6, '=Sum(G10:G'.$row.')', $regularFormatRF);
	$worksheet->write($row, 8, '=Sum(I10:I'.$row.')', $regularFormatRF);
	$worksheet->write($row, 10, '=Sum(K10:K'.$row.')', $regularFormatRF);
	$worksheet->write($row, 12, '=Sum(M10:M'.$row.')', $regularFormatRF);
	$worksheet->write($row, 14, '=Sum(O10:O'.$row.')', $regularFormatRF);
	$worksheet->write($row, 16, '=Sum(Q10:Q'.$row.')', $regularFormatRF);
	$worksheet->write($row, 18, '=Sum(S10:S'.$row.')', $regularFormatRF);
	$worksheet->write($row, 20, '=Sum(U10:U'.$row.')', $regularFormatRF);
	$worksheet->write($row, 22, '=Sum(W10:W'.$row.')', $regularFormatRF);
	$worksheet->write($row, 24, '=Sum(Y10:Y'.$row.')', $regularFormatRF);
	$worksheet->write($row, 26, '=Sum(AA10:AA'.$row.')', $regularFormatRF);
}

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>