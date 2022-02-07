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
$tgl_s=$_REQUEST['tgl_s'];
convert_var($tglctk,$tgl,$tglact,$tgl_d,$tgl_s);

$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];

$idunit1=$_REQUEST['idunit1'];
$jns_pasien=$_REQUEST['jns_pasien'];
$statuspasien=$_REQUEST['statuspasien'];
convert_var($tgl_d1,$tgl_s1,$idunit1,$jns_pasien,$statuspasien);

if($idunit1=="0" OR $idunit1=="1") $junit=" AND a.UNIT_ID<>20"; else $junit=" AND a.UNIT_ID=$idunit1";
if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p=" and a_kepemilikan.ID=$jns_pasien";
if($statuspasien=="" OR $statuspasien=="0") $statusp=""; else $statusp=" and (pel.jenis_kunjungan=$statuspasien)";
$jp=$_REQUEST['jp'];
$sp=$_REQUEST['sp'];
convert_var($junit,$jns_p,$statusp,$jp,$sp);

$defaultsort="a_penjualan.NO_PENJUALAN DESC";
$unitn="ALL UNIT";
if ($idunit1!="0"){
	$sql="SELECT * FROM a_unit WHERE UNIT_ID=".$idunit1;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$unitn=strtoupper($rows["UNIT_NAME"]);
	}
}

if ($idunit1=="0"){
	$tmpunit="";
 }else{
	$tmpunit="(a_penjualan.UNIT_ID = $idunit1) AND ";
 }
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($sorting,$filter);
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
//Sending HTTP headers
$workbook->send('Lap_Penjualan_'.$tgl_s.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Lap_Penjualan');
//Set a paper
$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.25);
$worksheet->setMargins_TB(0.25);
//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 3);
$worksheet->setColumn (1, 1, 8);
$worksheet->setColumn (2, 2, 6);
$worksheet->setColumn (3, 3, 6);
$worksheet->setColumn (4, 4, 7);
$worksheet->setColumn (5, 5, 14);
$worksheet->setColumn (6, 6, 6);
$worksheet->setColumn (7, 7, 12);
$worksheet->setColumn (8, 8, 14);
$worksheet->setColumn (9, 9, 5);
$worksheet->setColumn (10, 11, 8);
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
$regularFormatRNoWrap =& $workbook->addFormat(array('size'=>8,'align'=>'right'));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 6, "LAPORAN PENJUALAN", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "KEPEMILIKAN : $jp", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "JENIS PASIEN : $sp", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 6, "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tgl", $columnTitleFormat);
$worksheet->write($row, $column+2, "No Penj", $columnTitleFormat);
$worksheet->write($row, $column+3, "No Resep", $columnTitleFormat);
$worksheet->write($row, $column+4, "No RM", $columnTitleFormat);
$worksheet->write($row, $column+5, "Nama Pasien", $columnTitleFormat);
$worksheet->write($row, $column+6, "Cara Bayar", $columnTitleFormat);
$worksheet->write($row, $column+7, "KSO", $columnTitleFormat);
$worksheet->write($row, $column+8, "Poli (Ruangan)", $columnTitleFormat);
$worksheet->write($row, $column+9, "Shift", $columnTitleFormat);
$worksheet->write($row, $column+10, "Netto", $columnTitleFormat);
$worksheet->write($row, $column+11, "H. Tatal", $columnTitleFormat);
$worksheet->write($row, $column+12, "PPN", $columnTitleFormat);
$worksheet->write($row, $column+13, "H. Total + PPN", $columnTitleFormat);
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
	
	$sql="SELECT DATE_FORMAT(a_penjualan.TGL,'%d/%m/%Y') AS tgl1,a_penjualan.TGL,a_penjualan.UNIT_ID, a_penjualan.NO_PENJUALAN,am.NAMA AS KSO, 
		a_penjualan.NO_RESEP, a_penjualan.NO_PASIEN, a_penjualan.NAMA_PASIEN, a_penjualan.USER_ID, 
		a_kepemilikan.NAMA, a_unit.UNIT_NAME, a_penjualan.DOKTER, a_penjualan.SHIFT, a_penjualan.CARA_BAYAR,ac.nama AS cbayar, 
		a_penjualan.UTANG,SUM(FLOOR((a_penjualan.QTY_JUAL-a_penjualan.QTY_RETUR)*a_penjualan.HARGA_NETTO)) AS HARGA_NETTO,
		(a_penjualan.HARGA_TOTAL-SUM(FLOOR(a_penjualan.QTY_RETUR*a_penjualan.HARGA_SATUAN*((100-a_penjualan.BIAYA_RETUR)/100)))) AS HARGA_TOTAL2,
		SUM((a_penjualan.QTY_JUAL) * a_penjualan.HARGA_SATUAN) AS HARGA_TOTAL,
		FLOOR((a_penjualan.PPN/100) * SUM(a_penjualan.QTY_JUAL* a_penjualan.HARGA_SATUAN)) AS PPN_NILAI,
		SUM(a_penjualan.QTY_RETUR) as jRetur
		FROM a_penjualan LEFT JOIN a_unit ON (a_penjualan.RUANGAN = a_unit.UNIT_ID) 
		INNER JOIN a_kepemilikan ON (a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID) 
		INNER JOIN a_unit au ON a_penjualan.UNIT_ID=au.UNIT_ID 
		INNER JOIN a_cara_bayar ac ON a_penjualan.CARA_BAYAR=ac.id 
		LEFT JOIN a_mitra am ON a_penjualan.KSO_ID=am.IDMITRA 
		left join rspelindo_billing.b_pelayanan pel on a_penjualan.NO_KUNJUNGAN=pel.id 
		WHERE $tmpunit (a_penjualan.TGL BETWEEN '$tgl_d1' AND '$tgl_s1')".$jns_p.$statusp.$kso.$filter." 
		GROUP BY a_penjualan.NO_PENJUALAN,a_penjualan.UNIT_ID,a_penjualan.NAMA_PASIEN,a_penjualan.USER_ID ORDER BY ".$sorting;
