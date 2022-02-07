<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$tgl_d1=$_REQUEST['tgl_d1'];
$tgl_s1=$_REQUEST['tgl_s1'];
convert_var($tgl_d1,$tgl_s1);

$tgl_d=explode("-",$tgl_d1);$tgl_d=$tgl_d[2]."/".$tgl_d[1]."/".$tgl_d[0];
$tgl_s=explode("-",$tgl_s1);$tgl_s=$tgl_s[2]."/".$tgl_s[1]."/".$tgl_s[0];
$flimit=$_REQUEST['flimit'];
$tipe=$_REQUEST['tipe'];
convert_var($tgl_d,$tgl_d,$flimit,$tipe);

if ($tipe=="1"){
	$jdl="LAPORAN OBAT FAST MOVING";
	$kriteria=$flimit." PENJUALAN TERBANYAK";
	$sorting="QTY_TOTAL DESC";
}elseif ($tipe=="2"){
	$jdl="LAPORAN OBAT SLOW MOVING";
	$kriteria=$flimit." PENJUALAN TERKECIL";
	$sorting="QTY_TOTAL";
}
//Paging,Sorting dan Filter======
$defaultsort="QTY_TOTAL DESC";
$sorting="QTY_TOTAL DESC";
if ($sorting=="t2.OBAT_NAMA,t2.NAMA") $sorting=$defaultsort;
$filter=$_REQUEST["filter"];
//===============================
$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];

convert_var($filter,$kelas,$golongan,$jenis);

