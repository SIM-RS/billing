<?php
include "../sesi.php";
include("../koneksi/konek.php");

$nmBulan=array("Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
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

//laba rugi

$ta_lr=$_REQUEST['ta_lr'];

if ($ta_lr=="") $ta_lr=$th[2];

$bulan_l=$_REQUEST["bulan_lr"];
$bulan_lr=explode("|",$bulan_l);
$bulan_lr=$bulan_lr[0];
$nama_bulan=$bulan_lr[1];
if ($bulan_lr==""){
	$bulan_lr=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
}
$a=$bulan_lr-1;
// end laba rugi

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

//$title4="( 01-$ta_lr s/d ".(($bulan_lr<10)?"0".$bulan_lr:$bulan_lr)."-$ta_lr )";
$title4=strtoupper($nmBulan[$a])." ".$ta_lr;

if($bulan_lr < 3){
	$t1 = " 01-$ta_lr"; 
}else{ 
	$t1 = " 01-$ta_lr s/d ".(($a<10)?"0".$a:$a)."-".$ta_lr;
}

$t2 = (($bulan_lr<10)?"0".$bulan_lr:$bulan_lr)."-".$ta_lr;
$t3 = " 01-$ta_lr s/d ".(($bulan_lr<10)?"0".$bulan_lr:$bulan_lr)."-".$ta_lr;

//Write sheet title in upper left cell
$worksheet->write($row, 1, $pemkabRS, $sheetTitleFormatC);
$worksheet->mergeCells($row,1,$row,4);
$row += 1;
$worksheet->write($row, 1, "RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN", $sheetTitleFormatC);
$worksheet->mergeCells($row,1,$row,4);
$row += 1;
$worksheet->write($row, 1, $jdl_lap, $sheetTitleFormatC);
$worksheet->mergeCells($row,1,$row,4);
$row += 1;
$worksheet->write($row, 1, "$title4", $sheetTitleFormatC);
$worksheet->mergeCells($row,1,$row,4);
$row += 1;
$worksheet->write($row, 1, "(DALAM RUPIAH)", $sheetTitleFormatC);
$worksheet->mergeCells($row,1,$row,4);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+2, "$t1", $columnTitleFormat);
$worksheet->write($row, $column+3, "$t2", $columnTitleFormat);
$worksheet->write($row, $column+4, "$t3", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0; 
$row++;

$worksheet->write($row, 0, "710", $regularFormatC);
$worksheet->write($row, 1, "Pendapatan Pelayanan RSPM", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);
$worksheet->write($row, 3, "", $regularFormatR);
$worksheet->write($row, 4, "", $regularFormatR);

$stotOp=$stotOp2=$stotOp3=0;
$stotBiayaOp=$stotBiayaOp2=$stotBiayaOp3=0;
$stotBiayaOTL=$stotBiayaOTL2=$stotBiayaOTL3=0;
$stotBiayaPO=$stotBiayaPO2=$stotBiayaPO3=0;

$xStart=$row+1;
$xStart2=$row+1;

$i=0;
$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=3 AND MA_KODE LIKE '710%'";
$rs=mysql_query($sql);
while ($rw=mysql_fetch_array($rs)){
	$i++;
	$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					UNION
					SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT - j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rw["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
	//echo $sql."<br>";
	$rs1=mysql_query($sql);
	$rw1=mysql_fetch_array($rs1);
	$stotOp+=$rw1["nilai"];
	$stotOp2+=$rw1["nilai2"];
	
	$row++;
	$worksheet->write($row, 0, $rw["MA_KODE"], $regularFormatC);
	$worksheet->write($row, 1, "   ".$rw["MA_NAMA"], $regularFormat);
	$worksheet->write($row, 2, $rw1["nilai"], $regularFormatR);
	$worksheet->write($row, 3, $rw1["nilai2"], $regularFormatR);
	$worksheet->write($row, 4, ($rw1["nilai"]+$rw1["nilai2"]), $regularFormatR);
}

$stotOp3=$stotOp+$stotOp2;

$row++;
$rowPendOP=$row+1;
$rowPendOP2=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH :", $regularFormat);
$worksheet->write($row, 2, '=Sum(C'.$xStart.':C'.$row.')', $regularFormatR);
$worksheet->write($row, 3, '=Sum(D'.$xStart2.':D'.$row.')', $regularFormatR);
$worksheet->write($row, 4, '=Sum(E'.$xStart.':E'.$row.')', $regularFormatR);
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
$xStart2=$row+1;
while ($rwB=mysql_fetch_array($rsB)){
	$kode_MA_BPO=$rwB["MA_KODE"];
	$kode_MA_BPO_KP=$rwB["MA_KODE_KP"];
	$nama_MA_BPO=$rwB["MA_NAMA"];
	
	$sqlBPOSub="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kode_MA_BPO%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
	
	$rsBPOSub=mysql_query($sqlBPOSub);
	$rwBPOSub=mysql_fetch_array($rsBPOSub);
	
	$biayaBPO=$rwBPOSub["nilai"];
	$biayaBPO2=$rwBPOSub["nilai2"];
	$biayaBPO3=$biayaBPO+$biayaBPO2;

	$stotBiayaOp +=$biayaBPO;
	$stotBiayaOp2 +=$biayaBPO2;
	
	$row++;
	$worksheet->write($row, 0, $kode_MA_BPO, $regularFormatC);
	$worksheet->write($row, 1, "   ".$nama_MA_BPO, $regularFormat);
	$worksheet->write($row, 2, $biayaBPO, $regularFormatR);
	$worksheet->write($row, 3, $biayaBPO2, $regularFormatR);
	$worksheet->write($row, 4, $biayaBPO3, $regularFormatR);
}

$stotBiayaOp3 = $stotBiayaOp+$stotBiayaOp2;

$row++;
$rowTotBOP=$row+1;
$rowTotBOP2=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH :", $regularFormat);
$worksheet->write($row, 2, '=Sum(C'.$xStart.':C'.$row.')', $regularFormatR);
$worksheet->write($row, 3, '=Sum(D'.$xStart2.':D'.$row.')', $regularFormatR);
$worksheet->write($row, 4, '=Sum(E'.$xStart2.':E'.$row.')', $regularFormatR);

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


  $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr UNION SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";


$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaUmum=$rw1["nilai"];
$biayaUmum2=$rw1["nilai2"];
$biayaUmum3=$biayaUmum+$biayaUmum2;

$row++;
$row++;
$xStart=$row+1;
$xStart2=$row+1;
//$sTotOTL='C:'.($row+1);
$worksheet->write($row, 0, $kode_MA_BUmum, $regularFormatC);
$worksheet->write($row, 1, "Biaya OTL", $regularFormat);
$worksheet->write($row, 2, $biayaUmum, $regularFormatR);
$worksheet->write($row, 3, $biayaUmum2, $regularFormatR);
$worksheet->write($row, 4, $biayaUmum3, $regularFormatR);
	
$row++;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Biaya Penunjang Operasi (BPO)", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);
$worksheet->write($row, 3, "", $regularFormatR);
$worksheet->write($row, 4, "", $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKawaka'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BKaWaka=$rwB["MA_KODE_KP"];

 $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOKawaka%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOKaWaka=$rw1["nilai"];
$biayaBPOKaWaka2=$rw1["nilai2"];
$biayaBPOKaWaka3=$biayaBPOKaWaka+$biayaBPOKaWaka2;

$sTotBPO='C:'.($row+1);	
$sTotBPO2='D:'.($row+1);	
$sTotBPO3='E:'.($row+1);	
$row++;
$worksheet->write($row, 0, $kode_MA_BKaWaka, $regularFormatC);
$worksheet->write($row, 1, "Biaya Ka/Waka RSPM", $regularFormat);
$worksheet->write($row, 2, $biayaBPOKaWaka, $regularFormatR);
$worksheet->write($row, 3, $biayaBPOKaWaka2, $regularFormatR);
$worksheet->write($row, 4, $biayaBPOKaWaka3, $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOUmum'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BPOUmum=$rwB["MA_KODE_KP"];

$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOUmum%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOUmum=$rw1["nilai"];
$biayaBPOUmum2=$rw1["nilai2"];
$biayaBPOUmum3=$biayaBPOUmum+$biayaBPOUmum2;

$sTotBPO +='+C:'.($row+1);
$sTotBPO2 +='+D:'.($row+1);
$sTotBPO3 +='+E:'.($row+1);
$row++;
$worksheet->write($row, 0, $kode_MA_BPOUmum, $regularFormatC);
$worksheet->write($row, 1, "Biaya Dinas Umum", $regularFormat);
$worksheet->write($row, 2, $biayaBPOUmum, $regularFormatR);
$worksheet->write($row, 3, $biayaBPOUmum2, $regularFormatR);
$worksheet->write($row, 4, $biayaBPOUmum3, $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOKeu'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BPOKeu=$rwB["MA_KODE_KP"];

 $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOKeu%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOKeu=$rw1["nilai"];
$biayaBPOKeu2=$rw1["nilai2"];
$biayaBPOKeu3=$biayaBPOKeu+$biayaBPOKeu2;

$sTotBPO +='+C:'.($row+1);
$sTotBPO2 +='+D:'.($row+1);
$sTotBPO3 +='+E:'.($row+1);
$row++;
$worksheet->write($row, 0, $kode_MA_BPOKeu, $regularFormatC);
$worksheet->write($row, 1, "Biaya Dinas Keuangan", $regularFormat);
$worksheet->write($row, 2, $biayaBPOKeu, $regularFormatR);
$worksheet->write($row, 3, $biayaBPOKeu2, $regularFormatR);
$worksheet->write($row, 4, $biayaBPOKeu3, $regularFormatR);

$sql="SELECT * FROM ma_sak WHERE MA_KODE = '$kodeMaBPOTeknik'";
//echo $sql."<br>";
$rsB=mysql_query($sql);
$rwB=mysql_fetch_array($rsB);
$kode_MA_BPOTeknik=$rwB["MA_KODE_KP"];

 $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeMaBPOTeknik%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$biayaBPOTeknik=$rw1["nilai"];
$biayaBPOTeknik2=$rw1["nilai2"];
$biayaBPOTeknik3=$biayaBPOTeknik+$biayaBPOTeknik2;

$sTotBPO +='+C:'.($row+1);
$sTotBPO2 +='+D:'.($row+1);
$sTotBPO3 +='+E:'.($row+1);

$row++;
$worksheet->write($row, 0, $kode_MA_BPOTeknik, $regularFormatC);
$worksheet->write($row, 1, "Biaya Dinas Teknik", $regularFormat);
$worksheet->write($row, 2, $biayaBPOTeknik, $regularFormatR);
$worksheet->write($row, 3, $biayaBPOTeknik2, $regularFormatR);
$worksheet->write($row, 4, $biayaBPOTeknik3, $regularFormatR);

$stotBiayaOTL +=$biayaUmum;
$stotBiayaOTL2 +=$biayaUmum2;
$stotBiayaOTL3 = $stotBiayaOTL + $stotBiayaOTL2;

$stotBiayaPO=$biayaBPOKaWaka+$biayaBPOUmum+$biayaBPOKeu+$biayaBPOTeknik;
$stotBiayaPO2=$biayaBPOKaWaka2+$biayaBPOUmum2+$biayaBPOKeu2+$biayaBPOTeknik2;
$stotBiayaPO3=$stotBiayaPO+$stotBiayaPO2;

$stotBOTL_BPO=$stotBiayaOTL+$stotBiayaPO;
$stotBOTL_BPO2=$stotBiayaOT2L+$stotBiayaPO2;
$stotBOTL_BPO3=$stotBOTL_BPO+$stotBOTL_BPO2;

$totalBiayaOp=$stotBiayaOp+$stotBOTL_BPO;
$totalBiayaO2=$stotBiayaOp2+$stotBOTL_BPO2;
$totalBiayaO3=$totalBiayaO+$totalBiayaO2;

$LB_Op=$stotOp-$totalBiayaOp;
$LB_Op2=$stotOp2-$totalBiayaOp2;
$LB_Op3=$LB_Op+$LB_Op2;

$row++;
$rowTotBOTL_BPO=$row+1;
$rowTotBOTL_BPO2=$row+1;

$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH (BOTL + BPO) :", $regularFormat);
$worksheet->write($row, 2, '=Sum(C'.$xStart.':C'.$row.')', $regularFormatR);
$worksheet->write($row, 3, '=Sum(D'.$xStart2.':D'.$row.')', $regularFormatR);
$worksheet->write($row, 4, '=Sum(E'.$xStart.':E'.$row.')', $regularFormatR);

$row++;
$rowTotB=$row+1;
$rowTotB2=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "JUMLAH BIAYA OPERASI :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowTotBOP.'+C'.$rowTotBOTL_BPO, $regularFormatR);
$worksheet->write($row, 3, '=D'.$rowTotBOP.'+D'.$rowTotBOTL_BPO, $regularFormatR);
$worksheet->write($row, 4, '=E'.$rowTotBOP.'+E'.$rowTotBOTL_BPO, $regularFormatR);

$row++;
$rowLR_OP=$row+1;
$rowLR_OP2=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "LABA / RUGI OPERASI :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowPendOP.'-C'.$rowTotB, $regularFormatR);
$worksheet->write($row, 3, '=D'.$rowPendOP.'-D'.$rowTotB, $regularFormatR);
$worksheet->write($row, 4, '=E'.$rowPendOP.'-E'.$rowTotB, $regularFormatR);

$row++;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "PENDAPATAN / BIAYA DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, "", $regularFormatR);
$worksheet->write($row, 3, "", $regularFormatR);

$kodePend_Dluar="791";
$kodeBiaya_Dluar="891";
$kodePos_Dluar="901";

 $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.KREDIT-j.DEBIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodePend_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$Pend_DLuarUsaha=$rw1["nilai"];
$Pend_DLuarUsaha2=$rw1["nilai2"];
$Pend_DLuarUsaha3=$Pend_DLuarUsaha+$Pend_DLuarUsaha2;

$row++;
$rowPend_DLU=$row+1;
$rowPend_DLU2=$row+1;
$worksheet->write($row, 0, $kodePend_Dluar, $regularFormatC);
$worksheet->write($row, 1, "   PENDAPATAN DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, $Pend_DLuarUsaha, $regularFormatR);
$worksheet->write($row, 3, $Pend_DLuarUsaha2, $regularFormatR);
$worksheet->write($row, 4, $Pend_DLuarUsaha3, $regularFormatR);

 $sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodeBiaya_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
				
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$Biaya_DLuarUsaha=$rw1["nilai"];
$Biaya_DLuarUsaha2=$rw1["nilai2"];
$Biaya_DLuarUsaha3=$Biaya_DLuarUsaha+$Biaya_DLuarUsaha2;

$row++;
$rowB_DLU=$row+1;
$rowB_DLU2=$row+1;
$worksheet->write($row, 0, $kodeBiaya_Dluar, $regularFormatC);
$worksheet->write($row, 1, "   BIAYA DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, $Biaya_DLuarUsaha, $regularFormatR);
$worksheet->write($row, 3, $Biaya_DLuarUsaha2, $regularFormatR);
$worksheet->write($row, 4, $Biaya_DLuarUsaha3, $regularFormatR);

$row++;
$row++;
$rowSel_Pend_B_DLU=$row+1;
$rowSel_Pend_B_DLU2=$row+1;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "SELISIH PEND / BIAYA DILUAR USAHA :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowPend_DLU.'-C'.$rowB_DLU, $regularFormatR);
$worksheet->write($row, 3, '=D'.$rowPend_DLU2.'-D'.$rowB_DLU2, $regularFormatR);
$worksheet->write($row, 4, '=E'.$rowPend_DLU.'-E'.$rowB_DLU, $regularFormatR);

$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, IFNULL(SUM(j.DEBIT-j.KREDIT), 0) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '$kodePos_Dluar%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
$rs1=mysql_query($sql);
$rw1=mysql_fetch_array($rs1);
$Pos_DLuarUsaha=$rw1["nilai"];
$Pos_DLuarUsaha2=$rw1["nilai2"];
$Pos_DLuarUsaha3=$Pos_DLuarUsaha+$Pos_DLuarUsaha2;

$row++;
$rowPos_DLU=$row+1;
$rowPos_DLU2=$row+1;
$worksheet->write($row, 0, $kodePos_Dluar, $regularFormatC);
$worksheet->write($row, 1, "POS-POS DILUAR USAHA", $regularFormat);
$worksheet->write($row, 2, $Pos_DLuarUsaha, $regularFormatR);
$worksheet->write($row, 3, $Pos_DLuarUsaha2, $regularFormatR);
$worksheet->write($row, 4, $Pos_DLuarUsaha3, $regularFormatR);

$row++;
$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "LABA / RUGI SEBELUM PAJAK :", $regularFormat);
$worksheet->write($row, 2, '=C'.$rowLR_OP.'+C'.$rowSel_Pend_B_DLU.'-C'.$rowPos_DLU, $regularFormatR);
$worksheet->write($row, 3, '=D'.$rowLR_OP2.'+D'.$rowSel_Pend_B_DLU2.'-D'.$rowPos_DLU2, $regularFormatR);
$worksheet->write($row, 4, '=E'.$rowLR_OP.'+E'.$rowSel_Pend_B_DLU.'-E'.$rowPos_DLU, $regularFormatR);

$workbook->close();
mysql_close($konek);
?>