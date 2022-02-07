<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$defaultsort="o.OBAT_NAMA,m.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];

convert_var($defaultsort,$sorting,$kelas,$golongan,$jenis);
convert_var($kategori);

if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($fkelas=="")) $fgolongan=" WHERE o.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND o.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE o.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND o.OBAT_KELOMPOK=$jenis";}
if ($kategori=="") $fkategori=""; else { if (($fkelas=="")&&($fgolongan=="")&&($fjenis=="")) $fkategori=" WHERE o.OBAT_KATEGORI=$kategori"; else $fkategori=" AND o.OBAT_KATEGORI=$kategori";}

$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
$f1=$_REQUEST['f1'];

convert_var($g1,$k1,$j1,$f1);
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Stok_All_Unit.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Stok Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 10);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 12);
$worksheet->setColumn (3, 16, 10);
$worksheet->setColumn (17, 17, 13);
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
$regularFormatRF =& $workbook->addFormat(array('size'=>9,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 4, "LAPORAN STOK OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "UNIT : ALL UNIT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "KELAS : $k1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "KATEGORI : $f1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "GOLONGAN : $g1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "JENIS : $j1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "TGL : ".$tgl, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+3, "GD", $columnTitleFormat);
$worksheet->write($row, $column+4, "AP-RS", $columnTitleFormat);
$worksheet->write($row, $column+5, "AP-Krakatau", $columnTitleFormat);
$worksheet->write($row, $column+6, "AP-BICT", $columnTitleFormat);

$worksheet->write($row, $column+7, "PR", $columnTitleFormat);
$worksheet->write($row, $column+8, "FS", $columnTitleFormat);
$worksheet->write($row, $column+9, "Total", $columnTitleFormat);
$worksheet->write($row, $column+10, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }
  if ($sorting=="") $sorting=$defaultsort;
 $sql="SELECT o.OBAT_KODE,o.OBAT_NAMA AS obat,m.NAMA AS kepemilikan,v.*,unit1+unit2+unit3+unit4+unit5+unit6+unit7+unit8+unit9+unit11+unit12+unit17+unit20 AS total 
	FROM vstokall AS v INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) AS o ON v.obat_id=o.OBAT_ID INNER JOIN a_kepemilikan AS m ON v.kepemilikan_id=m.ID 
	LEFT JOIN a_kelas AS kls ON o.KLS_ID=kls.KLS_ID".$filter.$fkelas.$fgolongan.$fjenis.$fkategori."
	ORDER BY ".$sorting;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['obat'], $regularFormat);
	$worksheet->write($row, 2, $rows['kepemilikan'], $regularFormatC);
	$worksheet->write($row, 3, $rows['unit1'], $regularFormatR);
	$worksheet->write($row, 4, $rows['unit2'], $regularFormatR);
	$worksheet->write($row, 5, $rows['unit3'], $regularFormatR);
	$worksheet->write($row, 6, $rows['unit4'], $regularFormatR);
	$worksheet->write($row, 7, $rows['unit5'], $regularFormatR);
	$worksheet->write($row, 8, $rows['unit6'], $regularFormatR);
	$worksheet->write($row, 9, $rows['total'], $regularFormatR);
	$worksheet->write($row, 10, $rows['ntotal'], $regularFormatRF);
	$row++;
}
$worksheet->write($row, 9, "TOTAL", $regularFormatR);
$worksheet->write($row, 10, '=Sum(K8:K'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>