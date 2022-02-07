<?php 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//===============================
$wksheet="Master_Jurnal";
$headerrpt="MASTER JURNAL TRANSAKSI";
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
//Sending HTTP headers
$workbook->send($wksheet.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet($wksheet);
//Set a paper
$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.25);
$worksheet->setMargins_TB(0.25);
//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 14);
$worksheet->setColumn (1, 1, 90);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>11,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>9,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1,'vAlign'=>'vcenter'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#0,##0'));
$regularFormatF =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1,'numFormat'=>'#0'));

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 1, $headerrpt, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, $column, "Kode", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Transaksi", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
$strSQL="SELECT * from jenis_transaksi where JTRANS_aktif=1 ORDER BY JTRANS_KODE";
$rs = mysql_query($strSQL);
//echo $strSQL."<br>";
while ($rows=mysql_fetch_array($rs)){
	$mkode=$rows["JTRANS_KODE"];
	$worksheet->write($row, 0, $mkode, $regularFormatF);
	$worksheet->write($row, 1, $rows['JTRANS_NAMA'], $regularFormat);
	$row++;
}

$workbook->close();
mysql_free_result($rs);
mysql_close($konek);
?>