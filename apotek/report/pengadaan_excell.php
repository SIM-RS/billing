<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$unitid=$_REQUEST['unitid'];
$tgl_d1=$_REQUEST['tgl_d'];
$tgl_s1=$_REQUEST['tgl_s'];
$tgl_d=explode("-",$tgl_d1);
$tgl_d1=$tgl_d[2]."-".$tgl_d[1]."-".$tgl_d[0];
$tgl_d=$tgl_d[0]."/".$tgl_d[1]."/".$tgl_d[2];
$tgl_s=explode("-",$tgl_s1);
$tgl_s1=$tgl_s[2]."-".$tgl_s[1]."-".$tgl_s[0];
$tgl_s=$tgl_s[0]."/".$tgl_s[1]."/".$tgl_s[2];
//Paging,Sorting dan Filter======
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
require_once('../Excell/Writer.php');

//Creating a workbook
$workbook = new Spreadsheet_Excel_Writer();

//Sending HTTP headers
$workbook->send('Pengadaan.xls');

//Creating a worksheet
$worksheet=&$workbook->addWorksheet('Pengadaan');
$worksheet->setLandscape();

//set all columns same width
$columnWidth = 10;
$worksheet->setColumn (0, 0, 6);
$worksheet->setColumn (1, 1, 30);
$worksheet->setColumn (2, 9, 12);
$worksheet->setColumn (10, 10, 20);
//$worksheet->setColumn (0, $numColumns, $columnWidth);

//Setup different styles
$sheetTitleFormat =& $workbook->addFormat(array('size'=>14,'align'=>'center'));
$UnitTitleFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$UnitTitleFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center','vAlign'=>'vcenter','textWrap'=>1));
$UnitTitleFormatCB =& $workbook->addFormat(array('bold'=>1,'size'=>9,'align'=>'center','vAlign'=>'vcenter','textWrap'=>1));
$UnitTitleFormatC_TLBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'left'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter','textWrap'=>1));
$UnitTitleFormatC_TBR =& $workbook->addFormat(array('size'=>9,'top'=>1,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter','textWrap'=>1));
$UnitTitleFormatC_BR =& $workbook->addFormat(array('size'=>9,'bottom'=>1,'right'=>1,'align'=>'center','vAlign'=>'vcenter','textWrap'=>1));
$columnTitleFormat =& $workbook->addFormat(array('bold'=>1,'top'=>1,'bottom'=>1,'right'=>1,'size'=>11,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatC =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'center','fgcolor'=>'grey','pattern'=>1));
$sTotFormatR =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'right','fgcolor'=>'grey','pattern'=>1));
$sTotFormatL =& $workbook->addFormat(array('bold'=>1,'size'=>10,'align'=>'left','fgcolor'=>'grey','pattern'=>1));
$regularFormat =& $workbook->addFormat(array('size'=>9,'align'=>'left'));
$regularFormatC =& $workbook->addFormat(array('size'=>9,'align'=>'center'));
$regularFormatR =& $workbook->addFormat(array('size'=>9,'align'=>'right'));

/*Speadsheet writer is in format y,x (row, column)
 *  column1  |  column2 |  column3
 *   (0,0)      (0,1)      (0,2) */

$column = 0;
$row    = 0;

