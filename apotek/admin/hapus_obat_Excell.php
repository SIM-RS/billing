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

$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];

if ($bulan=="1") $bln = "Januari";
elseif ($bulan=="2") $bln = "Pebruari";
elseif ($bulan=="3") $bln = "Maret";
elseif ($bulan=="4") $bln = "April";
elseif ($bulan=="5") $bln = "Mei";
elseif ($bulan=="6") $bln = "Juni";
elseif ($bulan=="7") $bln = "Juli";
elseif ($bulan=="8") $bln = "Agustus";
elseif ($bulan=="9") $bln = "September";
elseif ($bulan=="10") $bln = "Oktober";
elseif ($bulan=="11") $bln = "Nopember";
elseif ($bulan=="12") $bln = "Desember";

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Daftar_Usulan_Penghapusan_Obat.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Hapus Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 20);
$worksheet->setColumn (2, 2, 30);
$worksheet->setColumn (3, 3, 14);
$worksheet->setColumn (4, 4, 10);
$worksheet->setColumn (5, 5, 12);
$worksheet->setColumn (6, 6, 25);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1));
$regularFormatRN =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 2, "DAFTAR USULAN PENGHAPUSAN OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 2, "BULAN : $bln $tahun", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$row += 1;
$worksheet->write($row, $column, "Tgl Hapus", $columnTitleFormat);
$worksheet->write($row, $column+1, "No Hapus", $columnTitleFormat);
$worksheet->write($row, $column+2, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+3, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+4, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+5, "Nilai", $columnTitleFormat);
$worksheet->write($row, $column+6, "Alasan", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

	  
$sql="SELECT a_obat_hapus.TGL_HAPUS,a_obat_hapus.NO_HAPUS,a_unit.UNIT_NAME,a_obat.OBAT_NAMA,a_kepemilikan.NAMA,SUM(a_obat_hapus.QTY) AS QTY,SUM(a_obat_hapus.QTY*p.HARGA_BELI_SATUAN * (1-(p.DISKON/100) * 1.1)) AS nilai,a_obat_hapus.ALASAN
			FROM a_obat INNER JOIN a_obat_hapus ON (a_obat.OBAT_ID = a_obat_hapus.OBAT_ID) INNER JOIN a_kepemilikan 
			ON (a_kepemilikan.ID = a_obat_hapus.KEPEMILIKAN_ID) INNER JOIN a_unit ON (a_unit.UNIT_ID = a_obat_hapus.UNIT_ID) INNER JOIN a_penerimaan p ON p.ID=a_obat_hapus.PENERIMAAN_ID
			WHERE (MONTH(a_obat_hapus.TGL_HAPUS)=$bulan AND YEAR(a_obat_hapus.TGL_HAPUS)=$tahun)
			GROUP BY a_obat_hapus.NO_HAPUS, a_unit.UNIT_NAME, a_obat.OBAT_NAMA, a_kepemilikan.NAMA";

$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){


	$worksheet->write($row, 0, date("d/m/Y",strtotime($rows['TGL_HAPUS'])), $regularFormatC);
	$worksheet->write($row, 1, $rows['NO_HAPUS'], $regularFormatC);
	$worksheet->write($row, 2, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 3, $rows['NAMA'], $regularFormat);
	$worksheet->write($row, 4, $rows['QTY'], $regularFormatR);
	$worksheet->write($row, 5, $rows['nilai'], $regularFormatR);
	$worksheet->write($row, 6, $rows['ALASAN'], $regularFormat);
	$row++;
}

$worksheet->write($row, 4, "TOTAL", $regularFormatR);
$worksheet->write($row, 5, '=SUM(F5:F'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>