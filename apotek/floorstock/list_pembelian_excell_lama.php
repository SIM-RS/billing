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
$tgl_d=$_REQUEST['tgl_d'];
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s=$_REQUEST['tgl_s'];
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];

$idunit=$_REQUEST["idunit"];
$unit_tj=$_REQUEST['unit_tujuan'];

$defaultsort="a_penerimaan.ID desc";
$unitn="ALL UNIT";
if ($unit_tj!="0" && $unit_tj!=""){
	$sql="SELECT * FROM a_unit WHERE UNIT_ID=".$unit_tj;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$unitn=$rows["UNIT_NAME"];
	}
	
	$unit_tj="and a_penerimaan.UNIT_ID_TERIMA=$unit_tj";
}else{
	$unit_tj="";
}

$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
//Sending HTTP headers
$workbook->send('Buku_Penjualan_'.$tgl_s.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Buku_Penjualan');
//Set a paper
$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.25);
$worksheet->setMargins_TB(0.25);
//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 3);
$worksheet->setColumn (1, 1, 9);
$worksheet->setColumn (2, 2, 22);
$worksheet->setColumn (3, 3, 11);
$worksheet->setColumn (4, 4, 18);
$worksheet->setColumn (5, 5, 5);
$worksheet->setColumn (6, 6, 8);
$worksheet->setColumn (7, 7, 8);
$worksheet->setColumn (8, 9, 14);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>11,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>9,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>9,'align'=>'center','fgcolor'=>'grey','pattern'=>1,'textWrap'=>1,'vAlign'=>'vcenter'));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 3, "DAFTAR PENGIRIMAN OBAT KE RUANGAN/POLI", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tgl", $columnTitleFormat);
$worksheet->write($row, $column+2, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+3, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+4, "Ruangan", $columnTitleFormat);
$worksheet->write($row, $column+5, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+6, "Sub Total Beli", $columnTitleFormat);
$worksheet->write($row, $column+7, "Harga Jual", $columnTitleFormat);
$worksheet->write($row, $column+8, "Sub Total Jual", $columnTitleFormat);
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

$sql="SELECT TANGGAL,DATE_FORMAT(TANGGAL_ACT,'%d-%m-%Y') tgl1,NAMA,OBAT_NAMA,SUM(QTY_JUAL) AS QTY_SATUAN,HARGA_BELI_SATUAN,
			FLOOR(IF (NILAI_PAJAK>0,SUM(HARGA_BELI_TOTAL-(DISKON/100*HARGA_BELI_TOTAL)+(10/100*(HARGA_BELI_TOTAL-(DISKON/100*HARGA_BELI_TOTAL)))),SUM(HARGA_BELI_TOTAL-(DISKON/100*HARGA_BELI_TOTAL)))) AS HARGA_BELI_TOTAL,FLOOR(HARGA_SATUAN) AS HARGA_SATUAN,SUM(FLOOR(HARGA_SATUAN)*QTY_JUAL) AS SUB_TOTAL,UNIT_NAME 
			FROM a_penerimaan INNER JOIN a_obat ON a_penerimaan.OBAT_ID=a_obat.OBAT_ID 
			INNER JOIN a_kepemilikan ON a_penerimaan.KEPEMILIKAN_ID=a_kepemilikan.ID INNER JOIN a_unit 
			ON a_penerimaan.UNIT_ID_TERIMA=a_unit.UNIT_ID INNER JOIN a_penjualan ON a_penerimaan.ID=a_penjualan.PENERIMAAN_ID 
			WHERE a_penerimaan.UNIT_ID_KIRIM=$idunit AND TANGGAL BETWEEN '$tgl_d1' AND '$tgl_s1'" .$unit_tj.$filter." 
			GROUP BY a_penerimaan.OBAT_ID,TANGGAL,NOKIRIM ORDER BY ".$sorting;
$i=1;
$rowStart=$row+1;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rows['tgl1'], $regularFormatC);
	$worksheet->write($row, 2, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 3, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 4, $rows['UNIT_NAME'], $regularFormatC);
	$worksheet->write($row, 5, $rows['QTY_SATUAN'], $regularFormatC);
	$worksheet->write($row, 6, $rows['HARGA_BELI_TOTAL'], $regularFormatRF);
	$worksheet->write($row, 7, $rows['HARGA_SATUAN'], $regularFormatRF);
	$worksheet->write($row, 8, $rows['SUB_TOTAL'], $regularFormatRF);
	$row++;
	$i++;
}
$worksheet->write($row, 4, "Total", $regularFormatR);
$worksheet->write($row, 5, '=Sum(F'.$rowStart.':F'.$row.')', $regularFormatRF);
$worksheet->write($row, 6, '=Sum(G'.$rowStart.':G'.$row.')', $regularFormatRF);
$worksheet->write($row, 8, '=Sum(I'.$rowStart.':I'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>