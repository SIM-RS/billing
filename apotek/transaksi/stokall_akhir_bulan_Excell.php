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
convert_var($bl,$th,$nunit1,$idunit);

$bulan=$_REQUEST['bulan'];
$tahun=$_REQUEST['tahun'];
$unit=$_REQUEST['idunit'];
convert_var($bulan,$tahun,unit);

if ($bulan==""){ $bln=$bl;$fbulan=" AND cs.bulan='$bl'"; }else{ $bln=$bulan;$fbulan=" AND cs.bulan='$bulan'";}
if ($tahun==""){ $thn=$th;$ftahun=" AND cs.tahun='$th'"; }else{ $thn=$tahun;$ftahun=" AND cs.tahun='$tahun'";}
if ($unit==""){ $funit=" AND cs.unit_id=$idunit1"; }else{ $funit=" AND cs.unit_id=$unit";}
convert_var($fbulan,$ftahun,$funit);

$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];
convert_var($kelas,$golongan,$jenis,$kategori);

if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";
if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";

convert_var($fkelas,$fgolongan,$fjenis,$fkategori);

$g1=$_REQUEST['g1'];

//Paging,Sorting dan Filter======
//$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$defaultsort="OBAT_NAMA,NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($g1,$sorting,$filter);
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
$worksheet->setColumn (10, 10, 15);
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
	$query = "SELECT * FROM a_unit WHERE UNIT_TIPE<>3 AND UNIT_TIPE<>4 AND UNIT_TIPE<>7 AND UNIT_TIPE<>8 AND UNIT_ISAKTIF=1 AND unit_id = '$unit' AND UNIT_ID NOT IN(8,9)";
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
$worksheet->write($row, $column+4, "AP-RS", $columnTitleFormat);
// $worksheet->write($row, $column+5, "AP-KR", $columnTitleFormat);
// $worksheet->write($row, $column+6, "DP-BICT", $columnTitleFormat);
$worksheet->write($row, $column+5, "PR", $columnTitleFormat);
$worksheet->write($row, $column+6, "FS", $columnTitleFormat);
$worksheet->write($row, $column+7, "Total", $columnTitleFormat);
$worksheet->write($row, $column+8, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") $sorting=$defaultsort;
$sql = "SELECT 
  ao.OBAT_KODE,
  ao.OBAT_NAMA,
  ak.NAMA,
  SUM(IF(cs.unit_id = 12, cs.qty_akhir, 0)) AS GD,
  SUM(IF(cs.unit_id = 7, cs.qty_akhir, 0)) AS AP_RS,
  -- SUM(IF(cs.unit_id = 8, cs.qty_akhir, 0)) AS AP_KR,
  -- SUM(IF(cs.unit_id = 9, cs.qty_akhir, 0)) AS AP_BICT,
  SUM(IF(cs.unit_id = 16, cs.qty_akhir, 0)) AS PR,
  SUM(IF(cs.unit_id = 14, cs.qty_akhir, 0)) AS FS,
  
  SUM(cs.qty_akhir) total,
		  SUM(FLOOR(cs.nilai_akhir)) ntotal 
		FROM
		  a_rpt_mutasi cs 
  
  
  INNER JOIN a_obat ao 
    ON ao.OBAT_ID = cs.obat_id 
  INNER JOIN a_unit au 
    ON au.UNIT_ID = cs.unit_id 
  INNER JOIN a_kepemilikan ak 
    ON ak.ID = cs.kepemilikan_id
  LEFT JOIN a_kelas kls
    ON ao.KLS_ID=kls.KLS_ID 
WHERE  0=0 $fbulan $ftahun $filter $fkelas $fgolongan $fjenis $fkategori $fbentuk AND cs.UNIT_ID NOT IN(8,9)
GROUP BY ao.OBAT_ID,
  ak.ID 
ORDER BY ".$sorting;

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['GD'], $regularFormatR);
	$worksheet->write($row, 4, $rows['AP_RS'], $regularFormatR);
	// $worksheet->write($row, 5, $rows['AP_KR'], $regularFormatR);
	// $worksheet->write($row, 6, $rows['AP_BICT'], $regularFormatR);
	$worksheet->write($row, 5, $rows['PR'], $regularFormatR);
	$worksheet->write($row, 6, $rows['FS'], $regularFormatR);
	$worksheet->write($row, 7, $rows['total'], $regularFormatR);
	$worksheet->write($row, 8, floor($rows['ntotal']), $regularFormatR);
	$row++;
}

$worksheet->write($row, 9, "TOTAL", $regularFormatR);
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
$worksheet->write($row, 10, '=Sum(K5:K'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>