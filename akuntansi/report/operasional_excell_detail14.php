<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
$th=gmdate('d-m-Y',mktime(date('H')+7));
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

$ma_kode=$_REQUEST["ma_kode"];
$sql="SELECT * FROM ma_sak WHERE MA_KODE='$ma_kode'";
$rsMa=mysql_query($sql);
$rwMa=mysql_fetch_array($rsMa);
$clvl=$rwMa["MA_LEVEL"]+1;

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Operasional.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Operasional');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);
$worksheet->setColumn (1, 1, 65);
$worksheet->setColumn (2, 4, 20);
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
$worksheet->write($row, 1, $pemkabRS, $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "RUMAH SAKIT UMUM DAERAH", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "LAPORAN OPERASIONAL : ".$rwMa["MA_NAMA"], $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "$title4", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "(DALAM RUPIAH)", $sheetTitleFormatC);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+2, "NILAI", $columnTitleFormat);

$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=$clvl AND MA_KODE like '$ma_kode%'";
$rsMa=mysql_query($sql);
$j=0;
$stot=0;
while ($rwMa=mysql_fetch_array($rsMa))
{
	$sql="SELECT ABS(IFNULL(SUM(j.KREDIT-j.DEBIT),0)) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
	$rsNilai=mysql_query($sql);
	$rwNilai=mysql_fetch_array($rsNilai);
	$stot+=$rwNilai["nilai"];
	$j++;	
	$row++;
	$worksheet->write($row, 0, $j, $regularFormatC);
	$worksheet->write($row, 1, $rwMa["MA_NAMA"], $regularFormat);
	$worksheet->write($row, 2, $rwNilai["nilai"], $regularFormatR);
}
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Sub Total :", $regularFormat);
$worksheet->write($row, 2, $stot, $regularFormatR);
$row++;


$workbook->close();
mysql_close($konek);
?>