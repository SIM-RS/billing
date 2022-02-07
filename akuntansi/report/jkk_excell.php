<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
$th=gmdate('d-m-Y',mktime(date('H')+7));


$jdl_lap="LAP JKK";


$tgl_s=$_REQUEST["tgl_s"];
if ($tgl_s=="") $tgl_s="01".substr($th,2,8);
$cbln=(substr($tgl_s,3,1)=="0")?substr($tgl_s,4,1):substr($tgl_s,3,2);
$cthn=substr($tgl_s,6,4);
$tgl_d=$_REQUEST["tgl_d"];
if ($tgl_d=="") $tgl_d=$th;
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('JKK_EXCEL.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('JKK_EXCEL');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);
$worksheet->setColumn (1, 1, 20);
$worksheet->setColumn (2, 2, 20);
$worksheet->setColumn (3, 3, 50);
$worksheet->setColumn (4, 4, 20);
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0.00'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0.00'));
$regularFormatI =& $workbook->addFormat(array('italic'=>1,'size'=>9,'align'=>'left','textWrap'=>1));
$sTotTitleL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left'));
$sTotTitleC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center'));
$sTotTitleR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','numFormat'=>'#,##0.00'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

$title4="( $tgl_s  s/d  $tgl_d )";
//Write sheet title in upper left cell

$worksheet->write($row, 3, $namaRS, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 3, $jdl_lap, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 3, "$title4", $sheetTitleFormatC);

//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tanggal", $columnTitleFormat);
$worksheet->write($row, $column+2, "No Bukti", $columnTitleFormat);
$worksheet->write($row, $column+3, "Uraian", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
$tot5=0;

$row += 1;
$rowStart=$row;

$sql="SELECT a.no_kw, a.uraian,DATE_FORMAT(a.tgl,'%d-%m-%Y') tanggal,a.kredit FROM jurnal a 
 INNER JOIN `ma_sak` b ON a.`FK_SAK`=b.`MA_ID`
 WHERE a.`TGL` BETWEEN '$tgl_s1' AND '$tgl_d1' AND a.`D_K`='K' AND a.flag = '$flag' AND b.`MA_KODE` LIKE '1.1.01%'"; //decyber_jkk
$rs=mysql_query($sql);
$i=0;
while ($rows=mysql_fetch_array($rs)){
	$i++;
	$worksheet->write($row, 0, $i, $regularFormat);
	$worksheet->write($row, 1, $rows['tanggal'], $regularFormat);
	$worksheet->write($row, 2, $rows['no_kw'], $regularFormatC);
	$worksheet->write($row, 3, $rows['uraian'], $regularFormat);
	$worksheet->write($row, 4, $rows['kredit'], $regularFormatR);
	$row++;
	$i++;
}

$worksheet->write($row, 3, "Total", $regularFormat);
$worksheet->write($row, 4, '=Sum(E'.$rowStart.':E'.$row.')', $regularFormatR);

$workbook->close();
mysql_close($konek);
?>