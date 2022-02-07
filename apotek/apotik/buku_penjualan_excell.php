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
convert_var($tglctk,$tgl,$tglact,$tgl_s,$tgl_d);
$tgl_d1=explode("-",$tgl_d);
$tgl_d1=$tgl_d1[2]."-".$tgl_d1[1]."-".$tgl_d1[0];
$tgl_s1=explode("-",$tgl_s);
$tgl_s1=$tgl_s1[2]."-".$tgl_s1[1]."-".$tgl_s1[0];
$idunit1=$_REQUEST['idunit1'];
$kso_id=$_REQUEST['kso_id'];
convert_var($tgl_d1,$tgl_s1,$idunit1);
if($idunit1=="0" OR $idunit1=="1") $junit=" AND a.UNIT_ID<>20"; else $junit=" AND a.UNIT_ID=$idunit1";
$jns_pasien=$_REQUEST['jns_pasien'];
$kategori=$_REQUEST['kategori'];
convert_var($jns_pasien,$kategori);
if($jns_pasien=="" OR $jns_pasien=="0") $jns_p=""; else $jns_p=" and u.status_inap=$jns_pasien";
if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";
if($kso_id=="0"){ $fkso="";} else{ $fkso=" AND a.KSO_ID=$kso_id";}
$defaultsort="a.TGL DESC,a.ID DESC";
$unitn="ALL UNIT";


if ($idunit1!="0"){
	$sql="SELECT * FROM a_unit WHERE UNIT_ID=".$idunit1;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$unitn=$rows["UNIT_NAME"];
	}
}
$kso = "All KSO";
if ($kso_id!="0"){
	$sql="SELECT * FROM a_mitra WHERE idmitra=".$kso_id;
	//echo $sql;
	$rs=mysqli_query($konek,$sql);
	if ($rows=mysqli_fetch_array($rs)){
		$kso=$rows["NAMA"];
	}
}

$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
convert_var($sorting,$filter);
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
$worksheet->setColumn (1, 1, 8);
$worksheet->setColumn (2, 2, 8);
$worksheet->setColumn (3, 3, 14);
$worksheet->setColumn (4, 4, 14);
$worksheet->setColumn (5, 5, 10);
$worksheet->setColumn (6, 6, 10);
$worksheet->setColumn (7, 7, 4);
$worksheet->setColumn (8, 8, 8);
$worksheet->setColumn (9, 10, 14);
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
$worksheet->write($row, 5, "LAPORAN BUKU PENJUALAN", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "KSO : $kso", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 5, "TGL : ".$tgl_d." s/d ".$tgl_s, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tgl", $columnTitleFormat);
$worksheet->write($row, $column+2, "No Penjualan", $columnTitleFormat);
$worksheet->write($row, $column+3, "Nama Pasien", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+5, "Kategori", $columnTitleFormat);
$worksheet->write($row, $column+6, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+7, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+8, "Harga", $columnTitleFormat);
$worksheet->write($row, $column+9, "Poli (Ruangan)", $columnTitleFormat);
$worksheet->write($row, $column+10, "Dokter", $columnTitleFormat);
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

/* $sql="SELECT DATE_FORMAT(a.TGL,'%d/%m/%Y') AS tgl1,ok.kategori,a.NO_PENJUALAN,a.NAMA_PASIEN,ao.OBAT_NAMA,SUM(a.QTY_JUAL-a.QTY_RETUR) AS QTY_JUAL,ak.NAMA,u.UNIT_NAME,SUM(a.QTY_JUAL-a.QTY_RETUR)*HARGA_SATUAN AS H_JUAL,a.DOKTER FROM a_penjualan a INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID=ap.ID INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON a.JENIS_PASIEN_ID=ak.ID LEFT JOIN (SELECT * FROM a_unit WHERE UNIT_TIPE=3) AS u ON a.RUANGAN=u.UNIT_ID 
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
WHERE a.TGL BETWEEN '$tgl_d1' AND '$tgl_s1'".$junit.$jns_p.$filter.$fkategori." GROUP BY a.NO_PENJUALAN,a.TGL,ap.OBAT_ID ORDER BY ".$sorting; */

$sql = "SELECT 
			  DATE_FORMAT(a.TGL, '%d/%m/%Y') AS tgl1,
			  a.NO_PENJUALAN, ok.kategori, a.NAMA_PASIEN, ao.OBAT_NAMA,
			  SUM(a.QTY_JUAL - a.QTY_RETUR) AS QTY_JUAL,
			  ak.NAMA, u.UNIT_NAME,
			  SUM((a.QTY_JUAL - a.QTY_RETUR) * a.HARGA_SATUAN) AS H_JUAL,
			  a.DOKTER, ao.OBAT_ID, a.ID
			FROM
			  a_penjualan a 
			  INNER JOIN a_penerimaan ap ON a.PENERIMAAN_ID = ap.ID 
			  LEFT JOIN a_obat ao ON ap.OBAT_ID = ao.OBAT_ID 
			  INNER JOIN a_kepemilikan ak ON a.JENIS_PASIEN_ID = ak.ID 
			  LEFT JOIN (SELECT * FROM a_unit WHERE UNIT_TIPE = 3) AS u ON a.RUANGAN = u.UNIT_ID 
			  LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI 
			WHERE a.TGL BETWEEN '{$tgl_d1}' AND '{$tgl_s1}'".$junit.$jns_p.$fkso.$filter.$fkategori."
			GROUP BY a.NO_PENJUALAN, ap.OBAT_ID
			ORDER BY ".$sorting;
$i=1;
$rowStart=$row+1;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rows['tgl1'], $regularFormatC);
	$worksheet->write($row, 2, $rows['NO_PENJUALAN'], $regularFormatC);
	$worksheet->write($row, 3, $rows['NAMA_PASIEN'], $regularFormat);
	$worksheet->write($row, 4, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 5, $rows['kategori'], $regularFormatC);
	$worksheet->write($row, 6, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 7, $rows['QTY_JUAL'], $regularFormatC);
	$worksheet->write($row, 8, $rows['H_JUAL'], $regularFormatRF);
	$worksheet->write($row, 9, $rows['UNIT_NAME'], $regularFormatC);
	$worksheet->write($row, 10, $rows['DOKTER'], $regularFormatC);
	$row++;
	$i++;
}
$worksheet->write($row, 6, "Total", $regularFormatR);
$worksheet->write($row, 7, '=SUM(H'.$rowStart.':H'.$row.')', $regularFormatRF);
$worksheet->write($row, 8, '=SUM(I'.$rowStart.':I'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>