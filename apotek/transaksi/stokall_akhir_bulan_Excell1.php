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
$bl=date('m');
$th = date("Y");

$bulan=$_REQUEST['bulan'];if ($bulan==""){ $bln=$bl;$fbulan=" AND cs.bulan='$bl'"; }else{ $bln=$bulan;$fbulan=" AND cs.bulan='$bulan'";}
$tahun=$_REQUEST['tahun'];if ($tahun==""){ $thn=$th;$ftahun=" AND cs.tahun='$th'"; }else{ $thn=$tahun;$ftahun=" AND cs.tahun='$tahun'";}
$unit=$_REQUEST['idunit'];if ($unit==""){ $funit=" AND cs.unit_id=$idunit1"; }else{ $funit=" AND cs.unit_id=$unit";}

$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";
$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";

$g1=$_REQUEST['g1'];

//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$defaultsort="OBAT_NAMA,NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('StokAll_Akhir_Bulan.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Stok Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 14);
$worksheet->setColumn (3, 15, 8);
$worksheet->setColumn (16, 16, 10);
$worksheet->setColumn (17, 17, 12);
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

if($kelas == "")
{
	$nmkelas = "SEMUA";
}else{
	$query = "SELECT * FROM a_kelas WHERE kls_kode = '$kelas' ORDER BY KLS_KODE ";
	$exec = mysqli_query($konek,$query);
	$data = mysqli_fetch_array($exec);
	$nmkelas = $data['kls_nama'];
}

if($jenis == "")
{
	$nmjenis = "SEMUA";
}else{
	$query = "SELECT * FROM a_obat_jenis where obat_jenis_id = '$jenis'";
	$exec = mysqli_query($konek,$query);
	$data = mysqli_fetch_array($exec);
	$nmjenis = $data['obat_jenis'];
}

if($golongan == "")
{
	$nmgolongan = "SEMUA";
}else{
	$query = "SELECT * FROM a_obat_golongan WHERE kode = '$golongan'";
	$exec = mysqli_query($konek,$query);
	$data = mysqli_fetch_array($exec);
	$nmgolongan = $data['golongan'];
}

if($kategori == "")
{
	$nmkategori = "SEMUA";
}else{
	$query = "SELECT * FROM a_obat_kategori WHERE id = '$kategori'";
	$exec = mysqli_query($konek,$query);
	$data = mysqli_fetch_array($exec);
	$nmkategori = $data['kategori'];
}

if($unit == 0)
{
	$nmunit = "SEMUA";
}else{
	$query = "SELECT * FROM a_unit WHERE UNIT_TIPE<>3 AND UNIT_TIPE<>4 AND UNIT_TIPE<>7 AND UNIT_TIPE<>8 AND UNIT_ISAKTIF=1 AND unit_id = '$unit'";
	$exec = mysqli_query($konek,$query);
	$data = mysqli_fetch_array($exec);
	$nmunit = $data['unit_name'];
}

//Write sheet title in upper left cell
$worksheet->write($row, 5, "LAPORAN STOK OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "Akhir Bulan : ".$_REQUEST['tbulan']." $thn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "UNIT : $nmunit", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KELAS : $nmkelas", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KATEGORI : $nmkategori", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "GOLONGAN : $nmgolongan", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "JENIS : $nmjenis", $sheetTitleFormat);