//Write sheet title in upper left cell
$worksheet->write($row, 0, "DAFTAR PENGADAAN BARANG HABIS PAKAI", $UnitTitleFormatCB);
$worksheet->mergeCells($row,$column,$row,$column+10); 
$row += 1;
$worksheet->write($row, 0, "TRIBULAN .....( $tgl_d s/d $tgl_s )", $UnitTitleFormatCB);
$worksheet->mergeCells($row,$column,$row,$column+10); 
$row += 2;
$worksheet->write($row, 0, "SKPD", $UnitTitleFormat);
$worksheet->write($row, 2, ": ", $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, $tipe_kotaRS, $UnitTitleFormat);
$worksheet->write($row, 2, ": ".$kotaRS, $UnitTitleFormat);
$row += 1;
$worksheet->write($row, 0, "PROPINSI", $UnitTitleFormat);
$worksheet->write($row, 2, ": ".$propinsiRS, $UnitTitleFormat);
$row += 2;
//Write column titles two rows beneath sheet title//Write column titles two rows beneath sheet title
$worksheet->write($row, $column, "No", $UnitTitleFormatC_TLBR);
$worksheet->writeBlank($row+1, $column, $UnitTitleFormatC_TLBR);
$worksheet->mergeCells($row,$column,$row+1,$column); 
$worksheet->write($row, $column+1, "JENIS BARANG YG DIBELI", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row+1, $column+1, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+1,$row+1,$column+1); 
$worksheet->write($row, $column+2, "SPK/PERJANJIAN/KONTRAK", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row, $column+3, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+2,$row,$column+3); 
$worksheet->write($row, $column+4, "DPA/SPM/KWITANSI", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row, $column+5, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+4,$row,$column+5); 
$worksheet->write($row, $column+6, "JUMLAH", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row, $column+7, $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row, $column+8, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+6,$row,$column+8);
$worksheet->write($row, $column+9, "DIPERGUNAKAN UNIT", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row+1, $column+9, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+9,$row+1,$column+9);
$worksheet->write($row, $column+10, "KETERANGAN", $UnitTitleFormatC_TBR);
$worksheet->writeBlank($row+1, $column+10, $UnitTitleFormatC_TBR);
$worksheet->mergeCells($row,$column+10,$row+1,$column+10);
$row += 1;
$worksheet->write($row, $column+2, "TANGGAL", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+3, "NOMOR", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+4, "TANGGAL", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+5, "NOMOR", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+6, "BANYAKNYA BARANG", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+7, "HARGA SATUAN", $UnitTitleFormatC_BR);
$worksheet->write($row, $column+8, "JUMLAH HARGA", $UnitTitleFormatC_BR);
//Write each datapoint to the sheet starting one row beneath
//$row=0;
$row++;

  $sql="SELECT ap.ID,DATE_FORMAT(ap.TANGGAL,'%d-%m-%Y') AS tgl1,ao.OBAT_NAMA,ak.NAMA,ap.NOTERIMA,
		ap.QTY_SATUAN,ap.HARGA_BELI_SATUAN,ap.DISKON,ap.NILAI_PAJAK,a_pbf.PBF_NAMA 
		FROM a_penerimaan ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN 
		a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID INNER JOIN a_pbf ON ap.PBF_ID=a_pbf.PBF_ID 
		WHERE ap.TIPE_TRANS=0 AND ap.TANGGAL BETWEEN '$tgl_d1' AND '$tgl_s1' 
		ORDER BY ap.TANGGAL,ap.NOTERIMA,ao.OBAT_NAMA";

//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$i=0;
$noterima="";
while ($rows=mysqli_fetch_array($rs)){
	$i++;
	$idp=$rows['ID'];
	$sql="SELECT DISTINCT au.UNIT_NAME FROM a_penerimaan ap INNER JOIN a_unit au ON ap.UNIT_ID_TERIMA=au.UNIT_ID WHERE ID_LAMA=$idp AND TIPE_TRANS=1";
	$rs1=mysqli_query($konek,$sql);
	$iunit="";
	while ($rows1=mysqli_fetch_array($rs1)){
		$iunit .=$rows1["UNIT_NAME"].",";
	}
	if ($iunit!="") $iunit=substr($iunit,0,strlen($iunit)-1);
	$ket="";
	if ($noterima!=$rows['NOTERIMA']){
		$noterima=$rows['NOTERIMA'];
		$ket=$rows['PBF_NAMA']." - ".$rows['NOTERIMA'];
	}
	$diskon=$rows['DISKON'];
	$pajak=$rows['NILAI_PAJAK'];
	if ($pajak>0){
		$hbeli=floor($rows['HARGA_BELI_SATUAN']-($rows['HARGA_BELI_SATUAN']*$diskon/100)+($rows['HARGA_BELI_SATUAN']/10));
	}else{
		$hbeli=floor($rows['HARGA_BELI_SATUAN']-($rows['HARGA_BELI_SATUAN']*$diskon/100));
	}
	$worksheet->write($row, 0, $i, $regularFormatC);
	$worksheet->write($row, 1, $rows['OBAT_NAMA']." (".$rows['NAMA'].")", $regularFormat);
	$worksheet->write($row, 6, $rows['QTY_SATUAN'], $regularFormatR);
	$worksheet->write($row, 7, $hbeli, $regularFormatR);
	$worksheet->write($row, 8, $hbeli*$rows['QTY_SATUAN'], $regularFormatR);
	$worksheet->write($row, 9, $iunit, $regularFormat);
	$worksheet->write($row, 10, $ket, $regularFormat);
	$row++;
}

$worksheet->write($row, 0, "TOTAL  ", $regularFormatR);
$worksheet->mergeCells($row,0,$row,7);
$worksheet->write($row, 8, "=SUM(I10:I$row)", $regularFormatR);

$workbook->close();
mysqli_free_result($rs);
mysqli_close($konek);
?>