<?php
include "../sesi.php";
include("../koneksi/konek.php");
//$bln1="3|MARET";
$th=gmdate('d-m-Y',mktime(date('H')+7));
$sak_sap=$_REQUEST["sak_sap"];
if ($sak_sap=="") $sak_sap="1";
if ($sak_sap=="1"){
	$jdl_lap="LAPORAN RUGI LABA";
}else{
	$jdl_lap="LAPORAN RUGI LABA";
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
$workbook->send('Rugi_Laba.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Rugi_Laba');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 8);
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
$worksheet->write($row, 1, "RUMAH SAKIT PELABUHAN MEDAN", $sheetTitleFormatC);
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

$worksheet->write($row, 0, "710", $regularFormatC);
$worksheet->write($row, 1, "Pendapatan Pelayanan RSPM", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=3 AND MA_KODE LIKE '710%'";
$rs=mysql_query($sql);
$i=0;
$stotOp=0;
$stotBiayaOp=0;
$stotBiayaOTL=0;
$stotBiayaPO=0;
$xStart=$row+1;
while ($rw=mysql_fetch_array($rs)){
	$i++;
	$sql="SELECT IFNULL(SUM(j.KREDIT-j.DEBIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
	//echo $sql."<br>";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$stotOp+=$rw1["nilai"];
	
	$row++;
	$worksheet->write($row, 0, $rw["MA_KODE"], $regularFormatC);
	$worksheet->write($row, 1, "   ".$rw["MA_NAMA"], $regularFormat);
	$worksheet->write($row, 2, $rw1["nilai"], $regularFormatR);
}

$row++;
$rowPendOP=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH :", $regularFormat);
$worksheet->write($row, 2, '=Sum(C'.$xStart.':C'.$row.')', $regularFormatR);
//$worksheet->write($row, 2, $stotOp, $regularFormatR);
$row++;
$kodeMaOp="810";
$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$cma_id=$rwB["MA_ID"];
	
$row++;
$worksheet->write($row, 0, $kodeMaOp, $regularFormatC);
$worksheet->write($row, 1, "Biaya Pelayanan RSPM", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);

$kodeMaUmum="826";
$kodeMaBPOKawaka="831";
$kodeMaBPOUmum="832";
$kodeMaBPOKeu="833";
$kodeMaBPOTeknik="834";

$sql="SELECT * FROM ma_sak WHERE MA_PARENT = '$cma_id' ORDER BY MA_KODE";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$xStart=$row+1;
while ($rwB=mysql_fetch_array($rsB)){
	$kode_MA_BPO=$rwB["MA_KODE"];
	$kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
	$nama_MA_BPO=$rwB["MA_NAMA"];
	
	$sqlBPOSub="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
	$rsBPOSub=mysql_query($sqlBPOSub);
	$rwBPOSub=mysql_fetch_array($rsBPOSub);
	$biayaBPO=$rwBPOSub["nilai"];
	$stotBiayaOp +=$biayaBPO;
	
	$row++;
	$worksheet->write($row, 0, $kode_MA_BPO, $regularFormatC);
	$worksheet->write($row, 1, "   ".$nama_MA_BPO, $regularFormat);
	$worksheet->write($row, 2, $biayaBPO, $regularFormatR);
}

$row++;
$rowTotBOP=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH :", $regularFormat);
$worksheet->write($row, 2, '=Sum(C'.$xStart.':C'.$row.')', $regularFormatR);

/*$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaOp'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BOp=$rwB["MA_KODE_KP"];*/

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaUmum'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BUmum=$rwB["MA_KODE_KP"];

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaUmum=$rw1["nilai"];

$row++;
$row++;
$xStart=$row+1;
//$sTotOTL='C:'.($row+1);
$worksheet->write($row, 0, $kode_MA_BUmum, $regularFormatC);
$worksheet->write($row, 1, "Biaya OTL", $regularFormat);
$worksheet->write($row, 2, $biayaUmum, $regularFormatR);
	
$row++;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Biaya Penunjang Operasi (BPO)", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKawaka'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BKaWaka=$rwB["MA_KODE_KP"];

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOKaWaka=$rw1["nilai"];

$sTotBPO='C:'.($row+1);	
$row++;
$worksheet->write($row, 0, $kode_MA_BKaWaka, $regularFormatC);
$worksheet->write($row, 1, "Biaya Ka/Waka RSPM", $regularFormat);
$worksheet->write($row, 2, $biayaBPOKaWaka, $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOUmum'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BPOUmum=$rwB["MA_KODE_KP"];

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOUmum=$rw1["nilai"];

$sTotBPO +='+C:'.($row+1);
$row++;
$worksheet->write($row, 0, $kode_MA_BPOUmum, $regularFormatC);
$worksheet->write($row, 1, "Biaya Dinas Umum", $regularFormat);
$worksheet->write($row, 2, $biayaBPOUmum, $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKeu'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BPOKeu=$rwB["MA_KODE_KP"];

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOKeu=$rw1["nilai"];

$sTotBPO +='+C:'.($row+1);
$row++;
$worksheet->write($row, 0, $kode_MA_BPOKeu, $regularFormatC);
$worksheet->write($row, 1, "Biaya Dinas Keuangan", $regularFormat);
$worksheet->write($row, 2, $biayaBPOKeu, $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOTeknik'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BPOTeknik=$rwB["MA_KODE_KP"];

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOTeknik=$rw1["nilai"];

$sTotBPO +='+C:'.($row+1);
$row++;
$worksheet->write($row, 0, $kode_MA_BPOTeknik, $regularFormatC);
$worksheet->write($row, 1, "Biaya Dinas Teknik", $regularFormat);
$worksheet->write($row, 2, $biayaBPOTeknik, $regularFormatR);

$stotBiayaOTL +=$biayaUmum;
$stotBiayaPO=$biayaBPOKaWaka+$biayaBPOUmum+$biayaBPOKeu+$biayaBPOTeknik;
$stotBOTL_BPO=$stotBiayaOTL+$stotBiayaPO;
$totalBiayaOp=$stotBiayaOp+$stotBOTL_BPO;
$LB_Op=$stotOp-$totalBiayaOp;

$row++;
$rowTotBOTL_BPO=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH (BOTL + BPO) :", $regularFormat);
$worksheet->write($row, 2, '=Sum(C'.$xStart.':C'.$row.')', $regularFormatR);

$row++;
$rowTotB=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH BIAYA OPERASI :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowTotBOP.'+C'.$rowTotBOTL_BPO, $regularFormatR);

$row++;
$rowLR_OP=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "LABA / RUGI OPERASI :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowPendOP.'-C'.$rowTotB, $regularFormatR);

$row++;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "PENDAPATAN / BIAYA DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);

$kodePend_Dluar="791";
$kodeBiaya_Dluar="891";
$kodePos_Dluar="901";

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$Pend_DLuarUsaha=$rw1["nilai"];

$row++;
$rowPend_DLU=$row+1;
$worksheet->write($row, 0, $kodePend_Dluar, $regularFormatC);
$worksheet->write($row, 1, "   PENDAPATAN DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, $Pend_DLuarUsaha, $regularFormatR);

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$Biaya_DLuarUsaha=$rw1["nilai"];

$row++;
$rowB_DLU=$row+1;
$worksheet->write($row, 0, $kodeBiaya_Dluar, $regularFormatC);
$worksheet->write($row, 1, "   BIAYA DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, $Biaya_DLuarUsaha, $regularFormatR);

$row++;
$row++;
$rowSel_Pend_B_DLU=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "SELISIH PEND / BIAYA DILUAR USAHA :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowPend_DLU.'-C'.$rowB_DLU, $regularFormatR);

$sql="SELECT IFNULL(SUM(j.DEBIT-j.KREDIT),0) AS nilai FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK=ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND j.TGL BETWEEN '$tgl_s1' AND '$tgl_d1'";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$Pos_DLuarUsaha=$rw1["nilai"];

$row++;
$rowPos_DLU=$row+1;
$worksheet->write($row, 0, $kodePos_Dluar, $regularFormatC);
$worksheet->write($row, 1, "POS-POS DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, $Pos_DLuarUsaha, $regularFormatR);

$row++;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "LABA / RUGI SEBELUM PAJAK :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowLR_OP.'+C'.$rowSel_Pend_B_DLU.'-C'.$rowPos_DLU, $regularFormatR);

$workbook->close();
mysql_close($konek);
?>