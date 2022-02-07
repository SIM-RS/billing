<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$obatid=$_REQUEST['obatid'];
$kpid=$_REQUEST['kpid'];
$unitid=$_REQUEST['unitid'];
$tgl_d1=$_REQUEST['tgl_d'];
$tgl_s1=$_REQUEST['tgl_s'];
$tgl_d=explode("-",$tgl_d1);
$tgl_d1=$tgl_d[2]."-".$tgl_d[1]."-".$tgl_d[0];
$tgl_d=$tgl_d[0]."/".$tgl_d[1]."/".$tgl_d[2];
$tgl_s=explode("-",$tgl_s1);
$tgl_s1=$tgl_s[2]."-".$tgl_s[1]."-".$tgl_s[0];
$tgl_s=$tgl_s[0]."/".$tgl_s[1]."/".$tgl_s[2];
//Paging,Sorting dan Filter======
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Kartu_Barang.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Kartu Barang');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 6);
$worksheet->setColumn (1, 5, 10);
$worksheet->setColumn (6, 6, 35);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>9,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 0, "SKPD", $UnitTitleFormat);
$worksheet->write($row, 2, ": ", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, "UNIT KERJA", $UnitTitleFormat);
$worksheet->write($row, 2, ": ", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, "SUB UNIT KERJA", $UnitTitleFormat);
$worksheet->write($row, 2, ": ", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, $tipe_kotaRS, $UnitTitleFormat);
$worksheet->write($row, 2, ": ".$kotaRS, $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, "PROPINSI", $UnitTitleFormat);
$worksheet->write($row, 2, ": ".$propinsiRS, $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, "PERIODE", $UnitTitleFormat);
$worksheet->write($row, 2, ": ".$tgl_d." - ".$tgl_s, $UnitTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 2;
$worksheet->write($row, 0, "KARTU BARANG", $UnitTitleFormatCB);
$worksheet->mergeCells($row,$column,$row,$column+6); 
$row += 1;
$worksheet->write($row, 0, "NOMOR :", $UnitTitleFormatCB);
$worksheet->mergeCells($row,$column,$row,$column+6); 
$row += 2;
$worksheet->write($row, $column, "No", $UnitTitleFormatC_TLBR);
$worksheet->writeBlank($row+1, $column, $UnitTitleFormatC_TLBR);
$worksheet->mergeCells($row,$column,$row+1,$column); 
$worksheet->write($row, $column+1, "PENERIMAAN", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row, $column+2, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+1,$row,$column+2); 
$worksheet->write($row, $column+3, "PENGELUARAN", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row, $column+4, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+3,$row,$column+4); 
$worksheet->write($row, $column+5, "SISA", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row+1, $column+5, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+5,$row+1,$column+5); 
$worksheet->write($row, $column+6, "KETERANGAN", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row+1, $column+6, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+6,$row+1,$column+6);
$row += 1;
$worksheet->write($row, $column+1, "Tanggal", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+2, "Jumlah", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+3, "Tanggal", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+4, "Jumlah", $UnitTitleFormatC_BR);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
/*  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }
*/  
  $sql="SELECT *,date_format(TGL_ACT,'%d-%m-%Y') as tgl1 FROM a_kartustok WHERE OBAT_ID=$obatid AND KEPEMILIKAN_ID=$kpid AND UNIT_ID=$unitid AND 
  		TGL_TRANS BETWEEN '$tgl_d1' AND '$tgl_s1' ORDER BY TGL_ACT,ID";

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$i=0;
while ($rows=mysqli_fetch_array($rs)){
	$i++;
	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rows['tgl1'], $regularFormatC);
	$worksheet->write($row, 2, $rows['DEBET'], $regularFormatR);
	$worksheet->write($row, 3, $rows['tgl1'], $regularFormatC);
	$worksheet->write($row, 4, $rows['KREDIT'], $regularFormatR);
	$worksheet->write($row, 5, $rows['STOK_AFTER'], $regularFormatR);
	$worksheet->write($row, 6, $rows['KET'], $regularFormat);
	$row++;
}

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>