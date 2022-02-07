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

$tgl_d=$_REQUEST['tgl_d'];
$tgl_s=$_REQUEST['tgl_s'];
convert_var($tgl_d,$tgl_s);


$tgl_d1=tglSQL($tgl_d);
$tgl_s1=tglSQL($tgl_s);



$kpid=$_REQUEST['kpid'];
convert_var($tgl_d1,$tgl_s1,$kpid);

if($kpid==""){
	$kepemilikan="SEMUA";
	$kp="";
}
else{
	$kp=" AND k.ID=$kpid ";
	$s_k="select * from a_kepemilikan where ID=".$kpid;
	$q_k=mysqli_query($konek,$s_k);
	$r_k=mysqli_fetch_array($q_k);
	$kepemilikan=$r_k['NAMA'];
}

$filter=$_REQUEST['filter'];
$sorting=$_REQUEST['sorting'];

convert_var($filter,$sorting);

if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting=="") $sorting=$defaultsort;

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Daftar_Retur_Ke_PBF.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Retur Ke PBF');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 5);
$worksheet->setColumn (1, 1, 10);
$worksheet->setColumn (2, 2, 25);
$worksheet->setColumn (3, 3, 10);
$worksheet->setColumn (4, 4, 20);
$worksheet->setColumn (5, 5, 30);
$worksheet->setColumn (6, 6, 15);
$worksheet->setColumn (7, 7, 10);
$worksheet->setColumn (8, 8, 10);
$worksheet->setColumn (9, 9, 10);
$worksheet->setColumn (10, 10, 20);
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
$worksheet->write($row, 5, "DAFTAR RETUR KE PBF", $sheetTitleFormat);
$row++;
$worksheet->write($row, 5, "Periode : ".$_REQUEST['tgl_d']." s/d ".$_REQUEST['tgl_s'], $sheetTitleFormat);
$row++;
$worksheet->write($row, 5, "Kepemilikan : ".$kepemilikan, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tgl Return", $columnTitleFormat);
$worksheet->write($row, $column+2, "No Return", $columnTitleFormat);
$worksheet->write($row, $column+3, "Tgl Faktur", $columnTitleFormat);
$worksheet->write($row, $column+4, "No Faktur", $columnTitleFormat);
$worksheet->write($row, $column+5, "Obat", $columnTitleFormat);
$worksheet->write($row, $column+6, "Milik", $columnTitleFormat);
$worksheet->write($row, $column+7, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+8, "Harga", $columnTitleFormat);
$worksheet->write($row, $column+9, "Total", $columnTitleFormat);
$worksheet->write($row, $column+10, "Keterangan", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

$sql="SELECT ar.*,DATE_FORMAT(ap.TANGGAL,'%d/%m/%Y') AS tglfaktur,FLOOR(if(ap.NILAI_PAJAK=0,ap.HARGA_BELI_SATUAN,(ap.HARGA_BELI_SATUAN-(ap.HARGA_BELI_SATUAN*ap.DISKON/100))*(1+0.1))) AS aharga,ap.HARGA_BELI_SATUAN,ap.DISKON,a_pbf.PBF_NAMA, a_unit.UNIT_NAME, a_obat.OBAT_NAMA,k.NAMA, a_obat.OBAT_SATUAN_KECIL, ap.NOBUKTI 
FROM a_penerimaan_retur ar INNER JOIN a_penerimaan ap ON ar.PENERIMAAN_ID = ap.ID 
INNER JOIN a_pbf ON ar.PBF_ID = a_pbf.PBF_ID INNER JOIN a_obat ON ar.OBAT_ID = a_obat.OBAT_ID 
INNER JOIN a_unit ON ar.UNIT_ID = a_unit.UNIT_ID INNER JOIN a_kepemilikan k 
ON ar.KEPEMILIKAN_ID = k.ID 
WHERE ar.TGL BETWEEN '$tgl_d1' AND '$tgl_s1'".$kp.$filter." ORDER BY ".$sorting;
$queri=mysqli_query($konek,$sql);
$no=0;
$cpbf_id=0;
while($rows=mysqli_fetch_array($queri)){
	$no++;
	
	if ($cpbf_id!=$rows['PBF_ID']){
		$cpbf_id=$rows['PBF_ID'];
	
		$worksheet->write($row, $column, $rows['PBF_NAMA'], $regularFormatL);
		$worksheet->mergeCells($row,$column,$row,$column+3);
		$row++;
		$worksheet->write($row, $column, $no, $regularFormatC);
		$worksheet->write($row, $column+1, date("d/m/Y",strtotime($rows['TGL'])), $regularFormatC);
		$worksheet->write($row, $column+2, $rows['NO_RETUR'], $regularFormatC);
		$worksheet->write($row, $column+3, $rows['tglfaktur'], $regularFormatC);
		$worksheet->write($row, $column+4, $rows['NOBUKTI'], $regularFormatC);
		$worksheet->write($row, $column+5, $rows['OBAT_NAMA'], $regularFormatC);
		$worksheet->write($row, $column+6, $rows['NAMA'], $regularFormatC);
		$worksheet->write($row, $column+7, $rows['QTY'], $regularFormatC);
		$worksheet->write($row, $column+8, number_format($rows['aharga'],0,",","."), $regularFormatC);
		$worksheet->write($row, $column+9, number_format(floor($rows['QTY'] * $rows['aharga']),0,",","."), $regularFormatC);
		$worksheet->write($row, $column+10, $rows['KET'], $regularFormatC);
		$row++;
	}
	else{
		$worksheet->write($row, $column, $no, $regularFormatC);
		$worksheet->write($row, $column+1, date("d/m/Y",strtotime($rows['TGL'])), $regularFormatC);
		$worksheet->write($row, $column+2, $rows['NO_RETUR'], $regularFormatC);
		$worksheet->write($row, $column+3, $rows['tglfaktur'], $regularFormatC);
		$worksheet->write($row, $column+4, $rows['NOBUKTI'], $regularFormatC);
		$worksheet->write($row, $column+5, $rows['OBAT_NAMA'], $regularFormatC);
		$worksheet->write($row, $column+6, $rows['NAMA'], $regularFormatC);
		$worksheet->write($row, $column+7, $rows['QTY'], $regularFormatC);
		$worksheet->write($row, $column+8, number_format($rows['aharga'],0,",","."), $regularFormatC);
		$worksheet->write($row, $column+9, number_format(floor($rows['QTY'] * $rows['aharga']),0,",","."), $regularFormatC);
		$worksheet->write($row, $column+10, $rows['KET'], $regularFormatC);		
		$row++;
	}
	
}

/*$worksheet->write($row, 4, "TOTAL", $regularFormatR);
$worksheet->write($row, 5, '=SUM(F5:F'.$row.')', $regularFormatR);*/

$workbook->close();
//mysqli_free_result($rs);
mysqli_close($konek);
?>