if ($kelas=="") $fkelas=""; else{ if ($filter=="") $fkelas=" WHERE kls.KLS_KODE LIKE '".$kelas."%'"; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";}
if ($golongan=="") $fgolongan=""; else{ if (($filter=="")&&($kelas=="")) $fgolongan=" WHERE ao.OBAT_GOLONGAN='$golongan'"; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";}
if ($jenis=="") $fjenis=""; else { if (($filter=="")&&($fkelas=="")&&($fgolongan=="")) $fjenis=" WHERE ao.OBAT_KELOMPOK=$jenis"; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";}
convert_var($fkelas,$fgolongan,$fjenis);

$k1=$_REQUEST['k1'];
$g1=$_REQUEST['g1'];
$j1=$_REQUEST['j1'];
convert_var($k1,$g1,$j1);

require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();
if ($tipe=="1"){
	//Sending HTTP headers
	$workbook->send('Fast_Moving.xls');
	
	//Creating a worksheet
	$worksheet=&$workbook->addWorksheet('Fast_Moving');
}elseif ($tipe=="2"){
	//Sending HTTP headers
	$workbook->send('Slow_Moving.xls');
	
	//Creating a worksheet
	$worksheet=&$workbook->addWorksheet('Slow_Moving');
}
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 12);
$worksheet->setColumn (1, 1, 50);
$worksheet->setColumn (2, 2, 12);
$worksheet->setColumn (3, 3, 8);
$worksheet->setColumn (4, 4, 12);
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
$worksheet->write($row, 1, $jdl, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, $kriteria, $sheetTitleFormat);
$row += 1;
$worksheet->write($row, 1, "(".$tgl_d." - ".$tgl_s.")", $sheetTitleFormat);
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$row += 1;
$worksheet->write($row, $column, "Kode Obat", $columnTitleFormat);
$worksheet->write($row, $column+1, "Nama Obat", $columnTitleFormat);
$worksheet->write($row, $column+2, "Kepemilikan", $columnTitleFormat);
/*$worksheet->write($row, $column+3, "AP1", $columnTitleFormat);
$worksheet->write($row, $column+4, "AP2", $columnTitleFormat);
$worksheet->write($row, $column+5, "AP3", $columnTitleFormat);
$worksheet->write($row, $column+6, "AP4", $columnTitleFormat);
$worksheet->write($row, $column+7, "AP5", $columnTitleFormat);
$worksheet->write($row, $column+8, "AP6", $columnTitleFormat);
$worksheet->write($row, $column+9, "AP7", $columnTitleFormat);
$worksheet->write($row, $column+10, "AP8", $columnTitleFormat);
$worksheet->write($row, $column+11, "AP10", $columnTitleFormat);
$worksheet->write($row, $column+12, "AP11", $columnTitleFormat);
$worksheet->write($row, $column+13, "FS", $columnTitleFormat);*/
$worksheet->write($row, $column+3, "Total", $columnTitleFormat);
$worksheet->write($row, $column+4, "Nilai", $columnTitleFormat);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;
  if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
  }
  
/*	  $sql="SELECT * FROM 
(SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ak.NAMA,t1.*,t1.AP1+t1.AP2+t1.AP3+t1.AP4+t1.AP5+t1.AP6+t1.AP7+t1.AP8+t1.AP10+t1.AP11+t1.FS AS QTY_TOTAL FROM a_obat ao INNER JOIN 
			(SELECT `a_penerimaan`.`OBAT_ID` AS `OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID` AS `KEPEMILIKAN_ID`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 2),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP1`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 3),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP2`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 4),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP3`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 5),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP4`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 6),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP5`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 100),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP6`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 101),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP7`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 97),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP8`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 11),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP10`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 12),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `AP11`,
			SUM(IF((`a_penjualan`.`UNIT_ID` = 20),(`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`),0)) AS `FS`,
			SUM(FLOOR((`a_penjualan`.`QTY_JUAL` - `a_penjualan`.`QTY_RETUR`) * `a_penjualan`.`HARGA_SATUAN`)) AS `TOTAL` 
			FROM (`a_penerimaan` INNER JOIN `a_penjualan` ON((`a_penerimaan`.`ID` = `a_penjualan`.`PENERIMAAN_ID`))) 
			WHERE ((`a_penjualan`.`TGL` BETWEEN '$tgl_d1' AND '$tgl_s1') AND (`a_penjualan`.`QTY_JUAL` > `a_penjualan`.`QTY_RETUR`)) 
			GROUP BY `a_penerimaan`.`OBAT_ID`,`a_penerimaan`.`KEPEMILIKAN_ID`) AS t1 ON ao.OBAT_ID=t1.OBAT_ID 
			INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID) AS t2 ORDER BY ".$sorting." limit $flimit";*/
		if ($tipe=="1"){
			$sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ak.NAMA,t2.* FROM (SELECT * FROM (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,SUM(t1.QTY_JUAL) AS QTY_JUAL,SUM(t1.NILAI) AS NILAI FROM  
(SELECT PENERIMAAN_ID,UNIT_ID,QTY_JUAL-QTY_RETUR AS QTY_JUAL,(QTY_JUAL-QTY_RETUR) * HARGA_SATUAN AS NILAI FROM a_penjualan 
WHERE TGL BETWEEN '$tgl_d1' AND '$tgl_s1') t1 INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID
GROUP BY ap.OBAT_ID,ap.KEPEMILIKAN_ID) t2 ORDER BY QTY_JUAL DESC LIMIT $flimit) AS t2 INNER JOIN a_obat ao ON t2.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON t2.KEPEMILIKAN_ID=ak.ID";
		}elseif ($tipe=="2"){
			$sql="SELECT ao.OBAT_KODE,ao.OBAT_NAMA,ak.NAMA,t4.* FROM (SELECT * FROM (SELECT ah.OBAT_ID,ah.KEPEMILIKAN_ID,IFNULL(t2.QTY_JUAL,0) AS QTY_JUAL,IFNULL(t2.NILAI,0) AS NILAI FROM a_harga ah 
LEFT JOIN (SELECT ap.OBAT_ID,ap.KEPEMILIKAN_ID,SUM(t1.QTY_JUAL) AS QTY_JUAL,SUM(t1.NILAI) AS NILAI FROM  
(SELECT PENERIMAAN_ID,UNIT_ID,QTY_JUAL-QTY_RETUR AS QTY_JUAL,(QTY_JUAL-QTY_RETUR) * HARGA_SATUAN AS NILAI FROM a_penjualan 
WHERE TGL BETWEEN '$tgl_d1' AND '$tgl_s1') t1 INNER JOIN a_penerimaan ap ON t1.PENERIMAAN_ID=ap.ID
GROUP BY ap.OBAT_ID,ap.KEPEMILIKAN_ID) AS t2 ON (ah.OBAT_ID=t2.OBAT_ID AND ah.KEPEMILIKAN_ID=t2.KEPEMILIKAN_ID)) AS t3 
ORDER BY QTY_JUAL LIMIT $flimit) AS t4 INNER JOIN a_obat ao ON t4.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON t4.KEPEMILIKAN_ID=ak.ID";
		}
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
while ($rows=mysqli_fetch_array($rs)){
	$kode_obat=$rows['OBAT_KODE'];
	$worksheet->write($row, 0, "'$kode_obat'", $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA'], $regularFormat);
	$worksheet->write($row, 2, $rows['NAMA'], $regularFormatC);
/*	$worksheet->write($row, 3, $rows['AP1'], $regularFormatR);
	$worksheet->write($row, 4, $rows['AP2'], $regularFormatR);
	$worksheet->write($row, 5, $rows['AP3'], $regularFormatR);
	$worksheet->write($row, 6, $rows['AP4'], $regularFormatR);
	$worksheet->write($row, 7, $rows['AP5'], $regularFormatR);
	$worksheet->write($row, 8, $rows['AP6'], $regularFormatR);
	$worksheet->write($row, 9, $rows['AP7'], $regularFormatR);
	$worksheet->write($row, 10, $rows['AP8'], $regularFormatR);
	$worksheet->write($row, 11, $rows['AP10'], $regularFormatR);
	$worksheet->write($row, 12, $rows['AP11'], $regularFormatR);
	$worksheet->write($row, 13, $rows['FS'], $regularFormatR);*/
	$worksheet->write($row, 3, $rows['QTY_JUAL'], $regularFormatR);
	$worksheet->write($row, 4, $rows['NILAI'], $regularFormatR);
	$row++;
}
$worksheet->write($row, 2, "TOTAL", $regularFormatR);
$worksheet->write($row, 3, '=Sum(D5:D'.$row.')', $regularFormatR);
$worksheet->write($row, 4, '=Sum(E5:E'.$row.')', $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>