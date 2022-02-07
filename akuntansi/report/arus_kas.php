<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
$tgl_s=$_REQUEST["tgl_s"];
$tgl_se=explode("-",$tgl_s);
$bln=$tgl_se[1];
$thn=$tgl_se[2];
$tgl_se=$tgl_se[2]."-".$tgl_se[1]."-".$tgl_se[0];
$tgl_d=$_REQUEST["tgl_d"];
$tgl_de=explode("-",$tgl_d);
$tgl_de=$tgl_de[2]."-".$tgl_de[1]."-".$tgl_de[0];

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Arus_Kas.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Arus_Kas');
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
$worksheet->write($row, 1, "ARUS KAS", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "$title4", $sheetTitleFormatC);
$row += 1;
$worksheet->write($row, 1, "(DALAM RUPIAH)", $sheetTitleFormatC);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+2, "NILAI", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$tot1=0;
$tot2=0;
$tot3=0;
$tot4=0;
$tot5=0;
$row += 1;

$worksheet->write($row, $column, "1", $sTotTitleC);
$worksheet->write($row, $column+1, "ARUS KAS DARI AKTIVITAS OPERASIONAL", $sTotTitleL);
$row += 1;
$worksheet->write($row, $column+1, "Kas diterima dari :", $regularFormatI);
$row++;

$sql="SELECT t3.MA_NAMA,SUM(t3.KREDIT) AS NILAI FROM (SELECT c.MA_KODE,c.MA_NAMA,t2.* FROM (SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID WHERE b.MA_KODE LIKE '111%' AND a.D_K='D' AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de') AS t1,jurnal j WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 WHERE LEFT(t3.MA_KODE,3)<>'111' AND LEFT(t3.MA_KODE,2)<>'42' AND LEFT(t3.MA_KODE,2)<>'12' GROUP BY t3.MA_NAMA";
//echo $sql."<br>";
$rs=mysql_query($sql);
while ($rows=mysql_fetch_array($rs)){
	$worksheet->write($row, 1, $rows['MA_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NILAI'], $regularFormatR);
	$tot1 +=$rows['NILAI'];
	//echo $rows['MA_NAMA']." ".$rows['NILAI']."<br>";
	$row++;
}
$worksheet->write($row, 1, "Sub Jumlah", $sTotTitleL);
$worksheet->write($row, 2, $tot1, $sTotTitleR);

$row += 2;
$worksheet->write($row, 1, "Kas dibayarkan untuk :", $regularFormatI);
$row++;
$sql="SELECT t3.MA_NAMA,SUM(t3.DEBIT) AS NILAI FROM (SELECT DISTINCT c.MA_KODE,c.MA_NAMA,t2.* FROM (SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID WHERE b.MA_KODE LIKE '111%' AND a.D_K='K' AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de') AS t1,jurnal j WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_IDUSER=j.FK_IDUSER AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 WHERE LEFT(t3.MA_KODE,3)<>'111' AND LEFT(t3.MA_KODE,2)<>'42' AND LEFT(t3.MA_KODE,2)<>'12' GROUP BY t3.MA_NAMA";
//echo $sql."<br>";
$rs=mysql_query($sql);
while ($rows=mysql_fetch_array($rs)){
	$worksheet->write($row, 1, $rows['MA_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NILAI'], $regularFormatR);
	$tot2 +=$rows['NILAI'];
	//echo $rows['MA_NAMA']." ".$rows['NILAI']."<br>";
	$row++;
}
$worksheet->write($row, 1, "Sub Jumlah", $sTotTitleL);
$worksheet->write($row, 2, $tot2, $sTotTitleR);

$row += 2;
$worksheet->write($row, 1, "Arus kas bersih dari aktivitas operasional", $sTotTitleL);
$worksheet->write($row, 2, $tot1-$tot2, $sTotTitleR);

