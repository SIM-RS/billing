<?php
include "../sesi.php";
include("../koneksi/konek.php");

$nmBulan=array("Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
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
$workbook->send('RugiLaba_Detail.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('RugiLaba');
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

//$title4="( 1 - $ta_lr  s/d  $bulan_lr - $ta_lr )";
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
$worksheet->write($row, 1, "LAPORAN RUGI LABA : ".$rwMa["MA_NAMA"], $sheetTitleFormatC);
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

$sql="SELECT * FROM ma_sak WHERE MA_LEVEL=$clvl AND MA_KODE like '$ma_kode%'";
$rsMa=mysql_query($sql);
$j=0;
$stot=0;
$stot2=0;
$stot3=0;
while ($rwMa=mysql_fetch_array($rsMa))
{
	
	
		$sql="SELECT SUM(t.nilai) AS nilai, SUM(t.nilai2) AS nilai2 FROM(SELECT ABS(IFNULL(SUM(j.KREDIT-j.DEBIT), 0)) AS nilai ,'0' AS nilai2
					  FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND MONTH(j.TGL) < $bulan_lr AND YEAR(j.TGL) = $ta_lr
					  UNION
					  SELECT '0' AS nilai, ABS(IFNULL(SUM(j.KREDIT-j.DEBIT), 0)) AS nilai2 FROM jurnal j INNER JOIN ma_sak ma ON j.FK_SAK = ma.MA_ID
					  WHERE ma.MA_KODE LIKE '".$rwMa["MA_KODE"]."%' AND MONTH(j.TGL) = $bulan_lr AND YEAR(j.TGL) = $ta_lr) t ";
	
	
	$rsNilai=mysql_query($sql);
	$rwNilai=mysql_fetch_array($rsNilai);
	$stot+=$rwNilai["nilai"];
	$stot2+=$rwNilai["nilai2"];
	$j++;	
	$row++;
	$worksheet->write($row, 0, $j, $regularFormatC);
	$worksheet->write($row, 1, $rwMa["MA_NAMA"], $regularFormat);
	$worksheet->write($row, 2, $rwNilai["nilai"], $regularFormatR);
	$worksheet->write($row, 3, $rwNilai["nilai2"], $regularFormatR);
	$worksheet->write($row, 4, $rwNilai["nilai"]+$rwNilai["nilai2"], $regularFormatR);
}

$stot3=$stot+$stot2;

$row++;
$worksheet->write($row, 0, "", $regularFormatC);
$worksheet->write($row, 1, "Sub Total :", $regularFormat);
$worksheet->write($row, 2, $stot, $regularFormatR);
$worksheet->write($row, 3, $stot2, $regularFormatR);
$worksheet->write($row, 4, $stot3, $regularFormatR);
$row++;


$workbook->close();
mysql_close($konek);
?>