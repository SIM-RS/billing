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
$nunit1=$_REQUEST['nunit1'];
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];

convert_var($idunit,$nunit1,$kelas,$golongan,$jenis);
convert_var($kategori);

if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK='$jenis'";
if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";

$g1=$_REQUEST['g1'];
$k1=$_REQUEST['k1'];
$j1=$_REQUEST['j1'];
$f1=$_REQUEST['f1'];
convert_var($g1,$k1,$j1,$f1);
//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($sorting,$filter);
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Stok_Per_Unit.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Stok Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 14);
$worksheet->setColumn (3, 3, 14);
$worksheet->setColumn (4, 4, 8);
$worksheet->setColumn (5, 5, 12);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1,'numFormat'=>'#,##0'));
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
$worksheet->write($row, 1, "LAPORAN STOK OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "UNIT : $nunit1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "KELAS : $k1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "KATEGORI : $f1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "GOLONGAN : $g1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "JENIS : $j1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "TGL : ".$tgl, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kategori", $columnTitleFormat);
$worksheet->write($row, $column+3, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+4, "Stok", $columnTitleFormat);
$worksheet->write($row, $column+5, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") $sorting=$defaultsort;
/*$sql="SELECT ao.*,ak.ID,ak.NAMA,ap.QTY_STOK,ap.nilai 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK,IF(TIPE_TRANS=4,SUM(FLOOR(QTY_STOK*HARGA_BELI_SATUAN)),SUM(FLOOR((QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)) * 1.1))) AS nilai 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID WHERE ao.OBAT_ISAKTIF=1".$filter.$fkelas.$fgolongan.$fjenis.$fkategori." 
ORDER BY ".$sorting;*/
		$fil = " AND ap.QTY_STOK<>0";
		if($_REQUEST['stok_S']=='0'){
			$fil = " AND ap.QTY_STOK=0";
		}
$sql="SELECT ao.*,ak.ID,ak.NAMA,ap.QTY_STOK,ap.nilai,ok.kategori 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK,SUM(IF(((TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100) OR (NILAI_PAJAK<=0)),(FLOOR(QTY_STOK*HARGA_BELI_SATUAN * (1 - (`DISKON` / 100)))),(FLOOR((QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)) * 1.1)))) AS nilai 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>=0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID 
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
WHERE ao.OBAT_ISAKTIF=1".$fil.$filter.$fkelas.$fgolongan.$fjenis.$fkategori." 
ORDER BY ".$sorting;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['kategori'], $regularFormatC);
	$worksheet->write($row, 3, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 4, round($rows['QTY_STOK'],3), $regularFormatR);
	$worksheet->write($row, 5, $rows['nilai'], $regularFormatR);
	$row++;
}
$worksheet->write($row, 4, "TOTAL", $regularFormatR);
$worksheet->write($row, 5, '=Sum(F5:F'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>