$row += 2;
$worksheet->write($row, $column, "2", $sTotTitleC);
$worksheet->write($row, $column+1, "ARUS KAS UNTUK AKTIVITAS INVESTASI", $sTotTitleL);
$row++;
$sql="SELECT t3.MA_NAMA,SUM(t3.DEBIT) AS NILAI FROM (SELECT c.MA_KODE,c.MA_NAMA,t2.* FROM (SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID WHERE b.MA_KODE LIKE '111%' AND a.D_K='K' AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de') AS t1,jurnal j WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 WHERE LEFT(t3.MA_KODE,2)='12' GROUP BY t3.MA_NAMA";
//echo $sql."<br>";
$rs=mysql_query($sql);
while ($rows=mysql_fetch_array($rs)){
	$worksheet->write($row, 1, $rows['MA_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NILAI'], $regularFormatR);
	$tot3 +=$rows['NILAI'];
	//echo $rows['MA_NAMA']."<br>";
	$row++;
}
$worksheet->write($row, 1, "Sub Jumlah", $sTotTitleL);
$worksheet->write($row, 2, $tot3, $sTotTitleR);

$row += 2;
$worksheet->write($row, $column, "3", $sTotTitleC);
$worksheet->write($row, $column+1, "ARUS KAS DARI AKTIVITAS PENDANAAN", $sTotTitleL);
$row++;
$sql="SELECT t3.MA_NAMA,SUM(t3.DEBIT) AS NILAI FROM (SELECT c.MA_KODE,c.MA_NAMA,t2.* FROM (SELECT j.* FROM (SELECT b.MA_KODE,b.MA_NAMA,a.* FROM jurnal a INNER JOIN ma_sak b ON a.FK_SAK=b.MA_ID WHERE b.MA_KODE LIKE '111%' AND a.D_K='K' AND a.TGL BETWEEN '$tgl_se' AND '$tgl_de') AS t1,jurnal j WHERE t1.NO_TRANS=j.NO_TRANS AND t1.TGL=j.TGL AND t1.FK_LAST_TRANS=j.FK_LAST_TRANS) AS t2 INNER JOIN ma_sak c ON t2.FK_SAK=c.MA_ID) AS t3 WHERE LEFT(t3.MA_KODE,2)='42' GROUP BY t3.MA_NAMA";
//echo $sql."<br>";
$rs=mysql_query($sql);
while ($rows=mysql_fetch_array($rs)){
	$worksheet->write($row, 1, $rows['MA_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NILAI'], $regularFormatR);
	$tot4 +=$rows['NILAI'];
	//echo $rows['MA_NAMA']."<br>";
	$row++;
}
$worksheet->write($row, 1, "Sub Jumlah", $sTotTitleL);
$worksheet->write($row, 2, $tot4, $sTotTitleR);

$row += 2;
$worksheet->write($row, $column+1, "Jumlah Arus Kas Bersih", $sTotTitleL);
$worksheet->write($row, 2, $tot1-$tot2-$tot3+$tot4, $sTotTitleR);

$row +=2;
$worksheet->write($row, $column, "4", $sTotTitleC);
$worksheet->write($row, $column+1, "Saldo awal kas dan setara kas", $sTotTitleL);
$sql="SELECT SUM(a.SALDO_AWAL) AS SALDO_AWAL FROM saldo a INNER JOIN ma_sak b ON a.FK_MAID=b.MA_ID WHERE a.BULAN=$bln AND a.TAHUN=$thn AND LEFT(b.MA_KODE,3)='111'";
//echo $sql."<br>";
$rs=mysql_query($sql);
if ($rows=mysql_fetch_array($rs)){
	$tot5=$rows['SALDO_AWAL'];
}
$worksheet->write($row, 2, $tot5, $sTotTitleR);

$row +=2;
$worksheet->write($row, $column, "5", $sTotTitleC);
$worksheet->write($row, $column+1, "Saldo akhir kas dan setara kas", $sTotTitleL);
$worksheet->write($row, 2, $tot1-$tot2-$tot3+$tot4+$tot5, $sTotTitleR);

$workbook->close();
mysql_close($konek);
?>