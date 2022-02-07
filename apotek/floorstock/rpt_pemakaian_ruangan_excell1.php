<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$nunit1="FLOORSTOCK";
$cmbdata=$_REQUEST['cmbdata'];
if ($cmbdata=="") $cmbdata=0;
$tgl_d=$_REQUEST['tgl_d'];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Pemakaian_Ruangan.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Pemakaian_Ruangan');
$worksheet->setLandscape();

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;

$jdl="LAPORAN PEMAKAIAN OBAT OLEH RUANGAN/POLI";
$cUnit="ap.UNIT_ID=20";
$cUnit1="UNIT_ID=20";
if ($idunit==""){
	$cUnit="ap.UNIT_ID<>20";
	$cUnit1="UNIT_ID<>20";
	$nunit1="ALL FARMASI";
	$jdl="LAPORAN REKAP RESEP OBAT OLEH RUANGAN/POLI";
}

$sql="SELECT DISTINCT au.UNIT_ID,IFNULL(au.UNIT_KODE,CONCAT('P',au.UNIT_ID)) AS UNIT_KODE,au.UNIT_NAME FROM a_penjualan ap INNER JOIN a_unit au ON ap.RUANGAN=au.UNIT_ID 
WHERE $cUnit AND ap.TGL BETWEEN '$tgl_d1' AND '$tgl_s1' ORDER BY au.UNIT_KODE";
$rs=mysqli_query($konek,$sql);
$str1="";
$str2="";
while ($rows=mysqli_fetch_array($rs)){
	$arUNIT_ID[]=$rows["UNIT_ID"];
	$arPL[]=$rows["UNIT_KODE"];
	$arUNIT_NAME[]=$rows["UNIT_NAME"];
	$str1.="SUM(".$rows["UNIT_KODE"].") AS ".$rows["UNIT_KODE"].",";
	if ($cmbdata==0){
		$str2.="IF (t1.RUANGAN=".$rows["UNIT_ID"].",t1.QTY_JUAL,0) AS ".$rows["UNIT_KODE"].",";
	}else{
		$str2.="IF (t1.RUANGAN=".$rows["UNIT_ID"].",t1.NILAI,0) AS ".$rows["UNIT_KODE"].",";
	}
}

if ($str1!=""){
	$str1=substr($str1,0,strlen($str1)-1);
	$str2=substr($str2,0,strlen($str2)-1);
	$worksheet->setColumn (count($arPL)+2, count($arPL)+2, 12);
	$worksheet->setColumn (count($arPL)+3, count($arPL)+3, 14);
}

$arCol[]="C";$arCol[]="D";$arCol[]="E";$arCol[]="F";$arCol[]="G";$arCol[]="H";
$arCol[]="I";$arCol[]="J";$arCol[]="K";$arCol[]="L";$arCol[]="M";$arCol[]="N";
$arCol[]="O";$arCol[]="P";$arCol[]="Q";$arCol[]="R";$arCol[]="S";$arCol[]="T";
$arCol[]="U";$arCol[]="V";$arCol[]="W";$arCol[]="X";$arCol[]="Y";$arCol[]="Z";
$arCol[]="AA";$arCol[]="AB";$arCol[]="AC";$arCol[]="AD";$arCol[]="AE";$arCol[]="AF";
$arCol[]="AG";$arCol[]="AH";$arCol[]="AI";$arCol[]="AJ";$arCol[]="AK";$arCol[]="AL";
$arCol[]="AM";$arCol[]="AN";$arCol[]="AO";$arCol[]="AP";$arCol[]="AQ";$arCol[]="AR";
$arCol[]="AS";$arCol[]="AT";$arCol[]="AU";$arCol[]="AV";$arCol[]="AW";$arCol[]="AX";
$arCol[]="AY";$arCol[]="AZ";$arCol[]="BA";$arCol[]="BB";$arCol[]="BC";$arCol[]="BD";
$arCol[]="BE";$arCol[]="BF";$arCol[]="BG";$arCol[]="BH";$arCol[]="BI";$arCol[]="BJ";
$arCol[]="BK";$arCol[]="BL";$arCol[]="BM";$arCol[]="BN";$arCol[]="BO";$arCol[]="BP";
$arCol[]="BQ";$arCol[]="BR";$arCol[]="BS";$arCol[]="BT";$arCol[]="BU";$arCol[]="BV";
$arCol[]="AW";$arCol[]="AX";$arCol[]="BY";$arCol[]="BZ";$arCol[]="CA";$arCol[]="CB";

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 35);
$worksheet->setColumn (1, 1, 14);
//$worksheet->setColumn (2, 60, 8);
//$worksheet->setColumn (61, 61, 12);
//$worksheet->setColumn (62, 62, 14);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

