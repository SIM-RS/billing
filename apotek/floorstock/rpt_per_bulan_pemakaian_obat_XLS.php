<?php
include("../sesi.php"); 
include("../koneksi/konek.php");
//=================================
function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

function tgl2Text($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[0].' '.getBulan($t[1]).' '.$t[2];
   return $t;
}

function tgl2As($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'_'.strtoupper(substr(getBulan($t[1]),0,3));
   //$t=$t[2].'/'.$t[1].'/'.$t[0];
   return $t;
}

function getBulan($bln){
	if($bln=='01'){
		$bl='Januari';
	}else if($bln=='02'){
		$bl='Februari';
	}else if($bln=='03'){
		$bl='Maret';
	}else if($bln=='04'){
		$bl='April';
	}else if($bln=='05'){
		$bl='Mei';
	}else if($bln=='06'){
		$bl='Juni';
	}else if($bln=='07'){
		$bl='Juli';
	}else if($bln=='08'){
		$bl='Agustus';
	}else if($bln=='09'){
		$bl='September';
	}else if($bln=='10'){
		$bl='Oktober';
	}else if($bln=='11'){
		$bl='November';
	}else if($bln=='12'){
		$bl='Desember';
	}
	return $bl;
}

if($_REQUEST['tipe_lap']==2){
	$bln1 = $_REQUEST['bln1'];
	$thn1 = $_REQUEST['thn1'];
	$bln2 = $_REQUEST['bln2'];
	$thn2 = $_REQUEST['thn2'];

	$periode = "Bulan : ".getBulan($bln1)." ".$thn1." s/d ".getBulan($bln2)." ".$thn2." "; 	
	$fperiode = "AND DATE_FORMAT(ap.TANGGAL,'%Y-%m') BETWEEN '$thn1-$bln1' AND '$thn2-$bln2'";
}

//========
$kepemilikan_id = $_REQUEST['kepemilikan_id'];
if($kepemilikan_id==""){
$kepemilikan = "SEMUA";
$fKep="";
}
else{
$sKep = "SELECT * FROM a_kepemilikan WHERE ID=".$kepemilikan_id;
$qKep = mysqli_query($konek,$sKep);
$rKep = mysqli_fetch_array($qKep);
$kepemilikan = $rKep['NAMA'];
$fKep=" AND ap.KEPEMILIKAN_ID = $kepemilikan_id";
}

$unit_id = $_REQUEST['idunit'];
if($unit_id==""){
$ruangan = "SEMUA";
$fUnit="";
}
else{
$sUnit = "SELECT * FROM a_unit WHERE UNIT_ID=".$unit_id;
$qUnit = mysqli_query($konek,$sUnit);
$rUnit = mysqli_fetch_array($qUnit);
$ruangan = $rUnit['UNIT_NAME'];
$fUnit=" AND a_unit.UNIT_ID = $unit_id";
}

$golongan_id = $_REQUEST['golongan_id'];
if($golongan_id==""){
$golongan = "SEMUA";
$fGol="";
}
else{
$sGol = "SELECT * FROM a_obat_golongan WHERE kode='".$golongan_id."'";
$qGol = mysqli_query($konek,$sGol);
$rGol = mysqli_fetch_array($qGol);
$golongan = $rGol['golongan'];
$fGol=" AND ao.OBAT_GOLONGAN = '$golongan_id'";
}

$arrBln = array();

$sql = "SELECT PERIOD_DIFF($thn2$bln2,$thn1$bln1)";
$kueri = mysqli_query($konek,$sql);
$jbln = mysqli_fetch_array($kueri);

$jum_bln = $jbln[0];
$jum_bln = $jum_bln+1;

$bulan = $bln1;
$tahun = $thn1;

$b = strtoupper(getBulan($bulan));
$alias = substr("$b",0,3)."_".$tahun;
$ct = "SUM(IF(DATE_FORMAT(ap.TANGGAL,'%m-%Y')='$bulan-$tahun',ap.QTY_SATUAN,'0')) AS ".$alias;
array_push($arrBln,$alias);

for($i=1;$i<$jum_bln;$i++){
	$Add = "SELECT PERIOD_ADD($tahun$bulan,1)";
	$qAdd = mysqli_query($konek,$Add);
	$rAdd = mysqli_fetch_array($qAdd);
	$result = $rAdd[0];
	
	$bulan = substr($result,4,2);
	$tahun = substr($result,0,4);

	$b = strtoupper(getBulan($bulan));
	$alias = substr("$b",0,3)."_".$tahun;
	$ct = $ct.",SUM(IF(DATE_FORMAT(ap.TANGGAL,'%m-%Y')='$bulan-$tahun',ap.QTY_SATUAN,'0')) AS ".$alias;
	array_push($arrBln,$alias); 
}
//echo $ct;
//print_r($arrBln);

$sql = "SELECT 
  a_unit.UNIT_ID,
  a_unit.UNIT_NAME,
  ao.OBAT_ID,
  ao.OBAT_NAMA,
  $ct
