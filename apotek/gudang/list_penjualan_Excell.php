<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
convert_var($tglctk,$tgl,$tglact);
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit1=$_REQUEST['idunit1'];
$nunit1=$_REQUEST['nunit1'];
$kpid=$_REQUEST['kpid'];

if($kpid=="" OR $kpid=="0"){
	$jns_p="";
}else{
	$jns_p=" and a_kepemilikan.ID=$kpid";
}
$kso_id=$_REQUEST['kso_id'];
$status_inap=$_REQUEST['status_inap'];
convert_var($idunit1,$nunit1,$kpid,$kso_id,$status_inap);

if($kso_id=="" OR $kso_id=="0") $kso=""; else $kso=" and am.IDMITRA=$kso_id";
if($status_inap=="" OR $status_inap=="0") $status_i=""; else $status_i=" and a_unit.status_inap=$status_inap";

$k1=$_REQUEST['k1'];
$g1=$_REQUEST['g1'];
$j1=$_REQUEST['j1'];
convert_var($kso,$status_i,k1,g1,j1);

$tgld=$_REQUEST['tgld'];
$tgls=$_REQUEST['tgls'];
convert_var($tgld,$tgls);

$tgl_d=explode("-",$tgld);$tgl_d=$tgl_d[2]."-".$tgl_d[1]."-".$tgl_d[0];
$tgl_s=explode("-",$tgls);$tgl_s=$tgl_s[2]."-".$tgl_s[1]."-".$tgl_s[0];

//Paging,Sorting dan Filter======
$defaultsort="a_penjualan.TGL,a_penjualan.TGL_ACT,a_penjualan.NO_PENJUALAN";

$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($sorting,$filter);
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Lap_Penjualan_Apotek_'.$tgl_s.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Penjualan Apotek');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 10);
$worksheet->setColumn (1, 1, 8);
$worksheet->setColumn (2, 3, 8);
$worksheet->setColumn (4, 4, 25);
$worksheet->setColumn (5, 5, 8);
$worksheet->setColumn (6, 6, 12);
$worksheet->setColumn (7, 7, 18);
$worksheet->setColumn (8, 8, 18);
$worksheet->setColumn (9, 9, 5);
$worksheet->setColumn (10, 10, 12);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1));
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
$worksheet->write($row, 5, "LAPORAN PENJUALAN APOTEK", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "(".$tgl_d." - ".$tgl_s.")", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KEPEMILIKAN : $k1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "JENIS PASIEN : $g1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KSO : $j1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, $column, "Tgl", $columnTitleFormat);
$worksheet->write($row, $column+1, "No Jual", $columnTitleFormat);
$worksheet->write($row, $column+2, "No Resep", $columnTitleFormat);
$worksheet->write($row, $column+3, "No RM", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nama Pasien", $columnTitleFormat);
$worksheet->write($row, $column+5, "Cara Bayar", $columnTitleFormat);
$worksheet->write($row, $column+6, "Unit", $columnTitleFormat);
$worksheet->write($row, $column+7, "Ruangan (Poli)", $columnTitleFormat);
$worksheet->write($row, $column+8, "Dokter", $columnTitleFormat);
$worksheet->write($row, $column+9, "Shift", $columnTitleFormat);
$worksheet->write($row, $column+10, "Total", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

	  if ($filter!=""){
	  	$tfilter=explode("*-*",$filter);
		$filter="";
		for ($k=0;$k<count($tfilter);$k++){
			$ifilter=explode("|",$tfilter[$k]);
			$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
			//echo $filter."<br>";
		}
	  }

	if ($sorting=="") $sorting=$defaultsort;
  /*$sql="SELECT DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN, a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, 
a_kepemilikan.NAMA, a_unit.UNIT_NAME, au.UNIT_NAME AS UNIT_NAME1, a_penjualan.DOKTER, a_penjualan.SHIFT,ac.nama AS cara_bayar, 
(SUM(FLOOR(a_penjualan.QTY_JUAL*a_penjualan.HARGA_SATUAN))-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL
FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) 
INNER JOIN a_unit au ON a_penjualan.UNIT_ID=au.UNIT_ID INNER JOIN a_cara_bayar ac ON a_penjualan.CARA_BAYAR=ac.id 
INNER JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
WHERE (a_penjualan.TGL BETWEEN '$tgld' AND '$tgls') AND (au.UNIT_TIPE<>5)".$jns_p.$status_i.$kso.$filter." 
GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN ORDER BY ".$sorting;
*/
  $sql="SELECT DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN, a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, 
a_kepemilikan.NAMA, a_unit.UNIT_NAME, au.UNIT_NAME AS UNIT_NAME1, a_penjualan.DOKTER, a_penjualan.SHIFT,ac.nama AS cara_bayar, 
(a_penjualan.HARGA_TOTAL-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL2,
SUM((a_penjualan.QTY_JUAL - a_penjualan.QTY_RETUR) * a_penjualan.HARGA_SATUAN) AS HARGA_TOTAL
FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) 
INNER JOIN a_unit au ON a_penjualan.UNIT_ID=au.UNIT_ID INNER JOIN a_cara_bayar ac ON a_penjualan.CARA_BAYAR=ac.id 
INNER JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
WHERE (a_penjualan.TGL BETWEEN '$tgld' AND '$tgls') AND (au.UNIT_TIPE<>5)".$jns_p.$status_i.$kso.$filter." 
GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN ORDER BY ".$sorting;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	//$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, $rows['tgl1'], $regularFormatC);
	$worksheet->write($row, 1, $rows['NO_PENJUALAN'], $regularFormatC);
	$worksheet->write($row, 2, $rows['NO_RESEP'], $regularFormatC);
	$worksheet->write($row, 3, $rows['NO_PASIEN'], $regularFormatC);
	$worksheet->write($row, 4, $rows['NAMA_PASIEN'], $regularFormat);
	$worksheet->write($row, 5, $rows['cara_bayar'], $regularFormatC);
	$worksheet->write($row, 6, $rows['UNIT_NAME1'], $regularFormatC);
	$worksheet->write($row, 7, $rows['UNIT_NAME'], $regularFormatC);
	$worksheet->write($row, 8, $rows['DOKTER'], $regularFormatC);
	$worksheet->write($row, 9, $rows['SHIFT'], $regularFormatC);
	$worksheet->write($row, 10, $rows['HARGA_TOTAL'], $regularFormatR);
	$row++;
}
$worksheet->write($row, 8, "TOTAL", $regularFormatR);
$worksheet->write($row, 10, '=Sum(K7:K'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>