$worksheet->write($row, floor(count($arPL)/2), $jdl, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, floor(count($arPL)/2), "UNIT : $nunit1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, floor(count($arPL)/2), "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 0, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, 1, "Kepemilikan", $columnTitleFormat);
for ($i=0;$i<count($arPL);$i++){
	$worksheet->write($row, $i+2, $arPL[$i], $columnTitleFormat);
}
$worksheet->write($row, $i+2, "Total Qty", $columnTitleFormat);
$worksheet->write($row, $i+3, "Total Nilai", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") $sorting=$defaultsort;
if ($cmbdata==0){
	$sql="SELECT ao.OBAT_NAMA,ak.NAMA,t3.* FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_JUAL) AS QTY_JUAL,SUM(NILAI) AS NILAI,
".$str1." 
FROM (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,t1.*,
".$str2." 
FROM (SELECT PENERIMAAN_ID,QTY_JUAL,(QTY_JUAL * HARGA_SATUAN) AS NILAI,RUANGAN 
FROM a_penjualan WHERE $cUnit1 AND TGL BETWEEN '$tgl_d1' AND '$tgl_s1') AS t1
INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID) AS t2 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t3 
INNER JOIN a_obat ao ON t3.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON t3.KEPEMILIKAN_ID=ak.ID 
ORDER BY ao.OBAT_NAMA";
}else{
	$sql="SELECT ao.OBAT_NAMA,ak.NAMA,t3.* FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_JUAL) AS QTY_JUAL,SUM(NILAI) AS NILAI,
".$str1." 
FROM (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,t1.*,
".$str2." 
FROM (SELECT ap.*,IF(apn.NILAI_PAJAK>0,ap.QTY_JUAL*apn.HARGA_BELI_SATUAN*(1-(apn.DISKON/100))*1.1,ap.QTY_JUAL*apn.HARGA_BELI_SATUAN) AS NILAI 
FROM (SELECT PENERIMAAN_ID,QTY_JUAL,RUANGAN FROM a_penjualan WHERE $cUnit1 AND TGL BETWEEN '$tgl_d1' AND '$tgl_s1') AS ap 
INNER JOIN a_penerimaan apn ON ap.PENERIMAAN_ID=apn.ID) AS t1
INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID) AS t2 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t3 
INNER JOIN a_obat ao ON t3.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON t3.KEPEMILIKAN_ID=ak.ID 
ORDER BY ao.OBAT_NAMA";
}
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 1, $rows['NAMA'], $regularFormatC);
	for ($i=0;$i<count($arPL);$i++){
		$worksheet->write($row, $i+2, $rows[$arPL[$i]], $regularFormatR);
	}
	$worksheet->write($row, $i+2, $rows['QTY_JUAL'], $regularFormatR);
	$worksheet->write($row, $i+3, $rows['NILAI'], $regularFormatR);
	$row++;
}

$worksheet->write($row, 1, "TOTAL", $regularFormatR);
for ($i=0;$i<count($arPL);$i++){
	$worksheet->write($row, $i+2, '=Sum('.$arCol[$i].'5:'.$arCol[$i].$row.')', $regularFormatR);
}
$worksheet->write($row, $i+2, '=Sum('.$arCol[$i].'5:'.$arCol[$i].$row.')', $regularFormatR);
$worksheet->write($row, $i+3, '=Sum('.$arCol[$i+1].'5:'.$arCol[$i+1].$row.')', $regularFormatR);
$row++;
$row++;

$worksheet->write($row, 0, 'KETERANGAN : ', $regularFormatL);
for ($i=0;$i<count($arPL);$i++){
	$row++;
	$worksheet->write($row, 0, $arPL[$i]." : ".$arUNIT_NAME[$i], $regularFormatL);
}

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>