FROM
  a_penerimaan ap 
  INNER JOIN a_obat ao 
    ON ap.obat_id = ao.OBAT_ID 
  INNER JOIN a_unit 
    ON ap.UNIT_ID_TERIMA = a_unit.UNIT_ID 
  INNER JOIN a_penjualan p 
    ON ap.ID = p.PENERIMAAN_ID 
WHERE ap.UNIT_ID_KIRIM = 20 
  AND ap.TIPE_TRANS = 1 
  AND a_unit.UNIT_TIPE = 3
  $fKep
  $fGol
  $fUnit 
  $fperiode 
GROUP BY ap.OBAT_ID
ORDER BY ao.OBAT_NAMA";
$query=mysqli_query($konek,$sql);

//=================================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Pemakaian Obat Ruangan BULANAN.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Pemakaian Obat Ruangan BULANAN');
//$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 5);
$worksheet->setColumn (1, 1, 45);
$worksheet->setColumn (2, 2, 10);
$worksheet->setColumn (3, 3, 10);
$worksheet->setColumn (4, 4, 10);
$worksheet->setColumn (5, 5, 10);
$worksheet->setColumn (6, 6, 10);
$worksheet->setColumn (7, 7, 10);
$worksheet->setColumn (8, 8, 10);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>12,'align'=>'left'));
$sheetTitleFormatC =& $workbook->addFormat(array('size'=>12,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'yellow','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'yellow','pattern'=>1,'numFormat'=>'#,##0'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'yellow','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatRB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormatLNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'left'));
$regularFormatCNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center'));
$regularFormatRNoWrapB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'right'));
$gsTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'green','pattern'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
//==================================================

$worksheet->write($row, 7, "DATA TOTAL PEMAKAIAN OBAT / ALKES RUANGAN", $sheetTitleFormatC);
//$worksheet->writeBlank($row, 13, $sheetTitleFormatC);
//$worksheet->mergeCells($row,7,$row,13);

$row++;
$worksheet->write($row, 7, "KEPEMILIKAN : ".$kepemilikan, $sheetTitleFormatC);
//$worksheet->writeBlank($row, 13, $sheetTitleFormatC);
//$worksheet->mergeCells($row,7,$row+1,13);

$row++;
$worksheet->write($row, 7, "UNIT : ".$ruangan, $sheetTitleFormatC);
//$worksheet->writeBlank($row, 13, $sheetTitleFormatC);
//$worksheet->mergeCells($row,7,$row+1,13);

$row++;
$worksheet->write($row, 7, "GOLONGAN : ".$golongan, $sheetTitleFormatC);
//$worksheet->writeBlank($row, 13, $sheetTitleFormatC);
//$worksheet->mergeCells($row,7,$row+1,13);

$row++;
$worksheet->write($row, 7, $periode, $sheetTitleFormatC);
//$worksheet->writeBlank($row, 13, $sheetTitleFormatC);
//$worksheet->mergeCells($row,7,$row+2,13);

//Judul Tabel
//==================================================
$row+=4;
$worksheet->write($row, 0, "NO", $columnTitleFormat);
$worksheet->write($row, 1, "OBAT", $columnTitleFormat);
for($b=0;$b<count($arrBln);$b++)
{
$worksheet->write($row, 2+$b, $arrBln[$b], $columnTitleFormat);
}
$worksheet->write($row, 2+count($arrBln), "TOTAL", $columnTitleFormat);
// AWAL Record Tabel
//=================================================
$row+=1;
$no=0;
while($rows=mysqli_fetch_array($query))
{
$no++;
$worksheet->write($row, 0, $no, $regularFormatC);
$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
$tot = 0;
	for($b=0;$b<count($arrBln);$b++)
	{
	$arrB =  $arrBln[$b];
	$worksheet->write($row, 2+$b, $rows[$arrB], $regularFormatC);
	$tot = $tot + $rows[$arrB];
	}
$worksheet->write($row, 2+count($arrBln), number_format($tot,0,',','.'), $regularFormatR);
$row+=1;
}
// END Record Tabel
//=================================================
$row+=3;
$xx = date('d-m-Y');
$worksheet->write($row, 15, $kotaRS", ".$xx, $regularFormatC);
$worksheet->writeBlank($row, 16, $regularFormatC);
$worksheet->mergeCells($row,15,$row,16);
$row+=1;
$worksheet->write($row, 15, "Mengetahui", $regularFormatC);
$worksheet->writeBlank($row, 16, $regularFormatC);
$worksheet->mergeCells($row,15,$row,16);
$row+=1;
$worksheet->write($row, 15, "Ka Ruangan", $regularFormatC);
$worksheet->writeBlank($row, 16, $regularFormatC);
$worksheet->mergeCells($row,15,$row,16);
$row+=5;
$worksheet->write($row, 15, "(...............................)", $regularFormatC);
$worksheet->writeBlank($row, 16, $regularFormatC);
$worksheet->mergeCells($row,15,$row,16);


$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>