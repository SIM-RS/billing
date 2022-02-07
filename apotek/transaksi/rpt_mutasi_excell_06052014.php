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
$bulann=$_REQUEST['bulann'];
$tahun=$_REQUEST['tahun'];
$bulan1=$_REQUEST['bulan1'];
$bulan1n=$_REQUEST['bulan1n'];
$tahun1=$_REQUEST['tahun1'];

//$defaultsort="t6.OBAT_NAMA,t6.KEPEMILIKAN_ID";
$idunit1=$_REQUEST['idunit1'];
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
$kpid=$_REQUEST['kpid'];if ($kpid=="0") $filter=""; else $filter=" AND KEPEMILIKAN_ID=".$kpid;
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{$fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if ($kelas=="") $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
$kpid1=$_REQUEST['kpid1'];
$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
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
	$worksheet->setColumn (5, 16, 3);
	$worksheet->setColumn (17, 17, 5);
	$worksheet->setColumn (18, 18, 11);
}else{
	$worksheet->setColumn (0, 0, 3);
	$worksheet->setColumn (1, 1, 17);
	$worksheet->setColumn (2, 2, 8);
	$worksheet->setColumn (3, 3, 5);
	$worksheet->setColumn (4, 4, 11);
	$worksheet->setColumn (5, 14, 3);
	$worksheet->setColumn (15, 15, 5);
	$worksheet->setColumn (16, 16, 11);
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
	$worksheet->mergeCells($row,$column+5,$row,$column+9);
	$worksheet->write($row, $column+10, "Keluar", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+13, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+15, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+10,$row,$column+15);
	$worksheet->write($row, $column+16, "Adj", $columnTitleFormat);
	$worksheet->write($row, $column+17, "Saldo Akhir", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+18, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+17,$row,$column+18);
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
	$worksheet->mergeCells($row,$column+5,$row,$column+8);
	$worksheet->write($row, $column+9, "Keluar", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+10, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+11, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+12, $columnTitleFormat);
	$worksheet->writeBlank($row, $column+13, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+9,$row,$column+13);
	$worksheet->write($row, $column+14, "Adj", $columnTitleFormat);
	$worksheet->write($row, $column+15, "Saldo Akhir", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+16, $columnTitleFormat);
	$worksheet->mergeCells($row,$column+15,$row,$column+16);
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
	$worksheet->write($row, $column+6, "Prod", $columnTitleFormat);
	$worksheet->write($row, $column+7, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+9, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+10, "Jual", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Prod", $columnTitleFormat);
	$worksheet->write($row, $column+12, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+13, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+14, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+15, "Hapus", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+16, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+16,$row,$column+16);
	$worksheet->write($row, $column+17, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+18, "Nilai", $columnTitleFormat);
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
		
	$worksheet->write($row, $column+6, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+7, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+8, "Ret", $columnTitleFormat);
	if ($idunit1=="17")
		$worksheet->write($row, $column+9, "Prod", $columnTitleFormat);
	else
		$worksheet->write($row, $column+9, "Jual", $columnTitleFormat);
		
	$worksheet->write($row, $column+10, "Unit", $columnTitleFormat);
	$worksheet->write($row, $column+11, "Ret", $columnTitleFormat);
	$worksheet->write($row, $column+12, "Milik", $columnTitleFormat);
	$worksheet->write($row, $column+13, "Hapus", $columnTitleFormat);
	$worksheet->writeBlank($row, $column+14, $columnTitleFormat);
	$worksheet->mergeCells($row-1,$column+14,$row,$column+14);
	$worksheet->write($row, $column+15, "Qty", $columnTitleFormat);
	$worksheet->write($row, $column+16, "Nilai", $columnTitleFormat);
}

$row++;

  if ($sorting=="") $sorting=$defaultsort;
  if ($tipe=="1"){
	  if ($idunit1=="0"){
	  	$sql="SELECT ao.OBAT_NAMA,ak.NAMA,SUM(arpt.QTY_AWAL) AS QTY_AWAL,SUM(FLOOR(arpt.NILAI_AWAL)) AS NILAI_AWAL,
SUM(arpt.PBF) AS PBF,SUM(arpt.UNIT_IN) AS UNIT_IN,SUM(arpt.MILIK_IN) AS MILIK_IN,SUM(arpt.RETURN_IN) AS RETURN_IN, 
SUM(arpt.PRODUKSI_IN) AS PRODUKSI_IN,SUM(arpt.JUAL) AS JUAL,SUM(arpt.UNIT_OUT) AS UNIT_OUT,SUM(arpt.RETURN_OUT) AS RETURN_OUT, 
SUM(arpt.MILIK_OUT) AS MILIK_OUT,SUM(arpt.HAPUS) AS HAPUS,SUM(arpt.PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(arpt.ADJUST) AS ADJUST, 
SUM(arpt.QTY_AKHIR) AS QTY_AKHIR,SUM(FLOOR(arpt.NILAI_AKHIR)) AS NILAI_AKHIR
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun".$filter.") AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID".$fkelas.$fgolongan.$fjenis." 
GROUP BY arpt.OBAT_ID,arpt.KEPEMILIKAN_ID ORDER BY ao.OBAT_NAMA,ak.ID";
	  }else{
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,arpt.* 
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$bulan AND TAHUN=$tahun AND UNIT_ID=$idunit1".$filter.") AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
".$fkelas.$fgolongan.$fjenis." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }
  }else{
  	  if ($bulan<10) $tgl_awal=$tahun."-0".$bulan; else $tgl_awal=$tahun."-".$bulan;
	  if ($bulan1<10) $tgl_akhir=$tahun1."-0".$bulan1; else $tgl_akhir=$tahun1."-".$bulan1;
	  if ($idunit1=="0"){
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,arpt.* FROM 
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_AWAL1) AS QTY_AWAL,SUM(FLOOR(NILAI_AWAL1)) AS NILAI_AWAL,SUM(PBF) AS PBF,
SUM(UNIT_IN) AS UNIT_IN,SUM(MILIK_IN) AS MILIK_IN,SUM(RETURN_IN) AS RETURN_IN,SUM(PRODUKSI_IN) AS PRODUKSI_IN,
SUM(JUAL) AS JUAL,SUM(UNIT_OUT) AS UNIT_OUT,SUM(RETURN_OUT) AS RETURN_OUT,SUM(MILIK_OUT) AS MILIK_OUT,SUM(HAPUS) AS HAPUS,
SUM(PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(ADJUST) AS ADJUST,SUM(QTY_AKHIR1) AS QTY_AKHIR,SUM(FLOOR(NILAI_AKHIR1)) AS NILAI_AKHIR FROM 
(SELECT *,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',QTY_AWAL,0) AS QTY_AWAL1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',NILAI_AWAL,0) AS NILAI_AWAL1,
IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',QTY_AKHIR,0) AS QTY_AKHIR1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',NILAI_AKHIR,0) AS NILAI_AKHIR1
FROM a_rpt_mutasi WHERE (CONCAT(TAHUN,'-',IF (BULAN<10,CONCAT('0',BULAN),BULAN)) 
BETWEEN '$tgl_awal' AND '$tgl_akhir')".$filter.") AS tmp1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
".$fkelas.$fgolongan.$fjenis." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }else{
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,arpt.* FROM 
(SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_AWAL1) AS QTY_AWAL,SUM(FLOOR(NILAI_AWAL1)) AS NILAI_AWAL,SUM(PBF) AS PBF,
SUM(UNIT_IN) AS UNIT_IN,SUM(MILIK_IN) AS MILIK_IN,SUM(RETURN_IN) AS RETURN_IN,SUM(PRODUKSI_IN) AS PRODUKSI_IN,
SUM(JUAL) AS JUAL,SUM(UNIT_OUT) AS UNIT_OUT,SUM(RETURN_OUT) AS RETURN_OUT,SUM(MILIK_OUT) AS MILIK_OUT,SUM(HAPUS) AS HAPUS,
SUM(PRODUKSI_OUT) AS PRODUKSI_OUT,SUM(ADJUST) AS ADJUST,SUM(QTY_AKHIR1) AS QTY_AKHIR,SUM(FLOOR(NILAI_AKHIR1)) AS NILAI_AKHIR FROM 
(SELECT *,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',QTY_AWAL,0) AS QTY_AWAL1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan."',NILAI_AWAL,0) AS NILAI_AWAL1,
IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',QTY_AKHIR,0) AS QTY_AKHIR1,IF(CONCAT(TAHUN,'-',BULAN)='".$tahun."-".$bulan1."',NILAI_AKHIR,0) AS NILAI_AKHIR1
FROM a_rpt_mutasi WHERE UNIT_ID=$idunit1".$filter." AND CONCAT(TAHUN,'-',IF (BULAN<10,CONCAT('0',BULAN),BULAN)) 
BETWEEN '$tgl_awal' AND '$tgl_akhir') AS tmp1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
".$fkelas.$fgolongan.$fjenis." ORDER BY ao.OBAT_NAMA,ak.ID";
	  }
  }

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
if ($idunit1=="0"){
	while ($rows=mysqli_fetch_array($rs)){
		$qty_trans=$rows['QTY_AWAL']+$rows['PBF']+$rows['PRODUKSI_IN']+$rows['UNIT_IN'];
		$qty_trans+=$rows['MILIK_IN']+$rows['RETURN_IN']+$rows['JUAL']+$rows['PRODUKSI_OUT'];
		$qty_trans+=$rows['UNIT_OUT']+$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS'];
		$qty_trans+=$rows['ADJUST']+$rows['QTY_AKHIR'];
		if ($qty_trans<>0){
			$qty_akhir=$rows['QTY_AKHIR'];
			$nilai_akhir=floor($rows['NILAI_AKHIR']);
			$kode_obat=$rows['OBAT_KODE'];
			$worksheet->write($row, 0, $row-8, $regularFormatC);
			$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
			$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
			$worksheet->write($row, 3, $rows['QTY_AWAL'], $regularFormatR);
			$worksheet->write($row, 4, floor($rows['NILAI_AWAL']), $regularFormatRF);
			$worksheet->write($row, 5, $rows['PBF'], $regularFormatR);
			$worksheet->write($row, 6, $rows['PRODUKSI_IN'], $regularFormatR);
			$worksheet->write($row, 7, $rows['UNIT_IN'], $regularFormatR);
			$worksheet->write($row, 8, $rows['MILIK_IN'], $regularFormatR);
			$worksheet->write($row, 9, $rows['RETURN_IN'], $regularFormatR);
			$worksheet->write($row, 10, $rows['JUAL'], $regularFormatR);
			$worksheet->write($row, 11, $rows['PRODUKSI_OUT'], $regularFormatR);
			$worksheet->write($row, 12, $rows['UNIT_OUT'], $regularFormatR);
			$worksheet->write($row, 13, $rows['RETURN_OUT'], $regularFormatR);
			$worksheet->write($row, 14, $rows['MILIK_OUT'], $regularFormatR);
			$worksheet->write($row, 15, $rows['HAPUS'], $regularFormatR);
			$worksheet->write($row, 16, $rows['ADJUST'], $regularFormatR);
			$worksheet->write($row, 17, $qty_akhir, $regularFormatR);
			$worksheet->write($row, 18, $nilai_akhir, $regularFormatRF);
			$row++;
		}
	}
	$worksheet->write($row, 2, "Total Saldo Awal", $regularFormatR);
	$worksheet->writeBlank($row, 3, $regularFormatR);
	$worksheet->mergeCells($row,2,$row,3);
	$worksheet->write($row, 4, '=Sum(E10:E'.$row.')', $regularFormatRF);
	$worksheet->write($row, 14, "Total Saldo Akhir", $regularFormatR);
	$worksheet->writeBlank($row, 15, $regularFormatR);
	$worksheet->writeBlank($row, 16, $regularFormatR);
	$worksheet->writeBlank($row, 17, $regularFormatR);
	$worksheet->mergeCells($row,14,$row,17);
	$worksheet->write($row, 18, '=Sum(S10:S'.$row.')', $regularFormatRF);
}else{
	while ($rows=mysqli_fetch_array($rs)){
		$qty_trans=$rows['QTY_AWAL']+$rows['UNIT_IN']+$rows['MILIK_IN']+$rows['RETURN_IN']+$rows['UNIT_OUT'];
		$qty_trans+=$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS']+$rows['ADJUST']+$rows['QTY_AKHIR'];
		if ($idunit1=="17"){
			$qty_trans+=$rows['PRODUKSI_IN']+$rows['PRODUKSI_OUT'];
		}else{
			$qty_trans+=$rows['PBF']+$rows['JUAL'];
		}
		if ($qty_trans<>0){
			$qty_akhir=$rows['QTY_AKHIR'];
			$nilai_akhir=floor($rows['NILAI_AKHIR']);
			$kode_obat=$rows['OBAT_KODE'];
			$worksheet->write($row, 0, $row-8, $regularFormatC);
			$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
			$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
			$worksheet->write($row, 3, $rows['QTY_AWAL'], $regularFormatR);
			$worksheet->write($row, 4, floor($rows['NILAI_AWAL']), $regularFormatRF);
			if ($idunit1=="17")
				$worksheet->write($row, 5, $rows['PRODUKSI_IN'], $regularFormatR);
			else
				$worksheet->write($row, 5, $rows['PBF'], $regularFormatR);
				
			$worksheet->write($row, 6, $rows['UNIT_IN'], $regularFormatR);
			$worksheet->write($row, 7, $rows['MILIK_IN'], $regularFormatR);
			$worksheet->write($row, 8, $rows['RETURN_IN'], $regularFormatR);
			if ($idunit1=="17")
				$worksheet->write($row, 9, $rows['PRODUKSI_OUT'], $regularFormatR);
			else
				$worksheet->write($row, 9, $rows['JUAL'], $regularFormatR);
				
			$worksheet->write($row, 10, $rows['UNIT_OUT'], $regularFormatR);
			$worksheet->write($row, 11, $rows['RETURN_OUT'], $regularFormatR);
			$worksheet->write($row, 12, $rows['MILIK_OUT'], $regularFormatR);
			$worksheet->write($row, 13, $rows['HAPUS'], $regularFormatR);
			$worksheet->write($row, 14, $rows['ADJUST'], $regularFormatR);
			$worksheet->write($row, 15, $qty_akhir, $regularFormatR);
			$worksheet->write($row, 16, $nilai_akhir, $regularFormatRF);
			$row++;
		}
	}
	$worksheet->write($row, 2, "Total Saldo Awal", $regularFormatR);
	$worksheet->writeBlank($row, 3, $regularFormatR);
	$worksheet->mergeCells($row,2,$row,3);
	$worksheet->write($row, 4, '=Sum(E10:E'.$row.')', $regularFormatRF);
	$worksheet->write($row, 12, "Total Saldo Akhir", $regularFormatR);
	$worksheet->writeBlank($row, 13, $regularFormatR);
	$worksheet->writeBlank($row, 14, $regularFormatR);
	$worksheet->writeBlank($row, 15, $regularFormatR);
	$worksheet->mergeCells($row,12,$row,15);
	$worksheet->write($row, 16, '=Sum(Q10:Q'.$row.')', $regularFormatRF);
}

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>