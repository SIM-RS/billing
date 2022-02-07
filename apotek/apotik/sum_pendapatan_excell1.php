<?php 
// Koneksi =================================
include("../sesi.php"); 
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

$idunit1=$_REQUEST['idunit1'];
if ($idunit1=="0" || $idunit1=="1"){
	$idunit1="0";
	$kunit="";
	$unitn="ALL UNIT";
}else{
	$kunit=" UNIT_ID=$idunit1 AND ";
	$sql="select UNIT_NAME from a_unit where UNIT_ID=$idunit1";
	$rs=mysqli_query($konek,$sql);
	$u=mysqli_fetch_array($rs);
	$unitn=$u['UNIT_NAME'];
}

$defaultsort1="t2.TGL DESC,t2.SHIFT";
$defaultsort="t2.TGL,t2.SHIFT";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
//Sending HTTP headers
$workbook->send('Rekap_Penjualan_'.$unitn."_".$tgl_s1.'.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Rekap_Penjualan');
//Set a paper
$worksheet->setPaper(5);
//$worksheet->setLandscape();
$worksheet->setMargins_LR(0.25);
$worksheet->setMargins_TB(0.25);
//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 9);
$worksheet->setColumn (1, 1, 4);
$worksheet->setColumn (2, 2, 30);
$worksheet->setColumn (3, 3, 12);
$worksheet->setColumn (4, 4, 10);
$worksheet->setColumn (5, 5, 10);
$worksheet->setColumn (6, 6, 10);
$worksheet->setColumn (7, 7, 12);
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
$worksheet->write($row, 3, "LAPORAN REKAP PENJUALAN", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "UNIT : $unitn", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 3, "TGL : ".$tgl_d1." s/d ".$tgl_s1, $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, 0, "Tgl", $columnTitleFormat);
$worksheet->write($row, 1, "Shift", $columnTitleFormat);
$worksheet->write($row, 2, "KSO", $columnTitleFormat);
$worksheet->write($row, 3, "Milik", $columnTitleFormat);
$worksheet->write($row, 4, "Cara Bayar", $columnTitleFormat);
$worksheet->write($row, 5, "Tot Jual", $columnTitleFormat);
$worksheet->write($row, 6, "Tot Return", $columnTitleFormat);
$worksheet->write($row, 7, "Setoran", $columnTitleFormat);
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
	$filter=" WHERE ".substr($filter,5,strlen($filter)-5);
  }
  if ($sorting=="" or $sorting==$defaultsort1) $sorting=$defaultsort;
	$sql="SELECT DATE_FORMAT(t2.TGL,'%d/%m/%Y') AS TGL,t2.SHIFT,t2.NAMA,t2.KSO_ID,t2.KPID,t2.KPNAMA,t2.CARABAYAR_ID,t2.cara_bayar,SUM(t2.tot_jual) AS tot_jual,
		SUM(t2.tot_retur) AS tot_retur 
		FROM (SELECT t1.TGL,t1.SHIFT,t1.NAMA,t1.KSO_ID,t1.KPID,t1.KPNAMA,t1.CARABAYAR_ID,t1.cara_bayar,
		SUM(t1.tot_jual) AS tot_jual,tot_retur FROM 
		(SELECT TGL,TGL_ACT,NO_PENJUALAN,SHIFT,ap.KSO_ID,am.NAMA,ak.ID AS KPID,ak.NAMA AS KPNAMA,
		ac.id AS CARABAYAR_ID,ac.nama AS cara_bayar,FLOOR(HARGA_TOTAL) tot_jual,0 AS tot_retur 
		FROM a_penjualan ap INNER JOIN a_mitra am ON ap.KSO_ID=am.IDMITRA INNER JOIN a_cara_bayar ac ON ap.CARA_BAYAR=ac.id 
		INNER JOIN a_kepemilikan ak ON ap.JENIS_PASIEN_ID=ak.ID 
		WHERE ".$kunit."ap.TGL BETWEEN '$tgl_d' AND '$tgl_s' 
		GROUP BY SHIFT,NO_PENJUALAN,TGL,ap.KSO_ID,ap.UNIT_ID,ap.JENIS_PASIEN_ID,ap.CARA_BAYAR ORDER BY TGL_ACT DESC) AS t1 
		GROUP BY t1.TGL,t1.SHIFT,t1.NAMA,t1.KPNAMA,t1.cara_bayar
		UNION
		SELECT DATE(ar.tgl_retur) AS TGL,ar.shift_retur AS SHIFT,am1.NAMA,ap.KSO_ID,ap.JENIS_PASIEN_ID AS KPID,
		ak1.NAMA AS KPNAMA,ap.CARA_BAYAR AS CARABAYAR_ID,ac1.nama AS cara_bayar,0 AS tot_jual,SUM(ar.nilai) AS tot_retur 
		FROM a_return_penjualan ar INNER JOIN a_penjualan ap ON ar.idpenjualan=ap.ID INNER JOIN a_mitra am1 ON ap.KSO_ID=am1.IDMITRA 
		INNER JOIN a_kepemilikan ak1 ON ap.JENIS_PASIEN_ID=ak1.ID INNER JOIN a_cara_bayar ac1 ON ap.CARA_BAYAR=ac1.id 
		WHERE ".$kunit."DATE(ar.tgl_retur) BETWEEN '$tgl_d' AND '$tgl_s'
		GROUP BY DATE(ar.tgl_retur),ar.shift_retur,ap.KSO_ID,ap.UNIT_ID,ap.JENIS_PASIEN_ID,ap.CARA_BAYAR) AS t2".$filter."
		GROUP BY t2.TGL,t2.SHIFT,t2.KSO_ID,t2.KPID,t2.CARABAYAR_ID ORDER BY ".$sorting;
	//echo $sql."<br>";
$i=1;
$rowStart=$row+1;
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$ttot_jual=$rows["tot_jual"];
	$t_ret=$rows["tot_retur"];
	$tsetoran=$ttot_jual-$t_ret;
	$worksheet->write($row, 0, $rows['TGL'], $regularFormatC);
	$worksheet->write($row, 1, $rows['SHIFT'], $regularFormatC);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormat);
	$worksheet->write($row, 3, $rows['KPNAMA'], $regularFormatC);
	$worksheet->write($row, 4, $rows['cara_bayar'], $regularFormatC);
	$worksheet->write($row, 5, $ttot_jual, $regularFormatRF);
	$worksheet->write($row, 6, $t_ret, $regularFormatRF);
	$worksheet->write($row, 7, $tsetoran, $regularFormatRF);
	$row++;
	$i++;
}
$worksheet->write($row, 4, "Total", $regularFormatR);
$worksheet->write($row, 5, '=Sum(F'.$rowStart.':F'.$row.')', $regularFormatRF);
$worksheet->write($row, 6, '=Sum(G'.$rowStart.':G'.$row.')', $regularFormatRF);
$worksheet->write($row, 7, '=Sum(H'.$rowStart.':H'.$row.')', $regularFormatRF);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>