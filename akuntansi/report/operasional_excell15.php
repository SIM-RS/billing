<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
$th=gmdate('d-m-Y',mktime(date('H')+7));
$sak_sap=$_REQUEST["sak_sap"];
if ($sak_sap=="") $sak_sap="1";
if ($sak_sap=="1"){
	$jdl_lap="LAPORAN OPERASIONAL SAK";
}else{
	$jdl_lap="LAPORAN OPERASIONAL SAP";
}

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
$worksheet->write($row, 1, $jdl_lap, $sheetTitleFormatC);
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
$row++;

$worksheet->write($row, 0, "A", $regularFormatC);
$worksheet->write($row, 1, "Pendapatan", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=3 AND MA_KODE LIKE '4%'";
$rs=mysql_query($sql);
$i=0;
$stotOp=0;
$stotBiayaOp=0;
while ($rw=mysql_fetch_array($rs)){
	$i++;
	$sql="SELECT IFNULL(SUM(j.KREDIT-j.DEBIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
	//echo $sql."<br>";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$stotOp+=$rw1["nilai"];
	
	$row++;
	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, "   ".$rw["MA_NAMA"], $regularFormat);
	$worksheet->write($row, 2, $rw1["nilai"], $regularFormatR);
}
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Sub Total :", $regularFormat);
$worksheet->write($row, 2, $stotOp, $regularFormatR);
$row++;
$worksheet->write($row, 0, "B", $regularFormatC);
$worksheet->write($row, 1, "Biaya Operasional", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '51%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaOp=$rw1["nilai"];

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '52%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaUmum=$rw1["nilai"];

$row++;
$worksheet->write($row, 0, "1", $regularFormatC);
$worksheet->write($row, 1, "   Biaya Pelayanan", $regularFormat);
$worksheet->write($row, 2, $biayaOp, $regularFormatR);
$row++;
$worksheet->write($row, 0, "2", $regularFormatC);
$worksheet->write($row, 1, "   Biaya Umum & Administrasi", $regularFormat);
$worksheet->write($row, 2, $biayaUmum, $regularFormatR);

$stotBiayaOp=$biayaOp+$biayaUmum;
$a_b=$stotOp-$stotBiayaOp;
$pendNonOp=0;
$biayaNonOp=0;

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '53%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaNonOp=$rw1["nilai"];
$sd_sblm_pos2lb=$a_b+$pendNonOp-$biayaNonOp;

$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Sub Total : ", $regularFormat);
$worksheet->write($row, 2, $stotBiayaOp, $regularFormatR);
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Surplus (Defisit) Setelah Biaya Operasional (A-B)", $regularFormat);
$worksheet->write($row, 2, $a_b, $regularFormatR);
$row++;
$worksheet->write($row, 0, "C", $regularFormatC);
$worksheet->write($row, 1, "Pendapatan Non Operasional", $regularFormat);
$worksheet->write($row, 2, $pendNonOp, $regularFormatR);
$row++;
$worksheet->write($row, 0, "D", $regularFormatC);
$worksheet->write($row, 1, "Biaya Non Operasional", $regularFormat);
$worksheet->write($row, 2, $biayaNonOp, $regularFormatR);
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Surplus (Defisit) sebelum pos keuntungan/kerugian", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Surplus (Defisit) sebelum pos-pos luar biasa", $regularFormat);
$worksheet->write($row, 2, $sd_sblm_pos2lb, $regularFormatR);

$pendKLB=0;
$biayaKLB=0;
$row++;
$worksheet->write($row, 0, "1", $regularFormatC);
$worksheet->write($row, 1, "Pendapatan dari Kejadian Luar Biasa", $regularFormat);
$worksheet->write($row, 2, $pendKLB, $regularFormatR);
$row++;
$worksheet->write($row, 0, "2", $regularFormatC);
$worksheet->write($row, 1, "Biaya dari Kejadian Luar Biasa", $regularFormat);
$worksheet->write($row, 2, $biayaKLB, $regularFormatR);

$sdBersih=$sd_sblm_pos2lb+$pendKLB-$biayaKLB;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Surplus (Defisit) tahun berjalan bersih", $regularFormat);
$worksheet->write($row, 2, $sdBersih, $regularFormatR);

$workbook->close();
mysql_close($konek);
?>