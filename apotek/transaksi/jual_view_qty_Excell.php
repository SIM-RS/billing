<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit1=$_REQUEST['idunit1'];
$nunit1=$_REQUEST['nunit1'];
$tgl_d1=$_REQUEST['tgl_d1'];
$tgl_s1=$_REQUEST['tgl_s1'];
$tgl_d=explode("-",$tgl_d1);$tgl_d=$tgl_d[2]."/".$tgl_d[1]."/".$tgl_d[0];
$tgl_s=explode("-",$tgl_s1);$tgl_s=$tgl_s[2]."/".$tgl_s[1]."/".$tgl_s[0];

convert_var($tgl_d1,$tgl_s1,$tgl2,$idunit1);
convert_var($tgl_d,$tgl_s);
//Paging,Sorting dan Filter======
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
convert_var($kelas,$golongan,$jenis);

if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}

convert_var($fkelas,$fgolongan,$fjenis);
$k1=$_REQUEST['k1'];
$g1=$_REQUEST['g1'];
$j1=$_REQUEST['j1'];
convert_var($k1,$g1,$j1);
convert_var($page,$sorting,$filter,$act);

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Pemakaian_Per_Unit.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Pemakaian Obat');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 35);
$worksheet->setColumn (2, 2, 14);
$worksheet->setColumn (3, 3, 8);
$worksheet->setColumn (4, 4, 12);
$worksheet->setColumn (5, 5, 8);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
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
$worksheet->write($row, 1, "LAPORAN PEMAKAIAN OBAT", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "UNIT : $nunit1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "KELAS : $k1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "GOLONGAN : $g1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "JENIS : $j1", $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "(".$tgl_d." - ".$tgl_s.")", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
$worksheet->write($row, $column+3, "Qty", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
$worksheet->write($row, $column+5, "Sisa Stok", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
  }
  if ($sorting=="") $sorting=$defaultsort;
  
  $sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA,t1.*,
	   (SELECT STOK_AFTER FROM a_kartustok WHERE `TGL_TRANS` BETWEEN'$tgl_d1' AND '$tgl_s1' AND UNIT_ID = $idunit1 AND OBAT_ID=t1.OBAT_ID ORDER BY ID DESC LIMIT 1 ) stok_sisa FROM a_obat ao INNER JOIN 
	(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
	SUM(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) AS `QTY`,
	SUM(FLOOR((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
	FROM (`a_penerimaan` INNER JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
	WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`) AND (a_penjualan.UNIT_ID=$idunit1)) 
	GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
	INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID".$filter.$fkelas.$fgolongan.$fjenis." ORDER BY ".$sorting;

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
	$worksheet->write($row, 3, $rows['QTY'], $regularFormatR);
	$worksheet->write($row, 4, $rows['TOTAL'], $regularFormatR);
	$worksheet->write($row, 5, $rows['stok_sisa'], $regularFormatR);
	$row++;
}
$worksheet->write($row, 2, "TOTAL", $regularFormatR);
$worksheet->write($row, 4, '=Sum(E8:E'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>