//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+3, "GD", $columnTitleFormat);
$worksheet->write($row, $column+4, "AP1", $columnTitleFormat);
$worksheet->write($row, $column+5, "AP2", $columnTitleFormat);
$worksheet->write($row, $column+6, "AP3", $columnTitleFormat);
$worksheet->write($row, $column+7, "AP4", $columnTitleFormat);
$worksheet->write($row, $column+8, "AP5", $columnTitleFormat);
$worksheet->write($row, $column+9, "AP6", $columnTitleFormat);
$worksheet->write($row, $column+10, "AP7", $columnTitleFormat);
$worksheet->write($row, $column+11, "AP8", $columnTitleFormat);
$worksheet->write($row, $column+12, "AP10", $columnTitleFormat);
$worksheet->write($row, $column+13, "AP11", $columnTitleFormat);
$worksheet->write($row, $column+14, "PR", $columnTitleFormat);
$worksheet->write($row, $column+15, "FS", $columnTitleFormat);
$worksheet->write($row, $column+16, "Total", $columnTitleFormat);
$worksheet->write($row, $column+17, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") $sorting=$defaultsort;
$sql = "SELECT gab.*,ao.OBAT_NAMA,ao.OBAT_KODE,ak.NAMA,
(gab.gd+gab.ap1+gab.ap2+gab.ap3+gab.ap4+gab.ap5+gab.ap6+gab.ap7+gab.ap8+gab.ap10+gab.ap11+gab.pr+gab.fs) AS total    
FROM (SELECT cs.obat_id,cs.kepemilikan_id,
SUM(IF(unit_id=1,cs.qty_stok,0)) gd,
SUM(IF(unit_id=2,cs.qty_stok,0)) ap1,
SUM(IF(unit_id=3,cs.qty_stok,0)) ap2,
SUM(IF(unit_id=4,cs.qty_stok,0)) ap3,
SUM(IF(unit_id=5,cs.qty_stok,0)) ap4,
SUM(IF(unit_id=6,cs.qty_stok,0)) ap5,
SUM(IF(unit_id=100,cs.qty_stok,0)) ap6,
SUM(IF(unit_id=101,cs.qty_stok,0)) ap7,
SUM(IF(unit_id=97,cs.qty_stok,0)) ap8,
SUM(IF(unit_id=11,cs.qty_stok,0)) ap10,
SUM(IF(unit_id=12,cs.qty_stok,0)) ap11,
SUM(IF(unit_id=17,cs.qty_stok,0)) pr,
SUM(IF(unit_id=20,cs.qty_stok,0)) fs,
SUM(FLOOR(cs.nilai)) nilai
FROM a_rpt_current_stok cs 
WHERE 0=0 $fbulan $ftahun
GROUP BY cs.obat_id,cs.kepemilikan_id) gab 
INNER JOIN a_obat ao ON gab.obat_id=ao.OBAT_ID
INNER JOIN a_kepemilikan ak ON gab.kepemilikan_id=ak.ID
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID
WHERE 0 = 0".$filter." $fkelas $fgolongan $fjenis $fkategori ORDER BY ".$sorting;

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['gd'], $regularFormatR);
	$worksheet->write($row, 4, $rows['ap1'], $regularFormatR);
	$worksheet->write($row, 5, $rows['ap2'], $regularFormatR);
	$worksheet->write($row, 6, $rows['ap3'], $regularFormatR);
	$worksheet->write($row, 7, $rows['ap4'], $regularFormatR);
	$worksheet->write($row, 8, $rows['ap5'], $regularFormatR);
	$worksheet->write($row, 9, $rows['ap6'], $regularFormatR);
	$worksheet->write($row, 10, $rows['ap7'], $regularFormatR);
	$worksheet->write($row, 11, $rows['ap8'], $regularFormatR);
	$worksheet->write($row, 12, $rows['ap10'], $regularFormatR);
	$worksheet->write($row, 13, $rows['ap11'], $regularFormatR);
	$worksheet->write($row, 14, $rows['pr'], $regularFormatR);
	$worksheet->write($row, 15, $rows['fs'], $regularFormatR);
	$worksheet->write($row, 16, $rows['total'], $regularFormatR);
	$worksheet->write($row, 17, $rows['nilai'], $regularFormatR);
	$row++;
}

$worksheet->write($row, 16, "TOTAL", $regularFormatR);
/*$worksheet->write($row, 3, '=Sum(D5:D'.$row.')', $regularFormatR);
$worksheet->write($row, 4, '=Sum(E5:E'.$row.')', $regularFormatR);
$worksheet->write($row, 5, '=Sum(F5:F'.$row.')', $regularFormatR);
$worksheet->write($row, 6, '=Sum(G5:G'.$row.')', $regularFormatR);
$worksheet->write($row, 7, '=Sum(H5:H'.$row.')', $regularFormatR);
$worksheet->write($row, 8, '=Sum(I5:I'.$row.')', $regularFormatR);
$worksheet->write($row, 9, '=Sum(J5:J'.$row.')', $regularFormatR);
$worksheet->write($row, 10, '=Sum(K5:K'.$row.')', $regularFormatR);
$worksheet->write($row, 11, '=Sum(L5:L'.$row.')', $regularFormatR);
$worksheet->write($row, 12, '=Sum(M5:M'.$row.')', $regularFormatR);
$worksheet->write($row, 13, '=Sum(N5:N'.$row.')', $regularFormatR);
$worksheet->write($row, 14, '=Sum(O5:O'.$row.')', $regularFormatR);
$worksheet->write($row, 15, '=Sum(P5:P'.$row.')', $regularFormatR);
$worksheet->write($row, 16, '=Sum(Q5:Q'.$row.')', $regularFormatR);*/
$worksheet->write($row, 17, '=Sum(R5:R'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>