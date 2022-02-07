<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");


function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

$tgl_d = $_REQUEST['tgl_d'];
$tgl_s = $_REQUEST['tgl_s'];


$qry="select * from a_unit where UNIT_ID=".$_REQUEST['idunit'];
$exe=mysqli_query($konek,$qry);
$show=mysqli_fetch_array($exe);
$nama_unit = $show['UNIT_NAME'];

if($_REQUEST['kpid']=='0'){
	$kepemilikan = 'SEMUA';
}
else{
	$qry2="select * from a_kepemilikan where ID=".$_REQUEST['kpid'];
	$exe2=mysqli_query($konek,$qry2);
	$show2=mysqli_fetch_array($exe2);
	$kepemilikan = $show2['NAMA'];
}

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Return_Dari_Unit.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Return Dari Unit');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 20);
$worksheet->setColumn (2, 2, 14);
$worksheet->setColumn (3, 3, 24);
$worksheet->setColumn (4, 4, 12);
$worksheet->setColumn (5, 5, 12);
$worksheet->setColumn (6, 6, 30);
$worksheet->setColumn (7, 7, 12);
$worksheet->setColumn (8, 8, 14);
$worksheet->setColumn (9, 9, 14);
$worksheet->setColumn (10, 10, 20);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 5, "LAPORAN RETURN DARI UNIT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "UNIT : $nama_unit", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KEPEMILIKAN : $kepemilikan", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "(".$tgl_d." s/d ".$tgl_s.")", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$row += 1;
$worksheet->write($row, $column, "Tanggal", $columnTitleFormat);
$worksheet->write($row, $column+1, "No Return", $columnTitleFormat);
$worksheet->write($row, $column+2, "Tgl Terima", $columnTitleFormat);
$worksheet->write($row, $column+3, "No Terima", $columnTitleFormat);
$worksheet->write($row, $column+4, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+5, "Unit", $columnTitleFormat);
$worksheet->write($row, $column+6, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+7, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+8, "QTY Return", $columnTitleFormat);
$worksheet->write($row, $column+9, "QTY Terima", $columnTitleFormat);
$worksheet->write($row, $column+10, "Alasan", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

if($_REQUEST['kpid']=='0'){
	$fkpid = '';
}
else{
	$fkpid = ' AND a_retur_togudang.KEPEMILIKAN_ID='.$_REQUEST['kpid'];
}

$funit = ' AND a_retur_togudang.UNIT_ID='.$_REQUEST['idunit'];
	  
$sql="SELECT 
  a_retur_togudang.*,
  a_unit.UNIT_NAME,
  a_obat.OBAT_KODE,
  a_obat.OBAT_NAMA,
  a_obat.OBAT_SATUAN_KECIL,
  k.NAMA
FROM
  a_retur_togudang 
  INNER JOIN a_unit 
	ON a_retur_togudang.UNIT_ID = a_unit.UNIT_ID 
  INNER JOIN a_obat 
	ON a_retur_togudang.OBAT_ID = a_obat.OBAT_ID 
  INNER JOIN a_kepemilikan k 
	ON a_retur_togudang.KEPEMILIKAN_ID = k.ID 
WHERE a_retur_togudang.TGL_RETUR BETWEEN '".tglSQL($tgl_d)."' 
  AND '".tglSQL($tgl_s)."' $fkpid $funit
ORDER BY ID_RETUR";

$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){

	$no_retur=$rows['NO_RETUR'];
	$cidretur=$rows['ID_RETUR'];
	$sql="SELECT NOTERIMA,TGL_TERIMA,if (SUM(QTY_SATUAN) is null,0,SUM(QTY_SATUAN)) AS QTY_SATUAN FROM a_penerimaan WHERE FK_MINTA_ID=$cidretur AND NOKIRIM='$no_retur'";
	$rs1=mysqli_query($konek,$sql);
	$qty_terima=0;
	if ($rows1=mysqli_fetch_array($rs1)) 
		$qty_terima=$rows1['QTY_SATUAN'];

	$worksheet->write($row, 0, $rows['TGL_RETUR'], $regularFormatC);
	$worksheet->write($row, 1, $rows['NO_RETUR'], $regularFormatC);
	$worksheet->write($row, 2, $rows1['TGL_TERIMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows1['NOTERIMA'], $regularFormatC);
	$worksheet->write($row, 4, $rows['OBAT_KODE'], $regularFormat);
	$worksheet->write($row, 5, $rows['UNIT_NAME'], $regularFormat);
	$worksheet->write($row, 6, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 7, $rows['NAMA'], $regularFormat);
	$worksheet->write($row, 8, $rows['QTY'], $regularFormatR);
	$worksheet->write($row, 9, $qty_terima, $regularFormatR);
	$worksheet->write($row, 10, $rows['ALASAN'], $regularFormat);
	$row++;
}

//$worksheet->write($row, 2, "TOTAL", $regularFormatR);
//$worksheet->write($row, 4, '=Sum(E8:E'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>