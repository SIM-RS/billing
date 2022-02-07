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
$workbook->send('Daftar_Master_Obat.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Daftar Master Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 15;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 20);
$worksheet->setColumn (2, 2, 30);
$worksheet->setColumn (3, 3, 14);
$worksheet->setColumn (4, 4, 12);
$worksheet->setColumn (5, 5, 12);
$worksheet->setColumn (6, 6, 17);
$worksheet->setColumn (7, 7, 17);
$worksheet->setColumn (8, 8, 17);
$worksheet->setColumn (9, 9, 17);

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
$worksheet->write($row, 3, "DAFTAR MASTER OBAT", $sheetTitleFormat);
$row += 1;

//$worksheet->write($row, 2, "BULAN : $bln $tahun", $sheetTitleFormat);

//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$row += 1;

$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+3, "Satuan Kecil", $columnTitleFormat);
$worksheet->write($row, $column+4, "Bentuk", $columnTitleFormat);
$worksheet->write($row, $column+5, "Kelas", $columnTitleFormat);
$worksheet->write($row, $column+6, "Kategori", $columnTitleFormat);
$worksheet->write($row, $column+7, "Jenis", $columnTitleFormat);
$worksheet->write($row, $column+8, "Gol", $columnTitleFormat);
$worksheet->write($row, $column+9, "Habis Pakai", $columnTitleFormat);

//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;



	$status=$_GET['status'];
	$sorting=$_GET['sorting'];
	$page = $_GET['page'];
	$filter=$_REQUEST["filter"];

	if ($status == "") $status=1;
	$defaultsort = "OBAT_KODE desc";

	if ($sorting == "") $sorting = $defaultsort;
	
	if ($filter!=""){
	  	$tfilter=explode("*-*",$filter);
  		$filter="";
  		for ($k=0;$k<count($tfilter);$k++){
  			$ifilter=explode("|",$tfilter[$k]);
  			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
  		}
	}


	$sql="SELECT 
		   a_obat.*, 
           a_pabrik.PABRIK, 
           a_kelas.KLS_NAMA, 
           aoj.obat_jenis,
           aog.golongan,
           aok.kategori 
	  From a_obat 
	  LEFT JOIN a_pabrik ON a_obat.PABRIK_ID = a_pabrik.PABRIK_ID
	  LEFT JOIN a_kelas ON a_obat.KLS_ID = a_kelas.KLS_ID 
	  LEFT JOIN a_obat_kategori aok ON a_obat.OBAT_KATEGORI=aok.id 
	  LEFT JOIN a_obat_golongan aog ON a_obat.OBAT_GOLONGAN=aog.kode 
	  LEFT JOIN a_obat_jenis aoj ON a_obat.OBAT_KELOMPOK=aoj.obat_jenis_id 
	  WHERE OBAT_ISAKTIF= $status ".$filter." ORDER BY ".$sorting;

	/*
	if ($page=="") $page="1";
	$perpage=50;
	$tpage=($page-1)*$perpage;
	if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	if ($page>1) $bpage=$page-1; else $bpage=1;
	if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	*/
	//	$sql=$sql." limit $tpage,$perpage";
	//echo $sql;
	


	$rs=mysqli_query($konek,$sql);
	$i=1;

while ($rows=mysqli_fetch_array($rs)){

	$worksheet->write($row, 0, $i , $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_KODE'], $regularFormatC);
	$worksheet->write($row, 2, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 3, $rows['OBAT_SATUAN_KECIL'], $regularFormat);
	$worksheet->write($row, 4, $rows['OBAT_BENTUK'], $regularFormatR);
	$worksheet->write($row, 5, $rows['KLS_NAMA'], $regularFormatR);
	$worksheet->write($row, 6, $rows['kategori'], $regularFormat);
	$worksheet->write($row, 7, $rows['obat_jenis'], $regularFormat);
	$worksheet->write($row, 8, $rows['golongan'], $regularFormat);
	$worksheet->write($row, 9, ($rows['HABIS_PAKAI']==1?'Ya':'Tidak'), $regularFormat);

	$row++;$i++;
}

//$worksheet->write($row, 4, "TOTAL", $regularFormatR);
//$worksheet->write($row, 5, '=SUM(F5:F'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>