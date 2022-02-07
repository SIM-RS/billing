<?php
include "../sesi.php";
include("../koneksi/konek.php");
$bln1="3|MARET";
$bln1=explode("|",$bln1);
$ta1="2009";
$day1 = cal_days_in_month(CAL_GREGORIAN, $bln1[0], $ta1);
$tgl2="1";
if ($tgl2=="1"){
	$bln2="12|DESEMBER";
	$bln2=explode("|",$bln2);
	$ta2="2008";
	$day2 = cal_days_in_month(CAL_GREGORIAN, $bln2[0], $ta2);
}

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Neraca.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Neraca');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 4);
$worksheet->setColumn (1, 1, 65);
$worksheet->setColumn (2, 4, 20);
//$worksheet->setColumn (0, $numColumns, $columnWidth);
 
//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14));
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

if ($tgl2=="1") $title4="PER $day1 $bln1[1] $ta1 DAN PER $day2 $bln2[1] $ta2"; else $title4="PER $day1 $bln1[1] $ta1";
//Write sheet title in upper left cell
$worksheet->write($row, $column, $pemkabRS, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, $column, "RUMAH SAKIT UMUM DAERAH", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, $column, "NERACA", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, $column, "$title4", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, $column, "(DALAM RUPIAH)", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "NO", $columnTitleFormat);
$worksheet->write($row, $column+1, "URAIAN", $columnTitleFormat);
$worksheet->write($row, $column+2, "CATATAN", $columnTitleFormat);
if ($tgl2=="1"){
	$worksheet->write($row, $column+3, "$bln1[1] $ta1", $columnTitleFormat);
	$worksheet->write($row, $column+4, "$bln2[1] $ta2", $columnTitleFormat);
}else{
	$worksheet->write($row, $column+3, "NILAI", $columnTitleFormat);
}

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$tmpCOA="";
$tmpTotCOA="";
$stot1=0;
$stot2=0;
$tot1=0;
$tot2=0;
$stot1tmp=0;
$stot2tmp=0;
$numL=64;
$row++;
$sql="select * from ma_sak where MA_LEVEL<=3 and MA_AKTIF=1 and left(MA_KODE,1)<4 order by MA_KODE";
$rs=mysql_query($sql);
while ($rows=mysql_fetch_array($rs)){
	if ($rows['MA_LEVEL']==1){
		if ($num>0){
			$worksheet->write($row, 1, "Jumlah $tmpCOA", $sTotFormatC);
			$worksheet->write($row, 2, "", $sTotFormatL);
			$worksheet->write($row, 3, $stot1tmp, $sTotFormatR);			
			$worksheet->write($row+2, 1, "TOTAL $tmpTotCOA", $sTotFormatC);
			$worksheet->write($row+2, 2, "", $sTotFormatR);
			$worksheet->write($row+2, 3, $stot1, $sTotFormatR);
			if ($tgl2=="1"){
				$worksheet->write($row, 4, $stot2tmp, $sTotFormatR);
				$worksheet->write($row+2, 4, $stot2, $sTotFormatR);
			}
			$row +=4;
		}
		$num=0;
		if ($numL>65){
			$tot1 +=$stot1;
			$tot2 +=$stot2;
		}
		$stot1=0;
		$stot2=0;
		$numL++;
		if ($numL==67){
			$tmpTotCOA1 = $tmpTotCOA." & ".$rows['MA_NAMA'];
		}
		$tmpTotCOA=$rows['MA_NAMA'];
		$worksheet->write($row, 0, chr($numL), $regularFormat);
	}elseif($rows['MA_LEVEL']==2){
		if ($num>0){
			$worksheet->write($row, 1, "Jumlah $tmpCOA", $sTotFormatC);
			$worksheet->write($row, 2, "", $sTotFormatL);
			$worksheet->write($row, 3, $stot1tmp, $sTotFormatR);
			if ($tgl2=="1"){
				$worksheet->write($row, 4, $stot2tmp, $sTotFormatR);
			}
			$row +=2;
		}
		$stot1tmp=0;
		$stot2tmp=0;
		$num++;
		$tmpCOA=$rows['MA_NAMA'];
		$worksheet->write($row, 0, $num, $regularFormatR);
	}elseif($rows['MA_LEVEL']==3){
		if ($tgl2=="1"){
			$mkode=$rows['MA_KODE'];
			$sql="select sum(SALDO_AWAL) as saldo from saldo s inner join ma_sak m on s.FK_MAID=m.MA_ID where s.BULAN=$bln1[0] and s.TAHUN=$ta1 and m.MA_KODE like '$mkode%' group by s.FK_MAID";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)) $s1=$rows1['saldo']; else $s1=0;
			$sql="select sum(SALDO_AWAL) as saldo from saldo s inner join ma_sak m on s.FK_MAID=m.MA_ID where s.BULAN=$bln2[0] and s.TAHUN=$ta2 and m.MA_KODE like '$mkode%' group by s.FK_MAID";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)) $s2=$rows1['saldo']; else $s2=0;
			$sql="select sum(DEBIT)-sum(KREDIT) as nilai from jurnal j inner join ma_sak m on j.FK_SAK=m.MA_ID where month(TGL)=$bln1[0] and year(TGL)=$ta1 and m.MA_KODE like '$mkode%' group by FK_SAK";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)) $nilai1=$rows1['nilai']+$s1; else $nilai1=$s1;
			$stot1 +=$nilai1;
			$stot1tmp +=$nilai1;
			$sql="select sum(DEBIT)-sum(KREDIT) as nilai from jurnal j inner join ma_sak m on j.FK_SAK=m.MA_ID where month(TGL)=$bln2[0] and year(TGL)=$ta2 and m.MA_KODE like '$mkode%' group by FK_SAK";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)) $nilai2=$rows1['nilai']+$s2; else $nilai2=$s2;
			$stot2 +=$nilai2;
			$stot2tmp +=$nilai2;
			$worksheet->write($row, 3, $nilai1, $regularFormatR);
			$worksheet->write($row, 4, $nilai2, $regularFormatR);
		}else{
			$mkode=$rows['MA_KODE'];
			$sql="select sum(SALDO_AWAL) as saldo from saldo s inner join ma_sak m on s.FK_MAID=m.MA_ID where s.BULAN=$bln1[0] and s.TAHUN=$ta1 and m.MA_KODE like '$mkode%' group by s.FK_MAID";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)) $s1=$rows1['saldo']; else $s1=0;
			$sql="select sum(DEBIT)-sum(KREDIT) as nilai from jurnal j inner join ma_sak m on j.FK_SAK=m.MA_ID where month(TGL)=$bln1[0] and year(TGL)=$ta1 and m.MA_KODE like '$mkode%' group by FK_SAK";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)) $nilai1=$rows1['nilai']+$s1; else $nilai1=$s1;
			$stot1 +=$nilai1;
			$stot1tmp +=$nilai1;
			$worksheet->write($row, 3, $nilai1, $regularFormatR);
		}
	}
	$worksheet->write($row, 1, $rows['MA_NAMA'], $regularFormat);
	//echo $rows['MA_NAMA']."<br>";
	$row++;
}

$worksheet->write($row, 1, "Jumlah $tmpCOA", $sTotFormatC);
$worksheet->write($row, 2, "", $sTotFormatL);
$worksheet->write($row, 3, $stot1tmp, $sTotFormatR);
$worksheet->write($row+2, 1, "TOTAL $tmpTotCOA", $sTotFormatC);
$worksheet->write($row+2, 2, "", $sTotFormatR);
$worksheet->write($row+2, 3, $stot1, $sTotFormatR);
$worksheet->write($row+4, 1, "TOTAL $tmpTotCOA1", $sTotFormatC);
$worksheet->write($row+4, 2, "", $sTotFormatR);
$worksheet->write($row+4, 3, $tot1, $sTotFormatR);
if ($tgl2=="1"){
	$worksheet->write($row, 4, $stot2tmp, $sTotFormatR);
	$worksheet->write($row+2, 4, $stot2, $sTotFormatR);
	$worksheet->write($row+4, 4, $tot2, $sTotFormatR);
}
$worksheet->write($row+6, 0, "", $regularFormatR);
$workbook->close();
mysql_close($konek);
?>