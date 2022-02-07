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
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Stok_Akhir_Bulan.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Stok Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 14);
$worksheet->setColumn (3, 3, 8);
$worksheet->setColumn (4, 4, 12);
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


//Write sheet title in upper left cell
$worksheet->write($row, 1, "LAPORAN STOK OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "Akhir Bulan : ".$_REQUEST['tbulan']." $thn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "UNIT : $nunit1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "KELAS : $nmkelas", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "KATEGORI : $nmkategori", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "GOLONGAN : $nmgolongan", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "JENIS : $nmjenis", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+3, "Stok", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") $sorting=$defaultsort;
$sql = "SELECT 
		  ao.OBAT_ID,
		  ao.OBAT_KODE,
		  ao.OBAT_NAMA,
		  ak.NAMA,
		  cs.qty_stok,
		  FLOOR(cs.nilai) nilai 
		FROM
		  a_rpt_current_stok cs 
		  INNER JOIN a_obat ao 
			ON ao.OBAT_ID = cs.obat_id 
		  INNER JOIN a_unit au 
			ON au.UNIT_ID = cs.unit_id 
		  INNER JOIN a_kepemilikan ak 
			ON ak.ID = cs.kepemilikan_id
		  LEFT JOIN a_kelas kls
            ON ao.KLS_ID=kls.KLS_ID 
		WHERE 0=0 $fbulan $ftahun $funit $filter $fkelas $fgolongan $fjenis $fkategori
		ORDER BY $sorting";//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['qty_stok'], $regularFormatR);
	$worksheet->write($row, 4, $rows['nilai'], $regularFormatR);
	$row++;
}
$worksheet->write($row, 2, "TOTAL", $regularFormatR);
$worksheet->write($row, 4, '=Sum(E5:E'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>