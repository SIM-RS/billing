<?php 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$kso = $_REQUEST['kso'];
$kson = $_REQUEST['kson'];
if ($kso=="0") $kson="SEMUA";
$ckso = $kso;
$tipe=$_REQUEST['tipe'];
$unit_id=$_REQUEST['unit_id'];
$unitN=$_REQUEST['unitN'];
$jenis_layananN=$_REQUEST['jenis_layananN'];
$inap=$_REQUEST['inap'];
$tgl_d=tglSQL($_REQUEST['tgl_d']);

//Paging,Sorting dan Filter======
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
//===============================
require_once('../Excell/Writer.php');

$workbook = new Spreadsheet_Excel_Writer();
$workbook->send('Penerimaan_Tunai_'.tglSQL($tgl_d).'.xls');

$worksheet=&$workbook->addWorksheet('Penerimaan Billing');
$worksheet->setPaper("letter");
//$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.2);
$worksheet->setMargins_TB(0.2);
$columnWidth = 10;

$worksheet->setColumn (0, 0, 3);
$worksheet->setColumn (1, 2, 9);
$worksheet->setColumn (3, 3, 8);
$worksheet->setColumn (4, 5, 20);
$worksheet->setColumn (6, 6, 10);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>10,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>8,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>8,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>8,'align'=>'center','textWrap'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center'));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right'));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left'));
$sTotFormatCF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'center','textWrap'=>1,'numFormat'=>'#,##0'));
$sTotFormatRF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));
$sTotFormatLF =& $workbook->addFormat(array('bold'=>1,'size'=>8,'align'=>'left','textWrap'=>1,'numFormat'=>'#,##0'));
$regularFormat =& $workbook->addFormat(array('size'=>8,'align'=>'left','textWrap'=>1));
$regularFormatC =& $workbook->addFormat(array('size'=>8,'align'=>'center','textWrap'=>1));
$regularFormatR =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1));
$regularFormatRF =& $workbook->addFormat(array('size'=>8,'align'=>'right','textWrap'=>1,'numFormat'=>'#,##0'));

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 4, "LAPORAN PENERIMAAN TUNAI", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "KSO : $kson", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "TGL : ".tglSQL($tgl_d), $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "JENIS LAYANAN : ".$jenis_layananN, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 4, "TEMPAT LAYANAN : ".$unitN, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;

$worksheet->write($row, $column, "No", $columnTitleFormat);
$worksheet->write($row, $column+1, "Tgl Kunjungan", $columnTitleFormat);
$worksheet->write($row, $column+2, "Tgl Pulang", $columnTitleFormat);
$worksheet->write($row, $column+3, "No RM", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nama", $columnTitleFormat);
$worksheet->write($row, $column+5, "Tempat Layanan", $columnTitleFormat);
$worksheet->write($row, $column+6, "Penerimaan", $columnTitleFormat);

$row += 1;
//Write each datapoint to the sheet starting one row beneath
//$row=0;
/*  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }*/
if ($sorting=="") {
	$sorting=$defaultsort;
}

$waktu = " and b.tgl = '$tgl_d' ";

if($inap == 0){
	 //non-inap
	$kso = " AND t.kso_id='$kso' ";
	
	 $sql = "SELECT * FROM (SELECT k.id,t2.unit_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglK,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tglP,
mp.no_rm,mp.nama pasien,mu.nama AS unit,SUM(t2.nilai) bayar
FROM (SELECT t1.*,p.kunjungan_id,p.unit_id FROM (SELECT bt.* FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
WHERE bt.tipe=0 AND bt.nilai>0 $waktu) AS t1 INNER JOIN $dbbilling.b_tindakan t ON t1.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id WHERE p.unit_id='$unit_id' $kso) AS t2
INNER JOIN $dbbilling.b_ms_unit mu ON t2.unit_id=mu.id INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id
INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id GROUP BY k.id) AS t3 $filter order by $sorting";
}else{
	 //inap
	$ksoP = " and p.kso_id = '$kso' ";
	$kso = " AND t.kso_id='$kso' ";
	 
	$sql="SELECT * FROM (SELECT k.id,t2.*,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglK,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tglP,mp.no_rm,mp.nama AS pasien,
mu.nama unit FROM (SELECT t1.kunjungan_id,$unit_id AS unit_id,IFNULL(SUM(t1.nilai),0) AS bayar 
FROM (SELECT bt.id,b.kunjungan_id,bt.nilai FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
WHERE bt.tipe=0 $waktu $kso AND p.unit_id='$unit_id'
UNION
SELECT bt.id,b.kunjungan_id,bt.nilai FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan_kamar t ON bt.tindakan_id=t.id INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
WHERE bt.tipe=1 $waktu $ksoP AND p.unit_id='$unit_id') AS t1 GROUP BY t1.kunjungan_id) AS t2 
INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN $dbbilling.b_ms_unit mu ON t2.unit_id=mu.id) AS t3 $filter order by $sorting";
}
//echo $sql."<br>";
$rs=mysql_query($sql);
$i=0;
$tmpLay = '';
while ($rows=mysql_fetch_array($rs)){
	$i++;
	$tmpLay = $rows['unit'];

	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rows["tglK"], $regularFormatC);
	$worksheet->write($row, 2, $rows["tglP"], $regularFormatC);
	$worksheet->write($row, 3, $rows["no_rm"], $regularFormatC);
	$worksheet->write($row, 4, $rows["pasien"], $regularFormat);
	$worksheet->write($row, 5, $tmpLay, $regularFormat);
	$worksheet->write($row, 6, $rows["bayar"], $regularFormatRF);
	$row++;
	$tmpLay = '';
}

$worksheet->write($row, 5, "Sub Total", $sTotFormatR);
$worksheet->write($row, 6, '=Sum(G7:G'.$row.')', $sTotFormatRF);
	
$workbook->close();
mysql_free_result($rs);
mysql_close($konek);
?>