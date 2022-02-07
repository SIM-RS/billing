<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];

if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$unit_tujuan=$_REQUEST['unit_tujuan']; 
if($unit_tujuan=="") $unit_tujuan=$idunit;
if(($unit_tujuan=="0")||($unit_tujuan=="")) $unit_tj=""; else $unit_tj="UNIT_ID=$unit_tujuan AND ";
convert_var($idunit,$bulan,$ta,$minta_id,$unit_tujuan);

$unitn=$_REQUEST['unitn'];
$tgl_d=$_REQUEST['tgl_d'];
$d=explode("-",$tgl_d);
$tgl_de="$d[2]-$d[1]-$d[0]";
$tgl_s=$_REQUEST['tgl_s'];
$s=explode("-",$tgl_s);
$tgl_se="$s[2]-$s[1]-$s[0]";

convert_var($unitn,$tgl_de,$tgl_se);



//Paging,Sorting dan Filter==========
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($page,$sorting,$filter);
//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Stok_Opname'.$tgl_s.'.xls');

$worksheet=&$workbook->addWorksheet('Stok Opname');
$worksheet->setPaper("letter");
//$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 10;
$worksheet->setColumn (0, 0, 3);
$worksheet->setColumn (1, 1, 37);
$worksheet->setColumn (2, 2, 10);
$worksheet->setColumn (3, 3, 4);
$worksheet->setColumn (4, 4, 11);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 1, "LAPORAN STOK OPNAME OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+3, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+4, "Total", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }
  if ($sorting=="") $sorting=$defaultsort;
	if ($_GET['tgl_d']=='') $tgl_1=0; else $tgl_1=$tgl_de;
	if ($_GET['tgl_s']=='') $tgl_2=0; else $tgl_2=$tgl_se;
	$sql="SELECT ao.OBAT_NAMA,ak.NAMA,SUM(t1.DEBET) AS QTYOP,ah.HARGA_BELI_SATUAN,SUM(FLOOR(t1.DEBET * ah.HARGA_BELI_SATUAN)) AS NILAI FROM 
(SELECT * FROM a_kartustok WHERE ".$unit_tj."tipetrans=5 AND TGL_TRANS BETWEEN '$tgl_1' AND '$tgl_2') AS t1
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON t1.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID INNER JOIN 
a_harga ah ON (t1.OBAT_ID=ah.OBAT_ID AND t1.KEPEMILIKAN_ID=ah.KEPEMILIKAN_ID)".$filter." 
GROUP BY ao.OBAT_ID,ak.ID ORDER BY ".$sorting;

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$worksheet->write($row, 0, $row-3, $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['QTYOP'], $regularFormatR);
	$worksheet->write($row, 4, floor($rows['NILAI']), $regularFormatRF);
	$row++;
}
$worksheet->write($row, 2, "Sub Total", $regularFormatR);
$worksheet->write($row, 4, '=Sum(E5:E'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>