$i=1;
$rowStart=$row+1;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){

	if($rows['SHIFT']==1){
	$s='Pagi';
	}elseif($rows['SHIFT']==2){
	$s='Siang';
	}else{
	$s='Malam';}

	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rows['tgl1'], $regularFormatC);
	$worksheet->write($row, 2, $rows['NO_PENJUALAN'], $regularFormatC);
	$worksheet->write($row, 3, $rows['NO_RESEP'], $regularFormatC);
	$worksheet->write($row, 4, $rows['NO_PASIEN'], $regularFormatC);
	$worksheet->write($row, 5, $rows['NAMA_PASIEN'], $regularFormat);
	$worksheet->write($row, 6, $rows['cbayar'], $regularFormatC);
	$worksheet->write($row, 7, $rows['KSO'], $regularFormatC);
	$worksheet->write($row, 8, $rows['UNIT_NAME'], $regularFormatC);
	$worksheet->write($row, 9, $s , $regularFormatC);
	$worksheet->write($row, 10, $rows['HARGA_NETTO'], $regularFormatRF);
	$worksheet->write($row, 11, $rows['HARGA_TOTAL'], $regularFormatRF);
	$worksheet->write($row, 12, $rows['PPN_NILAI'], $regularFormatRF);
	$worksheet->write($row, 13, $rows['HARGA_TOTAL']+$rows['PPN_NILAI'], $regularFormatRF);
	$row++;
	$i++;
}
$worksheet->write($row, 9, "Total", $regularFormatRNoWrap);
$worksheet->write($row, 10, '=Sum(K'.$rowStart.':K'.$row.')', $regularFormatRF);
$worksheet->write($row, 11, '=Sum(L'.$rowStart.':L'.$row.')', $regularFormatRF);
$worksheet->write($row, 12, '=Sum(M'.$rowStart.':M'.$row.')', $regularFormatRF);
$worksheet->write($row, 13, '=Sum(N'.$rowStart.':N'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>