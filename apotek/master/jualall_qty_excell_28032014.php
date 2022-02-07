<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tgl_d1=$_REQUEST['tgl_d1'];
$tgl_s1=$_REQUEST['tgl_s1'];
$tgl_d=explode("-",$tgl_d1);$tgl_d=$tgl_d[2]."/".$tgl_d[1]."/".$tgl_d[0];
$tgl_s=explode("-",$tgl_s1);$tgl_s=$tgl_s[2]."/".$tgl_s[1]."/".$tgl_s[0];
//Paging,Sorting dan Filter======
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
if ($sorting=="t2.OBAT_NAMA,t2.NAMA") $sorting=$defaultsort;
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
$k1=$_REQUEST['k1'];
$g1=$_REQUEST['g1'];
$j1=$_REQUEST['j1'];

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Pemakaian_All_Unit.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Pemakaian Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 10);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 12);
$worksheet->setColumn (3, 14, 8);
$worksheet->setColumn (15, 15, 12);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 3, "LAPORAN PEMAKAIAN OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "ALL UNIT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "KELAS : ".$k1, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "GOLONGAN : ".$g1, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "JENIS : ".$j1, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "(".$tgl_d." - ".$tgl_s.")", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+3, "AP1", $columnTitleFormat);
$worksheet->write($row, $column+4, "AP2", $columnTitleFormat);
$worksheet->write($row, $column+5, "AP3", $columnTitleFormat);
$worksheet->write($row, $column+6, "AP4", $columnTitleFormat);
$worksheet->write($row, $column+7, "AP5", $columnTitleFormat);
$worksheet->write($row, $column+8, "AP6", $columnTitleFormat);
$worksheet->write($row, $column+9, "AP7", $columnTitleFormat);
$worksheet->write($row, $column+10, "AP8", $columnTitleFormat);
$worksheet->write($row, $column+11, "AP10", $columnTitleFormat);
$worksheet->write($row, $column+12, "AP11", $columnTitleFormat);
$worksheet->write($row, $column+13, "FS", $columnTitleFormat);
$worksheet->write($row, $column+14, "Total", $columnTitleFormat);
$worksheet->write($row, $column+15, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }
  
  $sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ak.NAMA,t1.*,t1.AP1+t1.AP2+t1.AP3+t1.AP4+t1.AP5+t1.AP6+t1.AP7+t1.AP8+t1.AP10+t1.AP11+t1.FS AS QTY_TOTAL FROM a_obat ao INNER JOIN 
		(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 2),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP1`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 3),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP2`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 4),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP3`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 5),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP4`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 6),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP5`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 100),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP6`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 101),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP7`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 97),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP8`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 11),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP10`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 12),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP11`,
		SUM(IF((`a_penjualan`.`UNIT_ID` = 20),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `FS`,
		SUM(FLOOR((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
		FROM (`a_penerimaan` INNER JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
		WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`)) 
		GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
		LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
		INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID".$filter.$fkelas.$fgolongan.$fjenis." ORDER BY ".$sorting;

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['AP1'], $regularFormatR);
	$worksheet->write($row, 4, $rows['AP2'], $regularFormatR);
	$worksheet->write($row, 5, $rows['AP3'], $regularFormatR);
	$worksheet->write($row, 6, $rows['AP4'], $regularFormatR);
	$worksheet->write($row, 7, $rows['AP5'], $regularFormatR);
	$worksheet->write($row, 8, $rows['AP6'], $regularFormatR);
	$worksheet->write($row, 9, $rows['AP7'], $regularFormatR);
	$worksheet->write($row, 10, $rows['AP8'], $regularFormatR);
	$worksheet->write($row, 11, $rows['AP10'], $regularFormatR);
	$worksheet->write($row, 12, $rows['AP11'], $regularFormatR);
	$worksheet->write($row, 13, $rows['FS'], $regularFormatR);
	$worksheet->write($row, 14, $rows['QTY_TOTAL'], $regularFormatR);
	$worksheet->write($row, 15, $rows['TOTAL'], $regularFormatR);
	$row++;
}
$worksheet->write($row, 13, "TOTAL", $regularFormatR);
$worksheet->write($row, 15, '=Sum(P8:P'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>